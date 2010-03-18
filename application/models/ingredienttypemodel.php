<?php

class IngredienttypeModel extends Model{
	
	// List all the ingredienttype in the database
	function list_ingredienttype()
	{
		$query = "SELECT * FROM ingredient_type ORDER BY ingredient_type";
		
		log_message('debug', "IngredienttypeModel.list_ingredienttype : " . $query);
		$result = $this->db->query($query);
		
		$ingredienttypes = array();
		
		foreach ($result->result_array() as $row) {
			
			$this->load->library('IngredienttypeLib');
			unset($this->ingredienttypeLib);
			
			$this->ingredienttypeLib->ingredienttypeId = $row['ingredient_type_id'];
			$this->ingredienttypeLib->ingredienttypeName = $row['ingredient_type'];
			
			$ingredienttypes[] = $this->ingredienttypeLib;
			unset($this->ingredienttypeLib);
		}
		return $ingredienttypes;
	}
	
	// Add the ingredienttype to the database
	function addIngredienttype() {
		$return = true;
		
		$query = "SELECT * FROM ingredient_type WHERE ingredient_type = '" . $this->input->post('ingredienttypeName') . "'";
		log_message('debug', 'IngredienttypeModel.addIngredienttype : Try to get duplicate Ingredienttype record : ' . $query);
		
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$query = "INSERT INTO ingredient_type (ingredient_type_id, ingredient_type)" .
					" values (NULL, '" . $this->input->post('ingredienttypeName') . "')";
			log_message('debug', 'IngredienttypeModel.addingredienttype : Insert Ingredienttype : ' . $query);
			
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
	
	function getIngredienttypeFromId($ingredienttypeId) {
		
		$query = "SELECT * FROM ingredient_type WHERE ingredient_type_id = " . $ingredienttypeId;
		log_message('debug', "IngredienttypeModel.getIngredienttypeFromId : " . $query);
		$result = $this->db->query($query);
		
		$ingredienttype = array();
		
		$this->load->library('IngredienttypeLib');
		
		$row = $result->row();
		
		$this->ingredienttypeLib->ingredienttypeId = $row->ingredienttype_id;
		$this->ingredienttypeLib->ingredienttypeName = $row->ingredienttype_name;
		
		return $this->ingredienttypeLib;
	}
	
	function updateIngredienttype() {
		$return = true;
		
		$query = "SELECT * FROM ingredienttype WHERE ingredienttype_name = '" . $this->input->post('ingredienttypeName') . "' AND ingredienttype_id <> " . $this->input->post('ingredienttypeId');
		log_message('debug', 'IngredienttypeModel.updateIngredienttype : Try to get Duplicate record : ' . $query);
			
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$data = array(
						'ingredienttype_name' => $this->input->post('ingredienttypeName'), 
					);
			$where = "ingredienttype_id = " . $this->input->post('ingredienttypeId');
			$query = $this->db->update_string('ingredienttype', $data, $where);
			
			log_message('debug', 'IngredienttypeModel.updateIngredienttype : ' . $query);
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