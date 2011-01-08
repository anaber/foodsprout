<?php
set_time_limit(0);

error_reporting(E_ALL ^ E_WARNING);
	
$defines_file = '../includes/properties.php';
if (file_exists($defines_file))
{
	require_once($defines_file);
} 

$geocode = new GeoCode();

$geocode->index();
//$geocode->geocodeZip();




class GeoCode {
	var $db;
	
	function __construct() {
		global $DB_HOST, $DB_USER, $DB_PASSWORD, $DATABSE;
		$this->db = mysql_connect($DB_HOST, $DB_USER, $DB_PASSWORD);
		mysql_select_db($DATABSE, $this->db);
	}
	
	function index() {
		$this->processAddresses(1, 100000);
	}
	
	function processAddresses($from, $to) {
		// TO-DO : Alter zipcode field from address table before making these changes. 
		// Update zipcode to add 0 before 4 digit zipcodes.
		// ALTER TABLE `address` CHANGE COLUMN `zipcode` `zipcode` VARCHAR(6) NOT NULL  ;
		// UPDATE `address` SET zipcode = CONCAT('0', zipcode) AND geocoded = 0 WHERE CHAR_LENGTH( `zipcode` ) = 4;
		
		$query = "SELECT address.*, state.state_code, country.country_name FROM address, state, country " .
				" WHERE address_id >= $from AND address_id <= $to " .
				" AND address.state_id = state.state_id" .
				" AND address.country_id = country.country_id" .
				" AND geocoded = 0" .
				" ORDER BY address_id";
		
		$result = mysql_query($query);
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			
			
			$address = $this->prepareAddress($row['address'], $row['city'], $row['state_code'], $row['country_name'], $row['zipcode']);
			
			echo $row['address_id'] . ":";
			$latLng = array();
			
			$latLng = $this->geoCodeAddressV3($address);
			//print_r($latLng);die;
			//if ( isset($latLng['latitude']) && !empty($latLng['latitude']) ) {
			if ( $latLng ) {
				if ($this->updateAddress($latLng['latitude'], $latLng['longitude'], $row['address_id'], $latLng) ) {
					echo "DONE \n";
				} else {
					echo "FAILED \n";
				}
			} else {
				echo "BAD Address : $address \n";
			}
			
		}
	}
	
	function updateAddress($latitude, $longitude, $address_id, $latLng) {
		$return = false;
		
		$query = 'UPDATE address SET ' .
					'latitude = "' . $latitude . '", ' .
					'longitude = "' . $longitude . '", ' .
					' approximate = ' . ( ( $latLng['approximate'] == 1 ) ? 1 : 0 ) . ', ' . 
					'geocoded = 1 ' .
					' WHERE address_id = ' . $address_id;
		
		if ( mysql_query($query) ) {
			$return = true;
		} else {
			$return = false;
		}
		
		return $return;
	}
	
	function prepareAddress($address, $city, $state, $country, $zipcode) {
		$address = $address . ' ' . $city . ' ' . $state . ' ' . $country . ' ' . $zipcode;
		
		return $address;
	}
	
	function geoCodeAddress($address) {
		
		global $GOOGLE_MAP_KEY;
		$a = array();
		$url = "http://maps.google.com/maps/geo?q=".urlencode($address)."&output=csv&key=".$GOOGLE_MAP_KEY;
		if ($d = @fopen($url, "r")) {
			$gcsv = @fread($d, 30000);
			@fclose($d);
			//echo $gcsv; die;
			$tmp = explode(",", $gcsv);
			
			if ($tmp[0] != 200) {
				return false;
			} else {
				$a['latitude'] = $tmp[2];
				$a['longitude'] = $tmp[3];
				return $a;
			}
		}
	}
	
	function geoCodeAddressV3($address) {
		global $GEOCODE_URL;
		
		$json = '';
		$a = array();
		
		if (!empty($GEOCODE_URL) ) {
			$url = $GEOCODE_URL . "?address=".urlencode($address);
		} else {	
			$url = "http://maps.google.com/maps/api/geocode/json?address=".urlencode($address)."&sensor=false";
		}
		
		$ch = curl_init ();
		curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_POST, 1); 
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_VERBOSE, 0);
		$json = curl_exec ($ch);
		curl_close($ch);
		
		if ( $json ) {
			$arr = json_decode($json);
			
			if ($arr->status != 'OK') {
				return false;
			} else {
				
				$a['latitude'] = $arr->results[0]->geometry->location->lat;
				$a['longitude'] = $arr->results[0]->geometry->location->lng;
				$a['approximate'] = ( (count($arr->results) > 1) ? 1 : 0 );
				return $a;
			}
		} else {
			return false;
		}
	}
	
	function geocodeZip () {
		/*
		$query = "SELECT * " .
				" FROM zipcode " .
				" ORDER BY zipcode limit 0, 5000";
		$result = mysql_query($query);
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			echo $row['zipcode'] . " : " . $row['latitude'] . " : " . $row['longitude'] . " : " . $row['approximate'] . " : " . $row['geocoded'] . " \n"; 
		}
		die;
		*/
		/*
		$query = "SELECT * " .
				" FROM zip_source " .
				" WHERE CountryID = 223 " .
				" AND Geocoded = 0 " .
				" ORDER BY Zip limit 0, 10000";
		*/
		$query = "SELECT * " .
				" FROM zipcode " .
				" WHERE geocoded = 0 " .
				" ORDER BY zipcode";
		
		$result = mysql_query($query);
		
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			//$zipcode = $row['Zip'];
			//$address = $row['City'] . ", " . $row['State']  . " " . $zipcode . ', USA';
			
			$zipcode = $row['zipcode'];
			$address = $zipcode  . ', USA';
			
			$latLng = $this->geoCodeAddressV3($address);
			
			$query = "SELECT * FROM " .
					" zipcode " .
					" WHERE zipcode = " . $zipcode;
			$result1 = mysql_query($query);
			if (mysql_num_rows($result1) > 0) {
				$query = '';
				
				if ( $latLng ) {
					$query = 'UPDATE zipcode ' .
						' SET latitude = \'' . $latLng['latitude'] . '\', ' .
						' longitude = \'' . $latLng['longitude'] . '\',' .
						' approximate = ' . ( ( $latLng['approximate'] == 1 ) ? 1 : 0 ) . ', ' . 
						' geocoded = 1 ' . 
						' WHERE zipcode =  ' . $zipcode;
					mysql_query($query);
					echo $zipcode . " : DONE \n"; 
					/*
					$query = 'UPDATE zip_source ' .
						' SET Geocoded = 1 ' .
						' WHERE LocationID =  ' . $row['LocationID'];
					mysql_query($query);
					*/
				} else {
					$query = 'UPDATE zipcode ' .
						' SET geocoded = 0 ' .
						' WHERE zipcode =  ' . $zipcode;
					mysql_query($query);
					
					echo $zipcode . " : FAILED #" . $address . "\n";
				}
				
			} else {
				
				$query = '';
				if ( $latLng ) {
					$query = 'INSERT INTO zipcode' .
						' (zipcode, latitude, longitude, approximate, geocoded) ' .
						' VALUES ('.$zipcode.', \''. $latLng['latitude'] .'\', \''. $latLng['longitude'] .'\', \''. $latLng['approximate'] .'\', 1 )';
					mysql_query($query);
					echo $zipcode . " : ADDED \n"; 
					/*
					$query = 'UPDATE zip_source ' .
						' SET Geocoded = 1 ' .
						' WHERE LocationID =  ' . $row['LocationID'];
					mysql_query($query);
					*/
					
				} else {
					$query = 'INSERT INTO zipcode' .
						' (zipcode, latitude, longitude, approximate, geocoded) ' .
						' VALUES ('.$zipcode.', NULL, NULL, NULL, 0 )';
					mysql_query($query);
					
					echo $zipcode . " : ADDED-F #" . $address . "\n"; 
				}
				
			}
			
		}
	}
	
}


?>
