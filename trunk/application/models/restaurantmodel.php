<?php

class RestaurantModel extends Model{

	/**
	 * Migration: 		Done
	 * Migration by: 	Deepak
	 */
	// Generate a simple list of the recent restaurants added to the db
	function listNewRestaurants()
	{
		$query = "SELECT producer.*
					FROM producer WHERE is_restaurant = 1
					ORDER BY producer_id DESC limit 5";

		log_message('debug', "RestaurantModel.listNewRestaurants : " . $query);
		$result = $this->db->query($query);

		$restaurants = array();
		$CI =& get_instance();
		foreach ($result->result_array() as $row) {

			$this->load->library('RestaurantLib');
			unset($this->RestaurantLib);

			$this->RestaurantLib->restaurantId = $row['producer_id'];
			$this->RestaurantLib->restaurantName = $row['producer'];
			//$this->RestaurantLib->creationDate = $row['creation_date'];

			$restaurants[] = $this->RestaurantLib;
			unset($this->RestaurantLib);
		}

		return $restaurants;
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
								sin( radians( latitude ) ) ) ) AS distance FROM address HAVING distance <= '.$distance.' ORDER BY distance LIMIT 0 , 50';

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

	/**
	 * Migration: 		Done
	 * Migrated by: 	Deepak
	 * 
	 * Verified: 		Yes
	 * Verified By: 	Deepak
	 */
	function getRestaurantsJson() {

		global $PER_PAGE, $DEFAULT_ZOOM_LEVEL, $ZIPCODE_ZOOM_LEVEL, $CITY_ZOOM_LEVEL;

		$p = $this->input->post('p'); // Page
		$pp = $this->input->post('pp'); // Per Page
		$sort = $this->input->post('sort');
		$order = $this->input->post('order');
		$filter = $this->input->post('f');

		//$filter = 'r_10,c_6';

		$CI =& get_instance();

		$sustainableWithZipcode = false;

		//echo $filter;
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
		//$q = '94117';
		//$filter = 'c_7';

		if ($q == '0') {
			$q = '';
		}

		$city = '';

		$citySearch =  $this->input->post('city');
		//$city = '41,6009,13721';

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

		$base_query = 'SELECT producer.*, producer_category.producer_category, producer_category.producer_category_id' .
				' FROM producer' . 
				' LEFT JOIN producer_category_member ' .
				'		ON producer.producer_id = producer_category_member.producer_id'.
				' LEFT JOIN producer_category '.
				'		ON producer_category_member.producer_category_id = producer_category.producer_category_id';
				 
		$base_query_count = 'SELECT count(*) AS num_records' .
				' FROM producer';
		if ( count($arrRestaurantTypeId) > 0  || count($arrCuisineId) > 0 ) {
			$base_query_count .= 
				' LEFT JOIN producer_category_member ' .
				'		ON producer.producer_id = producer_category_member.producer_id'.
				' LEFT JOIN producer_category '.
				'		ON producer_category_member.producer_category_id = producer_category.producer_category_id';
		}
		
		$where = ' WHERE is_restaurant = 1'.
		         ' AND producer.status = \'live\' ';
		         
		if ($sustainableWithZipcode || ( !empty($citySearch) ) ) {
			$where	.= ' AND claims_sustainable = 1 ';
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

		if ( !empty($q) || !empty($city) || !empty($citySearch) || $sustainableWithZipcode ) {
			if (!empty($where) ) {
				$where .= ' AND (';
			} else {
				$where .= ' WHERE (';
			}

			/*
			 //$where	.= ' OR ( '
			 $where	.= '		SELECT address.address_id'
			 . '			from address, state, country'
			 . '			WHERE'
			 . '				address.restaurant_id = restaurant.restaurant_id'
			 . '				AND address.state_id = state.state_id'
			 . '				AND address.country_id = country.country_id'
			 . ' 			AND (';
			 */
			$where	.= '		SELECT address.address_id'
			. '			from address'
			. '			WHERE'
			. '				address.producer_id = producer.producer_id'
			. ' 			AND (';
			if ( !empty($q) ) {
				$where	.= '					address.zipcode = "' . $q . '"';
			} else if ( !empty($city) ) {
				$where	.= '					address.city_id IN (' . $city . ') ';
			} else if ( !empty($citySearch) ) {
				//$where	.= '					address.city_id = ' . $citySearch . ' AND address.claims_sustainable = 1 ';
				$where	.= '					address.city_id = ' . $citySearch;
			}

			$where	.= '				)'
			. '				LIMIT 0, 1'
			. '		)';

		}

		$query = $base_query_count . $where;
		//echo $query;
		//die;

		$result = $this->db->query($query);
		$row = $result->row();
		$numResults = $row->num_records;

		$query = $base_query . $where;
		$query .= ' GROUP BY producer.producer_id ';
		
		if ( empty($sort) ) {
			$sort_query = ' ORDER BY claims_sustainable DESC, producer';
			$sort = 'claims_sustainable DESC, producer';
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

		$geocodeArray = array();
		foreach ($result->result_array() as $row) {


			$this->load->library('RestaurantLib');
			unset($this->RestaurantLib);

			$this->RestaurantLib->restaurantId = $row['producer_id'];
			$this->RestaurantLib->restaurantName = $row['producer'];

			$this->RestaurantLib->creationDate = $row['creation_date'];
			$this->RestaurantLib->claimsSustainable = $row['claims_sustainable'];

			$CI->load->model('AddressModel','',true);
			//$addresses = $CI->AddressModel->getAddressForCompany( $row['restaurant_id'], '', '', '', '', $q, $city, $citySearch);
			$addresses = $CI->AddressModel->getAddressForProducer($row['producer_id'], $q, $city, $citySearch);
			$this->RestaurantLib->addresses = $addresses;

			$CI->load->model('ProducerCategoryModel','',true);
			$cuisines = $CI->ProducerCategoryModel->getCuisinesForRestaurant( $row['producer_id']);
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
				/*
				 if ($address->claimsSustainable) {
				 $this->RestaurantLib->claimsSustainable = $address->claimsSustainable;
				 }
				 */
				$arrLatLng['restaurantName'] = $this->RestaurantLib->restaurantName;
				$arrLatLng['id'] = $address->addressId;
				$geocodeArray[] = $arrLatLng;

				if ($firstAddressId == '') {
					$firstAddressId = $address->addressId;
				}
			}
			
			if ($firstAddressId != '') {
				$CI->load->model('CustomUrlModel','',true);
				$customUrl = $CI->CustomUrlModel->getCustomUrlForProducerAddress($row['producer_id'], $firstAddressId);
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
		$last = $totalPages - 1;

		if ($numResults == 0) {
			$mapZoomLevel = $DEFAULT_ZOOM_LEVEL;
		}

		$params = requestToParamsCitySearch($numResults, $start, $totalPages, $first, $last, $page, $sort, $order, $q, $filter, $mapZoomLevel, $citySearch);
		$arr = array(
			'results'    => $restaurants,
			'param'      => $params,
			'geocode'	 => $geocodeArray,
		);
		//print_r_pre($arr);
		//die;
		/*
		$arr = array(
		'param' => array('numResults' => 0)
		);
		*/
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

		if ( !empty($q) ) {

			$where  .= ' AND (restaurant.restaurant_name like "' .$q . '%"'
			
			. ' OR restaurant.restaurant_id like "' . $q . '%"';

			$where .= ' )';

		}

		$base_query_count = $base_query_count . $where;

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

		log_message('debug', "RestaurantModel.getRestaurantsJsonAdmin : " . $query);
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
				if ( !$companyId) {
					//$return = false;
					return false;
				}
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
			$restaurantChainId = $this->input->post('restaurantChainId');

			if ($result->num_rows() == 0) {
				$query = "INSERT INTO restaurant (restaurant_id, company_id, restaurant_chain_id, restaurant_type_id, restaurant_name, creation_date, custom_url, phone, fax, email, url, status, track_ip, user_id, facebook, twitter)" .
						" values (NULL, '".$companyId."', " . ( !empty ( $restaurantChainId ) ? $restaurantChainId : 'NULL' ) . ", " . $this->input->post('restaurantTypeId') . ", \"" . $restaurantName . "\", NOW(), '" . $this->input->post('customUrl') . "', '" . $this->input->post('phone') . "', '" . $this->input->post('fax') . "', '" . $this->input->post('email') . "', '" . $this->input->post('url') . "', '" . $this->input->post('status') . "', '" . getRealIpAddr() . "', " . $this->session->userdata['userId'] . ", '" . $this->input->post('facebook') . "', '" . $this->input->post('twitter') . "' )";

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
					$address = $CI->AddressModel->addAddress($newRestaurantId, '', '', '', '', $companyId);
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

//	$query  =	"SELECT restaurant.*, restaurant_chain.restaurant_chain, company.company_name" .
//				" FROM restaurant" .
//				" LEFT JOIN restaurant_chain" .
//				" ON restaurant.restaurant_chain_id = restaurant_chain.restaurant_chain_id" .
//				" LEFT JOIN company" .
//				" ON restaurant.company_id = company.company_id" .
//				" WHERE restaurant.restaurant_id = ".$restaurantId;

		$query = "select * from producer WHERE producer.producer_id = ".$restaurantId;
		
		log_message('debug', "RestaurantModel.getRestaurantFromId : " . $query);
		$result = $this->db->query($query);

		$restaurant = array();

		$this->load->library('RestaurantLib');

		$row = $result->row();


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
			//$this->restaurantLib->companyId = $row->producer_id;
			//$this->restaurantLib->companyName = $row->producer;
			//$this->restaurantLib->restaurantChainId = $row->restaurant_chain_id;
			//$this->restaurantLib->restaurantChain = $row->producer;
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

			$cuisines = $this->getCuisineIdsForRestaurant( $row->producer_id);
			$this->restaurantLib->cuisines = $cuisines;

			$CI =& get_instance();

			$CI->load->model('AddressModel','',true);

			$addresses = $CI->AddressModel->getAddressForProducer($row->producer_id, $q, $city, '');
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
		
		return $result[0]['restaurant_type_id'];
		
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
						'facebook' => $this->input->post('facebook'),
						'twitter' => $this->input->post('twitter'),
						'status' => $this->input->post('status'),
			);
			$where = "restaurant_id = " . $this->input->post('restaurantId');
			$query = $this->db->update_string('restaurant', $data, $where);

			log_message('debug', 'RestaurantModel.updateRestaurant : ' . $query);
			if ( $this->db->query($query) ) {
				//update cuisines
				$this->updateCuisines($this->input->post('restaurantId'), explode(",", $this->input->post('cuisineId')));
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


	function updateCuisines($restaurantId, $cuisineIds) {
		$query = "SELECT cuisine_id FROM restaurant_cuisine WHERE restaurant_id = $restaurantId";
		log_message('debug', 'RestaurantModel.updateCuisines : get existing cuisines : ' . $query);

		$result = $this->db->query($query);
		$existingCuisineIds = array();
		foreach ($result->result_array() as $row) {
			$existingCuisineIds[] = $row['cuisine_id'];
		}

		$action = array();

		foreach($cuisineIds as $cuisineId) {
			$cuisineId = trim($cuisineId);
			if (!(in_array($cuisineId, $existingCuisineIds) > 0)) {
				$query = "INSERT INTO restaurant_cuisine (restaurant_id, cuisine_id) VALUE ( $restaurantId, $cuisineId)";
				log_message('debug', 'RestaurantModel.updateCuisines : insert new cuisine : ' . $query);
				$result = $this->db->query($query);
			} else {
				$action[$cuisineId] = 'update';
			}
		}

		foreach ($existingCuisineIds as $existingCuisineId) {
			if (array_key_exists ($existingCuisineId, $action) ) {
				// Do nothing...
			} else {
				$query = "DELETE FROM restaurant_cuisine WHERE restaurant_id = $restaurantId AND cuisine_id = $existingCuisineId";
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

	function getRestaurantMenusJson() {
		global $PER_PAGE;

		$p = $this->input->post('p'); // Page
		$pp = $this->input->post('pp'); // Per Page
		$sort = $this->input->post('sort');
		$order = $this->input->post('order');

		$q = $this->input->post('q');

		if ($q == '0') {
			$q = '';
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
		$last = $totalPages - 1;

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

		$base_query = 'SELECT restaurant.*, restaurant_chain.restaurant_chain, company.company_name, restaurant_type.restaurant_type, user.email, user.first_name' .
				' FROM restaurant' .
				' LEFT JOIN restaurant_chain' .
				' ON restaurant.restaurant_chain_id = restaurant_chain.restaurant_chain_id' .
				' LEFT JOIN company' .
				' ON restaurant.company_id = company.company_id' . 
				' LEFT JOIN restaurant_type' .
				' ON restaurant.restaurant_type_id = restaurant_type.restaurant_type_id' .
				' LEFT JOIN user' .
				' ON restaurant.user_id = user.user_id';
		;

		$base_query_count = 'SELECT count(*) AS num_records' .
				' FROM restaurant, restaurant_type, user';

		$where = ' WHERE restaurant.restaurant_type_id = restaurant_type.restaurant_type_id ' .
				' AND restaurant.status = \'queue\' ';

		if ( !empty($q) ) {

			$where .= ' AND (restaurant.restaurant_name like "%' .$q . '%")';

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

		log_message('debug', "RestaurantModel.getRestaurantMenusJson : " . $query);
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
		$last = $totalPages - 1;


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
		$where = "restaurant_id = " . $restaurantId;
		$query = $this->db->update_string('restaurant', $data, $where);

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

}



?>