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
		$originalQ = $q;
		$q = strtolower($q);
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
			$cities .= 'Create "'.$originalQ.'"|' . $originalQ;
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
	
	function getCityJsonAdmin() {
		global $PER_PAGE;
		
		$p = $this->input->post('p'); // Page
		$pp = $this->input->post('pp'); // Per Page
		$sort = $this->input->post('sort');
		$order = $this->input->post('order');
		
		$q = $this->input->post('q');
		
		if ($q == '0') {
			$q = '';
		}
		
		$start = 0;
		$page = 0;
		
		
		$base_query = 'SELECT city.*' .
				' FROM city';
		
		$base_query_count = 'SELECT count(city_id) AS num_records' .
				' FROM city';
		$where = '';
		if (! empty ($q) ) {
		$where .= ' WHERE' 
				. '	city like "%' .$q . '%"';
		}
		$base_query_count = $base_query_count . $where;
		
		$query = $base_query_count;
		
		$result = $this->db->query($query);
		$row = $result->row();
		$numResults = $row->num_records;
		
		$query = $base_query . $where;
		
		if ( empty($sort) ) {
			$sort_query = ' ORDER BY city';
			$sort = 'city';
		} else {
			$sort_query = ' ORDER BY ' . $sort;
		}
		
		if ( empty($order) ) {
			$order = 'ASC';
		}
		
		$query = $query . ' ' . $sort_query . ' ' . $order;
		
		if (!empty($pp) && $pp != 'all' ) {
			$PER_PAGE = $pp;
		}
		
		if (!empty($pp) && $pp == 'all') {
			// NO NEED TO LIMIT THE CONTENT
		} else {
			
			if (!empty($p) || $p != 0) {
				$page = $p;
				$p = $p * $PER_PAGE;
				$query .= " LIMIT $p, " . $PER_PAGE;
				$start = $p;
				
			} else {
				$query .= " LIMIT 0, " . $PER_PAGE;
			}
		}
		
		log_message('debug', "CityModel.getCityJsonAdmin : " . $query);
		$result = $this->db->query($query);
		
		$cities = array();
		
		$CI =& get_instance();
		
		foreach ($result->result_array() as $row) {
			
			$this->load->library('CityLib');
			unset($this->CityLib);
			
			$this->CityLib->cityId = $row['city_id'];
			$this->CityLib->city = $row['city'];
			
			$CI->load->model('StateModel','',true);
			$states = $CI->StateModel->getStateFromId($row['state_id']);
			$this->CityLib->states = $states;
			
			$cities[] = $this->CityLib;
			unset($this->CityLib);
		}
		
		if (!empty($pp) && $pp == 'all') {
			$PER_PAGE = $numResults;
		}
		
		$totalPages = ceil($numResults/$PER_PAGE);
		$first = 0;
		$last = $totalPages - 1;		
		
		$params = requestToParams($numResults, $start, $totalPages, $first, $last, $page, $sort, $order, $q, '', '');
		$arr = array(
			'results'    => $cities,
			'param'      => $params,
	    );
	    
	    return $arr;
	}
	
	function getCityBasedOnRestaurant ($restaurantId, $q) {
		$originalQ = $q;
		$q = strtolower($q);
		
		$query = 'SELECT DISTINCT (address.city_id), city.city, city.state_id, state.state_code' .
				' FROM address, city, state' .
				' WHERE address.restaurant_id =1' .
				' AND address.city_id = city.city_id' .
				' AND city.state_id = state.state_id' .
				' AND city.city like "%'.$q.'%"';
		
		$cities = '';
		
		log_message('debug', "CityModel.getCityBasedOnState : " . $query);
		$result = $this->db->query($query);
		
		if ( $result->num_rows() > 0) {
			foreach ($result->result_array() as $row) {
				$cities .= $row['city'] . ', ' . $row['state_code'] ."|".$row['city_id']."\n";
			}
		} else {
			$cities .= 'Create "'.$originalQ.'"|' . $originalQ;
		}
		
		return $cities;
	}
	
	
}


?>