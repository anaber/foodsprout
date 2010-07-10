<?php

class FarmModel extends Model{
	
	// Create a simple list of all the farms
	function listFarm()
	{
		$query = "SELECT farm.* " .
				" FROM farm " .
				" ORDER BY farm_name";
		
		log_message('debug', "FarmModel.listFarm : " . $query);
		$result = $this->db->query($query);
		
		$farms = array();
		$CI =& get_instance();
		foreach ($result->result_array() as $row) {
			
			$this->load->library('FarmLib');
			unset($this->FarmLib);
			
			$this->FarmLib->farmId = $row['farm_id'];
			$this->FarmLib->farmName = $row['farm_name'];
			$this->FarmLib->farmerType = $row['farmer_type'];
			$this->FarmLib->creationDate = $row['creation_date'];
			
			$CI->load->model('AddressModel','',true);
			$addresses = $CI->AddressModel->getAddressForCompany( '', $row['farm_id'], '', '', '', '' );
			$this->FarmLib->addresses = $addresses;
			
			$CI->load->model('SupplierModel','',true);
			$suppliers = $CI->SupplierModel->getSupplierForCompany( '', $row['farm_id'], '', '', '' );
			$this->FarmLib->suppliers = $suppliers;
			
			$farms[] = $this->FarmLib;
			unset($this->FarmLib);
		}
		
		return $farms;
	}
	
	// Insert the new farm data into the database
	function addFarm() {
		global $ACTIVITY_LEVEL_DB;
		
		$return = true;
		
		$companyId = $this->input->post('companyId');
		$farmName = $this->input->post('farmName');
		
		$CI =& get_instance();
		
		if (empty($companyId) && empty($farmName) ) {
			$GLOBALS['error'] = 'no_name';
			$return = false;
		} else {
			if ( empty($companyId) ) {
				// Enter manufacture into company
				$CI->load->model('CompanyModel','',true);
				$companyId = $CI->CompanyModel->addCompany($this->input->post('farmName'));
			} else {
				if (empty($farmName) ) {
					// Consider company name as manufacture name
					$CI->load->model('CompanyModel','',true);
					$company = $CI->CompanyModel->getCompanyFromId($companyId);
					$farmName = $company->companyName;
				}
			}
			
			$query = "SELECT * FROM farm WHERE farm_name = \"" . $farmName . "\"";
			log_message('debug', 'FarmModel.addFarm : Try to get duplicate Farm record : ' . $query);
			
			$result = $this->db->query($query);
			
			if ($result->num_rows() == 0) {
				$query = "INSERT INTO farm (farm_id, company_id, farm_type_id, farmer_type, farm_name, creation_date, custom_url, url, is_active)" .
						" values (NULL, ".$companyId.", " . $this->input->post('farmTypeId') . ", '" . $this->input->post('farmerType') . "', \"" . $farmName . "\", NOW(), '" . $this->input->post('customUrl') . "', '" . $this->input->post('url') . "', '" . $ACTIVITY_LEVEL_DB[$this->input->post('isActive')] . "' )";
				
				log_message('debug', 'FarmModel.addManufacture : Insert Farm : ' . $query);
				$return = true;
				
				if ( $this->db->query($query) ) {
					$newFarmId = $this->db->insert_id();
					
					$CI->load->model('AddressModel','',true);
					$address = $CI->AddressModel->addAddress('', $newFarmId, '', '', $companyId);
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
	
	// Get all the information about one specific farm from an ID
	function getFarmFromId($farmId) {
		
		//$query = "SELECT manufacture.*, address.* FROM manufacture, address WHERE manufacture.manufacture_id = address.manufacture_id AND manufacture.manufacture_id = " . $manufactureId;
		$query = "SELECT farm.*, company.company_name, farm_type.farm_type " .
				" FROM farm, company, farm_type " .
				" WHERE farm.farm_id = " . $farmId . 
				" AND farm.company_id = company.company_id" .
				" AND farm.farm_type_id = farm_type.farm_type_id ";
		log_message('debug', "FarmModel.getFarmFromId : " . $query);
		$result = $this->db->query($query);
		
		$this->load->library('FarmLib');
		
		$row = $result->row();
		
		$geocodeArray = array();
		
		if ($row) {
			$this->FarmLib->farmId = $row->farm_id;
			$this->FarmLib->companyId = $row->company_id;
			$this->FarmLib->companyName = $row->company_name;
			$this->FarmLib->farmTypeId = $row->farm_type_id;
			$this->FarmLib->farmType = $row->farm_type;
			$this->FarmLib->farmerType = $row->farmer_type;
			$this->FarmLib->farmName = $row->farm_name;
			$this->FarmLib->customUrl = $row->custom_url;
			$this->FarmLib->url = $row->url;
			$this->FarmLib->isActive = $row->is_active;
			
			
			$CI =& get_instance();
			
			$CI->load->model('AddressModel','',true);
			$addresses = $CI->AddressModel->getAddressForCompany( '', $row->farm_id, '', '', '', '');
			$this->FarmLib->addresses = $addresses;
			
			foreach ($addresses as $key => $address) {
				$arrLatLng = array();
				
				$arrLatLng['latitude'] = $address->latitude;
				$arrLatLng['longitude'] = $address->longitude;
				$arrLatLng['address'] = $address->completeAddress;
				
				$arrLatLng['addressLine1'] = $address->address;
				$arrLatLng['addressLine2'] = $address->city . ' ' . $address->state;
				$arrLatLng['addressLine3'] = $address->country . ' ' . $address->zipcode;
				
				$arrLatLng['farmName'] = $this->FarmLib->farmName;
				$arrLatLng['id'] = $address->addressId;
				$geocodeArray[] = $arrLatLng;
			}
			$this->FarmLib->param->numResults = 2;
			$this->FarmLib->geocode = $geocodeArray;
			
			return $this->FarmLib;
		} else {
			return;
		}
	}
	
	function updateFarm() {
		global $ACTIVITY_LEVEL_DB;
		$return = true;
		
		$query = "SELECT * FROM farm WHERE farm_name = \"" . $this->input->post('farmName') . "\" AND farm_id <> " . $this->input->post('farmId');
		log_message('debug', 'FarmModel.updateFarm : Try to get Duplicate record : ' . $query);
		
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$data = array(
						'company_id' => $this->input->post('companyId'), 
						'farm_name' => $this->input->post('farmName'),
						'custom_url' => $this->input->post('customUrl'),
						'url' => $this->input->post('url'),
						'farm_type_id' => $this->input->post('farmTypeId'),
						'farmer_type' => $this->input->post('farmerType'),
						'is_active' => $ACTIVITY_LEVEL_DB[$this->input->post('isActive')],
					);
			$where = "farm_id = " . $this->input->post('farmId');
			$query = $this->db->update_string('farm', $data, $where);
			
			log_message('debug', 'FarmModel.updateFarm : ' . $query);
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
	
	function addFarmWithNameOnly($farmName) {
		global $ACTIVITY_LEVEL_DB;
		
		$return = true;
		
		$companyId = '';
		
		$CI =& get_instance();
		
		if (empty($companyId) && empty($farmName) ) {
			$GLOBALS['error'] = 'no_name';
			$return = false;
		} else {
			if ( empty($companyId) ) {
				$CI->load->model('CompanyModel','',true);
				$companyId = $CI->CompanyModel->addCompany($farmName);
			} 
			
			if ($companyId) {
				$query = "SELECT * FROM farm WHERE farm_name = \"" . $farmName . "\" AND company_id = '" . $companyId . "'";
				log_message('debug', 'FarmModel.addFarm : Try to get duplicate Farm record : ' . $query);
				
				$result = $this->db->query($query);
				
				if ($result->num_rows() == 0) {
					$query = "INSERT INTO farm (farm_id, company_id, farm_type_id, farm_name, creation_date, custom_url, is_active)" .
							" values (NULL, ".$companyId.", NULL, \"" . $farmName . "\", NOW(), NULL, '" . $ACTIVITY_LEVEL_DB['active'] . "' )";
					
					log_message('debug', 'FarmModel.addFarm : Insert Farm : ' . $query);
					$return = true;
					
					if ( $this->db->query($query) ) {
						$newFarmId = $this->db->insert_id();
						$return = $newFarmId;
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
	
	function getFarmsJsonAdmin() {
		global $PER_PAGE, $FARMER_TYPES;
		
		$p = $this->input->post('p'); // Page
		$pp = $this->input->post('pp'); // Per Page
		$sort = $this->input->post('sort');
		$order = $this->input->post('order');
		
		$q = $this->input->post('q');
		
		if ($q == '0') {
			$q = '';
		}
		
		$start = 0;
		$page = 0;
		
		
		$base_query = 'SELECT farm.*, farm_type.farm_type' .
				' FROM farm, farm_type';
		
		$base_query_count = 'SELECT count(*) AS num_records' .
				' FROM farm, farm_type';
		
		$where = ' WHERE farm.farm_type_id = farm_type.farm_type_id';
		
		$where .= ' AND (' 
				. '	farm.farm_name like "%' .$q . '%"'
				. ' OR farm.farm_id like "%' . $q . '%"'
				. ' OR farm_type.farm_type like "%' . $q . '%"';		
		$where .= ' )';
		
		$base_query_count = $base_query_count . $where;
		
		$query = $base_query_count;
		
		$result = $this->db->query($query);
		$row = $result->row();
		$numResults = $row->num_records;
		
		$query = $base_query . $where;
		
		if ( empty($sort) ) {
			$sort_query = ' ORDER BY farm_name';
			$sort = 'farm_name';
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
		
		log_message('debug', "FarmModel.getFarmsJsonAdmin : " . $query);
		$result = $this->db->query($query);
		
		$farms = array();
		
		$CI =& get_instance();
		
		$geocodeArray = array();
		foreach ($result->result_array() as $row) {
			
			$this->load->library('FarmLib');
			unset($this->FarmLib);
			
			$this->FarmLib->farmId = $row['farm_id'];
			$this->FarmLib->farmName = $row['farm_name'];
			$this->FarmLib->farmTypeId = $row['farm_type_id'];
			$this->FarmLib->farmType = $row['farm_type'];
			$this->FarmLib->farmerType = ( !empty($row['farmer_type']) ? $FARMER_TYPES[$row['farmer_type']] : '');
			
			$CI->load->model('SupplierModel','',true);
			$suppliers = $CI->SupplierModel->getSupplierForCompany( '', $row['farm_id'], '', '', '');
			$this->FarmLib->suppliers = $suppliers;
			
			$CI->load->model('AddressModel','',true);
			$addresses = $CI->AddressModel->getAddressForCompany( '', $row['farm_id'], '', '', '', '');
			$this->FarmLib->addresses = $addresses;
			
			$farms[] = $this->FarmLib;
			unset($this->FarmLib);
		}
		
		if (!empty($pp) && $pp == 'all') {
			$PER_PAGE = $numResults;
		}
		
		$totalPages = ceil($numResults/$PER_PAGE);
		$first = 0;
		$last = $totalPages - 1;
		
		
		$params = requestToParams($numResults, $start, $totalPages, $first, $last, $page, $sort, $order, $q, '', '');
		$arr = array(
			'results'    => $farms,
			'param'      => $params,
			'geocode'	 => $geocodeArray,
	    );
	    
	    return $arr;
	}
	
	function getFarmssJson() {
		global $PER_PAGE, $DEFAULT_ZOOM_LEVEL, $ZIPCODE_ZOOM_LEVEL, $CITY_ZOOM_LEVEL;
		
		$p = $this->input->post('p'); // Page
		$pp = $this->input->post('pp'); // Per Page
		$sort = $this->input->post('sort');
		$order = $this->input->post('order');
		$filter = $this->input->post('f');
		
		//$filter = 'r_10,c_6';
		
		
		//echo $filter;
		$arr_filter = explode(',', $filter);
		
		$arrFarmTypeId = array();
		//$arrCuisineId = array();
		
		foreach($arr_filter as $key => $value) {
			$arr_value = explode('_', $value) ;
			
			if ($arr_value[0] == 'f') {
				$arrFarmTypeId[] = $arr_value[1];
			}
			/*
			if ($arr_value[0] == 'c') {
				$arrCuisineId[] = $arr_value[1];
			}
			*/
		}
		
		
		$q = $this->input->post('q');
		//$q = '80301';
		//$filter = 'c_7';
		
		if ($q == '0') {
			$q = '';
		}
		
		$city = '';
		//$city = '41,6009,13721';
		
		$mapZoomLevel = $ZIPCODE_ZOOM_LEVEL;
		
		/*
		$mapZoomLevel = $DEFAULT_ZOOM_LEVEL;
		
		if ($q == '') {
			
			if (isset ($_COOKIE['seachedZip']) && !empty($_COOKIE['seachedZip']) ) {
				$q = $_COOKIE['seachedZip'];
				$mapZoomLevel = $ZIPCODE_ZOOM_LEVEL;
			} else {
				// By default display all restaurants of SFO
				$city = '41,6009,13721';
				$city = '';
				$mapZoomLevel = $CITY_ZOOM_LEVEL;
			}
		} else {
			setcookie('seachedZip', $q, time()+60*60*24*30*365);
			$mapZoomLevel = $ZIPCODE_ZOOM_LEVEL;
		}
		*/
		
		
		$start = 0;
	
		$page = 0;
		
		/*
		$base_query = 'SELECT restaurant.*, restaurant_cuisine.*, cuisine.cuisine_name, restaurant_type.restaurant_type' .
				' FROM restaurant, restaurant_cuisine, cuisine, restaurant_type';
		
		$where = ' WHERE restaurant.restaurant_id = restaurant_cuisine.restaurant_id '
				. ' AND restaurant_cuisine.cuisine_id = cuisine.cuisine_id '
				. ' AND restaurant.restaurant_type_id = restaurant_type.restaurant_type_id';
		*/
		
		$base_query = 'SELECT farm.*, farm_type.farm_type' .
				' FROM farm, farm_type';
		
		$base_query_count = 'SELECT count(*) AS num_records' .
				' FROM farm, farm_type';
		
		
		$where = ' WHERE farm.farm_type_id = farm_type.farm_type_id';
		
		/*
		$where .= 'restaurant.restaurant_name like "%' .$q . '%"'
				. ' OR restaurant.restaurant_id like "%' . $q . '%"';
		*/
		
		//if ( count($arrFarmTypeId) > 0  || count($arrCuisineId) > 0 ) {
		if ( count($arrFarmTypeId) > 0 ) {
			$where .= ' AND (';
			
			if(count($arrFarmTypeId) > 0 ) {
				$where .= ' farm.farm_type_id IN (' . implode(',', $arrFarmTypeId) . ')';
			}
			
			/*
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
			*/
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
					. '				address.farm_id = farm.farm_id'
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
			
		}
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
			$sort_query = ' ORDER BY farm_name';
			$sort = 'farm_name';
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
		
		log_message('debug', "FarmModel.getFarmsJson : " . $query);
		$result = $this->db->query($query);
		
		$farms = array();
		
		$CI =& get_instance();
		
		$geocodeArray = array();
		foreach ($result->result_array() as $row) {
			
			
			$this->load->library('FarmLib');
			unset($this->FarmLib);
			
			$this->FarmLib->farmId = $row['farm_id'];
			$this->FarmLib->farmName = $row['farm_name'];
			$this->FarmLib->farmType = $row['farm_type'];
			
			$this->FarmLib->creationDate = $row['creation_date'];
			
			$CI->load->model('AddressModel','',true);
			//$addresses = $CI->AddressModel->getAddressForCompany( '', $row['farm_id'], '', '', $q, $city);
			$addresses = $CI->AddressModel->getAddressForCompany( '', $row['farm_id'], '', '', '', '');
			$this->FarmLib->addresses = $addresses;
			
			
			//$cuisines = $this->getCuisinesForRestaurant( $row['restaurant_id']);
			//$this->FarmLib->cuisines = $cuisines;
			
			foreach ($addresses as $key => $address) {
				$arrLatLng = array();
				
				$arrLatLng['latitude'] = $address->latitude;
				$arrLatLng['longitude'] = $address->longitude;
				$arrLatLng['address'] = $address->completeAddress;
				
				$arrLatLng['addressLine1'] = $address->address;
				$arrLatLng['addressLine2'] = $address->city . ' ' . $address->state;
				$arrLatLng['addressLine3'] = $address->country . ' ' . $address->zipcode;
				
				$arrLatLng['farmName'] = $this->FarmLib->farmName;
				$arrLatLng['id'] = $address->addressId;
				$geocodeArray[] = $arrLatLng;
			}
			
			
			$farms[] = $this->FarmLib;
			unset($this->FarmLib);
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
			'results'    => $farms,
			'param'      => $params,
			'geocode'	 => $geocodeArray,
	    );
	    //print_r_pre($arr);
		//die;
	    return $arr;
		
	}
	
	function getDistinctUsedFarmType($c)
	{
		$query = "SELECT DISTINCT farm.farm_type_id, farm_type.farm_type
					FROM farm, farm_type
					WHERE farm.farm_type_id = farm_type.farm_type_id LIMIT 0, $c";
		
		log_message('debug', "FarmModel.getDistinctUsedFarmType : " . $query);
		$result = $this->db->query($query);
		
		$farmTypes = array();
		$CI =& get_instance();
		foreach ($result->result_array() as $row) {
			
			$this->load->library('FarmTypeLib');
			unset($this->FarmTypeLib);
			
			$this->FarmTypeLib->farmTypeId = $row['farm_type_id'];
			$this->FarmTypeLib->farmType = $row['farm_type'];
			
			$farmTypes[] = $this->FarmTypeLib;
			unset($this->FarmTypeLib);
		}
		
		return $farmTypes;
	}
	
	
}

?>