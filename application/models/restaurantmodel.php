<?php

class RestaurantModel extends Model{
	
	
	// List all the products in the database
	function list_restaurant()
	{
		$query = "SELECT restaurant.*, state.state_name, country.country_name " .
				" FROM restaurant, state, country " .
				" WHERE restaurant.state_id = state.state_id" .
				" AND restaurant.country_id = country.country_id " .
				" ORDER BY restaurant_name";
		
		log_message('debug', "RestaurantModel.list_restaurant : " . $query);
		$result = $this->db->query($query);
		
		$companies = array();
		
		foreach ($result->result_array() as $row) {
			
			$this->load->library('RestaurantLib');
			unset($this->restaurantLib);
			
			$this->restaurantLib->restaurantId = $row['restaurant_id'];
			$this->restaurantLib->restaurantName = $row['restaurant_name'];
			$this->restaurantLib->streetAddress = $row['street_address'];
			$this->restaurantLib->stateId = $row['state_id'];
			$this->restaurantLib->stateName = $row['state_name'];
			$this->restaurantLib->countryId = $row['country_id'];
			$this->restaurantLib->countryName = $row['country_name'];
			$this->restaurantLib->zipcode = $row['zipcode'];
			$this->restaurantLib->creationDate = $row['creation_date'];
			
			$companies[] = $this->restaurantLib;
			unset($this->restaurantLib);
		}
		
		return $companies;
	}
	
	function addRestaurant() {
		$return = true;
		
		$query = "SELECT * FROM restaurant WHERE restaurant_name = '" . $this->input->post('restaurantName') . "'";
		log_message('debug', 'RestaurantModel.addRestaurant : Try to get duplicate Restaurant record : ' . $query);
		
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$query = "INSERT INTO restaurant (restaurant_id, restaurant_name, country_id, state_id, city, street_address, zipcode, creation_date)" .
					" values (NULL, '" . $this->input->post('restaurantName') . "', '" . $this->input->post('countryId') . "', '" . $this->input->post('stateId') . "', '" . $this->input->post('city') . "', '" . $this->input->post('streetAddress') . "', '" . $this->input->post('zipcode') . "', NOW() )";
			log_message('debug', 'RestaurantModel.addRestaurant : Insert Restaurant : ' . $query);
			
			if ( $this->db->query($query) ) {
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
	
	function getRestaurantFromId($restaurantId) {
		
		$query = "SELECT * FROM restaurant WHERE restaurant_id = " . $restaurantId;
		log_message('debug', "RestaurantModel.getRestaurantFromId : " . $query);
		$result = $this->db->query($query);
		
		$restaurant = array();
		
		$this->load->library('RestaurantLib');
		
		$row = $result->row();
		
		$this->restaurantLib->restaurantId = $row->restaurant_id;
		$this->restaurantLib->restaurantName = $row->restaurant_name;
		$this->restaurantLib->streetAddress = $row->street_address;
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
			
			$data = array(
						'restaurant_name' => $this->input->post('restaurantName'), 
						'street_address' => $this->input->post('streetAddress'),
						'city' => $this->input->post('city'),
						'state_id' => $this->input->post('stateId'),
						'country_id' => $this->input->post('countryId'),
						'zipcode' => $this->input->post('zipcode'),
						 
					);
			$where = "restaurant_id = " . $this->input->post('restaurantId');
			$query = $this->db->update_string('restaurant', $data, $where);
			
			log_message('debug', 'RestaurantModel.updateRestaurant : ' . $query);
			if ( $this->db->query($query) ) {
				$return = true;
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