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
		/** 
		 * One time activity
		 */
		//$this->createTempTable();
		//$this->dumpDataToTempTable();
		//$this->verifyNumRecords();
		
		/** 
		 * Triger again and again to generate URL for records which are not processed yet 
		 */
		$this->generateCustomUrl();
		
		/** 
		 * One time activity
		 */
		//$this->dumpDataToCustomUrlTable();	
		//$this->dropTempTable();
	}
	
	
	function generateCustomUrl() {
		
		$query = "SELECT * FROM temp_custom_url WHERE custom_url IS NULL limit 0, 100000";
		$result = mysql_query($query);
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			echo $row['custom_url_id'];
			
			if (!$row['custom_url']) {
				$producer_without_spaces = $this->_trimWhiteSpaces(trim($row['producer']));
				
				$producer_slug = strtolower(str_replace(' ', '-', str_replace("'", '',$producer_without_spaces))); 
				
				$query = 'UPDATE temp_custom_url' .
					' SET ' .
					' producer_slug = \''.$producer_slug.'\' ' .
					' WHERE custom_url_id = ' . $row['custom_url_id'];
				//echo $query . "<br />";
				mysql_query($query);
				
				$producer_with_city = $producer_without_spaces;
				
				if($row['city'] != ''){
					$producer_with_city .= '-'.$this->_trimWhiteSpaces(trim($row['city']));
				}
				
				$slug = $producer_with_city;
				$slug = strtolower(str_replace(' ', '-', str_replace("'", '',$slug))); 
				
				echo '##' . $row['producer'] . '##' . $row['city'] . '##' . $slug . '## Correct Slug : ';
				
				/*
				$query = 'SELECT * ' .
					' FROM temp_custom_url' .
					' WHERE ' .
					' producer_id = ' . $row['producer_id'] .
					' AND city = \''.$row['city'].'\'' .
					' AND custom_url = \''.$slug.'\'';
				*/
				$query = 'SELECT * ' .
					' FROM temp_custom_url' .
					' WHERE ' .
					' producer_slug = \'' . $producer_slug . '\'' . 
					' AND custom_url = \''.$slug.'\'';
				
				//echo $query . "<br />";
				$result1 = mysql_query($query);
				if (mysql_num_rows($result1) == 0) {
					//echo "Update Custom URL <br />";
					$query = 'UPDATE temp_custom_url' .
						' SET ' .
						' custom_url = \''.$slug.'\', ' .
						' city_counter = 1' .
						' WHERE custom_url_id = ' . $row['custom_url_id'];
					//echo $query . "<br />";
					mysql_query($query);
					echo $slug;
				} else {
					
					/*
					$query = 'SELECT * ' .
						' FROM temp_custom_url' .
						' WHERE ' .
						' producer_id = ' . $row['producer_id'] .
						' AND city = \''.$row['city'].'\'' .
						' AND custom_url != \'\'' .
						' ORDER BY city_counter DESC ';
					*/
					$query = 'SELECT * ' .
						' FROM temp_custom_url' .
						' WHERE ' .
						' producer_slug = \'' . $producer_slug . '\'' . 
						' AND city = \''.$row['city'].'\'' .
						' AND custom_url != \'\'' .
						' ORDER BY city_counter DESC ';
					
					//echo $query;
					
					$result1 = mysql_query($query);
					$row1 = mysql_fetch_array($result1, MYSQL_ASSOC);
					
					$city_counter = $row1['city_counter'];
					$city_counter_next = $city_counter +1;
					$slug = $slug . '-' . $city_counter_next;
					//echo $slug;
					/*
					$query = 'SELECT * ' .
						' FROM temp_custom_url' .
						' WHERE ' .
						' producer_id = ' . $row['producer_id'] .
						' AND city = \''.$row['city'].'\'' .
						' AND custom_url = \''.$slug.'\'';
					*/
					$query = 'SELECT * ' .
						' FROM temp_custom_url' .
						' WHERE ' .
						' producer_slug = \'' . $producer_slug . '\'' . 
						' AND city = \''.$row['city'].'\'' .
						' AND custom_url = \''.$slug.'\'';
					
					//echo $query . "\n";
					$result1 = mysql_query($query);
					if (mysql_num_rows($result1) == 0) {
						//echo "Update Custom URL <br />";
						$query = 'UPDATE temp_custom_url' .
							' SET ' .
							' custom_url = \''.$slug.'\', ' .
							' city_counter = ' . $city_counter_next .
							' WHERE custom_url_id = ' . $row['custom_url_id'];
						//echo $query . "<br />";
						echo $slug;
						mysql_query($query);
					} else {
						die("\n Fails at level 2 \n");
					}
				}
			} else {
				echo '## Already generated custom_url'; 
			}
			
			echo "\n";
			
		}
	}
	
	function createTempTable(){
		$query = "CREATE TABLE IF NOT EXISTS `temp_custom_url` (
				  `custom_url_id` int(11) NOT NULL AUTO_INCREMENT,
				  `producer_id` int(11) NOT NULL,
				  `producer` varchar(255) NOT NULL,
				  `producer_slug` varchar(255) DEFAULT NULL,
				  `address_id` int(11) NOT NULL,
				  `city` varchar(95) NOT NULL,
				  `city_counter` int(11) NULL,
				  `custom_url` varchar(255) DEFAULT NULL,
				  `farm_id` int(11) DEFAULT NULL,
				  `manufacture_id` int(11) DEFAULT NULL,
				  `distributor_id` int(11) DEFAULT NULL,
				  `restaurant_id` int(11) DEFAULT NULL,
				  `farmers_market_id` int(11) DEFAULT NULL,
				  PRIMARY KEY (`custom_url_id`),
				  KEY `fk_address_custom_url1` (`custom_url`),
				  KEY `fk_address_restaurant1` (`restaurant_id`),
				  KEY `fk_address_farm1` (`farm_id`),
				  KEY `fk_address_distributor1` (`distributor_id`),
				  KEY `fk_address_farmers_market1` (`farmers_market_id`),
				  KEY `fk_address_manufacture1` (`manufacture_id`),
				  KEY `fk_producer_id` (`producer_id`),
				  KEY `fk_producer_slug` (`producer_slug`)
				) ENGINE=InnoDB  DEFAULT CHARSET=latin1;"; 
		mysql_query($query); 
		echo "Table temp_custom_url created \n";
	}
	
	function dropTempTable(){
		$query = "DROP TABLE `temp_custom_url`";
		mysql_query($query); 
		echo "Table temp_custom_url droped \n";
		
	}
	
	function dumpDataToTempTable(){
		$query = "
				insert into temp_custom_url (producer_id, producer, producer_slug, address_id, city, city_counter, custom_url, farm_id, manufacture_id, distributor_id, restaurant_id, farmers_market_id)
				SELECT
				address.producer_id,
				producer.producer,
				NULL,
				address.address_id,
				address.city,
				NULL,
				NULL,
				address.farm_id,
				address.manufacture_id,
				address.distributor_id,
				address.restaurant_id,
				address.farmers_market_id
				FROM
				address ,
				producer
				WHERE
				address.producer_id =  producer.producer_id		
		"; 
		mysql_query($query); 
		echo "address data dumped from producer and address to temp_custom_url \n"; 
	}
	
	function verifyNumRecords() {
		$query = "select count(address_id) as num_records from address";
		$result = mysql_query($query);
		$row = mysql_fetch_object($result);
		$num_rows1 = $row->num_records;
		
		echo "No. of records in Address table : " . $num_rows1 . "\n";
		
		$query = "select count(custom_url_id) as num_records from temp_custom_url";
		$result = mysql_query($query);
		$row = mysql_fetch_object($result);
		$num_rows2 = $row->num_records;
		
		echo "No. of records in Temp Custom URL table : " . $num_rows2;
		
		if ($num_rows1 == $num_rows2) {
			echo "\n G O O D ! ! ! All data imported correctly from address to temp_custom_url table\n";
		} else {
			echo "\n B A D ! ! ! Something is wrong\n";
		}
	}
	
	function _trimWhiteSpaces($string){
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
	
	function dumpDataToCustomUrlTable(){
		$query = "
				insert into custom_url (custom_url_id, custom_url, producer_id, address_id, city, city_counter, farm_id, manufacture_id, distributor_id, restaurant_id, farmers_market_id, product_id, user_id)
				SELECT custom_url_id, custom_url, producer_id, address_id, city, city_counter, farm_id, manufacture_id, distributor_id, restaurant_id, farmers_market_id, NULL, NULL
				FROM
				temp_custom_url"; 
		mysql_query($query); 
		echo "Data dumped from temp table to main table\n"; 
	}
	
	
}


?>
