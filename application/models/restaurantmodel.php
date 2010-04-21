<?php

class RestaurantModel extends Model{
	
	
	// Generate a simple list of all the restaurants in the database.
	function listRestaurant()
	{
		$query = "SELECT restaurant.* " .
				" FROM restaurant " .
				" ORDER BY restaurant_name";
		
		log_message('debug', "RestaurantModel.listRestaurant : " . $query);
		$result = $this->db->query($query);
		
		$restaurants = array();
		$CI =& get_instance();
		foreach ($result->result_array() as $row) {
			
			$this->load->library('RestaurantLib');
			unset($this->RestaurantLib);
			
			$this->RestaurantLib->restaurantId = $row['restaurant_id'];
			$this->RestaurantLib->restaurantName = $row['restaurant_name'];
			$this->RestaurantLib->creationDate = $row['creation_date'];
			
			$CI->load->model('AddressModel','',true);
			$addresses = $CI->AddressModel->getAddressForCompany( $row['restaurant_id'], '', '', '' );
			$this->RestaurantLib->addresses = $addresses;
			
			$CI->load->model('SupplierModel','',true);
			$suppliers = $CI->SupplierModel->getSupplierForCompany( $row['restaurant_id'], '', '', '' );
			$this->RestaurantLib->suppliers = $suppliers;
			
			
			$restaurants[] = $this->RestaurantLib;
			unset($this->RestaurantLib);
		}
		
		return $restaurants;
	}
	
	// Generate a detailed list of all the restaurants in the database.
	function listRestaurantMore()
	{
		
	}
	
	// Input the data from the controller
	function addRestaurant() {
		global $ACTIVITY_LEVEL_DB;
		
		
		$return = true;
		
		$companyId = $this->input->post('companyId');
		$restaurantName = $this->input->post('restaurantName');
		
		$CI =& get_instance();
		
		
		if (empty($companyId) && empty($restaurantName) ) {
			$GLOBALS['error'] = 'no_name';
			$return = false;
		} else {
			if ( empty($companyId) ) {
				// Enter manufacture into company
				$CI->load->model('CompanyModel','',true);
				$companyId = $CI->CompanyModel->addCompany($this->input->post('restaurantName'));
			} else {
				if (empty($restaurantName) ) {
					// Consider company name as manufacture name
					$CI->load->model('CompanyModel','',true);
					$company = $CI->CompanyModel->getCompanyFromId($companyId);
					$restaurantName = $company->companyName;
				}
			}
			
			$query = "SELECT * FROM restaurant WHERE restaurant_name = '" . $restaurantName . "' AND company_id = '" . $companyId . "'";
			log_message('debug', 'RestaurantModel.addRestaurant : Try to get duplicate Restaurant record : ' . $query);
			
			$result = $this->db->query($query);
			
			if ($result->num_rows() == 0) {
				$query = "INSERT INTO restaurant (restaurant_id, company_id, restaurant_type_id, cuisine_id, restaurant_name, creation_date, custom_url, is_active)" .
						" values (NULL, ".$companyId.", " . $this->input->post('restaurantTypeId') . ", " . $this->input->post('cuisineId') . ", '" . $restaurantName . "', NOW(), '" . $this->input->post('customUrl') . "', '" . $ACTIVITY_LEVEL_DB[$this->input->post('isActive')] . "' )";
				
				log_message('debug', 'RestaurantModel.addRestaurant : Insert Restaurant : ' . $query);
				$return = true;
				
				if ( $this->db->query($query) ) {
					$newRestaurantId = $this->db->insert_id();
					
					$CI->load->model('AddressModel','',true);
					$address = $CI->AddressModel->addAddress($newRestaurantId, '', '', '', '');
				} else {
					$return = false;
				}
				
			} else {
				$GLOBALS['error'] = 'duplicate';
				$return = false;
			}
			
		}
		
		return $return;	
	}
	
	// Pulls the data from the database for a specific restaurant
	function getRestaurantFromId($restaurantId) {
		
		//$query = "SELECT restaurant.*, address.* FROM restaurant, address WHERE restaurant.restaurant_id = address.restaurant_id AND restaurant.restaurant_id = " . $restaurantId;
		$query = "SELECT * FROM restaurant WHERE restaurant_id = " . $restaurantId;
		log_message('debug', "RestaurantModel.getRestaurantFromId : " . $query);
		$result = $this->db->query($query);
		
		$restaurant = array();
		
		$this->load->library('RestaurantLib');
		
		$row = $result->row();
		
		$this->restaurantLib->restaurantId = $row->restaurant_id;
		$this->restaurantLib->companyId = $row->company_id;
		$this->restaurantLib->restaurantTypeId = $row->restaurant_type_id;
		$this->restaurantLib->restaurantName = $row->restaurant_name;
		$this->restaurantLib->customUrl = $row->custom_url;
		$this->restaurantLib->isActive = $row->is_active;
		
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
	
	function addRestaurantWithNameOnly($restaurantName) {
		global $ACTIVITY_LEVEL_DB;
		
		$return = true;
		
		$companyId = '';
		
		$CI =& get_instance();
		
		if (empty($companyId) && empty($restaurantName) ) {
			$GLOBALS['error'] = 'no_name';
			$return = false;
		} else {
			if ( empty($companyId) ) {
				$CI->load->model('CompanyModel','',true);
				$companyId = $CI->CompanyModel->addCompany($restaurantName);
			} 
			
			if ($companyId) {
				$query = "SELECT * FROM restaurant WHERE restaurant_name = '" . $restaurantName . "' AND company_id = '" . $companyId . "'";
				log_message('debug', 'RestaurantModel.addRestaurant : Try to get duplicate Restaurant record : ' . $query);
				
				$result = $this->db->query($query);
				
				if ($result->num_rows() == 0) {
					$query = "INSERT INTO restaurant (restaurant_id, company_id, restaurant_type_id, restaurant_name, creation_date, custom_url, is_active)" .
							" values (NULL, ".$companyId.", NULL, '" . $restaurantName . "', NOW(), NULL, '" . $ACTIVITY_LEVEL_DB['active'] . "' )";
					
					log_message('debug', 'RestaurantModel.addRestaurant : Insert Restaurant : ' . $query);
					$return = true;
					
					if ( $this->db->query($query) ) {
						$newRestaurantId = $this->db->insert_id();
						$return = $newRestaurantId;
					} else {
						$return = false;
					}
					
				} else {
					$GLOBALS['error'] = 'duplicate';
					$return = false;
				}
			} else {
				$return = false;
			}
			
		}
		
		return $return;	
	}
	
}



?>