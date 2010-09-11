<?php

class VegetabletypeModel extends Model{
	
	// List all the vegetabletype in the database
	function list_vegetabletype()
	{
		$query = "SELECT * FROM vegetable_type ORDER BY vegetable_type";
		
		log_message('debug', "VegetabletypeModel.list_vegetabletype : " . $query);
		$result = $this->db->query($query);
		
		$vegetabletypes = array();
		
		foreach ($result->result_array() as $row) {
			
			$this->load->library('VegetabletypeLib');
			unset($this->vegetabletypeLib);
			
			$this->vegetabletypeLib->vegetabletypeId = $row['vegetable_type_id'];
			$this->vegetabletypeLib->vegetabletypeName = $row['vegetable_type'];
			
			$vegetabletypes[] = $this->vegetabletypeLib;
			unset($this->vegetabletypeLib);
		}
		return $vegetabletypes;
	}
	
	// Add the vegetabletype to the database
	function addVegetabletype() {
		$return = true;
		
		$query = "SELECT * FROM vegetable_type WHERE vegetable_type = \"" . $this->input->post('vegetabletypeName') . "\"";
		log_message('debug', 'VegetabletypeModel.addVegetabletype : Try to get duplicate Vegetabletype record : ' . $query);
		
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$query = "INSERT INTO vegetable_type (vegetable_type_id, vegetable_type)" .
					" values (NULL, \"" . $this->input->post('vegetabletypeName') . "\")";
			log_message('debug', 'VegetabletypeModel.addVegetabletype : Insert Vegetabletype : ' . $query);
			
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
	
	function getVegetabletypeFromId($vegetabletypeId) {
		
		$query = "SELECT * FROM vegetable_type WHERE vegetable_type_id = " . $vegetabletypeId;
		log_message('debug', "VegetabletypeModel.getVegetabletypeFromId : " . $query);
		$result = $this->db->query($query);
		
		$vegetabletype = array();
		
		$this->load->library('VegetabletypeLib');
		
		$row = $result->row();
		
		$this->vegetabletypeLib->vegetabletypeId = $row->vegetable_type_id;
		$this->vegetabletypeLib->vegetabletypeName = $row->vegetable_type;
		
		return $this->vegetabletypeLib;
	}
	
	function updateVegetabletype() {
		$return = true;
		
		$query = "SELECT * FROM vegetable_type WHERE vegetable_type = \"" . $this->input->post('vegetabletypeName') . "\" AND vegetable_type_id <> " . $this->input->post('vegetabletypeId');
		log_message('debug', 'VegetabletypeModel.updateVegetabletype : Try to get Duplicate record : ' . $query);
			
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$data = array(
						'vegetable_type' => $this->input->post('vegetabletypeName'), 
					);
			$where = "vegetable_type_id = " . $this->input->post('vegetabletypeId');
			$query = $this->db->update_string('vegetable_type', $data, $where);
			
			log_message('debug', 'VegetabletypeModel.updateVegetabletype : ' . $query);
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