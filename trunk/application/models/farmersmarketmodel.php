<?php

class FarmersMarketModel extends Model{

	// Insert the new farm data into the database
	function addFarmersMarket() {
		$return = true;
		
		$farmersMarketName = $this->input->post('farmersMarketName');
		
		$CI =& get_instance();
		
		$query = "SELECT * FROM producer WHERE producer = \"" . $farmersMarketName . "\"  AND is_farmers_market = 1";
		log_message('debug', 'FarmersMarketModel.addFarmersMarket : Try to get duplicate Farmers Market record : ' . $query);
		
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			$query = "INSERT INTO producer (producer_id, producer, creation_date, custom_url, url, status, track_ip, user_id, facebook, twitter, is_farmers_market)" .
					" values (NULL, \"" . $farmersMarketName . "\", NOW(), '" . $this->input->post('customUrl') . "', '" . $this->input->post('url') . "', '" . $this->input->post('status') . "', '" . getRealIpAddr() . "', " . $this->session->userdata['userId'] . ", '" . $this->input->post('facebook') . "', '" . $this->input->post('twitter') . "', 1 )";
			
			log_message('debug', 'FarmersMarketModel.addFarmersMarket : Insert Farmers Market : ' . $query);
			$return = true;
			
			if ( $this->db->query($query) ) {
				$newFarmersMarketId = $this->db->insert_id();
				
					$CI->load->model('AddressModel','',true);
					$addressId = $CI->AddressModel->addAddress($newFarmersMarketId);
					
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
		
		return $return;
	}
	
	// Get all the information about one specific farm from an ID
	function getFarmersMarketFromId($farmersMarketId ,$addressId='') {

		$query = "SELECT 
					*
				FROM 
					producer
				WHERE 
					 is_farmers_market = 1
				AND 
					producer.producer_id = " . $farmersMarketId;
		log_message('debug', "FarmersMarketModel.getFarmersMarketFromId : " . $query);
		$result = $this->db->query($query);
		
		$this->load->library('FarmersMarketLib');
		
		$row = $result->row();
		
		if ($row) {
			$geocodeArray = array();
		
			$this->FarmersMarketLib->farmersMarketId = $row->producer_id;
			$this->FarmersMarketLib->farmersMarketName = $row->producer;
			
			$this->FarmersMarketLib->customUrl = $row->custom_url;
			
			//$this->FarmersMarketLib->customUrl = $this->getCustomURL($row->farmers_market_id);
			
			$this->FarmersMarketLib->url = $row->url;
			$this->FarmersMarketLib->facebook = $row->facebook;
			$this->FarmersMarketLib->twitter = $row->twitter;
			$this->FarmersMarketLib->status = $row->status;
			
			$CI =& get_instance();
			
			$CI->load->model('AddressModel','',true);
			if(isset($addressId) && $addressId !=''){
				$addresses = $CI->AddressModel->getAddressForProducer($row->producer_id, '', '', '', $addressId);
			}else{
				$addresses = $CI->AddressModel->getAddressForProducer($row->producer_id, '', '', '');
			}			
			
			$this->FarmersMarketLib->addresses = $addresses;
			
			foreach ($addresses as $key => $address) {
				$arrLatLng = array();
				
				$arrLatLng['latitude'] = $address->latitude;
				$arrLatLng['longitude'] = $address->longitude;
				$arrLatLng['address'] = $address->completeAddress;
				$arrLatLng['addressLine1'] = $address->address;
				$arrLatLng['addressLine2'] = $address->city . ' ' . $address->state;
				$arrLatLng['addressLine3'] = $address->country . ' ' . $address->zipcode;
				$arrLatLng['farmersMarketName'] = $this->FarmersMarketLib->farmersMarketName;
				$arrLatLng['id'] = $address->addressId;
				$geocodeArray[] = $arrLatLng;
			}
			$this->FarmersMarketLib->param->numResults = 2;
			$this->FarmersMarketLib->geocode = $geocodeArray;
			
			return $this->FarmersMarketLib;
		} else {
			return;
		}
	}
	
	function updateFarmersMarket() {
		$return = true;
		
		$query = "SELECT * FROM producer WHERE producer = \"" . $this->input->post('farmersMarketName') . "\" AND producer_id <> " . $this->input->post('farmersMarketId'). " AND is_farmers_market = 1";
		log_message('debug', 'FarmersMarketModel.updateFarmersMarket : Try to get Duplicate record : ' . $query);
		
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$data = array(
						'producer' => $this->input->post('farmersMarketName'),
						'custom_url' => $this->input->post('customUrl'),
						'url' => $this->input->post('url'),
						'status' => $this->input->post('status'),
						'facebook' => $this->input->post('facebook'),
						'twitter' => $this->input->post('twitter'),
					);
			$where = "producer_id = " . $this->input->post('farmersMarketId');
			$query = $this->db->update_string('producer', $data, $where);
			
			log_message('debug', 'FarmersMarketModel.updateFarmersMarket : ' . $query);
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
	
	function getFarmersMarketsJsonAdmin() {
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
		
		
		$base_query = 'SELECT *' .
				' FROM producer';
		
		$base_query_count = 'SELECT count(*) AS num_records' .
				' FROM producer';
		
		$where = ' WHERE is_farmers_market = 1';
		
		if ( !empty($q) ) {

			$where  .= ' AND (producer.producer like "%' .$q . '%"'
			. ' OR producer.producer_id like "%' . $q . '%"';
			$where .= ' )';

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
		
		log_message('debug', "FarmersMarketModel.getFarmersMarketsJsonAdmin : " . $query);
		$result = $this->db->query($query);
		
		$farms = array();
		
		$CI =& get_instance();
		
		$geocodeArray = array();
		foreach ($result->result_array() as $row) {
			
			$this->load->library('FarmersMarketLib');
			unset($this->FarmersMarketLib);
			
			$this->FarmersMarketLib->farmersMarketId = $row['producer_id'];
			$this->FarmersMarketLib->farmersMarketName = $row['producer'];
			
			$CI->load->model('SupplierModel','',true);
			$suppliers = $CI->SupplierModel->getSupplierForCompany( '', '', '', '', '', $row['producer_id']);
			$this->FarmersMarketLib->suppliers = $suppliers;
			
			$CI->load->model('AddressModel','',true);
			$addresses = $CI->AddressModel->getAddressForCompany( '', '', '', '', $row['producer_id'], '', '', '');
			$this->FarmersMarketLib->addresses = $addresses;
			
			$farms[] = $this->FarmersMarketLib;
			unset($this->FarmersMarketLib);
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
	
	function getFarmersMarketJson2($c = '') {
		global $PER_PAGE, $DEFAULT_ZOOM_LEVEL, $ZIPCODE_ZOOM_LEVEL, $CITY_ZOOM_LEVEL, $FARM_ZOOM_LEVEL, $FARMERS_MARKET_ZOOM_LEVEL, $FARMERS_MARKET_DEFAULT_RADIUS;
		
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
			$radius = $this->input->get('r'); // Per Page
		}
		
		if (empty  ($radius) ) {
			$radius = $FARMERS_MARKET_DEFAULT_RADIUS;
		}
		
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
		if (!$q) {
			$q = $this->input->get('q');
		}
		
		if ($q == '0') {
			$q = '';
		}
		
		$city = '';
		//$city = '41,6009,13721';
		
		if ($c) {
			$citySearch = $c;
		} else {
			$citySearch =  $this->input->post('city');
			if ($citySearch == false) {
				$citySearch = '';
			}
			if (!$citySearch) {
				$citySearch = $this->input->get('city');
			}
			if ($citySearch == false) {
				$citySearch = '';
			}
		}
		
		if ($citySearch == '') {
			$mapZoomLevel = $FARMERS_MARKET_ZOOM_LEVEL;
			
			if ($q == '') {
				if (isset ($_COOKIE['seachedZip']) && !empty($_COOKIE['seachedZip']) ) {
					$q = $_COOKIE['seachedZip'];
					$mapZoomLevel = $FARMERS_MARKET_ZOOM_LEVEL;
				} else {
					if ($this->session->userdata('isAuthenticated') == 1 ) { // Authenticated
						$q = $this->session->userdata['zipcode'];
						$mapZoomLevel = $FARMERS_MARKET_ZOOM_LEVEL;
						setcookie('seachedZip', $q, time()+60*60*24*30*365);
					}
				}
			} else {
				setcookie('seachedZip', $q, time()+60*60*24*30*365);
				$mapZoomLevel = $FARMERS_MARKET_ZOOM_LEVEL;
			}
			
		} else {
			$mapZoomLevel = $CITY_ZOOM_LEVEL;
			
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
		
		$base_query = 'SELECT producer.*' .
				' FROM producer';
		
		$base_query_count = 'SELECT count(*) AS num_records' .
				' FROM producer';
		
		$where = ' WHERE is_farmers_market = 1'.
		         ' AND producer.status = \'live\' ';
		
		
		//if ( !empty($q) || !empty($city) ) {
		if ( $latLng || $citySearch ) {
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
			} elseif ($citySearch) {
				$where	.= '		address.address_id';
			}
					/*
					$where	.=  '	from address, state, country'
					. '			WHERE' 
					. '				address.farmers_market_id = farmers_market.farmers_market_id'
					. '				AND address.state_id = state.state_id'
					. '				AND address.country_id = country.country_id';
					*/
					$where	.=  '	from address'
					. '			WHERE' 
					. '				address.producer_id = producer.producer_id';
					
					
				if (count($latLng) > 0 ) {
					$where	.= ' 			HAVING ( distance <= ' . $radius . ') ';
				} else if ( !empty($q) ) {	 
					$where	.= ' 			HAVING ( address.zipcode = "' . $q . '") ';
				} elseif ($citySearch) {
					$where	.= '			AND address.city_id = ' . $citySearch;
				}
					
			$where	.= '				LIMIT 0, 1'
					. '		)';
		}
		$base_query_count = $base_query_count . $where;
		
		
		//$query = $base_query_count . " ORDER BY restaurant_name ";
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
		
		//echo $query;die;
		log_message('debug', "FarmersMarketModel.getFarmersMarketJson : " . $query);
		$result = $this->db->query($query);
		
		$farms = array();
		
		$geocodeArray = array();
		foreach ($result->result_array() as $row) {
			
			
			$this->load->library('FarmersMarketLib');
			unset($this->FarmersMarketLib);
			
			$this->FarmersMarketLib->farmersMarketId = $row['producer_id'];
			$this->FarmersMarketLib->farmersMarketName = $row['producer'];
			//$this->FarmersMarketLib->customURL = $this->getCustomURL($row['farmers_market_id']);
			
			
			$CI->load->model('AddressModel','',true);
			//$addresses = $CI->AddressModel->getAddressForCompany( '', $row['farm_id'], '', '', $q, $city, '');
			$addresses = $CI->AddressModel->getAddressForProducer($row['producer_id'], '', '', '');
			$this->FarmersMarketLib->addresses = $addresses;
			
			$this->FarmersMarketLib->customUrl = '';
			$firstAddressId = '';
			
			foreach ($addresses as $key => $address) {
				$arrLatLng = array();
				
				$arrLatLng['latitude'] = $address->latitude;
				$arrLatLng['longitude'] = $address->longitude;
				$arrLatLng['address'] = $address->completeAddress;
				
				$arrLatLng['addressLine1'] = $address->address;
				$arrLatLng['addressLine2'] = $address->city . ' ' . $address->state;
				$arrLatLng['addressLine3'] = $address->country . ' ' . $address->zipcode;
				
				$arrLatLng['farmersMarketName'] = $this->FarmersMarketLib->farmersMarketName;
				$arrLatLng['id'] = $address->addressId;
				$geocodeArray[] = $arrLatLng;
				
				if ($firstAddressId == '') {
					$firstAddressId = $address->addressId;
				}
			}
			
			if ($firstAddressId != '') {
				$CI->load->model('CustomUrlModel','',true);
				$customUrl = $CI->CustomUrlModel->getCustomUrlForProducerAddress($row['producer_id'], $firstAddressId);
				$this->FarmersMarketLib->customUrl = $customUrl;
			}
			
			$farms[] = $this->FarmersMarketLib;
			unset($this->FarmersMarketLib);
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
		
		$params = requestToParamsFarmersMarket($numResults, $start, $totalPages, $first, $last, $page, $sort, $order, $q, $filter, $mapZoomLevel, $radius, $citySearch);
		$arr = array(
			'results'    => $farms,
			'param'      => $params,
			'geocode'	 => $geocodeArray,
	    );
		
	    return $arr;
		
	}
	
	function getCustomURL($farmersMarketId){
		
		$results = $this->db->get_where("custom_url", array('farmers_market_id'=>$farmersMarketId));
		
		if($results->num_rows() > 0){
			
			$results = $results->result_array();

			return 	$results[0]['custom_url'];
			
		}
	}
	
	function getQueueFarmersMarketJson() {
		global $PER_PAGE;
		
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

		$where = ' WHERE producer.is_farmers_market=1 ' .
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
		
		log_message('debug', "FarmersMarketModel.getQueueFarmersMarketJson : " . $query);
		$result = $this->db->query($query);
		
		$farms = array();
		
		$CI =& get_instance();
		
		$geocodeArray = array();
		foreach ($result->result_array() as $row) {
			
			$this->load->library('FarmersMarketLib');
			unset($this->FarmersMarketLib);
			
			$this->FarmersMarketLib->farmersMarketId = $row['producer_id'];
			$this->FarmersMarketLib->farmersMarketName = $row['producer'];
			$this->FarmersMarketLib->userId = $row['user_id'];
			$this->FarmersMarketLib->email = $row['email'];
			$this->FarmersMarketLib->ip = $row['track_ip'];
			
			$farms[] = $this->FarmersMarketLib;
			unset($this->FarmersMarketLib);
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
	
	function getFarmersMarketJson($c = '') {
		global $PER_PAGE, $DEFAULT_ZOOM_LEVEL, $ZIPCODE_ZOOM_LEVEL, $CITY_ZOOM_LEVEL, $FARM_ZOOM_LEVEL, $FARMERS_MARKET_ZOOM_LEVEL, $FARMERS_MARKET_DEFAULT_RADIUS;
		
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
		if ($filter == false) {
			$filter = '';
		}
		
		$radius = $this->input->post('r');
		if (!$radius) {
			$radius = $this->input->get('r'); // Per Page
		}
		
		if (empty  ($radius) ) {
			$radius = $FARMERS_MARKET_DEFAULT_RADIUS;
		}
		
		$q = $this->input->post('q');
		if (!$q) {
			$q = $this->input->get('q');
		}
		
		if ($q == '0') {
			$q = '';
		}
		
		$city = '';
		
		if ($c) {
			$citySearch = $c;
		} else {
			$citySearch =  $this->input->post('city');
			if ($citySearch == false) {
				$citySearch = '';
			}
			if (!$citySearch) {
				$citySearch = $this->input->get('city');
			}
			if ($citySearch == false) {
				$citySearch = '';
			}
		}
		
		if ($citySearch == '') {
			$mapZoomLevel = $FARMERS_MARKET_ZOOM_LEVEL;
			
			if ($q == '') {
				if (isset ($_COOKIE['seachedZip']) && !empty($_COOKIE['seachedZip']) ) {
					$q = $_COOKIE['seachedZip'];
					$mapZoomLevel = $FARMERS_MARKET_ZOOM_LEVEL;
				} else {
					if ($this->session->userdata('isAuthenticated') == 1 ) { // Authenticated
						$q = $this->session->userdata['zipcode'];
						$mapZoomLevel = $FARMERS_MARKET_ZOOM_LEVEL;
						setcookie('seachedZip', $q, time()+60*60*24*30*365);
					}
				}
			} else {
				setcookie('seachedZip', $q, time()+60*60*24*30*365);
				$mapZoomLevel = $FARMERS_MARKET_ZOOM_LEVEL;
			}
			
		} else {
			$mapZoomLevel = $CITY_ZOOM_LEVEL;
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
		
		$base_query = 'SELECT address.*, producer.* ';
		if ( $latLng ) {
			$base_query .= ', ( 3959 * acos( cos( radians(' . $latLng['latitude'] . ') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(' . $latLng['longitude'] . ') ) + sin( radians(' . $latLng['latitude'] . ') ) * sin( radians( latitude ) ) ) ) AS distance ';
		}
		$base_query .= 	
				' FROM address, producer';
				 
		$base_query_count = 'SELECT count(*) AS num_records' .
				' FROM address, producer ';
		
		$where = ' WHERE ';
		if ($citySearch) {
			$where	.= ' address.city_id = ' . $citySearch . ' AND ';
		}
		$where .= ' address.producer_id = producer.producer_id' .
				 ' AND producer.is_farmers_market = 1'.
		         ' AND producer.status = \'live\' ';
		
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
		
		log_message('debug', "FarmersMarketModel.getFarmersMarketJson : " . $query);
		$result = $this->db->query($query);
		
		$farms = array();
		
		$geocodeArray = array();
		foreach ($result->result_array() as $row) {
			
			
			$this->load->library('FarmersMarketLib');
			unset($this->FarmersMarketLib);
			
			$this->FarmersMarketLib->farmersMarketId = $row['producer_id'];
			$this->FarmersMarketLib->farmersMarketName = $row['producer'];
			
			$addresses = $CI->AddressModel->getAddressForProducer($row['producer_id'], '', '', '');
			$this->FarmersMarketLib->addresses = $addresses;
			
			$this->FarmersMarketLib->customUrl = '';
			$firstAddressId = '';
			
			foreach ($addresses as $key => $address) {
				$arrLatLng = array();
				
				$arrLatLng['latitude'] = $address->latitude;
				$arrLatLng['longitude'] = $address->longitude;
				$arrLatLng['address'] = $address->completeAddress;
				
				$arrLatLng['addressLine1'] = $address->address;
				$arrLatLng['addressLine2'] = $address->city . ' ' . $address->state;
				$arrLatLng['addressLine3'] = $address->country . ' ' . $address->zipcode;
				
				$arrLatLng['farmersMarketName'] = $this->FarmersMarketLib->farmersMarketName;
				$arrLatLng['id'] = $address->addressId;
				$geocodeArray[] = $arrLatLng;
				
				if ($firstAddressId == '') {
					$firstAddressId = $address->addressId;
				}
			}
			
			if ($firstAddressId != '') {
				$customUrl = $CI->CustomUrlModel->getCustomUrlForProducerAddress($row['producer_id'], $firstAddressId);
				$this->FarmersMarketLib->customUrl = $customUrl;
			}
			
			$farms[] = $this->FarmersMarketLib;
			unset($this->FarmersMarketLib);
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
		
		$params = requestToParamsFarmersMarket($numResults, $start, $totalPages, $first, $last, $page, $sort, $order, $q, $filter, $mapZoomLevel, $radius, $citySearch);
		$arr = array(
			'results'    => $farms,
			'param'      => $params,
			'geocode'	 => $geocodeArray,
	    );
		
	    return $arr;
		
	}

	// Used to build the sitemap.  Returns all the slugs
	function getFarmersMarketCount() {
		$query = "SELECT count(*) as total FROM producer WHERE is_farmers_market = 1";
		$result = $this->db->query($query);
		
		$row = $result->row(); 
		return $row->total;
	}
	
	// Used to build the sitemap.  Returns all the slugs
	function getFarmersMarketSitemap($start,$end) {
		$query = "SELECT creation_date,custom_url.custom_url
					FROM producer, custom_url WHERE is_farmers_market = 1 AND producer.producer_id=custom_url.producer_id LIMIT ".$start.", ".$end;

		log_message('debug', "FarmersMarketModel.getFarmersMarketSitemap : " . $query);
		$result = $this->db->query($query);

		$farmersMarket = array();
		$CI =& get_instance();
		foreach ($result->result_array() as $row) {

			$this->load->library('FarmersMarketLib');
			unset($this->FarmersMarketLib);

			$this->FarmersMarketLib->customURL = $row['custom_url'];
			$this->FarmersMarketLib->creationDate = $row['creation_date'];

			$farmersMarket[] = $this->FarmersMarketLib;
			unset($this->FarmersMarketLib);
		}

		return $farmersMarket;	
	}

}

?>