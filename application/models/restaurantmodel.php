<?php

class RestaurantModel extends Model{

	/**
	 * Migration: 		Done
	 * Migration by: 	Deepak
	 */
	// Generate a simple list of the recent restaurants added to the db
	function listNewRestaurants()
	{
		$query = "SELECT producer.*, custom_url.custom_url
					FROM producer, custom_url WHERE is_restaurant = 1 AND producer.producer_id=custom_url.producer_id
					ORDER BY producer_id DESC limit 10";

		log_message('debug', "RestaurantModel.listNewRestaurants : " . $query);
		$result = $this->db->query($query);

		$restaurants = array();
		
		foreach ($result->result_array() as $row) {

			$this->load->library('RestaurantLib');
			unset($this->RestaurantLib);

			$this->RestaurantLib->restaurantId = $row['custom_url'];
			$this->RestaurantLib->restaurantName = $row['producer'];
			//$this->RestaurantLib->creationDate = $row['creation_date'];

			$restaurants[] = $this->RestaurantLib;
			unset($this->RestaurantLib);
		}

		return $restaurants;
	}

	function getRestaurantsMobileByCoordinates($latitude = '', $longitude = '', $distance = ''){

			$query_zips = 'SELECT address_id, ( 3959 * acos( cos( radians("'.$latitude.'") ) * cos( radians( latitude ) ) *
								cos( radians( longitude ) - radians("'.$longitude.'") ) + sin( radians("'.$latitude.'") ) * 
								sin( radians( latitude ) ) ) ) AS distance FROM address HAVING distance <= '.$distance.' ORDER BY distance';

			$proximity_zips = $this->db->query($query_zips)->result_array();
			
			if(sizeof($proximity_zips) > 0){

				$address_ids = array();
				
				foreach($proximity_zips as $zip){
					$address_ids[] = "'".$zip['address_id']."'";	
				}
				
				$ids = implode(",", $address_ids);
				
			$query = "SELECT
							address.address_id,
							address.producer_id,
							address.address,
							address.city,
							address.zipcode,
							producer.producer,
							producer.phone,
							producer.fax,
							producer.email,
							producer.url,
							producer.facebook,
							producer.twitter,
							producer.description,
							custom_url.custom_url
							FROM
							address ,
							producer ,
							custom_url
							WHERE
							address.producer_id =  producer.producer_id AND
							producer.is_restaurant =  '1' AND
							address.address_id IN  (".$ids.") AND
							producer.status =  'live' AND
							address.address_id =  custom_url.address_id AND
							producer.claims_sustainable=1";
				
				 $restaurants = $this->db->query($query)->result_array();
				 
				 foreach($restaurants as $key=>$restaurant){
				 	 $cuisine_query = "SELECT
												producer_category.producer_category as cuisine_name
												FROM
												producer ,
												producer_category ,
												producer_category_member
												WHERE
												producer.producer_id =  producer_category_member.producer_id AND
												producer_category_member.producer_category_id =  producer_category.producer_category_id AND
												producer.producer_id =  '".$restaurant['producer_id']."' AND
												producer_category.cuisine_id IS NOT NULL ";
				 	
				 	$quisine_results = $this->db->query($cuisine_query)->result_array();
				 	$cuisines_id = array();
					foreach($quisine_results as $cuisine){				
						$cuisines_id[] = $cuisine['cuisine_name'];	
					}
					$restaurants[$key]['cuisine'] = implode(",", $cuisines_id);
				 }
				 
				 
				return $restaurants;
			}//end else initial zips 
			else{
				//no zip found in proximity
				return false;
			}
	}

	function getRestaurantsMobileByZipCode($zipcode, $distance){


		//select lat/long of searched zip

		$zip_query = 'select * from zipcode where `zipcode` = "'.$zipcode.'"';
		$zip_code_info = $this->db->query($zip_query)->result_array();
		if(sizeof($zip_code_info) > 0){
			//query to find all zips near this zip
			$latitude = $zip_code_info[0]['latitude'];
			$longitude = $zip_code_info[0]['longitude'];;

			$query_zips = 'SELECT address_id, ( 3959 * acos( cos( radians("'.$latitude.'") ) * cos( radians( latitude ) ) *
								cos( radians( longitude ) - radians("'.$longitude.'") ) + sin( radians("'.$latitude.'") ) * 
								sin( radians( latitude ) ) ) ) AS distance FROM address HAVING distance <= '.$distance.' ORDER BY distance';

			$proximity_zips = $this->db->query($query_zips)->result_array();
			
			if(sizeof($proximity_zips) > 0){

				$address_ids = array();
				
				foreach($proximity_zips as $zip){
					$address_ids[] = "'".$zip['address_id']."'";	
				}
				
				$ids = implode(",", $address_ids);
				
				$query = "SELECT
							address.address_id,
							address.producer_id,
							address.address,
							address.city,
							address.zipcode,
							producer.producer,
							producer.phone,
							producer.fax,
							producer.email,
							producer.url,
							producer.facebook,
							producer.twitter,
							producer.description,
							custom_url.custom_url
							FROM
							address ,
							producer ,
							custom_url
							WHERE
							address.producer_id =  producer.producer_id AND
							producer.is_restaurant =  '1' AND
							address.address_id IN  (".$ids.") AND
							producer.status =  'live' AND
							address.address_id =  custom_url.address_id";
				
				 $restaurants = $this->db->query($query)->result_array();
				 
				 foreach($restaurants as $key=>$restaurant){
				 	 $cuisine_query = "SELECT
												producer_category.producer_category as cuisine_name
												FROM
												producer ,
												producer_category ,
												producer_category_member
												WHERE
												producer.producer_id =  producer_category_member.producer_id AND
												producer_category_member.producer_category_id =  producer_category.producer_category_id AND
												producer.producer_id =  '".$restaurant['producer_id']."' AND
												producer_category.cuisine_id IS NOT NULL ";
				 	
				 	$quisine_results = $this->db->query($cuisine_query)->result_array();
				 	$cuisines_id = array();
					foreach($quisine_results as $cuisine){				
						$cuisines_id[] = $cuisine['cuisine_name'];	
					}
					$restaurants[$key]['cuisine'] = implode(",", $cuisines_id);
				 }
				 
				 
				return $restaurants;
			}//end else initial zips 
			else{
				//no zip found in proximity
				return false;
			}
		}else{

			//zipnotfound
			return false;
		}
	}

	function getRestaurantsJsonAdmin() {

		global $PER_PAGE, $DEFAULT_ZOOM_LEVEL, $ZIPCODE_ZOOM_LEVEL, $CITY_ZOOM_LEVEL;

		$p = $this->input->post('p'); // Page
		$pp = $this->input->post('pp'); // Per Page
		$sort = $this->input->post('sort');
		$order = $this->input->post('order');

		$arrRestaurantTypeId = array();
		$arrCuisineId = array();
		$producerIds=array();
		$producers_temp=array();
		$producers=array();

		$q = $this->input->post('q');
		//$q = 'fast';
		//$filter = 'c_7';

		if ($q == '0') {
			$q = '';
		}
		
		// we don't need map in admin area, why do we have this?
		$mapZoomLevel = $DEFAULT_ZOOM_LEVEL;

		$start = 0;

		$page = 0;

		$base_query = 'SELECT * FROM producer ';

		$base_query_count = 'SELECT count(*) AS num_records' .
				' FROM producer';

		$where = ' WHERE is_restaurant = 1';
		
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

		log_message('debug', "RestaurantModel.getRestaurantsJsonAdmin : " . $query);
		$result = $this->db->query($query);
		//fetch all producer id		
		foreach($result->result_array() as $row){
			$producerIds[] = $row['producer_id'];
			$producers[] = $row;
			$producers_temp[] = $row;
		}
		
		$producerIds = implode(',',$producerIds);

		if(!empty($producerIds)) {
			$prodCatQuery = "SELECT producer_category_member.producer_id, producer_category_member.producer_category_id, 
									producer_category.producer_category 
							FROM producer_category_member
							LEFT JOIN producer_category
							ON producer_category_member.producer_category_id=producer_category.producer_category_id
							WHERE producer_id IN (".$producerIds.")
							GROUP BY producer_id";
			$prodCategories = $this->db->query($prodCatQuery)->result_array();

			$i=0;
			foreach($producers_temp as $producer_temp) {
				foreach($prodCategories as $prodCategory) {
					if( $producer_temp['producer_id'] == $prodCategory['producer_id']) {
						$producers[]=$producer_temp;
						$producers[$i]['producer_category_id'] = $prodCategory['producer_category_id'];
						$producers[$i]['producer_category'] = $prodCategory['producer_category'];
						break;
					}
				}
				$i++;
			}
		}

		$restaurants = array();

		$CI =& get_instance();

		$geocodeArray = array();
		foreach ($producers as $row) {

			$this->load->library('RestaurantLib');
			unset($this->RestaurantLib);

			$this->RestaurantLib->restaurantId = $row['producer_id'];
			$this->RestaurantLib->restaurantName = $row['producer'];
			//$this->RestaurantLib->restaurantChain = $row['restaurant_chain'];
			//$this->RestaurantLib->companyName = $row['company_name'];
			$this->RestaurantLib->creationDate = $row['creation_date'];

			$restaurants[] = $this->RestaurantLib;
			unset($this->RestaurantLib);
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

		$params = requestToParams($numResults, $start, $totalPages, $first, $last, $page, $sort, $order, $q, '', $mapZoomLevel);
		$arr = array(
			'results'    => $restaurants,
			'param'      => $params,
			'geocode'	 => $geocodeArray,
		);

		return $arr;

	}



	function getRestaurantsJsonAdmin_old() {

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
		
		// we don't need map in admin area, why do we have this?
		$mapZoomLevel = $DEFAULT_ZOOM_LEVEL;

		$start = 0;

		$page = 0;
		
		$base_query = 'SELECT producer.*, producer_category.producer_category, producer_category.producer_category_id' .
				' FROM producer' . 
				' LEFT JOIN producer_category_member ' .
				' ON producer.producer_id = producer_category_member.producer_id'.
				' LEFT JOIN producer_category '.
				' ON producer_category_member.producer_category_id = producer_category.producer_category_id';

		$base_query_count = 'SELECT count(*) AS num_records' .
				' FROM producer';

		$where = ' WHERE is_restaurant = 1';
		
		if ( !empty($q) ) {

			$where  .= ' AND (producer.producer like "' .$q . '%"'
			
			. ' OR producer.producer_id like "' . $q . '%"';

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

		log_message('debug', "RestaurantModel.getRestaurantsJsonAdmin : " . $query);
		$result = $this->db->query($query);

		$restaurants = array();

		$CI =& get_instance();

		$geocodeArray = array();

		foreach ($result->result_array() as $row) {

			$this->load->library('RestaurantLib');
			unset($this->RestaurantLib);

			$this->RestaurantLib->restaurantId = $row['producer_id'];
			$this->RestaurantLib->restaurantName = $row['producer'];
			//$this->RestaurantLib->restaurantChain = $row['restaurant_chain'];
			//$this->RestaurantLib->companyName = $row['company_name'];
			$this->RestaurantLib->creationDate = $row['creation_date'];

			$restaurants[] = $this->RestaurantLib;
			unset($this->RestaurantLib);
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

		$params = requestToParams($numResults, $start, $totalPages, $first, $last, $page, $sort, $order, $q, '', $mapZoomLevel);
		$arr = array(
			'results'    => $restaurants,
			'param'      => $params,
			'geocode'	 => $geocodeArray,
		);

		return $arr;

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

//		$query = "SELECT restaurant_cuisine.*" .
//				" FROM restaurant_cuisine" .
//				" WHERE " .
//				" restaurant_cuisine.restaurant_id = " . $restaurantId;
//		
		
		$query = "SELECT
				producer_category.cuisine_id
				FROM
				producer ,
				producer_category ,
				producer_category_member
				WHERE
				producer.producer_id =  producer_category_member.producer_id AND
				producer_category_member.producer_category_id =  producer_category.producer_category_id AND
				producer.is_restaurant =  '1' AND
				producer.producer_id = " . $restaurantId;

		log_message('debug', "RestaurantModel.getCuisineIdsForRestaurant : " . $query);
		$result = $this->db->query($query);

		foreach ($result->result_array() as $row) {
			$cuisines[] = $row['cuisine_id'];
		}
		return $cuisines;
	}

	// Input the data from the controller
	function addRestaurant() {
		$return = true;

		//$companyId = $this->input->post('companyId');
		$restaurantName = $this->input->post('restaurantName');

		$CI =& get_instance();

		$query = "SELECT * FROM producer WHERE producer = \"" . $restaurantName . "\" AND is_restaurant = 1";
		log_message('debug', 'RestaurantModel.addRestaurant : Try to get duplicate Restaurant record : ' . $query);
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {

			
			$query = "INSERT INTO producer (producer_id, producer, creation_date, custom_url, city_area_id, phone, fax, email, url, status, track_ip, user_id, facebook, twitter, is_restaurant)" .
					" values (NULL, \"" . $restaurantName . "\", NOW(), NULL, NULL, '" . $this->input->post('phone') . "', '" . $this->input->post('fax') . "', '" . $this->input->post('email') . "', '" . $this->input->post('url') . "', '" . $this->input->post('status') . "', '" . getRealIpAddr() . "', " . $this->session->userdata['userId'] . ", '" . $this->input->post('facebook') . "', '" . $this->input->post('twitter') . "', 1 )";
			log_message('debug', 'RestaurantModel.addRestaurant : Insert Restaurant : ' . $query);
			$return = true;

			
			if ( $this->db->query($query) ) {
				$newRestaurantId = $this->db->insert_id();
				
				// CHECK IF USER SELECT A MULTIPLE CUISINE
				if(strpos($this->input->post('cuisineId'),',') !== FALSE)
					$arrCuisineId = explode(',', $this->input->post('cuisineId'));
				else
					$arrCuisineId[] = $this->input->post('cuisineId');

				for($i = 0; $i < count($arrCuisineId); $i++) {
					$query = "INSERT INTO producer_category_member (producer_category_member_id, producer_category_id, producer_id, address_id)" .
					" values (NULL, " . $arrCuisineId[$i] . ", " . $newRestaurantId . ", NULL )";

					if ( $this->db->query($query) ) {
						$restaurantCuisineId = mysql_insert_id();
						//$restaurantCuisineId = 418558;
					}
				}

				$restaurantTypeId = $this->input->post('restaurantTypeId');
				if ($restaurantTypeId) {
					$query = "INSERT INTO producer_category_member (producer_category_member_id, producer_category_id, producer_id, address_id)" .
					" values (NULL, " . $restaurantTypeId . ", " . $newRestaurantId . ", NULL )";

					if ( $this->db->query($query) ) {
						$restaurantTypeId = mysql_insert_id();
						//$restaurantTypeId = 418559;
					}
				}
				
				$CI->load->model('AddressModel','',true);
				$addressId = $CI->AddressModel->addAddress($newRestaurantId);
				
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

	// Pulls the data from the database for a specific restaurant
	function getRestaurantFromId($restaurantId, $addressId='') {

		$query = "select * from producer WHERE producer.producer_id = ".$restaurantId;
		
		log_message('debug', "RestaurantModel.getRestaurantFromId : " . $query);
		$result = $this->db->query($query);

		$restaurant = array();

		$this->load->library('RestaurantLib');

		$row = $result->row();

		$CI =& get_instance();
		$city = '';
		$q = '';

		if (isset ($_COOKIE['seachedZip']) && !empty($_COOKIE['seachedZip']) ) {
			$q = $_COOKIE['seachedZip'];
		} else {
			if ($this->session->userdata('isAuthenticated') != 1 ) {
				// If user is NOT logged in, display restaurants from SFO
				$city = '41,6009,13721';
			} else {
				// If user is LOGGED in, display restaurants near hiz zipcode
				$q = $this->session->userdata['zipcode'];
				setcookie('seachedZip', $q, time()+60*60*24*30*365);
			}
		}

		if ($row) {
			$geocodeArray = array();

			$this->restaurantLib->restaurantId = $row->producer_id;
			$this->restaurantLib->restaurantTypeId = $this->getRestaurantTypeId($row->producer_id);
			$this->restaurantLib->restaurantName = $row->producer;
			$this->restaurantLib->customURL = $row->custom_url;
			$this->restaurantLib->phone = $row->phone;
			$this->restaurantLib->fax = $row->fax;
			$this->restaurantLib->email = $row->email;
			$this->restaurantLib->url = $row->url;
			$this->restaurantLib->facebook = $row->facebook;
			$this->restaurantLib->twitter = $row->twitter;
			$this->restaurantLib->status = $row->status;

			//$cuisines = $this->getCuisineIdsForRestaurant( $row->producer_id);
			//$this->restaurantLib->cuisines = $cuisines;
			
			$CI->load->model('ProducerCategoryModel','',true);
			$cuisines = $CI->ProducerCategoryModel->getCuisineIdsForRestaurant( $row->producer_id);
			$this->restaurantLib->cuisines = $cuisines;
			
			$CI->load->model('AddressModel','',true);
			
			if(isset($addressId) && $addressId !=''){
				$addresses = $CI->AddressModel->getAddressForProducer($row->producer_id, '', '', '', $addressId);
			} else {
				$addresses = $CI->AddressModel->getAddressForProducer($row->producer_id, $q, $city, '', $addressId);
			}
			
			$this->restaurantLib->addresses = $addresses;

			foreach ($addresses as $key => $address) {
				$arrLatLng = array();

				$arrLatLng['latitude'] = $address->latitude;
				$arrLatLng['longitude'] = $address->longitude;
				$arrLatLng['address'] = $address->completeAddress;

				$arrLatLng['addressLine1'] = $address->address;
				$arrLatLng['addressLine2'] = $address->city . ' ' . $address->state;
				$arrLatLng['addressLine3'] = $address->country . ' ' . $address->zipcode;

				$arrLatLng['restaurantName'] = $this->restaurantLib->restaurantName;
				$arrLatLng['id'] = $address->addressId;
				$geocodeArray[] = $arrLatLng;
			}
			$this->restaurantLib->param->numResults = 2;
			$this->restaurantLib->geocode = $geocodeArray;

			return $this->restaurantLib;
		} else {
			return;
		}
	}
	
	// Pulls the data from the database for a specific restaurant
	function getMinimumRestaurantInfoFromId($restaurantId) {

		$query = "SELECT 
					*
				FROM 
					producer
				WHERE 
					producer.producer_id = " . $restaurantId;
					
		$CI =& get_instance();
		log_message('debug', "RestaurantModel.getMinimumRestaurantInfoFromId : " . $query);
		$result = $this->db->query($query);

		$row = $result->row();
		if ($row) {
			$this->load->library('RestaurantLib');
			$geocodeArray = array();

			$this->restaurantLib->restaurantId = $row->producer_id;
			$this->restaurantLib->restaurantTypeId = $this->getRestaurantTypeId($row->producer_id);
			$this->restaurantLib->restaurantName = $row->producer;
			$this->restaurantLib->customURL = $row->custom_url;
			$this->restaurantLib->phone = $row->phone;
			$this->restaurantLib->fax = $row->fax;
			$this->restaurantLib->email = $row->email;
			$this->restaurantLib->url = $row->url;
			$this->restaurantLib->facebook = $row->facebook;
			$this->restaurantLib->twitter = $row->twitter;
			$this->restaurantLib->status = $row->status;

			//$cuisines = $this->getCuisineIdsForRestaurant( $row->producer_id);
			//$this->restaurantLib->cuisines = $cuisines;
			
			$CI->load->model('ProducerCategoryModel','',true);
			$cuisines = $CI->ProducerCategoryModel->getCuisineIdsForRestaurant( $row->producer_id);
			$this->restaurantLib->cuisines = $cuisines;
			
			return $this->restaurantLib;
		} else {
			return;
		}
	}
	
	function getRestaurantTypeId($restaurantId){
	$query = "SELECT
				producer_category.restaurant_type_id
				FROM
				producer ,
				producer_category ,
				producer_category_member
				WHERE
				producer.producer_id =  producer_category_member.producer_id AND
				producer_category_member.producer_category_id =  producer_category.producer_category_id AND
				producer.is_restaurant =  '1' AND
				producer_category.restaurant_type_id is not null AND
				producer.producer_id = " . $restaurantId;

		log_message('debug', "RestaurantModel.getCuisineIdsForRestaurant : " . $query);
		$result = $this->db->query($query)->result_array();

		if( !empty($result) )
			return $result[0]['restaurant_type_id'];
		else 
			return array();
	}
	

	// Pulls the data from the database for a specific restaurant
	function getRestaurantChainFromId($restaurantChainId) {

		$query = "SELECT * FROM producer WHERE producer_id = " . $restaurantChainId;

		log_message('debug', "RestaurantModel.getRestaurantChainFromId : " . $query);
		$result = $this->db->query($query);

		$restaurant = array();

		$this->load->library('RestaurantChainLib');

		$row = $result->row();

		$this->restaurantChainLib->restaurantChainId = $row->producer_id;
		$this->restaurantChainLib->restaurantChain = $row->producer;

		return $this->restaurantChainLib;
	}

	// Update the restaurant in the database with new information
	function updateRestaurant() {
		$return = true;

		$query = "SELECT * FROM producer WHERE producer = \"" . $this->input->post('restaurantName') . "\" AND producer_id <> " . $this->input->post('restaurantId')."  AND is_restaurant = 1";
		log_message('debug', 'RestaurantModel.updateRestaurant : Try to get Duplicate record : ' . $query);

		$result = $this->db->query($query);

		if ($result->num_rows() == 0) {
//			$restaurantChainId = $this->input->post('restaurantChainId');
			$data = array(
						'producer' => $this->input->post('restaurantName'), 
						'custom_url' => $this->input->post('customUrl'),
//						'company_id' => $this->input->post('companyId'),
//						'restaurant_chain_id' => ( !empty($restaurantChainId) ? $restaurantChainId : NULL ) ,
//						'restaurant_type_id' => $this->input->post('restaurantTypeId'),
						'phone' => $this->input->post('phone'),
						'fax' => $this->input->post('fax'),
						'email' => $this->input->post('email'),
						'url' => $this->input->post('url'),
						'facebook' => $this->input->post('facebook'),
						'twitter' => $this->input->post('twitter'),
						'status' => $this->input->post('status'),
			);
			$where = "producer_id = " . $this->input->post('restaurantId');
			$query = $this->db->update_string('producer', $data, $where);

			log_message('debug', 'RestaurantModel.updateRestaurant : ' . $query);
			if ( $this->db->query($query) ) {
				//update cuisines
				
				// CHECK IF USER SELECT A MULTIPLE CUISINE
				if(strpos($this->input->post('cuisineId'),',') !== FALSE)
					$arrCuisineId = explode(',', $this->input->post('cuisineId'));
				else
					$arrCuisineId[] = $this->input->post('cuisineId');

				$this->updateCuisines($this->input->post('restaurantId'), $arrCuisineId);
				
				//update restaurant type
				$this->updateRestaurantType($this->input->post('restaurantId'), $this->input->post('restaurantTypeId'));

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


	function updateRestaurantType($restaurantId, $restaurantTypeId) {
	
		$query = "SELECT producer_category_id FROM producer_category WHERE producer_category_id IN (SELECT producer_category_id 
				FROM producer_category_member WHERE producer_id=$restaurantId) AND restaurant_type_id IS NOT NULL";
		log_message('debug', 'RestaurantModel.updateCuisines : get existing cuisines : ' . $query);

		$result = $this->db->query($query)->result_array();

		if( !empty($result) ) {
			$oldRestaurantTypeId = $result[0]['producer_category_id'];
	
			$where = "producer_id = " . $restaurantId;

			if( !empty($oldRestaurantTypeId) )
				$where .= " AND producer_category_id=".$oldRestaurantTypeId;
		
			$this->db->update('producer_category_member', array('producer_category_id'=>$restaurantTypeId), $where);
		}else{
		
			$data = array(
						'producer_category_id' => $restaurantTypeId,
						'producer_id' => $restaurantId
						);
		
			$this->db->insert('producer_category_member', $data);
		
		}
	}

	function updateCuisines($restaurantId, $cuisineIds) {
		$query = "SELECT producer_category_id FROM producer_category WHERE producer_category_id IN (SELECT producer_category_id 
				FROM producer_category_member WHERE producer_id=$restaurantId) AND cuisine_id IS NOT NULL";
		log_message('debug', 'RestaurantModel.updateCuisines : get existing cuisines : ' . $query);

		$result = $this->db->query($query);
		$existingCuisineIds = array();
		foreach ($result->result_array() as $row) {
			$existingCuisineIds[] = $row['producer_category_id'];
		}

		$action = array();

		foreach($cuisineIds as $cuisineId) {
			$cuisineId = trim($cuisineId);
			if(!empty($cuisineId)) {
				if (!(in_array($cuisineId, $existingCuisineIds) > 0)) {
					$query = "INSERT INTO producer_category_member (producer_category_member_id, producer_category_id, producer_id, address_id)" .
						" VALUES (NULL, " . $cuisineId . ", " . $restaurantId . ", NULL )";
					log_message('debug', 'RestaurantModel.updateCuisines : insert new cuisine : ' . $query);
					$result = $this->db->query($query);
				} else {
					$action[$cuisineId] = 'update';
				}
			}
		}


		foreach ($existingCuisineIds as $existingCuisineId) {
			if (array_key_exists ($existingCuisineId, $action) ) {
				// Do nothing...
			} else {
				$query = "DELETE FROM producer_category_member WHERE producer_id = $restaurantId AND producer_category_id = $existingCuisineId";
				log_message('debug', 'RestaurantModel.updateCuisines : delete cuisine : ' . $query);
				$result = $this->db->query($query);
			}
		}
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
				log_message('debug', 'RestaurantModel.addRestaurantWithNameOnly : Try to get duplicate Restaurant record : ' . $query);

				$result = $this->db->query($query);

				if ($result->num_rows() == 0) {
					$query = "INSERT INTO restaurant (restaurant_id, company_id, restaurant_type_id, restaurant_name, creation_date, custom_url, status, track_ip, user_id)" .
							" values (NULL, ".$companyId.", NULL, \"" . $restaurantName . "\", NOW(), NULL, 'live', '" . getRealIpAddr() . "', " . $this->session->userdata['userId'] . " )";

					log_message('debug', 'RestaurantModel.addRestaurantWithNameOnly : Insert Restaurant : ' . $query);
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

	function getDistinctUsedRestaurantType($c) {
		$query = "SELECT 
					DISTINCT producer_category.producer_category_id, 
					producer_category.producer_category 
				FROM 
					producer_category, producer_category_member 
				WHERE 
					producer_category_member.producer_category_id = producer_category.producer_category_id 
					AND producer_category.category_group1 = 2  LIMIT 0, $c";
		
		log_message('debug', "RestaurantModel.getDistinctUsedRestaurantType : " . $query);
		$result = $this->db->query($query);

		$restaurantTypes = array();
		$CI =& get_instance();
		foreach ($result->result_array() as $row) {

			$this->load->library('RestaurantTypeLib');
			unset($this->RestaurantTypeLib);

			$this->RestaurantTypeLib->restaurantTypeId = $row['producer_category_id'];
			$this->RestaurantTypeLib->restaurantType = $row['producer_category'];

			$restaurantTypes[] = $this->RestaurantTypeLib;
			unset($this->RestaurantTypeLib);
		}

		return $restaurantTypes;
	}

	function getDistinctUsedCuisine($c) {
		$query = "SELECT 
					DISTINCT producer_category.producer_category_id, 
					producer_category.producer_category 
				FROM 
					producer_category, producer_category_member 
				WHERE 
					producer_category_member.producer_category_id = producer_category.producer_category_id 
					AND producer_category.category_group1 = 1  LIMIT 0, $c";
		log_message('debug', "RestaurantModel.getDistinctUsedCuisine : " . $query);
		$result = $this->db->query($query);

		$cuisine = array();

		foreach ($result->result_array() as $row) {

			$this->load->library('CuisineLib');
			unset($this->CuisineLib);

			$this->CuisineLib->cuisineId = $row['producer_category_id'];
			$this->CuisineLib->cuisineName = $row['producer_category'];

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

	function getRestaurantMenusJson($producerId = null) {
		global $PER_PAGE;

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

		$q = $this->input->post('q'); 
		if (!$q) {
			$q = $this->input->get('q');
		}
		
		if ($q == '0') {
			$q = '';
		}
		if (!$q) {
			$q = $producerId;
		}
		
		$CI =& get_instance();

		$CI->load->model('RestaurantModel');
		$restaurant = $CI->RestaurantModel->getRestaurantFromId($q);
		//$restaurantChainId = $restaurant->restaurantChainId;
		$restaurantChainId = '';

		$start = 0;
		$page = 0;

		$base_query = 'SELECT *' .
				' FROM product';

		$base_query_count = 'SELECT count(*) AS num_records' .
				' FROM product';


		$where = '';
		if( !empty($restaurantChainId) ){
			$where = ' WHERE (restaurant_id  = ' . $q . ' OR restaurant_chain_id = ' . $q . ') ';
		} else {
			$where = ' WHERE producer_id  = ' . $q;
		}

		$where .= ' AND product.status = \'live\'';

		$base_query_count = $base_query_count . $where;

		$query = $base_query_count;

		$result = $this->db->query($query);
		$row = $result->row();
		$numResults = $row->num_records;

		$query = $base_query . $where;

		if ( empty($sort) ) {
			$sort_query = ' ORDER BY product_name';
			$sort = 'product_name';
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

		log_message('debug', "RestaurantModel.getRestaurantMenusJson : " . $query);
		$result = $this->db->query($query);

		$menu = array();



		foreach ($result->result_array() as $row) {

			$this->load->library('ProductLib');
			unset($this->productLib);

			$this->productLib->productId = $row['product_id'];
			$this->productLib->productName = $row['product_name'];
			$this->productLib->ingredient = $row['ingredient_text'];
			$this->productLib->image = '';

			$menu[] = $this->productLib;
			unset($this->productLib);
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
			'results'    => $menu,
			'param'      => $params,
		);

		return $arr;
	}

	function getQueueRestaurantsJson() {
		global $PER_PAGE;

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

		$start = 0;

		$page = 0;

		$base_query = 'SELECT producer.*,user.email, user.first_name FROM producer LEFT JOIN user ON producer.user_id=user.user_id';


		$base_query_count = 'SELECT count(*) AS num_records FROM producer LEFT JOIN user ON producer.user_id=user.user_id';

		$where = ' WHERE producer.is_restaurant=1 ' .
				' AND producer.status = \'queue\' ';

		if ( !empty($q) ) {

			$where .= ' AND (producer.producer like "%' .$q . '%")';

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

		log_message('debug', "RestaurantModel.getRestaurantMenusJson : " . $query);
		$result = $this->db->query($query);

		$restaurants = array();

		$CI =& get_instance();

		$geocodeArray = array();
		foreach ($result->result_array() as $row) {

			$this->load->library('RestaurantLib');
			unset($this->RestaurantLib);

			$this->RestaurantLib->restaurantId = $row['producer_id'];
			$this->RestaurantLib->restaurantName = $row['producer'];
			//$this->RestaurantLib->restaurantChain = $row['restaurant_chain'];
			//$this->RestaurantLib->companyName = $row['company_name'];
			$this->RestaurantLib->userId = $row['user_id'];
			$this->RestaurantLib->email = $row['email'];
			$this->RestaurantLib->ip = $row['track_ip'];
			$this->RestaurantLib->dateAdded = date ("Y-m-d", strtotime($row['creation_date']) ) ;

			$restaurants[] = $this->RestaurantLib;
			unset($this->RestaurantLib);
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
			'results'    => $restaurants,
			'param'      => $params,
			'geocode'	 => $geocodeArray,
		);
		//print_r_pre($arr);
		//die;
		return $arr;

	}

	function updateRestaurantSustainable($restaurantId, $claimsSustainable) {
		$return = true;

		$data = array(
					'claims_sustainable' => $claimsSustainable,
		);
		$where = "producer_id = " . $restaurantId;
		$query = $this->db->update_string('producer', $data, $where);

		log_message('debug', 'RestaurantModel.updateRestaurant : ' . $query);
		if ( $this->db->query($query) ) {
			$return = true;
		} else {
			$return = false;
		}

		return $return;
	}
	
	/**
	 * Migration: 		Done
	 * Migrated by: 	Deepak
	 * 
	 * Verified: 		Yes
	 * Verified By: 	Deepak
	 */
	function searchRestaurants($q) {
		$query = "SELECT producer_id, producer
					FROM producer
					WHERE producer like '$q%'
					AND  is_restaurant = 1
					ORDER BY producer ";
		$restaurants = '';
		log_message('debug', "RestaurantModel.searchRestaurants : " . $query);
		$result = $this->db->query($query);
		foreach ($result->result_array() as $row) {
			$restaurants .= $row['producer']."|".$row['producer_id']."\n";
		}

		return $restaurants;
	}
	
	// Used to build the sitemap.  Returns all the slugs
	function getRestaurantsSitemap($start,$end) {
		$query = "SELECT creation_date,custom_url.custom_url
					FROM producer, custom_url WHERE is_restaurant = 1 AND producer.producer_id=custom_url.producer_id LIMIT ".$start.", ".$end;

		log_message('debug', "RestaurantModel.getRestaurantsSitemap : " . $query);
		$result = $this->db->query($query);

		$restaurants = array();
		$CI =& get_instance();
		foreach ($result->result_array() as $row) {

			$this->load->library('RestaurantLib');
			unset($this->RestaurantLib);

			$this->RestaurantLib->customURL = $row['custom_url'];
			$this->RestaurantLib->creationDate = $row['creation_date'];

			$restaurants[] = $this->RestaurantLib;
			unset($this->RestaurantLib);
		}

		return $restaurants;	
	}
	
	// Used to build the sitemap.  Returns all the slugs
	function getRestaurantCount() {
		$query = "SELECT count(*) as total FROM producer WHERE is_restaurant = 1";
		$result = $this->db->query($query);
		
		$row = $result->row(); 
		return $row->total;
	}
	
	
	function getRestaurantsJson($c = '') {

		global $PER_PAGE, $DEFAULT_ZOOM_LEVEL, $ZIPCODE_ZOOM_LEVEL, $CITY_ZOOM_LEVEL;

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
		
		$CI =& get_instance();

		$sustainableWithZipcode = false;

		$arr_filter = explode(',', $filter);

		$arrRestaurantTypeId = array();
		$arrCuisineId = array();

		foreach($arr_filter as $key => $value) {
			if ($value == 's') {
				$sustainableWithZipcode = true;
			} else {
				$arr_value = explode('_', $value) ;

				if ($arr_value[0] == 'r') {
					$arrRestaurantTypeId[] = $arr_value[1];
				}

				if ($arr_value[0] == 'c') {
					$arrCuisineId[] = $arr_value[1];
				}
			}
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
		
		$mapZoomLevel = $DEFAULT_ZOOM_LEVEL;
		
		if ($citySearch == '') {
			if ($q == '') {

				if (isset ($_COOKIE['seachedZip']) && !empty($_COOKIE['seachedZip']) ) {
					$q = $_COOKIE['seachedZip'];
					$mapZoomLevel = $ZIPCODE_ZOOM_LEVEL;
				} else {

					if ($this->session->userdata('isAuthenticated') != 1 ) {
						// If user is NOT logged in, display restaurants from SFO
						$city = '41,6009,13721';
						$mapZoomLevel = $CITY_ZOOM_LEVEL;
					} else {
						// If user is LOGGED in, display restaurants near hiz zipcode
						$q = $this->session->userdata['zipcode'];
						$mapZoomLevel = $ZIPCODE_ZOOM_LEVEL;
						setcookie('seachedZip', $q, time()+60*60*24*30*365);
					}
				}
			} else {
				setcookie('seachedZip', $q, time()+60*60*24*30*365);
				$mapZoomLevel = $ZIPCODE_ZOOM_LEVEL;
			}
		} else {
			$mapZoomLevel = $CITY_ZOOM_LEVEL;
		}
		
		$start = 0;

		$page = 0;

		$base_query = 'SELECT address.*, producer.*, producer.producer, producer_category.producer_category, producer_category.producer_category_id ' .
				' FROM address, producer' . 
				' LEFT JOIN producer_category_member ' .
				'		ON producer.producer_id = producer_category_member.producer_id'.
				' LEFT JOIN producer_category '.
				'		ON producer_category_member.producer_category_id = producer_category.producer_category_id';
				 
		$base_query_count = 'SELECT count(*) AS num_records' .
				' FROM address, producer';
		if ( count($arrRestaurantTypeId) > 0  || count($arrCuisineId) > 0 ) {
			$base_query_count .= 
				' LEFT JOIN producer_category_member ' .
				'		ON producer.producer_id = producer_category_member.producer_id'.
				' LEFT JOIN producer_category '.
				'		ON producer_category_member.producer_category_id = producer_category.producer_category_id';
		}
		
		$where = ' WHERE ';
		if ( !empty($q) ) {
			$where	.= '					address.zipcode = ' . $q . ' AND ';
		} else if ( !empty($city) ) {
			$where	.= '					address.city_id IN (' . $city . ') ' . ' AND ';
		} else if ( !empty($citySearch) ) {
			$where	.= '					address.city_id = ' . $citySearch . ' AND ';
		}
		$where .= ' address.producer_id = producer.producer_id';
		
		$where .= ' AND producer.is_restaurant = 1'.
		         ' AND producer.status = \'live\' ';
		
		
		if ($sustainableWithZipcode || ( !empty($citySearch) ) ) {
			$where	.= ' AND producer.claims_sustainable = 1 ';
		}
		

		if ( count($arrRestaurantTypeId) > 0  || count($arrCuisineId) > 0 ) {
			$where .= ' AND (';

			if(count($arrRestaurantTypeId) > 0 ) {
				$where .= ' producer_category_member.producer_category_id IN (' . implode(',', $arrRestaurantTypeId) . ')';
			}


			if(count($arrCuisineId) > 0 ) {
				// Cuisine
				if(count($arrRestaurantTypeId) > 0 ) {
					$where	.= ' OR ( ';
				} else {
					$where	.= ' ( ';
				}
				$where .= ' producer_category_member.producer_category_id IN (' . implode(',', $arrCuisineId) . ')'
				. '		)';
			}

			$where .= ' )';
		}

		$query = $base_query_count . $where;
		
		$result = $this->db->query($query);
		$row = $result->row();
		$numResults = $row->num_records;

		$query = $base_query . $where;
		$query .= ' GROUP BY producer.producer_id ';
		
		if ( empty($sort) ) {
			$sort_query = ' ORDER BY producer.claims_sustainable';
			$sort = 'cs';
			//$sort = 'claims_sustainable';
		} else {
			if ($sort == 'cs') {
				$sort_query = ' ORDER BY producer.claims_sustainable';
			} else {
				$sort_query = ' ORDER BY ' . $sort;
			}
		}

		if ( empty($order) ) {
			$order = 'DESC';
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
		
		log_message('debug', "RestaurantModel.getRestaurantsJson : " . $query);
		$result = $this->db->query($query);
		
		$restaurants = array();

		$geocodeArray = array();
		foreach ($result->result_object() as $row) {

			
			$this->load->library('RestaurantLib');
			unset($this->RestaurantLib);
			
			$this->RestaurantLib->restaurantId = $row->producer_id;
			$this->RestaurantLib->restaurantName = $row->producer;

			$this->RestaurantLib->creationDate = $row->creation_date;
			$this->RestaurantLib->claimsSustainable = $row->claims_sustainable;
			
			$addresses = $CI->AddressModel->getAddressForProducer($row->producer_id, $q, $city, $citySearch, '');
			
			$this->RestaurantLib->addresses = $addresses;
			
			$CI->load->model('ProducerCategoryModel','',true);
			$cuisines = $CI->ProducerCategoryModel->getCuisinesForRestaurant( $row->producer_id);
			$this->RestaurantLib->cuisines = $cuisines;
			
			$this->RestaurantLib->customUrl = '';
			$firstAddressId = '';
			
			foreach ($addresses as $key => $address) {
				$arrLatLng = array();

				$arrLatLng['latitude'] = $address->latitude;
				$arrLatLng['longitude'] = $address->longitude;
				$arrLatLng['address'] = $address->completeAddress;

				$arrLatLng['addressLine1'] = $address->address;
				$arrLatLng['addressLine2'] = $address->city . ' ' . $address->state;
				$arrLatLng['addressLine3'] = $address->country . ' ' . $address->zipcode;
				$arrLatLng['claimsSustainable'] = $address->claimsSustainable;
				
				$arrLatLng['restaurantName'] = $this->RestaurantLib->restaurantName;
				$arrLatLng['id'] = $address->addressId;
				$geocodeArray[] = $arrLatLng;

				if ($firstAddressId == '') {
					$firstAddressId = $address->addressId;
				}
			}
			
			if ($firstAddressId != '') {
				$customUrl = $CI->CustomUrlModel->getCustomUrlForProducerAddress($row->producer_id, $firstAddressId);
				$this->RestaurantLib->customUrl = $customUrl;
			}
			
			$restaurants[] = $this->RestaurantLib;
			unset($this->RestaurantLib);
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

		$params = requestToParamsCitySearch($numResults, $start, $totalPages, $first, $last, $page, $sort, $order, $q, $filter, $mapZoomLevel, $citySearch);
		$arr = array(
			'results'    => $restaurants,
			'param'      => $params,
			'geocode'	 => $geocodeArray,
		);
		
		return $arr;

	}

    function tagRestaurant($data)
    {
        $this->db->insert('restaurant_consumed', $data);

        return $this->db->insert_id();
    }

}



?>