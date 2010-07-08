<?php

class RestaurantModel extends Model{
	
	
	// Generate a simple list of all the restaurants in the database.
	function listRestaurant()
	{
		/*
		$query = "SELECT restaurant.* , restaurant_cuisine.*, cuisine.cuisine_name
					FROM restaurant, restaurant_cuisine, cuisine
					WHERE restaurant.restaurant_id = restaurant_cuisine.restaurant_id
					AND cuisine.cuisine_id = restaurant_cuisine.cuisine_id
					ORDER BY restaurant_name limit 0, 100";
		*/
		$query = "SELECT restaurant.*
					FROM restaurant
					ORDER BY restaurant_name limit 0, 100";
		
		
		log_message('debug', "RestaurantModel.listRestaurant : " . $query);
		$result = $this->db->query($query);
		
		$restaurants = array();
		$CI =& get_instance();
		foreach ($result->result_array() as $row) {
			
			$this->load->library('RestaurantLib');
			unset($this->RestaurantLib);
			
			$this->RestaurantLib->restaurantId = $row['restaurant_id'];
			$this->RestaurantLib->restaurantName = $row['restaurant_name'];
			//$this->RestaurantLib->cuisineId = $row['cuisine_id'];
			//$this->RestaurantLib->cuisine = $row['cuisine_name'];
			
			$this->RestaurantLib->creationDate = $row['creation_date'];
			
			$CI->load->model('AddressModel','',true);
			$addresses = $CI->AddressModel->getAddressForCompany( $row['restaurant_id'], '', '', '', '' );
			$this->RestaurantLib->addresses = $addresses;
			
			$CI->load->model('SupplierModel','',true);
			$suppliers = $CI->SupplierModel->getSupplierForCompany( $row['restaurant_id'], '', '', '', '' );
			$this->RestaurantLib->suppliers = $suppliers;
			
			
			$restaurants[] = $this->RestaurantLib;
			unset($this->RestaurantLib);
		}
		
		return $restaurants;
	}
	
	
	// Generate a simple list of all the fast food chain restaurants.
	function listFastFood()
	{
		
		$query = "SELECT restaurant_chain.*
					FROM restaurant_chain
					ORDER BY restaurant_chain limit 0, 100";
		
		
		log_message('debug', "RestaurantModel.listFastFood : " . $query);
		$result = $this->db->query($query);
		
		$restaurants = array();
		$CI =& get_instance();
		foreach ($result->result_array() as $row) {
			
			$this->load->library('RestaurantChainLib');
			unset($this->RestaurantChainLib);
			
			$this->RestaurantChainLib->restaurantChainId = $row['restaurant_chain_id'];
			$this->RestaurantChainLib->restaurantChain = $row['restaurant_chain'];
			
			$restaurants[] = $this->RestaurantChainLib;
			unset($this->RestaurantChainLib);
		}
		
		return $restaurants;
	}
	
	
	function getRestaurantsJson() {
		global $PER_PAGE, $DEFAULT_ZOOM_LEVEL, $ZIPCODE_ZOOM_LEVEL, $CITY_ZOOM_LEVEL;
		
		$p = $this->input->post('p'); // Page
		$pp = $this->input->post('pp'); // Per Page
		$sort = $this->input->post('sort');
		$order = $this->input->post('order');
		$filter = $this->input->post('f');
		
		//$filter = 'r_10,c_6';
		
		
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
		
		$city = '';
		//$city = '41,6009,13721';
		
		$mapZoomLevel = $DEFAULT_ZOOM_LEVEL;
		
		if ($q == '') {
			
			if (isset ($_COOKIE['seachedZip']) && !empty($_COOKIE['seachedZip']) ) {
				$q = $_COOKIE['seachedZip'];
				$mapZoomLevel = $ZIPCODE_ZOOM_LEVEL;
			} else {
				// By default display all restaurants of SFO
				$city = '41,6009,13721';
				$mapZoomLevel = $CITY_ZOOM_LEVEL;
			}
		} else {
			setcookie('seachedZip', $q, time()+60*60*24*30*365);
			$mapZoomLevel = $ZIPCODE_ZOOM_LEVEL;
		}
		
		
		
		$start = 0;
	
		$page = 0;
		
		/*
		$base_query = 'SELECT restaurant.*, restaurant_cuisine.*, cuisine.cuisine_name, restaurant_type.restaurant_type' .
				' FROM restaurant, restaurant_cuisine, cuisine, restaurant_type';
		
		$where = ' WHERE restaurant.restaurant_id = restaurant_cuisine.restaurant_id '
				. ' AND restaurant_cuisine.cuisine_id = cuisine.cuisine_id '
				. ' AND restaurant.restaurant_type_id = restaurant_type.restaurant_type_id';
		*/
		
		$base_query = 'SELECT restaurant.*, restaurant_type.restaurant_type' .
				' FROM restaurant, restaurant_type';
		
		$base_query_count = 'SELECT count(*) AS num_records' .
				' FROM restaurant, restaurant_type';
		
		
		$where = ' WHERE restaurant.restaurant_type_id = restaurant_type.restaurant_type_id';
		
		/*
		$where .= 'restaurant.restaurant_name like "%' .$q . '%"'
				. ' OR restaurant.restaurant_id like "%' . $q . '%"';
		*/
		
		if ( count($arrRestaurantTypeId) > 0  || count($arrCuisineId) > 0 ) {
			$where .= ' AND (';
			
			if(count($arrRestaurantTypeId) > 0 ) {
				$where .= ' restaurant.restaurant_type_id IN (' . implode(',', $arrRestaurantTypeId) . ')';
			}
			
			
			if(count($arrCuisineId) > 0 ) {
			 		// Cuisine 
				if(count($arrRestaurantTypeId) > 0 ) {
					$where	.= ' OR ( ';
				} else {
					$where	.= ' ( ';
				}
				
			$where	.= '		SELECT restaurant_cuisine.restaurant_cuisine_id ' 
					. '			FROM restaurant_cuisine' 
					. '			WHERE' 
					. '				restaurant_cuisine.restaurant_id = restaurant.restaurant_id'
					. ' 			AND restaurant_cuisine.cuisine_id IN (' . implode(',', $arrCuisineId) . ')'
					. '				LIMIT 0, 1'
					. '		)';
			 }
			
			$where .= ' )';
		}
		
		if ( !empty($q) || !empty($city) ) {
			if (!empty($where) ) {
				$where .= ' AND (';  
			} else {
				$where .= ' WHERE (';
			}
			

			//$where	.= ' OR ( '
			$where	.= '		SELECT address.address_id' 
					. '			from address, state, country'
					. '			WHERE' 
					. '				address.restaurant_id = restaurant.restaurant_id'
					. '				AND address.state_id = state.state_id'
					. '				AND address.country_id = country.country_id'
					. ' 			AND (';
				if ( !empty($q) ) {	 
			$where	.= '					address.zipcode = "' . $q . '"';
				} else if ( !empty($city) ) {
			$where	.= '					address.city_id IN (' . $city . ')';
				}
					/*
					. '						address.address like "%' . $q . '%"'
					. '						OR address.city like "%' . $q . '%"'
					. '						OR address.zipcode like "%' . $q . '%"'
					. '						OR state.state_name like "%' . $q . '%"'
					. '						OR state.state_code like "%' . $q . '%"'
					. '						OR country.country_name like "%' . $q . '%"'
					*/

					
					
			$where	.= '				)'
					. '				LIMIT 0, 1'
					. '		)';
			
		}
		
		
		
		/*
		if(count($arrRestaurantTypeId) > 0 ) {
			$where .= ' AND restaurant.restaurant_type_id IN (' . implode(',', $arrRestaurantTypeId) . ')';
		}
		
		
		if ( !empty($q) || !empty($city) || count($arrCuisineId) > 0 ) {
			if (!empty($where) ) {
				$where .= ' AND (';  
			} else {
				$where .= ' WHERE (';
			}
			
			//$where	.= ' OR ( '
			$where	.= ' ( '
					. '		SELECT address.address_id' 
					. '			from address, state, country'
					. '			WHERE' 
					. '				address.restaurant_id = restaurant.restaurant_id'
					. '				AND address.state_id = state.state_id'
					. '				AND address.country_id = country.country_id'
					. ' 			AND (';
				if ( !empty($q) ) {	 
			$where	.= '					address.zipcode = "' . $q . '"';
				} else if ( !empty($city) ) {
			$where	.= '					address.city_id IN (' . $city . ')';
				}
				
			$where	.= '				)'
					. '				LIMIT 0, 1'
					. '		)';
					
			 	if(count($arrCuisineId) > 0 ) {
			 		
			 		// Cuisine 
			$where	.= ' AND ( '
					. '		SELECT restaurant_cuisine.restaurant_cuisine_id ' 
					. '			from restaurant_cuisine' 
					. '			WHERE' 
					. '				restaurant_cuisine.restaurant_id = restaurant.restaurant_id'
					. ' 			AND restaurant_cuisine.cuisine_id IN (' . implode(',', $arrCuisineId) . ')'
					. '				LIMIT 0, 1'
					. '		)';
			 	} 
					;
			
			$where .= ')';
			
		}
		*/
		
		$base_query_count = $base_query_count . $where;
		
		//echo $base_query_count;
		//die;
		
		//$query = $base_query_count . " ORDER BY restaurant_name ";
		$query = $base_query_count;
		
		$result = $this->db->query($query);
		$row = $result->row();
		$numResults = $row->num_records;
		
		$query = $base_query . $where;
		
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
		//echo $query . "<br />";
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
			//$this->RestaurantLib->cuisineId = $row['cuisine_id'];
			//$this->RestaurantLib->cuisine = $row['cuisine_name'];
			
			$this->RestaurantLib->creationDate = $row['creation_date'];
			
			$CI->load->model('AddressModel','',true);
			$addresses = $CI->AddressModel->getAddressForCompany( $row['restaurant_id'], '', '', '', $q, $city);
			$this->RestaurantLib->addresses = $addresses;
			
			
			$cuisines = $this->getCuisinesForRestaurant( $row['restaurant_id']);
			$this->RestaurantLib->cuisines = $cuisines;
			
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
			
			
			//$CI->load->model('SupplierModel','',true);
			//$suppliers = $CI->SupplierModel->getSupplierForCompany( $row['restaurant_id'], '', '', '', '' );
			//$this->RestaurantLib->suppliers = $suppliers;
			
			
			
			
			$restaurants[] = $this->RestaurantLib;
			unset($this->RestaurantLib);
		}
		
		if (!empty($pp) && $pp == 'all') {
			$PER_PAGE = $numResults;
		}
		
		$totalPages = ceil($numResults/$PER_PAGE);
		$first = 0;
		$last = $totalPages - 1;
		
		if ($numResults == 0) {
			$mapZoomLevel = $DEFAULT_ZOOM_LEVEL;
		}
		
		$params = requestToParams($numResults, $start, $totalPages, $first, $last, $page, $sort, $order, $q, $filter, $mapZoomLevel);
		$arr = array(
			'results'    => $restaurants,
			'param'      => $params,
			'geocode'	 => $geocodeArray,
	    );
	    //print_r_pre($arr);
		//die;
	    return $arr;
		
	}
	
	function getRestaurantsJsonAdmin() {
		global $PER_PAGE, $DEFAULT_ZOOM_LEVEL, $ZIPCODE_ZOOM_LEVEL, $CITY_ZOOM_LEVEL;
		
		$p = $this->input->post('p'); // Page
		$pp = $this->input->post('pp'); // Per Page
		$sort = $this->input->post('sort');
		$order = $this->input->post('order');
		
		$arrRestaurantTypeId = array();
		$arrCuisineId = array();
		
		$q = $this->input->post('q');
		//$q = 'fast';
		//$filter = 'c_7';
		
		if ($q == '0') {
			$q = '';
		}
		
		$mapZoomLevel = $DEFAULT_ZOOM_LEVEL;
		
		
		$start = 0;
	
		$page = 0;
		/*
		$base_query = 'SELECT restaurant.*, restaurant_chain.restaurant_chain, company.company_name, restaurant_type.restaurant_type' .
				' FROM restaurant, restaurant_type' .
				' LEFT JOIN restaurant_chain' .
				' ON restaurant.restaurant_chain_id = restaurant_chain.restaurant_chain_id' .
				' LEFT JOIN company' .
				' ON restaurant.company_id = company.company_id';
		*/
		$base_query = 'SELECT restaurant.*, restaurant_chain.restaurant_chain, company.company_name, restaurant_type.restaurant_type' .
				' FROM restaurant' .
				' LEFT JOIN restaurant_chain' .
				' ON restaurant.restaurant_chain_id = restaurant_chain.restaurant_chain_id' .
				' LEFT JOIN company' .
				' ON restaurant.company_id = company.company_id' . 
				' LEFT JOIN restaurant_type' .
				' ON restaurant.restaurant_type_id = restaurant_type.restaurant_type_id';
						
		$base_query_count = 'SELECT count(*) AS num_records' .
				' FROM restaurant, restaurant_type';
				
		$where = ' WHERE restaurant.restaurant_type_id = restaurant_type.restaurant_type_id';
		
		
		
		
		
		/*
		if ( count($arrRestaurantTypeId) > 0  || count($arrCuisineId) > 0 ) {
			$where .= ' AND (';
			
			if(count($arrRestaurantTypeId) > 0 ) {
				$where .= ' restaurant.restaurant_type_id IN (' . implode(',', $arrRestaurantTypeId) . ')';
			}
			
			
			if(count($arrCuisineId) > 0 ) {
			 		// Cuisine 
				if(count($arrRestaurantTypeId) > 0 ) {
					$where	.= ' OR ( ';
				} else {
					$where	.= ' ( ';
				}
				
			$where	.= '		SELECT restaurant_cuisine.restaurant_cuisine_id ' 
					. '			FROM restaurant_cuisine' 
					. '			WHERE' 
					. '				restaurant_cuisine.restaurant_id = restaurant.restaurant_id'
					. ' 			AND restaurant_cuisine.cuisine_id IN (' . implode(',', $arrCuisineId) . ')'
					. '				LIMIT 0, 1'
					. '		)';
			 }
			
			$where .= ' )';
		}
		*/
		if ( !empty($q) ) {
			
			$where .= ' AND (restaurant.restaurant_name like "%' .$q . '%"'
					. ' OR restaurant.restaurant_id like "%' . $q . '%"'
					. ' OR restaurant_type.restaurant_type like "%' . $q . '%"';
			
			$where .= ' OR (';
			$where	.= '		SELECT address.address_id' 
					. '			from address, state, country'
					. '			WHERE' 
					. '				address.restaurant_id = restaurant.restaurant_id'
					. '				AND address.state_id = state.state_id'
					. '				AND address.country_id = country.country_id'
					. ' 			AND (';
			$where	.= '					address.zipcode = "' . $q . '"'
					. '						OR address.address like "%' . $q . '%"'
					. '						OR address.city like "%' . $q . '%"'
					. '						OR address.zipcode like "%' . $q . '%"'
					. '						OR state.state_name like "%' . $q . '%"'
					. '						OR state.state_code like "%' . $q . '%"'
					. '						OR country.country_name like "%' . $q . '%"'
					. '				)'
					. '				LIMIT 0, 1'
					. '		)';
			
			$where .= ' )';
		}
		
		
		$base_query_count = $base_query_count . $where;
		
		
		
		//$query = $base_query_count . " ORDER BY restaurant_name ";
		$query = $base_query_count;
		
		$result = $this->db->query($query);
		$row = $result->row();
		$numResults = $row->num_records;
		
		$query = $base_query . $where;
		
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
			$this->RestaurantLib->restaurantChain = $row['restaurant_chain'];
			$this->RestaurantLib->companyName = $row['company_name'];
			
			$this->RestaurantLib->creationDate = $row['creation_date'];
			/*
			$CI->load->model('AddressModel','',true);
			$addresses = $CI->AddressModel->getAddressForCompany( $row['restaurant_id'], '', '', '', $q, '');
			$this->RestaurantLib->addresses = $addresses;
			
			
			$cuisines = $this->getCuisinesForRestaurant( $row['restaurant_id']);
			$this->RestaurantLib->cuisines = $cuisines;
			
			
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
			*/
			
			if ( $row['restaurant_chain_id'] ) {
				$CI->load->model('SupplierModel','',true);
				$suppliers = $CI->SupplierModel->getSupplierForCompany( '', '', '', '', $row['restaurant_chain_id'] );
				$this->RestaurantLib->suppliers = $suppliers;
				$this->RestaurantLib->suppliersFrom = 'restaurantChain';
			} else {
				$CI->load->model('SupplierModel','',true);
				$suppliers = $CI->SupplierModel->getSupplierForCompany( $row['restaurant_id'], '', '', '', '' );
				$this->RestaurantLib->suppliers = $suppliers;
				$this->RestaurantLib->suppliersFrom = 'restaurant';
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
		
		if ($numResults == 0) {
			$mapZoomLevel = $DEFAULT_ZOOM_LEVEL;
		}
		
		$params = requestToParams($numResults, $start, $totalPages, $first, $last, $page, $sort, $order, $q, '', $mapZoomLevel);
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
	
	function getCuisinesForRestaurant($restaurantId) {
		$cuisines = array();
		
		$query = "SELECT restaurant_cuisine.*, cuisine.cuisine_name" .
				" FROM restaurant_cuisine, cuisine" .
				" WHERE " .
				" restaurant_cuisine.restaurant_id = " . $restaurantId .
				" AND restaurant_cuisine.cuisine_id = cuisine.cuisine_id" .
				" ORDER BY cuisine_name";
		
		log_message('debug', "RestaurantModel.getCuisinesForRestaurant : " . $query);
		$result = $this->db->query($query);
		
		foreach ($result->result_array() as $row) {
			
			$this->load->library('CuisineLib');
			unset($this->cuisineLib);
			
			$this->cuisineLib->cuisineId = $row['cuisine_id'];
			$this->cuisineLib->cuisine = $row['cuisine_name'];
			
			$cuisines[] = $this->cuisineLib;
			unset($this->cuisineLib);
		}
		
		return $cuisines;
	}
	
	function getCuisineIdsForRestaurant($restaurantId) {
		$cuisines = array();
		
		$query = "SELECT restaurant_cuisine.*" .
				" FROM restaurant_cuisine" .
				" WHERE " .
				" restaurant_cuisine.restaurant_id = " . $restaurantId;
		
		log_message('debug', "RestaurantModel.getCuisineIdsForRestaurant : " . $query);
		$result = $this->db->query($query);
		
		foreach ($result->result_array() as $row) {
			$cuisines[] = $row['cuisine_id'];
		}
		
		return $cuisines;
	}
	
	// Input the data from the controller
	function addRestaurant() {
		global $ACTIVITY_LEVEL_DB;
		
		
		$return = true;
		
		$companyId = $this->input->post('companyId');
		$restaurantName = $this->input->post('restaurantName');
		
		$CI =& get_instance();
		
		//echo "Company Id:" . $companyId . ":Name:" . $restaurantName . ":";
		
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
			
			$query = "SELECT * FROM restaurant WHERE restaurant_name = \"" . $restaurantName . "\" AND company_id = '" . $companyId . "'";
			log_message('debug', 'RestaurantModel.addRestaurant : Try to get duplicate Restaurant record : ' . $query);
			
			$result = $this->db->query($query);
			
			if ($result->num_rows() == 0) {
				$query = "INSERT INTO restaurant (restaurant_id, company_id, restaurant_chain_id, restaurant_type_id, restaurant_name, creation_date, custom_url, phone, fax, email, url, is_active)" .
						" values (NULL, ".$companyId.", " . $this->input->post('restaurantChainId') . ", " . $this->input->post('restaurantTypeId') . ", \"" . $restaurantName . "\", NOW(), '" . $this->input->post('customUrl') . "', '" . $this->input->post('phone') . "', '" . $this->input->post('fax') . "', '" . $this->input->post('email') . "', '" . $this->input->post('url') . "', '" . $ACTIVITY_LEVEL_DB[$this->input->post('isActive')] . "' )";
				
				log_message('debug', 'RestaurantModel.addRestaurant : Insert Restaurant : ' . $query);
				$return = true;
				
				if ( $this->db->query($query) ) {
					$newRestaurantId = $this->db->insert_id();
					
					$arrCuisineId = explode(',', $this->input->post('cuisineId'));
					
					
					for($i = 0; $i < count($arrCuisineId); $i++) {
						$query = "INSERT INTO restaurant_cuisine (restaurant_cuisine_id, restaurant_id, cuisine_id)" .
						" values (NULL, " . $newRestaurantId . ", " . $arrCuisineId[$i] . " )";
						
						if ( mysql_query($query) ) {
							$restaurantCuisineId = mysql_insert_id();
						}
					}
					
					
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
		//$query = "SELECT * FROM restaurant WHERE restaurant_id = " . $restaurantId;
		$query = "SELECT restaurant.*, restaurant_chain.restaurant_chain, company.company_name" .
				" FROM restaurant" .
				" LEFT JOIN restaurant_chain" .
				" ON restaurant.restaurant_chain_id = restaurant_chain.restaurant_chain_id" .
				" LEFT JOIN company" .
				" ON restaurant.company_id = company.company_id" .
				" WHERE restaurant.restaurant_id = " . $restaurantId;
		
		log_message('debug', "RestaurantModel.getRestaurantFromId : " . $query);
		$result = $this->db->query($query);
		
		$restaurant = array();
		
		$this->load->library('RestaurantLib');
		
		$row = $result->row();
		
		$this->restaurantLib->restaurantId = $row->restaurant_id;
		$this->restaurantLib->companyId = $row->company_id;
		$this->restaurantLib->companyName = $row->company_name;
		$this->restaurantLib->restaurantChainId = $row->restaurant_chain_id;
		$this->restaurantLib->restaurantChain = $row->restaurant_chain;
		$this->restaurantLib->restaurantTypeId = $row->restaurant_type_id;
		$this->restaurantLib->restaurantName = $row->restaurant_name;
		$this->restaurantLib->customURL = $row->custom_url;
		$this->restaurantLib->phone = $row->phone;
		$this->restaurantLib->fax = $row->fax;
		$this->restaurantLib->email = $row->email;
		$this->restaurantLib->restaurantURL = $row->url;
		$this->restaurantLib->isActive = $row->is_active;
		
		$cuisines = $this->getCuisineIdsForRestaurant( $row->restaurant_id);
		$this->restaurantLib->cuisines = $cuisines;
		
		return $this->restaurantLib;
	}
	
	
	// Pulls the data from the database for a specific restaurant
	function getRestaurantChainFromId($restaurantChainId) {
		
		
		$query = "SELECT * FROM restaurant_chain WHERE restaurant_chain_id = " . $restaurantChainId;
		
		log_message('debug', "RestaurantModel.getRestaurantChainFromId : " . $query);
		$result = $this->db->query($query);
		
		$restaurant = array();
		
		$this->load->library('RestaurantChainLib');
		
		$row = $result->row();
		
		$this->restaurantChainLib->restaurantChainId = $row->restaurant_chain_id;
		$this->restaurantChainLib->restaurantChain = $row->restaurant_chain;
		
		return $this->restaurantChainLib;
	}
	
	
	// Update the restaurant in the database with new information
	function updateRestaurant() {
		global $ACTIVITY_LEVEL_DB;
		$return = true;
		
		$query = "SELECT * FROM restaurant WHERE restaurant_name = \"" . $this->input->post('restaurantName') . "\" AND restaurant_id <> " . $this->input->post('restaurantId');
		log_message('debug', 'RestaurantModel.updateRestaurant : Try to get Duplicate record : ' . $query);
			
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			$restaurantChainId = $this->input->post('restaurantChainId');
			$data = array(
						'restaurant_name' => $this->input->post('restaurantName'), 
						'custom_url' => $this->input->post('customUrl'),
						'company_id' => $this->input->post('companyId'),
						'restaurant_chain_id' => ( !empty($restaurantChainId) ? $restaurantChainId : NULL ) ,
						'restaurant_type_id' => $this->input->post('restaurantTypeId'),
						'phone' => $this->input->post('phone'),
						'fax' => $this->input->post('fax'),
						'email' => $this->input->post('email'),
						'url' => $this->input->post('url'),
						//'cuisine_id' => $this->input->post('cuisineId'),
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
				$query = "SELECT * FROM restaurant WHERE restaurant_name = \"" . $restaurantName . "\" AND company_id = '" . $companyId . "'";
				log_message('debug', 'RestaurantModel.addRestaurant : Try to get duplicate Restaurant record : ' . $query);
				
				$result = $this->db->query($query);
				
				if ($result->num_rows() == 0) {
					$query = "INSERT INTO restaurant (restaurant_id, company_id, restaurant_type_id, restaurant_name, creation_date, custom_url, is_active)" .
							" values (NULL, ".$companyId.", NULL, \"" . $restaurantName . "\", NOW(), NULL, '" . $ACTIVITY_LEVEL_DB['active'] . "' )";
					
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
	
	function getDistinctUsedRestaurantType($c)
	{
		$query = "SELECT DISTINCT restaurant.restaurant_type_id, restaurant_type.restaurant_type
					FROM restaurant, restaurant_type
					WHERE restaurant.restaurant_type_id = restaurant_type.restaurant_type_id LIMIT 0, $c";
		
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
	
	function getDistinctUsedCuisine($c)
	{
		$query = "SELECT DISTINCT restaurant_cuisine.cuisine_id, cuisine.cuisine_name
					FROM restaurant_cuisine, cuisine
					WHERE restaurant_cuisine.cuisine_id = cuisine.cuisine_id LIMIT 0, $c";
		
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
	
	// Pulls all the products owned by a restaurant
	function getRestaurantMenu($restaurantId) {
		$query = "SELECT * FROM product WHERE restaurant_id = " . $restaurantId;
		
		log_message('debug', "RestaurantModel.getRestaurantMenu : " . $query);
		$result = $this->db->query($query);
		
		$menu = array();
		
		foreach ($result->result_array() as $row) {
			
			$this->load->library('ProductLib');
			unset($this->productLib);
			
			$this->productLib->productId = $row['product_id'];
			$this->productLib->productName = $row['product_name'];
			$this->productLib->ingredient = $row['ingredient_text'];
			
			$menu[] = $this->productLib;
			unset($this->productLib);
		}
		return $menu;
	}
	
}



?>