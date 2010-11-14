<?php

class FarmModel extends Model{
	
	// list new farms
	function listNewFarms()
	{
		$query = "SELECT farm.* " .
				" FROM farm " .
				" ORDER BY farm_id DESC LIMIT 5";
		
		log_message('debug', "FarmModel.listNewFarms : " . $query);
		$result = $this->db->query($query);
		
		$farms = array();
		$CI =& get_instance();
		foreach ($result->result_array() as $row) {
			
			$this->load->library('FarmLib');
			unset($this->FarmLib);
			
			$this->FarmLib->farmId = $row['farm_id'];
			$this->FarmLib->farmName = $row['farm_name'];
			
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
				$query = "INSERT INTO farm (farm_id, company_id, farm_type_id, farmer_type, farm_name, creation_date, custom_url, url, status, track_ip, user_id, facebook, twitter)" .
						" values (NULL, ".$companyId.", " . $this->input->post('farmTypeId') . ", '" . $this->input->post('farmerType') . "', \"" . $farmName . "\", NOW(), '" . $this->input->post('customUrl') . "', '" . $this->input->post('url') . "', '" . $this->input->post('status') . "', '" . getRealIpAddr() . "', " . $this->session->userdata['userId'] . ", '" . $this->input->post('facebook') . "', '" . $this->input->post('twitter') . "' )";
				
				log_message('debug', 'FarmModel.addFarm : Insert Farm : ' . $query);
				$return = true;
				
				if ( $this->db->query($query) ) {
					$newFarmId = $this->db->insert_id();
					
					$CI->load->model('AddressModel','',true);
					$address = $CI->AddressModel->addAddress('', $newFarmId, '', '', '', $companyId);
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
		
		$query = "SELECT farm.*, company.company_name, farm_type.farm_type " .
				" FROM farm, company, farm_type " .
				" WHERE farm.farm_id = " . $farmId . 
				" AND farm.company_id = company.company_id" .
				" AND farm.farm_type_id = farm_type.farm_type_id ";
		log_message('debug', "FarmModel.getFarmFromId : " . $query);
		$result = $this->db->query($query);
		
		$this->load->library('FarmLib');
		
		$row = $result->row();
		
		if ($row) {
			$geocodeArray = array();
		
			$this->FarmLib->farmId = $row->farm_id;
			$this->FarmLib->companyId = $row->company_id;
			$this->FarmLib->companyName = $row->company_name;
			$this->FarmLib->farmTypeId = $row->farm_type_id;
			$this->FarmLib->farmType = $row->farm_type;
			$this->FarmLib->farmerType = $row->farmer_type;
			$this->FarmLib->farmName = $row->farm_name;
			$this->FarmLib->customUrl = $row->custom_url;
			$this->FarmLib->url = $row->url;
			$this->FarmLib->facebook = $row->facebook;
			$this->FarmLib->twitter = $row->twitter;
			$this->FarmLib->status = $row->status;
			
			$CI =& get_instance();
			
			$CI->load->model('AddressModel','',true);
			$addresses = $CI->AddressModel->getAddressForCompany( '', $row->farm_id, '', '', '', '', '', '');
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
						'facebook' => $this->input->post('facebook'),
						'twitter' => $this->input->post('twitter'),
						'status' => $this->input->post('status'),
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
				log_message('debug', 'FarmModel.addFarmWithNameOnly : Try to get duplicate Farm record : ' . $query);
				
				$result = $this->db->query($query);
				
				if ($result->num_rows() == 0) {
					$query = "INSERT INTO farm (farm_id, company_id, farm_type_id, farm_name, creation_date, custom_url, status, track_ip)" .
							" values (NULL, ".$companyId.", NULL, \"" . $farmName . "\", NOW(), NULL, 'live', '" . getRealIpAddr() . "' )";
					
					log_message('debug', 'FarmModel.addFarmWithNameOnly : Insert Farm : ' . $query);
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
		
		if (! empty ($q) ) {
		$where .= ' AND (' 
				. '	farm.farm_name like "%' .$q . '%"'
				. ' OR farm.farm_id like "%' . $q . '%"'
				. ' OR farm_type.farm_type like "%' . $q . '%"'		
				. ' )';
		}
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
			$suppliers = $CI->SupplierModel->getSupplierForCompany( '', $row['farm_id'], '', '', '', '');
			$this->FarmLib->suppliers = $suppliers;
			
			$CI->load->model('AddressModel','',true);
			$addresses = $CI->AddressModel->getAddressForCompany( '', $row['farm_id'], '', '', '', '', '', '');
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
	
	function getFarmsJson() {
		global $PER_PAGE, $FARM_DEFAULT_RADIUS, 
		$DEFAULT_ZOOM_LEVEL, $ZIPCODE_ZOOM_LEVEL, $CITY_ZOOM_LEVEL, $FARM_ZOOM_LEVEL;
		
		$CI =& get_instance();
		
		$p = $this->input->post('p'); // Page
		$pp = $this->input->post('pp'); // Per Page
		$sort = $this->input->post('sort');
		$order = $this->input->post('order');
		$filter = $this->input->post('f');
		$radius = $this->input->post('r');
		
		if (empty  ($radius) ) {
			$radius = $FARM_DEFAULT_RADIUS;
		}
		
		//$filter = 'r_10,c_6';
		
		$arr_filter = explode(',', $filter);
		
		$arrFarmTypeId = array();
		//$arrCuisineId = array();
		
		foreach($arr_filter as $key => $value) {
			$arr_value = explode('_', $value) ;
			
			if ($arr_value[0] == 'f') {
				$arrFarmTypeId[] = $arr_value[1];
			}
		}
		
		$q = $this->input->post('q');
		//$q = '80301';
		//$filter = 'c_7';
		
		if ($q == '0') {
			$q = '';
		}
		
		$mapZoomLevel = $DEFAULT_ZOOM_LEVEL;
		
		if ($q == '') {
			if (isset ($_COOKIE['seachedZip']) && !empty($_COOKIE['seachedZip']) ) {
				$q = $_COOKIE['seachedZip'];
				$mapZoomLevel = $FARM_ZOOM_LEVEL;
			} else {
				if ($this->session->userdata('isAuthenticated') == 1 ) { // Authenticated
					$q = $this->session->userdata['zipcode'];
					$mapZoomLevel = $FARM_ZOOM_LEVEL;
					setcookie('seachedZip', $q, time()+60*60*24*30*365);
				}
			}
		} else {
			setcookie('seachedZip', $q, time()+60*60*24*30*365);
			$mapZoomLevel = $FARM_ZOOM_LEVEL;
		}
		
		$latLng = array();
		if (! empty ($q) ) {
			$CI->load->model('ZipcodeModel','',true);
			$latLng = $CI->ZipcodeModel->getCoordinatesFromZipcode($q);
			
			if ( ! $latLng) {
				
				$address = $q. ', USA';
				$CI->load->model('GoogleMapModel','',true);
				$latLng = $CI->GoogleMapModel->geoCodeAddressV3($address);
				
				if ( $latLng ) {
					$CI->ZipcodeModel->addZipcode($q, $latLng);
				}
			}
		}
		
		$start = 0;
	
		$page = 0;
		
		$base_query = 'SELECT farm.*, farm_type.farm_type' .
				' FROM farm, farm_type';
		
		$base_query_count = 'SELECT count(*) AS num_records' .
				' FROM farm, farm_type';
		

		$where = ' WHERE farm.farm_type_id = farm_type.farm_type_id ' .
				' AND farm.status = \'live\' ';

		//if ( count($arrFarmTypeId) > 0  || count($arrCuisineId) > 0 ) {
		if ( count($arrFarmTypeId) > 0 ) {
			$where .= ' AND (';
			
			if(count($arrFarmTypeId) > 0 ) {
				$where .= ' farm.farm_type_id IN (' . implode(',', $arrFarmTypeId) . ')';
			}
			
			$where .= ' )';
		}
		
		
		//if ( !empty($q) || !empty($city) ) {
		if ( $latLng ) {
			//$latLng = array();
			if (!empty($where) ) {
				$where .= ' AND (';  
			} else {
				$where .= ' WHERE (';
			}

			$where	.= '		SELECT ';
			if (count($latLng) > 0 ) {
				$where .= ' 			( 3959 * acos( cos( radians(' . $latLng['latitude'] . ') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(' . $latLng['longitude'] . ') ) + sin( radians(' . $latLng['latitude'] . ') ) * sin( radians( latitude ) ) ) ) AS distance ';
			} else if ( !empty($q) ) {
				$where	.= '		address.address_id';
			}
					/*
					$where	.=  '	from address, state, country'
					. '			WHERE' 
					. '				address.farm_id = farm.farm_id'
					. '				AND address.state_id = state.state_id'
					. '				AND address.country_id = country.country_id';
					*/
					
					$where	.=  '	from address'
					. '			WHERE' 
					. '				address.farm_id = farm.farm_id';
					
				if (count($latLng) > 0 ) {
					$where	.= ' 			HAVING ( distance <= ' . $radius . ') ';
				} else if ( !empty($q) ) {
					$where	.= ' 			AND ( address.zipcode = "' . $q . '") ';
				} 

			$where	.= '				LIMIT 0, 1'
					. '		)';
			
		}
		
		$base_query_count = $base_query_count . $where;
		
		
		//$query = $base_query_count . " ORDER BY restaurant_name ";
		$query = $base_query_count;
		//die($query);
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
		
		$geocodeArray = array();
		foreach ($result->result_array() as $row) {
			
			
			$this->load->library('FarmLib');
			unset($this->FarmLib);
			
			$this->FarmLib->farmId = $row['farm_id'];
			$this->FarmLib->farmName = $row['farm_name'];
			$this->FarmLib->farmType = $row['farm_type'];
			
			$this->FarmLib->creationDate = $row['creation_date'];
			
			$CI->load->model('AddressModel','',true);
			//$addresses = $CI->AddressModel->getAddressForCompany( '', $row['farm_id'], '', '', '', $q, $city, '');
			$addresses = $CI->AddressModel->getAddressForCompany( '', $row['farm_id'], '', '', '', '', '', '');
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
		
		$params = requestToParams3($numResults, $start, $totalPages, $first, $last, $page, $sort, $order, $q, $filter, $mapZoomLevel, $radius);
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
	
	function getQueueFarmsJson() {
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
		
		
		$base_query = 'SELECT farm.*, farm_type.farm_type, user.email, user.first_name' .
				' FROM farm, farm_type, user';
		
		$base_query_count = 'SELECT count(*) AS num_records' .
				' FROM farm, farm_type, user';
		
		$where = ' WHERE farm.farm_type_id = farm_type.farm_type_id' .
				' AND farm.user_id = user.user_id ' .
				' AND farm.status = \'queue\' ';
		
		if (!empty ($q) ) {
			$where .= ' AND (' 
					. '	farm.farm_name like "%' .$q . '%"'
					. ' OR farm.farm_id like "%' . $q . '%"'
					. ' OR farm_type.farm_type like "%' . $q . '%"';		
			$where .= ' )';
		}
		
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
		
		log_message('debug', "FarmModel.getQueueFarmsJson : " . $query);
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
			$this->FarmLib->userId = $row['user_id'];
			$this->FarmLib->email = $row['email'];
			$this->FarmLib->ip = $row['track_ip'];
			$this->FarmLib->dateAdded = date ("Y-m-d", strtotime($row['creation_date']) ) ;
			
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
	
}

?>