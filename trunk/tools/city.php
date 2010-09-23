<?php
set_time_limit(0);

error_reporting(E_ALL ^ E_WARNING);
	
$defines_file = '../includes/properties.php';
if (file_exists($defines_file))
{
	require_once($defines_file);
} 

$city = new CityUpdate();

$city->index();




class CityUpdate {
	var $db;
	
	function __construct() {
		global $DB_HOST, $DB_USER, $DB_PASSWORD, $DATABSE;
		//$this->db = mysql_connect($DB_HOST, $DB_USER, $DB_PASSWORD);
		//mysql_select_db($DATABSE, $this->db);
		$this->db = mysql_connect('174.143.132.250', '468258_food3user', 'R3alF00d');
		mysql_select_db('468258_food3', $this->db);
	}
	
	function index() {
		$this->processAddresses(1, 883587);
		echo "\n\n------------------------V E R I F I C A T I O N---------------------------------\n\n";
		$this->verifyCityName(1, 500000);
	}
	
	function processAddresses($from, $to) {
		
		$query = "SELECT address.* " .
				" FROM address " .
				" WHERE address_id >= $from AND address_id <= $to " .
				" AND address.city_id IS NULL " .
				" ORDER BY address_id";
		
		$result = mysql_query($query);
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			
			echo $row['address_id'] . " : " . $row['city'] . ":";
			
			$cities = $this->searchCityWithinState($row['state_id'], $row['city']);
			
			$city_id = '';
			
			if (count($cities) > 0 ) {
				$city_id = $cities[0]['city_id'];
			} else {
				$city_id = $this->addCity($row['city'], $row['state_id'] );
				//$city_id = 'NEW -- ' . $city_id;
			}
			
			echo "City : " . $city_id  . " : ";
			
			//echo "<PRE>";
			//print_r($cities);
			
			if ($this->updateAddress($row['address_id'], $city_id )) {
				echo "DONE \n";
			} else {
				echo "FAILED \n";
			}
		}
	}
	
	function searchCityWithinState ($stateId, $city) {
		
		$query = 'SELECT city_id, city, state_id 
					FROM city
					WHERE city = "'.trim($city).'"
					AND state_id = ' . $stateId . '
					ORDER BY city ';
		
		$cities = array();
		
		$result = mysql_query($query);
		
		if ( mysql_num_rows($result) > 0) {
			$arr = array();
			
			$row = mysql_fetch_object($result);
			
			$arr['city_id'] = $row->city_id;
			$arr['state_id'] = $row->state_id;
			$arr['city'] = $row->city;
			
			$cities[] = $arr;
		}
		
		return $cities;
	}
	
	function addCity($cityName, $stateId) {
		$return = true;
		
		$query = "SELECT * FROM city WHERE city = \"" . $cityName . "\" AND state_id = " . $stateId;
		
		$result = mysql_query($query);
		
		if (mysql_num_rows($result) == 0) {
			
			$query = "INSERT INTO city (city_id, city, state_id)" .
					" values (NULL, \"" . $cityName . "\", $stateId )";
			
			if ( mysql_query($query) ) {
				$new_city_id = mysql_insert_id();

				$return = $new_city_id;
			} else {
				$return = false;
			}
		} else {
			$GLOBALS['error'] = 'duplicate_city';
			$return = false;
		}
		
		return $return;	
	}
	
	function updateAddress($address_id, $city_id) {
		$return = false;
		
		$query = 'UPDATE address SET ' .
					'city_id = "' . $city_id . '" ' .
					' WHERE address_id = ' . $address_id;
		
		if ( mysql_query($query) ) {
			$return = true;
		} else {
			$return = false;
		}
		
		return $return;
	}
	
	function verifyCityName($from, $to) {
		
		$query = "SELECT address.address_id, address.city_id, address.city as address_city, city.city " .
				" FROM address, city " .
				" WHERE address_id >= $from AND address_id <= $to " .
				" AND address.city_id = city.city_id" .
				" ORDER BY address_id";
		
		$result = mysql_query($query);
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			
			//echo $row['address_id'] . " : " . $row['city_id'] . ":" . $row['address_city'] . ":" . $row['city'] . ":";
			
			if ($row['address_city'] == $row['city']) {
				//echo "DONE \n";
			} else {
				echo $row['address_id'] . " : " . $row['city_id'] . ":" . $row['address_city'] . ":" . $row['city'] . ":";
				echo "FAILED \n";
			}
		}
	}
	
	
	
}


?>
