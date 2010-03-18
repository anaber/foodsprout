<?php

class RestaurantModel extends Model{
	
	
	// Generate a simple list of all the restaurants in the database.
	function list_restaurant()
	{
		$query = "SELECT restaurant.* " .
				" FROM restaurant " .
				" ORDER BY restaurant_name";
		
		log_message('debug', "RestaurantModel.list_restaurant : " . $query);
		$result = $this->db->query($query);
		
		$companies = array();
		
		foreach ($result->result_array() as $row) {
			
			$this->load->library('RestaurantLib');
			unset($this->restaurantLib);
			
			$this->restaurantLib->restaurantId = $row['restaurant_id'];
			$this->restaurantLib->restaurantName = $row['restaurant_name'];
			$this->restaurantLib->creationDate = $row['creation_date'];
			
			$companies[] = $this->restaurantLib;
			unset($this->restaurantLib);
		}
		
		return $companies;
	}
	
	// Generate a detailed list of all the restaurants in the database.
	function listRestaurantMore()
	{
		
	}
	
	// Input the data from the controller
	function addRestaurant() {
		$return = true;
		
		$query = "SELECT * FROM restaurant WHERE restaurant_name = '" . $this->input->post('restaurantName') . "'";
		log_message('debug', 'RestaurantModel.addRestaurant : Try to get duplicate Restaurant record : ' . $query);
		
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$query = "INSERT INTO restaurant (restaurant_id, restaurant_name, creation_date)" .
					" values (NULL, '" . $this->input->post('restaurantName') . "', NOW() )";
			log_message('debug', 'RestaurantModel.addRestaurant : Insert Restaurant : ' . $query);
			
			if ( $this->db->query($query) ) {
				$new_restaurant_id = $this->db->insert_id();
				
				$CI =& get_instance();
				$CI->load->model('AddressModel','',true);
				$address = $CI->AddressModel->prepareAddress($this->input->post('streetNumber'), $this->input->post('street'), $this->input->post('city'), $this->input->post('stateId'), $this->input->post('countryId'), $this->input->post('zipcode') );
			
				$CI->load->model('GoogleMapModel','',true);
				$latLng = $CI->GoogleMapModel->geoCodeAddress($address);
				
				$query = "INSERT INTO address (address_id, street_number, street, city, state_id, zipcode, country_id, latitude , longitude, restaurant_id)" .
						" values (NULL, '" . $this->input->post('streetNumber') . "', '" . $this->input->post('street') . "', '" . $this->input->post('city') . "', '" . $this->input->post('stateId') . "', '" . $this->input->post('zipcode') . "', '" . $this->input->post('countryId') . "', '" . ( isset($latLng['latitude']) ? $latLng['latitude']:'' ) . "', '" . ( isset($latLng['longitude']) ? $latLng['longitude']:'' ) . "', $new_restaurant_id )";
				
			log_message('debug', 'RestaurantModel.addRestaurant : Insert Restaurant : ' . $query);
			
			$result = $this->db->query($query);
				$return = true;
			} else {
				$return = false;
			}
			
			$return = true;
		} else {
			$GLOBALS['error'] = 'duplicate';
			$return = false;
		}
		
		return $return;	
	}
	
	// Pulls the data from the database for a specific restaurant
	function getRestaurantFromId($restaurantId) {
		
		$query = "SELECT restaurant.*, address.* FROM restaurant, address WHERE restaurant.restaurant_id = address.restaurant_id AND restaurant.restaurant_id = " . $restaurantId;
		log_message('debug', "RestaurantModel.getRestaurantFromId : " . $query);
		$result = $this->db->query($query);
		
		$restaurant = array();
		
		$this->load->library('RestaurantLib');
		
		$row = $result->row();
		
		$this->restaurantLib->restaurantId = $row->restaurant_id;
		$this->restaurantLib->restaurantName = $row->restaurant_name;
		$this->restaurantLib->streetNumber = $row->street_number;
		$this->restaurantLib->street = $row->street;
		$this->restaurantLib->city = $row->city;
		$this->restaurantLib->stateId = $row->state_id;
		$this->restaurantLib->countryId = $row->country_id;
		$this->restaurantLib->zipcode = $row->zipcode;
		
		return $this->restaurantLib;
	}
	
	function updateRestaurant() {
		$return = true;
		
		$query = "SELECT * FROM restaurant WHERE restaurant_name = '" . $this->input->post('restaurantName') . "' AND restaurant_id <> " . $this->input->post('restaurantId');
		log_message('debug', 'RestaurantModel.updateRestaurant : Try to get Duplicate record : ' . $query);
			
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$CI =& get_instance();
			$CI->load->model('AddressModel','',true);
			
			$address = $CI->AddressModel->prepareAddress($this->input->post('streetNumber'), $this->input->post('street'), $this->input->post('city'), $this->input->post('stateId'), $this->input->post('countryId'), $this->input->post('zipcode') );
			
			$CI->load->model('GoogleMapModel','',true);
			$latLng = $CI->GoogleMapModel->geoCodeAddress($address);
			
			$data = array(
						'restaurant_name' => $this->input->post('restaurantName'), 
					);
			$where = "restaurant_id = " . $this->input->post('restaurantId');
			$query = $this->db->update_string('restaurant', $data, $where);
			
			log_message('debug', 'RestaurantModel.updateRestaurant : ' . $query);
			if ( $this->db->query($query) ) {
				$return = true;
				
				$data = array(
						'street_number' => $this->input->post('streetNumber'),
						'street' => $this->input->post('street'),
						'city' => $this->input->post('city'),
						'state_id' => $this->input->post('stateId'),
						'country_id' => $this->input->post('countryId'),
						'zipcode' => $this->input->post('zipcode'),
						'latitude' => ( isset($latLng['latitude']) ? $latLng['latitude']:'' ) ,
						'longitude' => ( isset($latLng['longitude']) ? $latLng['longitude']:'' ),
						
					);
				$where = "restaurant_id = " . $this->input->post('restaurantId');
				$query = $this->db->update_string('address', $data, $where);
				if ( $this->db->query($query) ) {
					$return = true;
				} else {
					$return = false;
				}
				
			} else {
				$return = false;
			}
			
		} else {
			$GLOBALS['error'] = 'duplicate';
			$return = false;
		}
				
		return $return;
	}
	
}



?>