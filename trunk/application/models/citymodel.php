<?php

class CityModel extends Model{
	
	public $custom_url = '';
	
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
			$this->cityLib->customUrl = $row->custom_url;
			
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
	
	function getCitiesForProducer ($producerId, $q) {
		$originalQ = $q;
		$q = strtolower($q);
		
		$query = 'SELECT DISTINCT (address.city_id), city.city, city.state_id, state.state_code' .
				' FROM address, city, state' .
				' WHERE address.producer_id = ' . $producerId .
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
	
	function getCityFromZipDetails ($zipDetails) {
		
		$query = 'SELECT city_id, city.city, city.state_id, state.state_code, state.state_name' .
				' FROM city, state' .
				' WHERE city.state_id = state.state_id' .
				' AND city.city = "'.$zipDetails['city'] .'"' .
				' AND state.state_code = "'.$zipDetails['state_code'] .'"';
		
		log_message('debug', "CityModel.getCityFromZipDetails : " . $query);
		$result = $this->db->query($query);
		
		$this->load->library('CityLib');
		$row = $result->row();
		
		if ($row) {
			$this->cityLib->cityId = $row->city_id;
			$this->cityLib->city = $row->city;
			$this->cityLib->stateId = $row->state_id;
			$this->cityLib->stateCode = $row->state_code;
			$this->cityLib->stateName = $row->state_name;
			
			return $this->cityLib;
		} else {
			return false;
		}
	}
	
	function getCityFromCustomUrl($customUrl) {
		
		$query = 'SELECT * FROM city WHERE custom_url = "'. $customUrl . '"';
		log_message('debug', "CityModel.getCityFromCustomUrl : " . $query);
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
	
	
	function addCity($city, $stateId) {
		$return = true;
		
		$customUrl = $this->input->post('customUrl');
		
		if (!$customUrl) {
			$city_without_spaces = trimWhiteSpaces(trim($city));
			$city_with_state = $city_without_spaces;
			
			$CI =& get_instance();
			$CI->load->model('StateModel','',true);
			$state = $CI->StateModel->getStateFromId($stateId);
			
			$city_with_state .= '-'.trimWhiteSpaces(trim($state->stateCode));
			
			$customUrl = $city_with_state;
			$customUrl = strtolower(str_replace(' ', '-', str_replace("'", '',$customUrl))); 
		}
		
		
		$query = "SELECT * FROM city WHERE city = \"" . $city . "\" AND state_id = " . $stateId;
		log_message('debug', 'CityModel.addCity : Try to get duplicate City record : ' . $query);
		
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$query = "SELECT * FROM city WHERE custom_url = \"" . $customUrl . "\"";
			log_message('debug', 'CityModel.updateCity : Try to get Duplicate custom url : ' . $query);
			
			$result = $this->db->query($query);
			
			if ($result->num_rows() == 0) {
			
				$query = "INSERT INTO city (city_id, city, state_id, custom_url)" .
						" values (NULL, \"" . $city . "\", $stateId, '".$customUrl."' )";
				log_message('debug', 'CityModel.addCity : Insert City : ' . $query);
				
				if ( $this->db->query($query) ) {
					$new_city_id = $this->db->insert_id();
	
					$return = $new_city_id;
				} else {
					$return = false;
				}
			} else {
				$GLOBALS['error'] = 'duplicate_url';
				$return = false;
			}
		} else {
			$GLOBALS['error'] = 'duplicate_city';
			$return = false;
		}
		
		return $return;	
	}
	
	function updateCity() {
		$return = true;
		
		$customUrl = $this->input->post('customUrl');
		$city = $this->input->post('city');
		$stateId = $this->input->post('stateId');
		
		if (!$customUrl) {
			$city_without_spaces = trimWhiteSpaces(trim($city));
			$city_with_state = $city_without_spaces;
			
			$CI =& get_instance();
			$CI->load->model('StateModel','',true);
			$state = $CI->StateModel->getStateFromId($stateId);
			
			$city_with_state .= '-'.trimWhiteSpaces(trim($state->stateCode));
			
			$customUrl = $city_with_state;
			$customUrl = strtolower(str_replace(' ', '-', str_replace("'", '',$customUrl))); 
		}
		
		$query = "SELECT * FROM city WHERE city = \"" . $city . "\" AND state_id = " . $stateId . " AND city_id <> " . $this->input->post('cityId');
		log_message('debug', 'CityModel.updateCity : Try to get Duplicate record : ' . $query);
		
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$query = "SELECT * FROM city WHERE custom_url = \"" . $customUrl . "\" AND city_id <> " . $this->input->post('cityId');
			log_message('debug', 'CityModel.updateCity : Try to get Duplicate custom url : ' . $query);
			
			$result = $this->db->query($query);
			
			if ($result->num_rows() == 0) {
			
				$data = array(
							'city' => $city,
							'state_id' => $stateId,  
							'custom_url' => $customUrl,
						);
				$where = "city_id = " . $this->input->post('cityId');
				$query = $this->db->update_string('city', $data, $where);
				
				log_message('debug', 'CityModel.updateCity : ' . $query);
				if ( $this->db->query($query) ) {
					$return = true;
				} else {
					$return = false;
				}
			} else {
				$GLOBALS['error'] = 'duplicate_url';
				$return = false;
			}
		} else {
			$GLOBALS['error'] = 'duplicate';
			$return = false;
		}
		
		return $return;
	}
	
	
}


?>