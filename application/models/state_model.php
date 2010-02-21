<?php

class State_model extends Model{
	
	// Add a state to the database
	function add_state()
	{
		$insert_new_state = array(
			'state_name' => $this->input->post('state_name')
		);
		
		$insert = $this->db->insert('state', $insert_new_state);
		return $insert;
	}
	
	// List all the state in the database
	function list_state()
	{
		$this->db->order_by("state_name", "asc");
		$q = $this->db->get('state');
		
		if($q->num_rows() > 0) {
			foreach ($q->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		else{
			return FALSE;
		}
	}
	
}



?>