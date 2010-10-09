<?php

class ZipcodeModel extends Model{
	
	function getCoordinatesFromZipcode($zipcode) {
		
		$query = 'SELECT * FROM zipcode WHERE zipcode = "'. $zipcode . '"';
		log_message('debug', "ZipcodeModel.getCoordinatesFromZipcode : " . $query);
		$result = $this->db->query($query);
		
		$row = $result->row();
		$arr = array();
		
		if ($row) {
			
			$arr['zipcode'] = $row->zipcode;
			$arr['latitude'] = $row->latitude;
			$arr['longitude'] = $row->longitude;
			$arr['approximate'] = $row->approximate;
			
			return $arr;
		} else {
			return false;
		}
	}
	
	function addZipcode($zipcode, $latLng) {
		$return = true;
		
		$query = "SELECT * FROM zipcode WHERE zipcode = \"" . $zipcode . "\"";
		log_message('debug', 'ZipcodeModel.addZipcode : Try to get duplicate Zipcode record : ' . $query);
		
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$query = 'INSERT INTO zipcode' .
						' (zipcode, latitude, longitude, approximate, geocoded) ' .
						' VALUES ('.$zipcode.', \''. $latLng['latitude'] .'\', \''. $latLng['longitude'] .'\', \''. $latLng['approximate'] .'\', 1 )';
			log_message('debug', 'ZipcodeModel.addZipcode : Insert Zipcode : ' . $query);
			
			if ( $this->db->query($query) ) {
				$new_zipcode_id = $this->db->insert_id();

				$return = $new_zipcode_id;
			} else {
				$return = false;
			}
		} else {
			$GLOBALS['error'] = 'duplicate_zipcode';
			$return = false;
		}
		
		return $return;	
	}
	
}


?>