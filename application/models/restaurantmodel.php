<?php

class RestaurantModel extends Model{
	
	
	// Generate a simple list of all the restaurants in the database.
	function listRestaurant()
	{
		$query = "SELECT restaurant.* , cuisine.cuisine_name
					FROM restaurant, cuisine
					WHERE restaurant.cuisine_id = cuisine.cuisine_id
					ORDER BY restaurant_name";
		
		log_message('debug', "RestaurantModel.listRestaurant : " . $query);
		$result = $this->db->query($query);
		
		$restaurants = array();
		$CI =& get_instance();
		foreach ($result->result_array() as $row) {
			
			$this->load->library('RestaurantLib');
			unset($this->RestaurantLib);
			
			$this->RestaurantLib->restaurantId = $row['restaurant_id'];
			$this->RestaurantLib->restaurantName = $row['restaurant_name'];
			$this->RestaurantLib->cuisineId = $row['cuisine_id'];
			$this->RestaurantLib->cuisine = $row['cuisine_name'];
			
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
	
	
	function getRestaurantsJson() {
		global $PER_PAGE;
		
		$p = $this->input->post('p'); // Page
		$pp = $this->input->post('pp'); // Per Page
		$sort = $this->input->post('sort');
		$order = $this->input->post('order');
		$filter = $this->input->post('f');
		
		
		
		
		//echo $filter;
		$arr_filter = explode(',', $filter);
		
		$arrRestaurantTypeId = array();
		$arrCuisineId = array();
		
		foreach($arr_filter as $key => $value) {
			$arr_value = explode('_', $value) ;
			
			if ($arr_value[0] == 'r') {
				$arrRestaurantTypeId[] = $arr_value[1];
			}
			
			if ($arr_value[0] == 'c') {
				$arrCuisineId[] = $arr_value[1];
			}
		}
		
		
		$q = $this->input->post('q');
		//$q = '94107';
		//$filter = 'c_7';
		
		if ($q == '0') {
			$q = '';
		}
		//$arr_query = explode(' ', $q);
		
		$start = 0;
	
		$page = 0;
		
		$base_query = 'SELECT restaurant.*, cuisine.cuisine_name, restaurant_type.restaurant_type' .
				' FROM restaurant, cuisine, restaurant_type';
		
		$where = ' WHERE restaurant.cuisine_id = cuisine.cuisine_id '
				. ' AND restaurant.restaurant_type_id = restaurant_type.restaurant_type_id';
		
		if(count($arrRestaurantTypeId) > 0 ) {
			$where .= ' AND restaurant.restaurant_type_id IN (' . implode(',', $arrRestaurantTypeId) . ')';
		}
		
		if(count($arrCuisineId) > 0 ) {
			$where .= ' AND restaurant.cuisine_id IN (' . implode(',', $arrCuisineId) . ')';
		}
		
		if ( !empty($q) ) {
			if (!empty($where) ) {
				$where .= ' AND (';  
			} else {
				$where .= ' WHERE (';
			}
			
			$where .= 'restaurant.restaurant_name like "%' .$q . '%"'
					. ' OR restaurant.restaurant_id like "%' . $q . '%"';
			
			
			$where	.= ' OR ( '
					. '		SELECT address.address_id' 
					. '			from address, state, country'
					. '			WHERE' 
					. '				address.restaurant_id = restaurant.restaurant_id'
					. '				AND address.state_id = state.state_id'
					. '				AND address.country_id = country.country_id'
					. ' 			AND (' 
					. '						address.address like "%' . $q . '%"'
					. '						OR address.city like "%' . $q . '%"'
					. '						OR address.zipcode like "%' . $q . '%"'
					. '						OR state.state_name like "%' . $q . '%"'
					. '						OR state.state_code like "%' . $q . '%"'
					. '						OR country.country_name like "%' . $q . '%"'
					. '				)'
					. '				LIMIT 0, 1'
					. '		)'
			 		
					;
			
			$where .= ')';
			
		}
		
		$base_query = $base_query . $where;
		
		$query = $base_query . " ORDER BY restaurant_name ";
		
		//echo $query . "<BR/>";
		
		$result = $this->db->query($query);
		$numResults = $result->num_rows();
		
		
		$query = $base_query;
		
		if ( empty($sort) ) {
			$sort_query = ' ORDER BY restaurant_name';
			$sort = 'restaurant_name';
		} else {
			$sort_query = ' ORDER BY ' . $sort;
		}
		
		if ( empty($order) ) {
			$order = 'ASC';
		}
		
		$query = $query . ' ' . $sort_query . ' ' . $order;
		
		if (!empty($pp) && $pp != 'all' ) {
			$PER_PAGE = $pp;
		}
		
		if (!empty($pp) && $pp == 'all') {
			// NO NEED TO LIMIT THE CONTENT
		} else {
			
			if (!empty($p) || $p != 0) {
				$page = $p;
				$p = $p * $PER_PAGE;
				$query .= " LIMIT $p, " . $PER_PAGE;
				$start = $p;
				
			} else {
				$query .= " LIMIT 0, " . $PER_PAGE;
			}
		}
		//print_r_pre($_REQUEST);
		//echo $query;
		//die;
		
		log_message('debug', "RestaurantModel.getRestaurantsJson : " . $query);
		$result = $this->db->query($query);
		
		$restaurants = array();
		
		$CI =& get_instance();
		
		$geocodeArray = array();
		foreach ($result->result_array() as $row) {
			
			
			$this->load->library('RestaurantLib');
			unset($this->RestaurantLib);
			
			$this->RestaurantLib->restaurantId = $row['restaurant_id'];
			$this->RestaurantLib->restaurantName = $row['restaurant_name'];
			$this->RestaurantLib->cuisineId = $row['cuisine_id'];
			$this->RestaurantLib->cuisine = $row['cuisine_name'];
			
			$this->RestaurantLib->creationDate = $row['creation_date'];
			
			$CI->load->model('AddressModel','',true);
			$addresses = $CI->AddressModel->getAddressForCompany( $row['restaurant_id'], '', '', '' );
			$this->RestaurantLib->addresses = $addresses;
			
			$CI->load->model('SupplierModel','',true);
			$suppliers = $CI->SupplierModel->getSupplierForCompany( $row['restaurant_id'], '', '', '' );
			$this->RestaurantLib->suppliers = $suppliers;
		
			
			foreach ($addresses as $key => $address) {
				$arrLatLng = array();
				
				$arrLatLng['latitude'] = $address->latitude;
				$arrLatLng['longitude'] = $address->longitude;
				$arrLatLng['address'] = $address->completeAddress;
				
				$arrLatLng['addressLine1'] = $address->address;
				$arrLatLng['addressLine2'] = $address->city . ' ' . $address->state;
				$arrLatLng['addressLine3'] = $address->country . ' ' . $address->zipcode;
				
				$arrLatLng['restaurantName'] = $this->RestaurantLib->restaurantName;
				$arrLatLng['id'] = $address->addressId;
				$geocodeArray[] = $arrLatLng;
			}
			
		
			
			$restaurants[] = $this->RestaurantLib;
			unset($this->RestaurantLib);
		}
		
		if (!empty($pp) && $pp == 'all') {
			$PER_PAGE = $numResults;
		}
		
		$totalPages = ceil($numResults/$PER_PAGE);
		$first = 0;
		$last = $totalPages - 1;
		
		
		$params = requestToParams($numResults, $start, $totalPages, $first, $last, $page, $sort, $order, $q, $filter);
		$arr = array(
			'results'    => $restaurants,
			'param'      => $params,
			'geocode'	 => $geocodeArray,
	    );
	    //print_r_pre($arr);
	    //die;
	    return $arr;
		
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
					$address = $CI->AddressModel->addAddress($newRestaurantId, '', '', '', $companyId);
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
		global $ACTIVITY_LEVEL_DB;
		$return = true;
		
		$query = "SELECT * FROM restaurant WHERE restaurant_name = '" . $this->input->post('restaurantName') . "' AND restaurant_id <> " . $this->input->post('restaurantId');
		log_message('debug', 'RestaurantModel.updateRestaurant : Try to get Duplicate record : ' . $query);
			
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$data = array(
						'restaurant_name' => $this->input->post('restaurantName'), 
						'custom_url' => $this->input->post('customUrl'),
						'restaurant_type_id' => $this->input->post('restaurantTypeId'),
						'cuisine_id' => $this->input->post('cuisineId'),
						'is_active' => $ACTIVITY_LEVEL_DB[$this->input->post('isActive')],
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
	
	function getDistinctUsedRestaurantType()
	{
		$query = "SELECT DISTINCT restaurant.restaurant_type_id, restaurant_type.restaurant_type
					FROM restaurant, restaurant_type
					WHERE restaurant.restaurant_type_id = restaurant_type.restaurant_type_id";
		
		log_message('debug', "RestaurantModel.getDistinctRestaurantType : " . $query);
		$result = $this->db->query($query);
		
		$restaurantTypes = array();
		$CI =& get_instance();
		foreach ($result->result_array() as $row) {
			
			$this->load->library('RestaurantTypeLib');
			unset($this->RestaurantTypeLib);
			
			$this->RestaurantTypeLib->restaurantTypeId = $row['restaurant_type_id'];
			$this->RestaurantTypeLib->restaurantType = $row['restaurant_type'];
			
			$restaurantTypes[] = $this->RestaurantTypeLib;
			unset($this->RestaurantTypeLib);
		}
		
		return $restaurantTypes;
	}
	
	function getDistinctUsedCuisine()
	{
		$query = "SELECT DISTINCT restaurant.cuisine_id, cuisine.cuisine_name
					FROM restaurant, cuisine
					WHERE restaurant.cuisine_id = cuisine.cuisine_id";
		
		log_message('debug', "RestaurantModel.getDistinctUsedCuisine : " . $query);
		$result = $this->db->query($query);
		
		$cuisine = array();
		
		foreach ($result->result_array() as $row) {
			
			$this->load->library('CuisineLib');
			unset($this->CuisineLib);
			
			$this->CuisineLib->cuisineId = $row['cuisine_id'];
			$this->CuisineLib->cuisineName = $row['cuisine_name'];
			
			$cuisine[] = $this->CuisineLib;
			unset($this->CuisineLib);
		}
		
		return $cuisine;
	}
	
}



?>