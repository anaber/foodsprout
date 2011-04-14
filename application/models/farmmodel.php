<?php

class FarmModel extends Model{
	
	/**
	 * Migration: 		Done
	 * Migration by: 	Deepak
	 */
	// list new farms
	function listNewFarms() {
		$query = "SELECT producer.*, custom_url.custom_url" .
				" FROM producer, custom_url WHERE is_farm = 1 AND custom_url.producer_id=producer.producer_id" .
				" ORDER BY producer.producer_id DESC LIMIT 10";
		
		log_message('debug', "FarmModel.listNewFarms : " . $query);
		$result = $this->db->query($query);
		
		$farms = array();
		$CI =& get_instance();
		foreach ($result->result_array() as $row) {
			
			$this->load->library('FarmLib');
			unset($this->FarmLib);
			
			$this->FarmLib->farmId = $row['producer_id'];
			$this->FarmLib->farmName = $row['producer'];
			$this->FarmLib->customURL = $row['custom_url'];
			
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
/*			if ( empty($companyId) ) {
				// Enter manufacture into company
				//$CI->load->model('CompanyModel','',true);
				//$companyId = $CI->CompanyModel->addCompany($this->input->post('farmName'));
			} else {
				if (empty($farmName) ) {
					// Consider company name as manufacture name
					//$CI->load->model('CompanyModel','',true);
					//$company = $CI->CompanyModel->getCompanyFromId($companyId);
					//$farmName = $company->companyName;
				}
			}
*/			
			$query = "SELECT * FROM producer WHERE producer = \"" . $farmName . "\" AND is_farm = 1";
			log_message('debug', 'FarmModel.addFarm : Try to get duplicate Farm record : ' . $query);
			
			$result = $this->db->query($query);
			
			if ($result->num_rows() == 0) {
				$query = "INSERT INTO producer ( producer, creation_date, custom_url, city_area_id, phone, fax, email, url, status, track_ip, user_id, facebook, twitter, is_farm)" .
						" values ( \"" . $farmName . "\", NOW(), NULL, NULL, '" . $this->input->post('phone') . "', '" . $this->input->post('fax') . "', '" . $this->input->post('email') . "', '" . $this->input->post('url') . "', 'queue', '" . getRealIpAddr() . "', " . $this->session->userdata['userId'] . ", '" . $this->input->post('facebook') . "', '" . $this->input->post('twitter') . "', 1 )";
				
				log_message('debug', 'FarmModel.addFarm : Insert Farm : ' . $query);
				$return = true;
				
				if ( $this->db->query($query) ) {
					$newFarmId = $this->db->insert_id();

					//SAVE FARM TYPE
					$farmTypeId = $this->input->post('farmTypeId');
					if ($farmTypeId) {
						$query = "INSERT INTO producer_category_member (producer_category_member_id, producer_category_id, producer_id, address_id)" .
						" values (NULL, " . $farmTypeId . ", " . $newFarmId . ", NULL )";
	
						$this->db->query($query);
					}
					
					$CI->load->model('AddressModel','',true);
					$addressId = $CI->AddressModel->addAddress($newFarmId);
					
					if ($addressId) {
						$CI->load->model('CustomUrlModel','',true);
						$customUrlId = $CI->CustomUrlModel->generateCustomUrl($addressId);
					}

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
	function getFarmFromId($farmId, $addressId='') {
		/*
		$query = "SELECT producer.*, producer_category.producer_category, producer_category.producer_category_id " .
				" FROM producer, producer_category, producer_category_member " .
				" WHERE producer.producer_id = " . $farmId . 
				" AND producer.producer_id = producer_category_member.producer_id " .
		        " AND producer_category_member.producer_category_id = producer_category.producer_category_id";
		*/
		$query = "SELECT 
					producer.*, producer_category.producer_category, producer_category.producer_category_id
				FROM 
					producer
				LEFT JOIN producer_category_member 
					ON producer.producer_id = producer_category_member.producer_id 
				LEFT JOIN producer_category
					ON producer_category_member.producer_category_id = producer_category.producer_category_id
				WHERE 
					producer.producer_id = " . $farmId;
					
		log_message('debug', "FarmModel.getFarmFromId : " . $query);
		$result = $this->db->query($query);
		
		$this->load->library('FarmLib');
		
		$row = $result->row();
		
		if ($row) {
			$geocodeArray = array();
		
			$this->FarmLib->farmId = $row->producer_id;
			$this->FarmLib->farmTypeId = $row->producer_category_id;
			$this->FarmLib->farmType = $row->producer_category;
			$this->FarmLib->farmName = $row->producer;
			$this->FarmLib->customUrl = $row->custom_url;
			$this->FarmLib->url = $row->url;
			$this->FarmLib->facebook = $row->facebook;
			$this->FarmLib->twitter = $row->twitter;
			$this->FarmLib->status = $row->status;
			
			$CI =& get_instance();
			
			$CI->load->model('AddressModel','',true);
			
			if(isset($addressId) && $addressId !=''){
				$addresses = $CI->AddressModel->getAddressForProducer( $row->producer_id, '', '', '', $addressId);
			}else{
				$addresses = $CI->AddressModel->getAddressForProducer( $row->producer_id, '', '', '');
			}
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
		
		$query = "SELECT * FROM producer WHERE producer = \"" . $this->input->post('farmName') . "\" AND producer_id <> " . $this->input->post('farmId')." AND is_farm = 1";
		log_message('debug', 'FarmModel.updateFarm : Try to get Duplicate record : ' . $query);
		
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$data = array(
						//'company_id' => $this->input->post('companyId'), 
						'producer' => $this->input->post('farmName'),
						'custom_url' => $this->input->post('customUrl'),
						'url' => $this->input->post('url'),
						//'farm_type_id' => $this->input->post('farmTypeId'),
						//'farmer_type' => $this->input->post('farmerType'),
						'facebook' => $this->input->post('facebook'),
						'twitter' => $this->input->post('twitter'),
						'status' => $this->input->post('status')
					);
			$where = "producer_id = " . $this->input->post('farmId');
			$query = $this->db->update_string('producer', $data, $where);
			
			log_message('debug', 'FarmModel.updateFarm : ' . $query);
			if ( $this->db->query($query) ) {
			
				//UPDATE FARM TYPE
				$this->updateFarmType($this->input->post('farmId'), $this->input->post('farmTypeId'));

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
	
	function updateFarmType($farmId, $farmTypeId) {
	
		$query = "SELECT producer_category_id FROM producer_category WHERE producer_category_id IN (SELECT producer_category_id 
				FROM producer_category_member WHERE producer_id=$farmId) AND farm_type_id IS NOT NULL";
		log_message('debug', 'FarmModel.updateFarmType : get existing cuisines : ' . $query);

		$result = $this->db->query($query)->result_array();

		if( !empty($result) ) {
				$oldFarmTypeId = $result[0]['producer_category_id'];
		
			$where = "producer_id = " . $farmId;
	
			if( !empty($oldFarmTypeId) )
				$where .= " AND producer_category_id=".$oldFarmTypeId;
		
			$this->db->update('producer_category_member', array('producer_category_id'=>$farmTypeId), $where);
		}else{
			$data = array(
						'producer_category_id' => $farmTypeId,
						'producer_id' => $farmId
						);
		
			$this->db->insert('producer_category_member', $data);
		}
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
		
		
		$base_query = 'SELECT producer.*,producer_category.producer_category,producer_category.producer_category_id FROM producer
				LEFT JOIN producer_category_member ON producer.producer_id=producer_category_member.producer_id
				LEFT JOIN producer_category ON producer_category_member.producer_category_id=producer_category.producer_category_id';
				 
		$base_query_count = 'SELECT count(*) AS num_records FROM producer';
		
		$where = ' WHERE is_farm = 1';
		
		if ( !empty($q) ) {

			$where  .= ' AND (producer.producer like "%' .$q . '%"'
			. ' OR producer.producer_id like "%' . $q . '%"';
			$where .= ' )';

		}
		
		$query = $base_query_count.$where;
		
		$result = $this->db->query($query);
		$row = $result->row();
		$numResults = $row->num_records;
		
		$query = $base_query . $where;
		
		$query .= " GROUP BY producer_id";
		
		if ( empty($sort) ) {
			$sort_query = ' ORDER BY producer';
			$sort = 'producer';
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
			
			$this->FarmLib->farmId = $row['producer_id'];
			$this->FarmLib->farmName = $row['producer'];
			$this->FarmLib->farmTypeId = $row['producer_category_id'];
			$this->FarmLib->farmType = $row['producer_category'];
			//$this->FarmLib->farmerType = ( !empty($row['farmer_type']) ? $FARMER_TYPES[$row['farmer_type']] : '');
			
			$farms[] = $this->FarmLib;
			unset($this->FarmLib);
		}
		
		if (!empty($pp) && $pp == 'all') {
			$PER_PAGE = $numResults;
		}
		
		$totalPages = ceil($numResults/$PER_PAGE);
		$first = 0;
		if ($totalPages > 0) {
			$last = $totalPages - 1;
		} else {
			$last = 0;
		}
		
		
		$params = requestToParams($numResults, $start, $totalPages, $first, $last, $page, $sort, $order, $q, '', '');
		$arr = array(
			'results'    => $farms,
			'param'      => $params,
			'geocode'	 => $geocodeArray,
	    );
	    
	    return $arr;
	}
	
	function getDistinctUsedFarmType($c) {
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
		
		
		$base_query = 'SELECT producer.*,user.email, user.first_name FROM producer LEFT JOIN user ON producer.user_id=user.user_id';


		$base_query_count = 'SELECT count(*) AS num_records FROM producer LEFT JOIN user ON producer.user_id=user.user_id';

		$where = ' WHERE producer.is_farm=1 ' .
				' AND producer.status = \'queue\' ';

		if ( !empty($q) ) {

			$where .= ' AND (producer.producer like "%' .$q . '%")';

		}

		
		$base_query_count = $base_query_count . $where;
		
		$query = $base_query_count;
		
		$result = $this->db->query($query);
		$row = $result->row();
		$numResults = $row->num_records;
		
		$query = $base_query . $where;
		
		if ( empty($sort) ) {
			$sort_query = ' ORDER BY producer';
			$sort = 'producer';
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
			
			$this->FarmLib->farmId = $row['producer_id'];
			$this->FarmLib->farmName = $row['producer'];
			//$this->FarmLib->farmTypeId = $row['farm_type_id'];
			//$this->FarmLib->farmType = $row['farm_type'];
			//$this->FarmLib->farmerType = ( !empty($row['farmer_type']) ? $FARMER_TYPES[$row['farmer_type']] : '');
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
		if ($totalPages > 0) {
			$last = $totalPages - 1;
		} else {
			$last = 0;
		}
		
		
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
		
		$p = $this->input->post('p');
		if (!$p) {
			$p = $this->input->get('p');
		}
		
		$pp = $this->input->post('pp');
		if (!$pp) {
			$pp = $this->input->get('pp');
		}
		$sort = $this->input->post('sort');
		if (!$sort) {
			$sort = $this->input->get('sort');
		}
		
		$order = $this->input->post('order');
		if (!$order) {
			$order = $this->input->get('order');
		}
		
		$filter = $this->input->post('f');
		if (!$filter) {
			$filter = $this->input->get('f');
		}
		
		$radius = $this->input->post('r');
		if (!$radius) {
			$radius = $this->input->get('r');
		}
		
		if (empty  ($radius) ) {
			$radius = $FARM_DEFAULT_RADIUS;
		}
		
		$arr_filter = explode(',', $filter);
		
		$arrFarmTypeId = array();
		$arrFarmCropId = array();
		$arrCertificationId = array();
		
		foreach($arr_filter as $key => $value) {
			$arr_value = explode('_', $value) ;
			
			if ($arr_value[0] == 'f') {
				$arrFarmTypeId[] = $arr_value[1];
			}
			
			if ($arr_value[0] == 'fc') {
				$arrFarmCropId[] = $arr_value[1];
			}
			
			if ($arr_value[0] == 'c') {
				$arrCertificationId[] = $arr_value[1];
			}
		}
		
		$q = $this->input->post('q');
		if (!$q) {
			$q = $this->input->get('q'); // Per Page
		}
		
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
		
		$base_query = 'SELECT address.*, producer.*, producer_category.producer_category, producer_category.producer_category_id ';
		if ( $latLng ) {
			$base_query .= ', ( 3959 * acos( cos( radians(' . $latLng['latitude'] . ') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(' . $latLng['longitude'] . ') ) + sin( radians(' . $latLng['latitude'] . ') ) * sin( radians( latitude ) ) ) ) AS distance ';
		}
		$base_query .= 	
				' FROM address, producer' . 
				' LEFT JOIN producer_category_member ' .
				'		ON producer.producer_id = producer_category_member.producer_id'.
				' LEFT JOIN producer_category '.
				'		ON producer_category_member.producer_category_id = producer_category.producer_category_id';
				 
		$base_query_count = 'SELECT count(*) AS num_records' .
				' FROM address, producer ';
		if ( count($arrFarmTypeId) > 0  || count($arrFarmCropId) > 0 || count($arrCertificationId) > 0 ) {
			$base_query_count .= 
				' LEFT JOIN producer_category_member ' .
				'		ON producer.producer_id = producer_category_member.producer_id'.
				' LEFT JOIN producer_category '.
				'		ON producer_category_member.producer_category_id = producer_category.producer_category_id';
		}
		
		$where = ' WHERE ';
		
		$where .= ' address.producer_id = producer.producer_id' .
				 ' AND producer.is_farm = 1'.
		         ' AND producer.status = \'live\' ';

		if ( count($arrFarmTypeId) > 0  || count($arrFarmCropId) > 0 || count($arrCertificationId) > 0 ) {
			$where .= ' AND (';
			
			if(count($arrFarmTypeId) > 0 ) {
				$where .= ' producer_category_member.producer_category_id IN (' . implode(',', $arrFarmTypeId) . ')';
			}
			
			if(count($arrFarmCropId) > 0 ) {
				// Cuisine
				if(count($arrFarmTypeId) > 0 ) {
					$where	.= ' OR ( ';
				} else {
					$where	.= ' ( ';
				}
				$where .= ' producer_category_member.producer_category_id IN (' . implode(',', $arrFarmCropId) . ')'
				. '		)';
			}
			
			if(count($arrCertificationId) > 0 ) {
				// Cuisine
				if( count($arrFarmTypeId) > 0 || count($arrFarmCropId) > 0 ) {
					$where	.= ' OR ( ';
				} else {
					$where	.= ' ( ';
				}
				$where .= ' producer_category_member.producer_category_id IN (' . implode(',', $arrCertificationId) . ')'
				. '		)';
			}
			
			$where .= ' )';
		}
		$whereMainQuery = '';
		$whereCountQuery = '';
		if ( $latLng ) {
			$whereMainQuery	.= ' HAVING ( distance <= ' . $radius . ') ';
			
			$whereCountQuery	.= ' AND ( 3959 * acos( cos( radians(' . $latLng['latitude'] . ') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(' . $latLng['longitude'] . ') ) + sin( radians(' . $latLng['latitude'] . ') ) * sin( radians( latitude ) ) ) ) <= ' . $radius . ' ';
		}
		
		$query = $base_query_count . $where . $whereCountQuery;
		$result = $this->db->query($query);
		$row = $result->row();
		$numResults = $row->num_records;
		
		$query = $base_query . $where . $whereMainQuery;
		
		//$query .= ' GROUP BY producer.producer_id ';
		
		if ( empty($sort) ) {
			$sort_query = ' ORDER BY producer';
			$sort = 'producer';
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
		
		$CI->load->model('AddressModel','',true);
		$CI->load->model('CustomUrlModel','',true);
		
		log_message('debug', "FarmModel.getFarmsJson : " . $query);
		$result = $this->db->query($query);
		
		$farms = array();
		
		$geocodeArray = array();
		foreach ($result->result_array() as $row) {
			
			
			$this->load->library('FarmLib');
			unset($this->FarmLib);
			
			$this->FarmLib->farmId = $row['producer_id'];
			
			$this->FarmLib->farmName = $row['producer'];
			$this->FarmLib->farmType = $row['producer_category'];
			
			$this->FarmLib->creationDate = $row['creation_date'];
			
			$addresses = $CI->AddressModel->getAddressForProducer($row['producer_id'], '', '', '');
			$this->FarmLib->addresses = $addresses;
			
			$this->FarmLib->customUrl = '';
			$firstAddressId = '';
			
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
				
				if ($firstAddressId == '') {
					$firstAddressId = $address->addressId;
				}
			}
			
			if ($firstAddressId != '') {
				$customUrl = $CI->CustomUrlModel->getCustomUrlForProducerAddress($row['producer_id'], $firstAddressId);
				$this->FarmLib->customUrl = $customUrl;
			}
			
			$farms[] = $this->FarmLib;
			unset($this->FarmLib);
		}
		
		if (!empty($pp) && $pp == 'all') {
			$PER_PAGE = $numResults;
		}
		
		$totalPages = ceil($numResults/$PER_PAGE);
		$first = 0;
		if ($totalPages > 0) {
			$last = $totalPages - 1;
		} else {
			$last = 0;
		}
		
		if ($numResults == 0) {
			$mapZoomLevel = $DEFAULT_ZOOM_LEVEL;
		}
		
		$params = requestToParams3($numResults, $start, $totalPages, $first, $last, $page, $sort, $order, $q, $filter, $mapZoomLevel, $radius);
		$arr = array(
			'results'    => $farms,
			'param'      => $params,
			'geocode'	 => $geocodeArray,
	    );
	    
	    return $arr;
		
	}
	
	// Used to build the sitemap.  Returns all the slugs
	function getFarmCount() {
		$query = "SELECT count(*) as total FROM producer WHERE is_farm = 1";
		$result = $this->db->query($query);
		
		$row = $result->row(); 
		return $row->total;
	}
	
	// Used to build the sitemap.  Returns all the slugs
	function getFarmSitemap($start,$end) {
		$query = "SELECT creation_date,custom_url.custom_url
					FROM producer, custom_url WHERE is_farm = 1 AND producer.producer_id=custom_url.producer_id LIMIT ".$start.", ".$end;

		log_message('debug', "FarmModel.getFarmSitemap : " . $query);
		$result = $this->db->query($query);

		$farms = array();
		$CI =& get_instance();
		foreach ($result->result_array() as $row) {

			$this->load->library('FarmLib');
			unset($this->FarmLib);

			$this->FarmLib->customURL = $row['custom_url'];
			$this->FarmLib->creationDate = $row['creation_date'];

			$farms[] = $this->FarmLib;
			unset($this->FarmLib);
		}

		return $farms;	
	}

}

?>