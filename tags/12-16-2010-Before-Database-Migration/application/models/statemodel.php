<?php

class StateModel extends Model{
	
	// Add a state to the database
	function addState()
	{
		$insert_new_state = array(
			'state_name' => $this->input->post('state_name')
		);
		
		$insert = $this->db->insert('state', $insert_new_state);
		return $insert;
	}
	
	// List all the state in the database
	function listState() {
		$states = array();
		
		$this->db->order_by("state_name", "asc");
		$q = $this->db->get('state');
		
		if($q->num_rows() > 0) {
			foreach ($q->result() as $row) {
				$this->load->library('StateLib');
				unset($this->StateLib);
				
				$this->StateLib->stateId = $row->state_id;
				$this->StateLib->stateName = $row->state_name;
				
				$states[] = $this->StateLib;
				
				unset($this->StateLib);
			}
		}
		
		return $states;
	}
	
	function getStateFromId($stateId) {
		
		$query = 'SELECT * FROM state WHERE state_id = '. $stateId;
		log_message('debug', "StateModel.getStateFromId : " . $query);
		$result = $this->db->query($query);
		
		$this->load->library('StateLib');
		
		$row = $result->row();
		
		$this->stateLib->stateId = $row->state_id;
		$this->stateLib->stateName = $row->state_name;
		$this->stateLib->stateCode = $row->state_code;
		
		return $this->stateLib;
	}
	
}



?>