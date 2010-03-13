<?php

class FishModel extends Model{
	
	// Add a fish to the database
	function add_fish()
	{
		$insert_new_fish = array(
			'fish_name' => $this->input->post('fish_name')
		);
		
		$insert = $this->db->insert('fish', $insert_new_fish);
		return $insert;
	}
	
	// List all the fish in the database
	function list_fish()
	{
		$this->db->order_by("fish_name", "asc");
		$q = $this->db->get('fish');
		
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