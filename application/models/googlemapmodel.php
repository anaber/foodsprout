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
	
}



?>