<?php

class CityModel extends Model{
	
	function getCityFromName($cityId) {
		
		$query = 'SELECT * FROM city WHERE city = "'. $cityId . '"';
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