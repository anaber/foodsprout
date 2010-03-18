<?php

class InsectModel extends Model{
	
	// List all the insect in the database
	function list_insect()
	{
		$query = "SELECT * FROM insect ORDER BY insect_name";
		
		log_message('debug', "InsectModel.list_insect : " . $query);
		$result = $this->db->query($query);
		
		$insects = array();
		
		foreach ($result->result_array() as $row) {
			
			$this->load->library('InsectLib');
			unset($this->insectLib);
			
			$this->insectLib->insectId = $row['insect_id'];
			$this->insectLib->insectName = $row['insect_name'];
			$this->insectLib->description = $row['description'];
			
			$insects[] = $this->insectLib;
			unset($this->insectLib);
		}
		return $insects;
	}
	
	// Add the insect record into the database
	function addInsect() {
		$return = true;
		
		$query = "SELECT * FROM insect WHERE insect_name = '" . $this->input->post('insectName') . "'";
		log_message('debug', 'InsectModel.addInsect : Try to get duplicate Insect record : ' . $query);
		
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$query = "INSERT INTO insect (insect_id, insect_name, description)" .
					" values (NULL, '" . $this->input->post('insectName') . "', '" . $this->input->post('description') . "')";
			log_message('debug', 'InsectModel.addInsect : Insert Insect : ' . $query);
			
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
	
	function getInsectFromId($insectId) {
		
		$query = "SELECT * FROM insect WHERE insect_id = " . $insectId;
		log_message('debug', "InsectModel.getFarmFromId : " . $query);
		$result = $this->db->query($query);
		
		$insect = array();
		
		$this->load->library('InsectLib');
		
		$row = $result->row();
		
		$this->insectLib->insectId = $row->insect_id;
		$this->insectLib->insectName = $row->insect_name;
		$this->insectLib->description = $row->description;
		
		return $this->insectLib;
	}
	
	function updateInsect() {
		$return = true;
		
		$query = "SELECT * FROM insect WHERE insect_name = '" . $this->input->post('insectName') . "' AND insect_id <> " . $this->input->post('insectId');
		log_message('debug', 'InsectModel.updateInsect : Try to get Duplicate record : ' . $query);
			
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$data = array(
						'insect_name' => $this->input->post('insectName'),
						'description' => $this->input->post('description'),  
					);
			$where = "insect_id = " . $this->input->post('insectId');
			$query = $this->db->update_string('insect', $data, $where);
			
			log_message('debug', 'InsectModel.updateInsect : ' . $query);
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