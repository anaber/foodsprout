<?php

class Country_model extends Model{
	
	// Add a country to the database
	function add_country()
	{
		$insert_new_country = array(
			'country_name' => $this->input->post('country_name')
		);
		
		$insert = $this->db->insert('country', $insert_new_country);
		return $insert;
	}
	
	// List all the country in the database
	function list_country()
	{
		$this->db->order_by("country_name", "asc");
		$q = $this->db->get('country');
		
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