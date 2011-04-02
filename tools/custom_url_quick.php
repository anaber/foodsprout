<?php
set_time_limit(0);

error_reporting(E_ALL ^ E_WARNING);
	
$defines_file = '../includes/properties.php';
if (file_exists($defines_file)) {
	require_once($defines_file);
} 

$sustainable = new CustomUrl();

$sustainable->index();


class CustomUrl {
	var $db;
	
	function __construct() {
		global $DB_HOST, $DB_USER, $DB_PASSWORD, $DATABSE;
		$this->db = mysql_connect($DB_HOST, $DB_USER, $DB_PASSWORD);
		mysql_select_db($DATABSE, $this->db);
	}
	
	function index() {
		$this->updateBlankCityInAddressTable();
		$this->fetchAddressWithoutCustomUrl();
	}
	
	function updateBlankCityInAddressTable() {
		$query = "SELECT address.* FROM address
					WHERE address.city = ''";
		$result = mysql_query($query);
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			echo $row['address_id'] . "\n";
			$query = 'SELECT * FROM city WHERE city_id = ' . $row['city_id'];
			$result1 = mysql_query($query);
			$row1 = mysql_fetch_array($result1, MYSQL_ASSOC);
			$query = 'UPDATE address SET city = "'.$row1['city'].'" WHERE address_id = ' . $row['address_id'];
			mysql_query($query);
		}
	}
	
	function fetchAddressWithoutCustomUrl() {
		$query = 'SELECT address.address_id, address.producer_id FROM address ORDER BY address_id DESC LIMIT 0, 10000';
		//$query = 'SELECT address.address_id, address.producer_id FROM address LIMIT 0, 100';
		$result = mysql_query($query);
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			$query = 'SELECT custom_url_id FROM custom_url' .
					' WHERE address_id = ' . $row['address_id'] . ' AND producer_id = ' . $row['producer_id'];
			$result1 = mysql_query($query);
			$row1 = mysql_fetch_array($result1, MYSQL_ASSOC);
			if ($row1['custom_url_id'] == "") {
				echo $row['address_id'] . " : Generate : ";
				$this->generateCustomUrl($row['address_id'], $row['producer_id']);
			}
		}
	} 
	
	function generateCustomUrl($addressId, $producerId = '') {
		$query = 'SELECT * FROM producer' .
				' WHERE producer_id = ' . $producerId;
		$result = mysql_query($query);
		$row = mysql_fetch_array($result, MYSQL_ASSOC);
		$producer = $row['producer'];
		
		echo $producer . " : ";
		
		$producer_without_spaces = $this->trimWhiteSpaces(trim($producer));
		$producer_slug = strtolower(str_replace(' ', '-', str_replace("'", '',$producer_without_spaces)));
		$producer_with_city = $producer_without_spaces;
		
		echo $producer_with_city . " : ";
		
		$query = 'SELECT 
						address.*, city.city as city_name
					FROM address 
					LEFT JOIN city 
						ON address.city_id = city.city_id 
					WHERE 
						address.address_id = ' . $addressId;
		$result = mysql_query($query);
		$row1 = mysql_fetch_array($result, MYSQL_ASSOC);
		
		$producer_with_city .= '-' . $this->trimWhiteSpaces(trim($row1['city_name'])); 
		
		echo $producer_with_city . " : ";
		
		$slug = $producer_with_city;
		$slug = strtolower(str_replace(' ', '-', str_replace("'", '',$slug))); 
		echo $slug . " : ";
		
		$query = 'SELECT * FROM custom_url ' .
				' WHERE custom_url = "' . $slug . '"' .
				' AND city = "' . $row1['city_name'] . '"';
		$result = mysql_query($query);

		if (mysql_num_rows($result) == 0) {
			$cityCounter = 1;
		} else {
			//GET RESULT NUM ROWS
			$cityCounter = mysql_num_rows($result);
		}
		echo $cityCounter . " : ";
		
		$query = 'INSERT INTO custom_url (custom_url_id, custom_url, producer_id, address_id, city, city_counter, product_id, user_id)' .
				' VALUES (NULL, "'.$slug.'", '.$producerId.', '.$addressId.', "'.$row1['city_name'].'", '.$cityCounter.', NULL, NULL)';
		
		if ( mysql_query($query) ) {
			$cuatomUrlId = mysql_insert_id();
			echo $cuatomUrlId . "\n";
		}
	}
	
	function trimWhiteSpaces($string){
		$string = str_replace(" - ", " ", $string);
		$string = str_replace(".", "", $string);
		$string = str_replace(",", "", $string);
		$words = explode(" ", $string);
		$newString = ''; 
		if(sizeof($words) == 1 ){
			
			return $words[0];
			
		}else{
			foreach($words as $word){
				if($word != ''){
					$newString .= ' '.$word; 
				}
			}
			return trim($newString);
		}
	}
		
}


?>
