<?php

class MeattypeModel extends Model{
	
	// List all the meattype in the database
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
	
	function getMeattypeFromId($meattypeId) {
		
		$query = "SELECT * FROM meattype WHERE meattype_id = " . $meattypeId;
		log_message('debug', "MeattypeModel.getFarmFromId : " . $query);
		$result = $this->db->query($query);
		
		$meattype = array();
		
		$this->load->library('MeattypeLib');
		
		$row = $result->row();
		
		$this->meattypeLib->meattypeId = $row->meattype_id;
		$this->meattypeLib->meattypeName = $row->meattype_name;
		
		return $this->meattypeLib;
	}
	
	function updateMeattype() {
		$return = true;
		
		$query = "SELECT * FROM meattype WHERE meattype_name = '" . $this->input->post('meattypeName') . "' AND meattype_id <> " . $this->input->post('meattypeId');
		log_message('debug', 'MeattypeModel.updateMeattype : Try to get Duplicate record : ' . $query);
			
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$data = array(
						'meattype_name' => $this->input->post('meattypeName'), 
					);
			$where = "meattype_id = " . $this->input->post('meattypeId');
			$query = $this->db->update_string('meattype', $data, $where);
			
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