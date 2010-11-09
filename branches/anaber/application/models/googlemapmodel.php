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
		curl_setopt ($ch, CURLOPT_VERBOSE, 1);
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
				
				/*
				if (count($arr->results) > 1 ) {
					return false;
				} else {
					$a['latitude'] = $arr->results[0]->geometry->location->lat;
					$a['longitude'] = $arr->results[0]->geometry->location->lng;
					return $a;
				}
				*/
			}
		} else {
			return false;
		}
	}
	
}



?>