<?php

class CuisineModel extends Model{
	
	// List all the cuisine in the database
	function list_cuisine()
	{
		$query = "SELECT * FROM cuisine ORDER BY cuisine_name";
		
		log_message('debug', "CuisineModel.list_cuisine : " . $query);
		$result = $this->db->query($query);
		
		$cuisines = array();
		
		foreach ($result->result_array() as $row) {
			
			$this->load->library('CuisineLib');
			unset($this->cuisineLib);
			
			$this->cuisineLib->cuisineId = $row['cuisine_id'];
			$this->cuisineLib->cuisineName = $row['cuisine_name'];
			
			$cuisinees[] = $this->cuisineLib;
			unset($this->cuisineLib);
		}
		return $cuisines;
	}
	
	function addCuisine() {
		$return = true;
		
		$query = "SELECT * FROM cuisine WHERE cuisine_name = '" . $this->input->post('cuisineName') . "'";
		log_message('debug', 'CuisineModel.addCuisine : Try to get duplicate Cuisine record : ' . $query);
		
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$query = "INSERT INTO cuisine (cuisine_id, cuisine_name)" .
					" values (NULL, '" . $this->input->post('cuisineName') . "')";
			log_message('debug', 'CuisineModel.addcuisine : Insert Cuisine : ' . $query);
			
			if ( $this->db->query($query) ) {
				$return = true;
			} else {
				$return = false;
			}
			
			$return = true;
		} else {
			$GLOBALS['error'] = 'duplicate';
			$return = false;
		}
		
		return $return;	
	}
	
	function getCuisineFromId($cuisineId) {
		
		$query = "SELECT * FROM cuisine WHERE cuisine_id = " . $cuisineId;
		log_message('debug', "CuisineModel.getCuisineFromId : " . $query);
		$result = $this->db->query($query);
		
		$cuisine = array();
		
		$this->load->library('CuisineLib');
		
		$row = $result->row();
		
		$this->cuisineLib->cuisineId = $row->cuisine_id;
		$this->cuisineLib->cuisineName = $row->cuisine_name;
		
		return $this->cuisineLib;
	}
	
	function updateCuisine() {
		$return = true;
		
		$query = "SELECT * FROM cuisine WHERE cuisine_name = '" . $this->input->post('cuisineName') . "' AND cuisine_id <> " . $this->input->post('cuisineId');
		log_message('debug', 'CuisineModel.updateCuisine : Try to get Duplicate record : ' . $query);
			
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$data = array(
						'cuisine_name' => $this->input->post('cuisineName'), 
					);
			$where = "cuisine_id = " . $this->input->post('cuisineId');
			$query = $this->db->update_string('cuisine', $data, $where);
			
			log_message('debug', 'CuisineModel.updateCuisine : ' . $query);
			if ( $this->db->query($query) ) {
				$return = true;
			} else {
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