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




class GeoCode {
	var $db;
	
	function __construct() {
		global $DB_HOST, $DB_USER, $DB_PASSWORD, $DATABSE;
		$this->db = mysql_connect($DB_HOST, $DB_USER, $DB_PASSWORD);
		mysql_select_db($DATABSE, $this->db);
	}
	
	function index() {
		$this->processAddresses(59748, 75000);
	}
	
	function processAddresses($from, $to) {
		
		$query = "SELECT address.*, state.state_code, country.country_name FROM address, state, country " .
				" WHERE address_id >= $from AND address_id <= $to " .
				" AND address.state_id = state.state_id" .
				" AND address.country_id = country.country_id" .
				" ORDER BY address_id";
		
		$result = mysql_query($query);
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			
			
			$address = $this->prepareAddress($row['address'], $row['city'], $row['state_code'], $row['country_name'], $row['zipcode']);
			
			echo $row['address_id'] . ":";
			$latLng = array();
			
			$latLng = $this->geoCodeAddress($address);
			
			if ( isset($latLng['latitude']) && !empty($latLng['latitude']) ) {
				if ($this->updateAddress($latLng['latitude'], $latLng['longitude'], $row['address_id']) ) {
					echo "DONE \n";
				} else {
					echo "FAILED \n";
				}
			} else {
				echo "BAD Address : $address \n";
			}
			
		}
	}
	
	function updateAddress($latitude, $longitude, $address_id) {
		$return = false;
		
		$query = 'UPDATE address SET ' .
					'latitude = "' . $latitude . '", ' .
					'longitude = "' . $longitude . '", ' .
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
	
}


?>
