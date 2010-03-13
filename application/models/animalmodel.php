<?php

class AnimalModel extends Model{
	
	// Add a animal to the database
	function add_animal()
	{
		$insert_new_animal = array(
			'animal_name' => $this->input->post('animal_name')
		);
		
		$insert = $this->db->insert('animal', $insert_new_animal);
		return $insert;
	}
	
	// List all the animal in the database
	function list_animal()
	{
		$this->db->order_by("animal_name", "asc");
		$q = $this->db->get('animal');
		
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