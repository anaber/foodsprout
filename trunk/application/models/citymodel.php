<?php

class CityModel extends Model{
	
	function getCityFromName($city) {
		
		$query = 'SELECT * FROM city WHERE city = "'. $city . '"';
		log_message('debug', "CityModel.getCityFromName : " . $query);
		$result = $this->db->query($query);
		
		$this->load->library('CityLib');
		$row = $result->row();
		
		if ($row) {
			$this->cityLib->cityId = $row->city_id;
			$this->cityLib->stateId = $row->state_id;
			$this->cityLib->city = $row->city;
			
			return $this->cityLib;
		} else {
			return false;
		}
	}
	
	function getCityBasedOnState ($stateId, $q) {
		
		$query = 'SELECT city_id, city
					FROM city
					WHERE city like "%'.$q.'%"
					AND state_id = ' . $stateId . '
					ORDER BY city ';
		
		$cities = '';
		
		log_message('debug', "CityModel.getCityBasedOnState : " . $query);
		$result = $this->db->query($query);
		
		if ( $result->num_rows() > 0) {
			foreach ($result->result_array() as $row) {
				$cities .= $row['city']."|".$row['city_id']."\n";
			}
		} else {
			$cities .= 'Create "'.$q.'"|' . $q;
		}
		
		return $cities;
	}
	
	function addCity($cityName, $stateId) {
		$return = true;
		
		$query = "SELECT * FROM city WHERE city = \"" . $cityName . "\" AND state_id = " . $stateId;
		log_message('debug', 'CityModel.addCity : Try to get duplicate City record : ' . $query);
		
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$query = "INSERT INTO city (city_id, city, state_id)" .
					" values (NULL, \"" . $cityName . "\", $stateId )";
			log_message('debug', 'CityModel.addCity : Insert City : ' . $query);
			
			if ( $this->db->query($query) ) {
				$new_city_id = $this->db->insert_id();

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
	
	function getCityFromId($cityId) {
		
		$query = 'SELECT * FROM city WHERE city_id = "'. $cityId . '"';
		log_message('debug', "CityModel.getCityFromId : " . $query);
		$result = $this->db->query($query);
		
		$this->load->library('CityLib');
		$row = $result->row();
		
		if ($row) {
			$this->cityLib->cityId = $row->city_id;
			$this->cityLib->stateId = $row->state_id;
			$this->cityLib->city = $row->city;
			
			return $this->cityLib;
		} else {
			return false;
		}
	}
	
	
}


?>