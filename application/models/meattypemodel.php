<?php

class MeattypeModel extends Model{
	
	// List all the meat types in the database
	function list_meattype()
	{
		$query = "SELECT * FROM meat_type ORDER BY meat_type";
		
		log_message('debug', "MeattypeModel.list_meattype : " . $query);
		$result = $this->db->query($query);
		
		$meattypes = array();
		
		foreach ($result->result_array() as $row) {
			
			$this->load->library('MeattypeLib');
			unset($this->meattypeLib);
			
			$this->meattypeLib->meattypeId = $row['meat_type_id'];
			$this->meattypeLib->meattypeName = $row['meat_type'];
			
			$meattypes[] = $this->meattypeLib;
			unset($this->meattypeLib);
		}
		return $meattypes;
	}
	
	// Insert the meat type into the database
	function addMeattype() {
		$return = true;
		
		$query = "SELECT * FROM meat_type WHERE meat_type = '" . $this->input->post('meattypeName') . "'";
		log_message('debug', 'MeattypeModel.addMeattype : Try to get duplicate Meattype record : ' . $query);
		
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$query = "INSERT INTO meat_type (meat_type_id, meat_type)" .
					" values (NULL, '" . $this->input->post('meattypeName') . "')";
			log_message('debug', 'MeattypeModel.addMeattype : Insert Meattype : ' . $query);
			
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
	
	// Get the meat type information from a specific meat_type_id
	function getMeattypeFromId($meattypeId) {
		
		$query = "SELECT * FROM meat_type WHERE meat_type_id = " . $meattypeId;
		log_message('debug', "MeattypeModel.getFarmFromId : " . $query);
		$result = $this->db->query($query);
		
		$meattype = array();
		
		$this->load->library('MeattypeLib');
		
		$row = $result->row();
		
		$this->meattypeLib->meattypeId = $row->meat_type_id;
		$this->meattypeLib->meattypeName = $row->meat_type;
		
		return $this->meattypeLib;
	}
	
	// Update meat type information in the database
	function updateMeattype() {
		$return = true;
		
		$query = "SELECT * FROM meat_type WHERE meat_type = '" . $this->input->post('meattypeName') . "' AND meat_type_id <> " . $this->input->post('meattypeId');
		log_message('debug', 'MeattypeModel.updateMeattype : Try to get Duplicate record : ' . $query);
			
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$data = array(
						'meat_type' => $this->input->post('meattypeName'), 
					);
			$where = "meat_type_id = " . $this->input->post('meattypeId');
			$query = $this->db->update_string('meat_type', $data, $where);
			
			log_message('debug', 'MeattypeModel.updateMeattype : ' . $query);
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