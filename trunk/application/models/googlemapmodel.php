<?php

class GoogleMapModel extends Model{
	
	// List all the animal in the database
	function geoCodeAddress($address) {
		
		global $GOOGLE_MAP_KEY;
		$a = array();
		$url = "http://maps.google.com/maps/geo?q=".urlencode($address)."&output=csv&key=".$GOOGLE_MAP_KEY;
		
		if ($d = @fopen($url, "r")) {
			
			$gcsv = @fread($d, 30000);
			
			@fclose($d);
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
		
		if (!empty($GEOCODE_URL) ) {
			$url = $GEOCODE_URL . "?address=".urlencode($address);
			if ($d = @fopen($url, "r")) {
			
				$json = @fread($d, 30000);
				@fclose($d);
			}
		} else {
			$a = array();
			$url = "http://maps.google.com/maps/api/geocode/json?address=".urlencode($address)."&sensor=false";
			
			if ($d = @fopen($url, "r")) {
			
				$json = @fread($d, 30000);
				@fclose($d);
			}
		}
		
		if ( $json ) {
			$arr = json_decode($json);
			if ($arr->status != 'OK') {
				return false;
			} else {
				$a['latitude'] = $arr->results[0]->geometry->location->lat;
				$a['longitude'] = $arr->results[0]->geometry->location->lng;
				return $a;
			}
		} else {
			return false;
		}
	}
	
}



?>