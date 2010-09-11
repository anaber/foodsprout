<?php

class FruittypeModel extends Model{
	
	// List all the fruittype in the database
	function list_fruittype()
	{
		$query = "SELECT * FROM fruit_type ORDER BY fruit_type";
		
		log_message('debug', "FruittypeModel.list_fruittype : " . $query);
		$result = $this->db->query($query);
		
		$fruittypes = array();
		
		foreach ($result->result_array() as $row) {
			
			$this->load->library('FruittypeLib');
			unset($this->fruittypeLib);
			
			$this->fruittypeLib->fruittypeId = $row['fruit_type_id'];
			$this->fruittypeLib->fruittypeName = $row['fruit_type'];
			
			$fruittypes[] = $this->fruittypeLib;
			unset($this->fruittypeLib);
		}
		return $fruittypes;
	}
	
	// Add the fruittype to the database
	function addFruittype() {
		$return = true;
		
		$query = "SELECT * FROM fruittype WHERE fruittype_name = \"" . $this->input->post('fruittypeName') . "\"";
		log_message('debug', 'FruittypeModel.addFruittype : Try to get duplicate Fruittype record : ' . $query);
		
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$query = "INSERT INTO fruit_type (fruit_type_id, fruit_type)" .
					" values (NULL, \"" . $this->input->post('fruittypeName') . "\")";
			log_message('debug', 'FruittypeModel.addFruittype : Insert Fruittype : ' . $query);
			
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
	
	// Get information from the database about a specific fruit type based on a specific id
	function getFruittypeFromId($fruittypeId) {
		
		$query = "SELECT * FROM fruit_type WHERE fruit_type_id = " . $fruittypeId;
		log_message('debug', "FruittypeModel.getFruittypeFromId : " . $query);
		$result = $this->db->query($query);
		
		$fruittype = array();
		
		$this->load->library('FruittypeLib');
		
		$row = $result->row();
		
		$this->fruittypeLib->fruittypeId = $row->fruit_type_id;
		$this->fruittypeLib->fruittypeName = $row->fruit_type;
		
		return $this->fruittypeLib;
	}
	
	// Update the information in the database for a specific fruit type based on an 
	function updateFruittype() {
		$return = true;
		
		$query = "SELECT * FROM fruit_type WHERE fruit_type = \"" . $this->input->post('fruittypeName') . "\" AND fruit_type_id <> " . $this->input->post('fruittypeId');
		log_message('debug', 'FruittypeModel.updateFruittype : Try to get Duplicate record : ' . $query);
		
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$data = array(
						'fruit_type' => $this->input->post('fruittypeName'), 
					);
			$where = "fruit_type_id = " . $this->input->post('fruittypeId');
			$query = $this->db->update_string('fruit_type', $data, $where);
			
			log_message('debug', 'FruittypeModel.updateFruittype : ' . $query);
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