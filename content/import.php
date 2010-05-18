<?php
set_time_limit(0);

	error_reporting(E_ALL ^ E_WARNING);
	
$defines_file = '../includes/properties.php';
if (file_exists($defines_file))
{
	require_once($defines_file);
} 

$import = new Import();

$import->index();




class Import {
	var $db;
	
	protected $restaurantTypeMapping = array(
		'Sandwich Shops' => array(
							'restaurant_type' 		=> 'Deli',
							'restaurant_type_id' 	=> '7',
							'cuisine' 				=> 'Sandwiches',
							'cuisine_id' 			=> '36',
						),
		
		'Bar & Grill Restaurants' => array(
							'restaurant_type' 		=> 'Bar & Grill',
							'restaurant_type_id' 	=> '1',
							'cuisine' 				=> 'Unknown',
							'cuisine_id' 			=> '48',
						),
		'Pizza Restaurants' => array(
							'restaurant_type' 		=> 'Pizzeria',
							'restaurant_type_id' 	=> '14',
							'cuisine' 				=> 'Pizza',
							'cuisine_id' 			=> '34',
						),
		'Home Cooking Restaurants' => array(
							'restaurant_type' 		=> 'Restaurant',
							'restaurant_type_id' 	=> '15',
							'cuisine' 				=> 'Home Style',
							'cuisine_id' 			=> '20',
						),
		'Ice Cream & Frozen Yogurt Shops' => array(
							'restaurant_type' 		=> 'Creamery',
							'restaurant_type_id' 	=> '6',
							'cuisine' 				=> 'Ice Cream & Desserts',
							'cuisine_id' 			=> '21',
						),
		'Lunch Restaurants' => array(
							'restaurant_type' 		=> 'Restaurant',
							'restaurant_type_id' 	=> '15',
							'cuisine' 				=> 'Unknown',
							'cuisine_id' 			=> '48',
						),
		'Family Restaurants' => array(
							'restaurant_type' 		=> 'Restaurant',
							'restaurant_type_id' 	=> '15',
							'cuisine' 				=> 'Home Style',
							'cuisine_id' 			=> '20',
						),
		'Fine Dining Restaurants' => array(
							'restaurant_type' 		=> 'Fine Dining',
							'restaurant_type_id' 	=> '11',
							'cuisine' 				=> 'Unknown',
							'cuisine_id' 			=> '48',
						),
		'Wine Bars' => array(
							'restaurant_type' 		=> 'Wine Bar',
							'restaurant_type_id' 	=> '17',
							'cuisine' 				=> 'Unknown',
							'cuisine_id' 			=> '48',
						),
		'Seafood' => array(
							'restaurant_type' 		=> 'Restaurant',
							'restaurant_type_id' 	=> '15',
							'cuisine' 				=> 'Seafood',
							'cuisine_id' 			=> '37',
						),
		'American Restaurants' => array(
							'restaurant_type' 		=> 'Restaurant',
							'restaurant_type_id' 	=> '15',
							'cuisine' 				=> 'American',
							'cuisine_id' 			=> '1',
						),
		'Restaurants' => array(
							'restaurant_type' 		=> 'Restaurant',
							'restaurant_type_id' 	=> '15',
							'cuisine' 				=> 'Unknown',
							'cuisine_id' 			=> '48',
						),
		'Cafes' => array(
							'restaurant_type' 		=> 'Café',
							'restaurant_type_id' 	=> '3',
							'cuisine' 				=> 'Unknown',
							'cuisine_id' 			=> '48',
						),
		'Thai Restaurants' => array(
							'restaurant_type' 		=> 'Restaurant',
							'restaurant_type_id' 	=> '15',
							'cuisine' 				=> 'Thai',
							'cuisine_id' 			=> '45',
						),
		'Restaurant Cleaning Services' => array(
							'restaurant_type' 		=> 'Restaurant Services',
							'restaurant_type_id' 	=> '16',
							'cuisine' 				=> 'Unknown',
							'cuisine_id' 			=> '48',
						),
		'Truck Stops' => array(
							'restaurant_type' 		=> 'Conveinent Store',
							'restaurant_type_id' 	=> '5',
							'cuisine' 				=> 'Unknown',
							'cuisine_id' 			=> '48',
						),
		'Dinner Theater Restaurants' => array(
							'restaurant_type' 		=> 'Dinner Theater',
							'restaurant_type_id' 	=> '9',
							'cuisine' 				=> 'Unknown',
							'cuisine_id' 			=> '48',
						),
		'Cajun & Creole Restaurants' => array(
							'restaurant_type' 		=> 'Restaurant',
							'restaurant_type_id' 	=> '15',
							'cuisine' 				=> 'Cajun & Creole',
							'cuisine_id' 			=> '8',
						),
		'Steak & Barbecue Restaurants' => array(
							'restaurant_type' 		=> 'Restaurant',
							'restaurant_type_id' 	=> '15',
							'cuisine' 				=> 'Steak & Barbecue',
							'cuisine_id' 			=> '42',
						),
		'Chicken Restaurants' => array(
							'restaurant_type' 		=> 'Restaurant',
							'restaurant_type_id' 	=> '15',
							'cuisine' 				=> 'Unknown',
							'cuisine_id' 			=> '48',
						),
		'Delicatessens Retail' => array(
							'restaurant_type' 		=> 'Deli',
							'restaurant_type_id' 	=> '7',
							'cuisine' 				=> 'Sandwiches',
							'cuisine_id' 			=> '36',
						),
		'Burger Restaurants' => array(
							'restaurant_type' 		=> 'Restaurant',
							'restaurant_type_id' 	=> '15',
							'cuisine' 				=> 'American',
							'cuisine_id' 			=> '1',
						),
		'Fast Foods & Carry Out' => array(
							'restaurant_type' 		=> 'Fast Food',
							'restaurant_type_id' 	=> '10',
							'cuisine' 				=> 'Fast Food',
							'cuisine_id' 			=> '13',
						),
		'Crab House Restaurants' => array(
							'restaurant_type' 		=> 'Restaurant',
							'restaurant_type_id' 	=> '15',
							'cuisine' 				=> 'Seafood',
							'cuisine_id' 			=> '37',
						),
		'Asian Restaurants' => array(
							'restaurant_type' 		=> 'Restaurant',
							'restaurant_type_id' 	=> '15',
							'cuisine' 				=> 'Asian',
							'cuisine_id' 			=> '3',
						),
		'Continental Cuisine Restaurants' => array(
							'restaurant_type' 		=> 'Restaurant',
							'restaurant_type_id' 	=> '15',
							'cuisine' 				=> 'Continental',
							'cuisine_id' 			=> '10',
						),
		'Steak & Seafood Restaurants' => array(
							'restaurant_type' 		=> 'Restaurant',
							'restaurant_type_id' 	=> '15',
							'cuisine' 				=> 'Steak & Seafood',
							'cuisine_id' 			=> '43',
						),
		'Fish & Chips Restaurants' => array(
							'restaurant_type' 		=> 'Restaurant',
							'restaurant_type_id' 	=> '15',
							'cuisine' 				=> 'Fish & Chips',
							'cuisine_id' 			=> '14',
						),
		'Spanish Restaurants' => array(
							'restaurant_type' 		=> 'Restaurant',
							'restaurant_type_id' 	=> '15',
							'cuisine' 				=> 'Spanish',
							'cuisine_id' 			=> '41',
						),
		'Pasta Restaurants' => array(
							'restaurant_type' 		=> 'Restaurant',
							'restaurant_type_id' 	=> '15',
							'cuisine' 				=> 'Pasta',
							'cuisine_id' 			=> '33',
						),
		'Indian Restaurants' => array(
							'restaurant_type' 		=> 'Restaurant',
							'restaurant_type_id' 	=> '15',
							'cuisine' 				=> 'Indian',
							'cuisine_id' 			=> '22',
						),
		'Buffets Restaurants' => array(
							'restaurant_type' 		=> 'Restaurant',
							'restaurant_type_id' 	=> '15',
							'cuisine' 				=> 'Buffets',
							'cuisine_id' 			=> '7',
						),
		'Jamaican Restaurants' => array(
							'restaurant_type' 		=> 'Restaurant',
							'restaurant_type_id' 	=> '15',
							'cuisine' 				=> 'Jamaican',
							'cuisine_id' 			=> '24',
						),
		'Breakfast & Brunch Restaurants' => array(
							'restaurant_type' 		=> 'Restaurant',
							'restaurant_type_id' 	=> '15',
							'cuisine' 				=> 'Breakfast & Brunch',
							'cuisine_id' 			=> '6',
						),
		'Korean Restaurants' => array(
							'restaurant_type' 		=> 'Restaurant',
							'restaurant_type_id' 	=> '15',
							'cuisine' 				=> 'Korean',
							'cuisine_id' 			=> '26',
						),
		'Japanese Restaurants' => array(
							'restaurant_type' 		=> 'Restaurant',
							'restaurant_type_id' 	=> '15',
							'cuisine' 				=> 'Japanese',
							'cuisine_id' 			=> '25',
						),
		'French Restaurants' => array(
							'restaurant_type' 		=> 'Restaurant',
							'restaurant_type_id' 	=> '15',
							'cuisine' 				=> 'French',
							'cuisine_id' 			=> '15',
						),
		'Vietnamese Restaurants' => array(
							'restaurant_type' 		=> 'Restaurant',
							'restaurant_type_id' 	=> '15',
							'cuisine' 				=> 'Vietnamese',
							'cuisine_id' 			=> '47',
						),
		'Dessert Restaurants' => array(
							'restaurant_type' 		=> 'Restaurant',
							'restaurant_type_id' 	=> '15',
							'cuisine' 				=> 'Desserts',
							'cuisine_id' 			=> '11',
						),
		'Italian Restaurants' => array(
							'restaurant_type' 		=> 'Restaurant',
							'restaurant_type_id' 	=> '15',
							'cuisine' 				=> 'Italian',
							'cuisine_id' 			=> '23',
						),
		'Kosher Restaurants' => array(
							'restaurant_type' 		=> 'Restaurant',
							'restaurant_type_id' 	=> '15',
							'cuisine' 				=> 'Kosher',
							'cuisine_id' 			=> '27',
						),
		'Diners' => array(
							'restaurant_type' 		=> 'Diner',
							'restaurant_type_id' 	=> '8',
							'cuisine' 				=> 'Unknown',
							'cuisine_id' 			=> '48',
						),
		'Greek Restaurants' => array(
							'restaurant_type' 		=> 'Restaurant',
							'restaurant_type_id' 	=> '15',
							'cuisine' 				=> 'Greek',
							'cuisine_id' 			=> '18',
						),
		'Sushi Bars' => array(
							'restaurant_type' 		=> 'Restaurant',
							'restaurant_type_id' 	=> '15',
							'cuisine' 				=> 'Sushi',
							'cuisine_id' 			=> '44',
						),
		'Chinese Restaurants' => array(
							'restaurant_type' 		=> 'Restaurant',
							'restaurant_type_id' 	=> '15',
							'cuisine' 				=> 'Chinese',
							'cuisine_id' 			=> '9',
						),
		'Vegetarian Restaurants' => array(
							'restaurant_type' 		=> 'Restaurant',
							'restaurant_type_id' 	=> '15',
							'cuisine' 				=> 'Vegetarian',
							'cuisine_id' 			=> '46',
						),
		'Mediterranean Restaurants' => array(
							'restaurant_type' 		=> 'Restaurant',
							'restaurant_type_id' 	=> '15',
							'cuisine' 				=> 'Mediterranean',
							'cuisine_id' 			=> '29',
						),
		'Oriental Restaurants' => array(
							'restaurant_type' 		=> 'Restaurant',
							'restaurant_type_id' 	=> '15',
							'cuisine' 				=> 'Oriental',
							'cuisine_id' 			=> '32',
						),
		'Late Night Dining Restaurants' => array(
							'restaurant_type' 		=> 'Late Night Dining',
							'restaurant_type_id' 	=> '13',
							'cuisine' 				=> 'Unknown',
							'cuisine_id' 			=> '48',
						),
		'Latin American Restaurants' => array(
							'restaurant_type' 		=> 'Restaurant',
							'restaurant_type_id' 	=> '15',
							'cuisine' 				=> 'Latin American',
							'cuisine_id' 			=> '28',
						),
		'Health Food Restaurants' => array(
							'restaurant_type' 		=> 'Restaurant',
							'restaurant_type_id' 	=> '15',
							'cuisine' 				=> 'Health Food',
							'cuisine_id' 			=> '19',
						),
		'Catfish Restaurants' => array(
							'restaurant_type' 		=> 'Restaurant',
							'restaurant_type_id' 	=> '15',
							'cuisine' 				=> 'Seafood',
							'cuisine_id' 			=> '37',
						),
		'Southwestern Restaurants' => array(
							'restaurant_type' 		=> 'Restaurant',
							'restaurant_type_id' 	=> '15',
							'cuisine' 				=> 'Southwestern',
							'cuisine_id' 			=> '40',
						),
		'Cafeterias' => array(
							'restaurant_type' 		=> 'Cafeterias',
							'restaurant_type_id' 	=> '4',
							'cuisine' 				=> 'Unknown',
							'cuisine_id' 			=> '48',
						),
		'Soul Food Restaurants' => array(
							'restaurant_type' 		=> 'Restaurant',
							'restaurant_type_id' 	=> '15',
							'cuisine' 				=> 'Soul Food',
							'cuisine_id' 			=> '38',
						),
		'Mexican Restaurants' => array(
							'restaurant_type' 		=> 'Restaurant',
							'restaurant_type_id' 	=> '15',
							'cuisine' 				=> 'Mexican',
							'cuisine_id' 			=> '30',
						),
		'Southern Style Restaurants' => array(
							'restaurant_type' 		=> 'Restaurant',
							'restaurant_type_id' 	=> '15',
							'cuisine' 				=> 'Southern Style',
							'cuisine_id' 			=> '39',
						),
		'Dim Sum Restaurants' => array(
							'restaurant_type' 		=> 'Restaurant',
							'restaurant_type_id' 	=> '15',
							'cuisine' 				=> 'Dim Sum',
							'cuisine_id' 			=> '12',
						),
		'Pancakes & Waffles Restaurants' => array(
							'restaurant_type' 		=> 'Restaurant',
							'restaurant_type_id' 	=> '15',
							'cuisine' 				=> 'Breakfast & Brunch',
							'cuisine_id' 			=> '6',
						),
		'German Restaurants' => array(
							'restaurant_type' 		=> 'Restaurant',
							'restaurant_type_id' 	=> '15',
							'cuisine' 				=> 'German',
							'cuisine_id' 			=> '16',
						),
		'Gourmet Restaurants' => array(
							'restaurant_type' 		=> 'Restaurant',
							'restaurant_type_id' 	=> '15',
							'cuisine' 				=> 'Gourmet',
							'cuisine_id' 			=> '17',
						),
		'Waterfront Restaurants' => array(
							'restaurant_type' 		=> 'Restaurant',
							'restaurant_type_id' 	=> '15',
							'cuisine' 				=> 'Unknown',
							'cuisine_id' 			=> '48',
						),
		'Country Dining Restaurants' => array(
							'restaurant_type' 		=> 'Restaurant',
							'restaurant_type_id' 	=> '15',
							'cuisine' 				=> 'Home Style',
							'cuisine_id' 			=> '20',
						),
		'Karaoke Restaurants' => array(
							'restaurant_type' 		=> 'Karaoke',
							'restaurant_type_id' 	=> '12',
							'cuisine' 				=> 'Unknown',
							'cuisine_id' 			=> '48',
						),
		'Bistros' => array(
							'restaurant_type' 		=> 'Bistro',
							'restaurant_type_id' 	=> '2',
							'cuisine' 				=> 'Unknown',
							'cuisine_id' 			=> '48',
						),
		'New American Restaurants' => array(
							'restaurant_type' 		=> 'Restaurants',
							'restaurant_type_id' 	=> '15',
							'cuisine' 				=> 'New American',
							'cuisine_id' 			=> '31',
						),
		'Restaurant Equipment & Services' => array(
							'restaurant_type' 		=> 'Restaurant Services',
							'restaurant_type_id' 	=> '16',
							'cuisine' 				=> 'Unknown',
							'cuisine_id' 			=> '48',
						),
		'Basque Restaurants' => array(
							'restaurant_type' 		=> 'Restaurant',
							'restaurant_type_id' 	=> '15',
							'cuisine' 				=> 'Basque',
							'cuisine_id' 			=> '5',
						),
		'Raw Bar Restaurants' => array(
							'restaurant_type' 		=> 'Restaurant',
							'restaurant_type_id' 	=> '15',
							'cuisine' 				=> 'Raw Bar',
							'cuisine_id' 			=> '35',
						),
		'Armenian Restaurants' => array(
							'restaurant_type' 		=> 'Restaurant',
							'restaurant_type_id' 	=> '15',
							'cuisine' 				=> 'Armenian',
							'cuisine_id' 			=> '2',
						),
		'Omelet & Quiche Restaurants' => array(
							'restaurant_type' 		=> 'Restaurant',
							'restaurant_type_id' 	=> '15',
							'cuisine' 				=> 'Breakfast & Brunch',
							'cuisine_id' 			=> '6',
						),
		'Fast Food Restaurants' => array(
							'restaurant_type' 		=> 'Fast Food',
							'restaurant_type_id' 	=> '10',
							'cuisine' 				=> 'Fast Food',
							'cuisine_id' 			=> '13',
						),
		'Barbecue Restaurants' => array(
							'restaurant_type' 		=> 'Restaurant',
							'restaurant_type_id' 	=> '15',
							'cuisine' 				=> 'Barbecue',
							'cuisine_id' 			=> '4',
						),
						
	);
	
	function __construct() {
		global $DB_HOST, $DB_USER, $DB_PASSWORD, $DATABSE;
		$this->db = mysql_connect($DB_HOST, $DB_USER, $DB_PASSWORD);
		mysql_select_db($DATABSE, $this->db);
	}
	
	function index() {
		$this->importRestaurantData(1, 5000);
		
		/*
		//for($i = 93001; $i <= 93200; $i+=100) {
		for($i = 1; $i <= 100; $i+=100) {
			$from = $i;
			$to = $from + 99;
			
			echo $from . ": "  . $to . "\n";
			$this->importRestaurantData($from, $to);
		}
		*/
	}
	
	function importRestaurantData($from, $to) {
		
		$restaurantChain = $this->getRestaurantChain();
		
		$query = "SELECT biz_restaurants.*, state.state_id " .
				" FROM biz_restaurants, state " .
				" WHERE bizID >= $from AND bizID <= $to " .
				" AND biz_restaurants.bizState = state.state_code" .
				" ORDER BY bizID";
		
		$notFound = array();
		$notFoundCount = 1;
		$result = mysql_query($query);
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			
			// Chain
			$restaurantChainId = '';
			$restaurantChainRestaurantTypeId = '';
			
			$masterRestaurantName = $row['bizName'];
			
			$matchFound =  false;
			
			foreach ($restaurantChain as $restaurantChainName => $restaurantChainData) {
				
				
				$pattern = "/^$restaurantChainName/i";
				
				if (preg_match($pattern, $masterRestaurantName, $matches, PREG_OFFSET_CAPTURE) ) {
					
					$restaurantChainId = $restaurantChainData['restaurant_chain_id'];
					$restaurantChainRestaurantTypeId = $restaurantChainData['restaurant_type_id'];
					$matchFound =  true;
					break;
				}
			}
			
			echo "\n" . $row['bizID'] . ": ";
			
			// COMPANY
			$companyId = $this->getCompany($masterRestaurantName);
			
			// COUNTY
			$countyId = $this->getCounty($row['locCounty']);
			
			// CITY
			$cityId = $this->getCity($row['bizCity'], $row['state_id']);
			
			// MSA
			$msaId = '';
			if (!empty($row['locMSA']) ) {
				$msaId = $this->getMsa($row['locMSA']);
			}
			
			// MSA
			$pmsaId = '';
			if (!empty($row['locPMSA']) ) {
				$pmsaId = $this->getPmsa($row['locPMSA']);
			}
			
			// RESTAURANT TYPE
			$restaurantTypeId = $this->restaurantTypeMapping[$row['bizCatSub']]['restaurant_type_id'];
			
			// CUISINE
			$cuisineId = $this->restaurantTypeMapping[$row['bizCatSub']]['cuisine_id'];
			
			// RESTAURANT
			$restaurantId = $this->getRestaurant($row, $companyId, $restaurantChainId, $restaurantTypeId);
			
			// RESTAURANT CUISINE
			$this->getRestaurantCuisine($restaurantId, $cuisineId);
			
			// RESTAURANT ADDRESS
			if ($this->getRestaurantAddress($row, $cityId, $countyId, $companyId, $restaurantId, $msaId, $pmsaId) ) {
				echo "DONE";
			} else {
				echo "FAILED";
			}
			
		}
		
		
	}
	
	function getRestaurantAddress($row, $cityId, $countyId, $companyId, $restaurantId, $msaId, $pmsaId) {
		$query = 'SELECT * FROM address WHERE import_biz_id = "' . $row['bizID'] . '"';
		
		$result = mysql_query($query);
		
		$restaurantAddessId = '';
		$return = false;
		
		if (mysql_num_rows($result) == 0) {
			
			$query = "INSERT INTO address (address_id, address, city, city_id, state_id, county_id, zipcode, country_id, latitude, longitude, company_id, farm_id, manufacture_id, distributor_id, restaurant_id, msa_id, pmsa_id, import_biz_id)" .
						" values (NULL, \"" . $row['bizAddr'] . "\", \"" . $row['bizCity'] . "\", \"" . $cityId . "\", \"" . $row['state_id'] . "\",  \"" . $countyId . "\",  \"" . $row['bizZip'] . "\", 1,  \"" . $row['locLat'] . "\",  \"" . $row['locLong'] . "\", $companyId, NULL, NULL, NULL, $restaurantId, '" . $row['locMSA'] . "',  '" . $row['locPMSA'] . "', '" . $row['bizID'] . "')";
			
			if ( mysql_query($query) ) {
				$restaurantAddessId = mysql_insert_id();
				$return = true;
			} else {
				$return = false;
			}
			
		} else {
			
			$row2 = mysql_fetch_object($result);
			$restaurantAddessId = $row2->address_id;
			
			$query = 'UPDATE address SET ' .
					'address = "' . $row['bizAddr'] . '", ' .  
					'city = "' . $row['bizCity'] . '", ' .
					'city_id = ' . $cityId . ', '.
					'state_id = ' . $row['state_id'] . ', ' . 
					'county_id = ' . $countyId . ', ' .
					'zipcode = "' . $row['bizZip'] . '", ' .
					'country_id = 1, ' .
					'latitude = "' . $row['locLat'] . '", ' .
					'longitude = "' . $row['locLong'] . '", ' .
					'company_id = ' . $companyId . ', ' .
					'restaurant_id = ' . $restaurantId . ', ' .
					'msa_id = ' . ( !empty($msaId)? $msaId: 'NULL' ) . ', ' .
					'pmsa_id = ' . ( !empty($pmsaId)? $pmsaId: 'NULL' ).
					' WHERE address_id = ' . $restaurantAddessId;
			
			if ( mysql_query($query) ) {
				$return = true;
			} else {
				$return = false;
			}
		}
		return $return;
	}
	
	function getRestaurant($row, $companyId, $restaurantChainId, $restaurantTypeId) {
		$query = 'SELECT * FROM restaurant WHERE restaurant_name = "' . $row['bizName'] . '"';
		$result = mysql_query($query);
		
		$restaurantId = '';
		
		if (mysql_num_rows($result) == 0) {
			$query = "INSERT INTO restaurant (restaurant_id, company_id, restaurant_chain_id, restaurant_type_id, restaurant_name, creation_date, custom_url, city_area_id, user_id, phone, fax, email, url, is_active)" .
						" values (NULL, ".$companyId.", " . ( !empty($restaurantChainId)? $restaurantChainId: 'NULL' ) . ", " . $restaurantTypeId . ", \"" . $row['bizName'] . "\", NOW(), NULL, NULL, NULL, '" . $row['bizPhone'] . "',  '" . $row['bizFax'] . "',  '" . $row['bizEmail'] . "',  '" . $row['bizURL'] . "', 1 )";
			
			if ( mysql_query($query) ) {
				$restaurantId = mysql_insert_id();
				$return = true;
			} else {
				$return = false;
			}
		} else {
			$row2 = mysql_fetch_object($result);
			$restaurantId = $row2->restaurant_id;
			
			$query = 'UPDATE restaurant SET ' .
					'company_id = ' . $companyId . ', ' .  
					'restaurant_chain_id = ' . ( !empty($restaurantChainId)? $restaurantChainId: 'NULL' ) . ', ' .
					'restaurant_type_id = ' . $restaurantTypeId . ', '.
					'restaurant_name = "' . $row['bizName'] . '", ' . 
					'phone = "' . $row['bizPhone'] . '", ' .
					'fax = "' . $row['bizFax'] . '", ' .
					'email = "' . $row['bizEmail'] . '", ' .
					'url = "' . $row['bizURL'] . '" ' .
					' WHERE restaurant_id = ' . $restaurantId;
			
			if ( mysql_query($query) ) {
				$return = true;
			} else {
				$return = false;
			}
		}
		
		return $restaurantId;
	}
	
	function getRestaurantCuisine($restaurantId, $cuisineId) {
		$query = 'SELECT * FROM restaurant_cuisine WHERE restaurant_id = "' . $restaurantId . '" AND cuisine_id = ' . $cuisineId;
		$result = mysql_query($query);
		
		$restaurantCuisineId = '';
		
		if (mysql_num_rows($result) == 0) {
			$query = "INSERT INTO restaurant_cuisine (restaurant_cuisine_id, restaurant_id, cuisine_id)" .
					" values (NULL, " . $restaurantId . ", " . $cuisineId . " )";
			if ( mysql_query($query) ) {
				$restaurantCuisineId = mysql_insert_id();
			}
		} else {
			$row = mysql_fetch_object($result);
			$restaurantCuisineId = $row->restaurant_cuisine_id;
		}
		
		return $restaurantCuisineId;
	}
	
	function getCompany($companyName) {
		$query = 'SELECT * FROM company WHERE company_name = "' . $companyName . '"';
		$result = mysql_query($query);
		
		$companyId = '';
		
		if (mysql_num_rows($result) == 0) {
			$query = "INSERT INTO company (company_id, company_name, creation_date)" .
					" values (NULL, \"" . $companyName . "\", NOW() )";
			if ( mysql_query($query) ) {
				$companyId = mysql_insert_id();
			}
			
		} else {
			$row = mysql_fetch_object($result);
			$companyId = $row->company_id;
		}
		
		return $companyId;
	}
	
	function getCounty($county) {
		$query = 'SELECT * FROM county WHERE county = "' . $county . '"';
		$result = mysql_query($query);
		
		$countyId = '';
		
		if (mysql_num_rows($result) == 0) {
			$query = "INSERT INTO county (county_id, county)" .
					" values (NULL, \"" . $county . "\" )";
			if ( mysql_query($query) ) {
				$countyId = mysql_insert_id();
			}
		} else {
			$row = mysql_fetch_object($result);
			$countyId = $row->county_id;
		}
		
		return $countyId;
	}
	
	function getCity($city, $stateId) {
		$query = 'SELECT * FROM city WHERE city = "' . $city . '" AND state_id = ' . $stateId;
		$result = mysql_query($query);
		
		$cityId = '';
		
		if (mysql_num_rows($result) == 0) {
			$query = "INSERT INTO city (city_id, state_id, city)" .
					" values (NULL, $stateId, \"" . $city . "\" )";
			if ( mysql_query($query) ) {
				$cityId = mysql_insert_id();
			}
		} else {
			$row = mysql_fetch_object($result);
			$cityId = $row->city_id;
		}
		
		return $cityId;
	}
	
	function getMsa($msa_code) {
		$query = 'SELECT * FROM msa WHERE msa_code = "' . $msa_code . '"';
		$result = mysql_query($query);
		
		$msaId = '';
		
		if (mysql_num_rows($result) == 0) {
			$query = "INSERT INTO msa (msa_id, msa_code, msa)" .
					" values (NULL, \"" . $msa_code . "\", NULL )";
			if ( mysql_query($query) ) {
				$msaId = mysql_insert_id();
			}
		} else {
			$row = mysql_fetch_object($result);
			$msaId = $row->msa_id;
		}
		
		return $msaId;
	}
	
	function getPmsa($pmsa_code) {
		$query = 'SELECT * FROM pmsa WHERE pmsa_code = "' . $pmsa_code . '"';
		$result = mysql_query($query);
		
		$pmsaId = '';
		
		if (mysql_num_rows($result) == 0) {
			$query = "INSERT INTO pmsa (pmsa_id, pmsa_code, pmsa)" .
					" values (NULL, \"" . $pmsa_code . "\", NULL )";
			if ( mysql_query($query) ) {
				$pmsaId = mysql_insert_id();
			}
		} else {
			$row = mysql_fetch_object($result);
			$pmsaId = $row->pmsa_id;
		}
		
		return $pmsaId;
	}
	
	
	function getRestaurantChain() {
		$query = 'SELECT * FROM restaurant_chain ORDER BY restaurant_chain';
		
		$result = mysql_query($query);
		
		$restaurantChain = array();
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			$restaurantChain[ $row['match_string'] ] = array(
												'restaurant_chain_id' => $row['restaurant_chain_id'],
												'restaurant_type_id' => $row['restaurant_type_id'],
											);
		}
		return $restaurantChain;
		
	}
}


?>
