<?php

class IngredientModel extends Model{
	
	// Generate a simple list of all the companies in the database
	function list_ingredient()
	{
		$query = "SELECT ingredient.* " .
				 " FROM ingredient " .
				 " ORDER BY ingredient_name";
		
		log_message('debug', "IngredientModel.list_ingredient : " . $query);
		$result = $this->db->query($query);
		
		$ingredients = array();
		
		foreach ($result->result_array() as $row) {
			
			$this->load->library('IngredientLib');
			unset($this->ingredientLib);
			
			$this->ingredientLib->ingredientId = $row['ingredient_id'];
			$this->ingredientLib->ingredientName = $row['ingredient_name'];
			$this->ingredientLib->ingredientTypeId = $row['ingredient_type_id'];
			$this->ingredientLib->vegetableTypeId = $row['vegetable_type_id'];
			$this->ingredientLib->meatTypeId = $row['meat_type_id'];
			$this->ingredientLib->fruitTypeId = $row['fruit_type_id'];
			$this->ingredientLib->plantId = $row['plant_id'];
			
			$ingredients[] = $this->ingredientLib;
			unset($this->ingredientLib);
		}
		
		return $ingredients;
	}
	
	// Generate a detailed list of all the companies in the database.
	function listIngredientMore()
	{
		
	}
	
	// Add the ingredient data from the controller into the database
	function addIngredient() {
		$return = true;
		
		$query = "SELECT * FROM ingredient WHERE ingredient_name = \"" . $this->input->post('ingredientName') . "\"";
		log_message('debug', 'IngredientModel.addIngredient : Try to get duplicate Ingredient record : ' . $query);
		
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$query = "INSERT INTO ingredient (ingredient_id, ingredient_name, ingredient_type_id, vegetable_type_id, meat_type_id, fruit_type_id, plant_id)" .
					" values (NULL, \"" . $this->input->post('ingredientName') . "\", " . $this->input->post('ingredientTypeId') . ", " . $this->input->post('vegetableTypeId') . ", " . $this->input->post('meatTypeId') . ", " . $this->input->post('fruitTypeId') . ", " . $this->input->post('plantId') . " )";
			log_message('debug', 'IngredientModel.addIngredient : Insert Ingredient : ' . $query);
			
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
	
	// Get all the data for one specific ingredient using ingredient_id
	function getIngredientFromId($ingredientId) {
		
		$query = "SELECT * FROM ingredient WHERE ingredient_id = " . $ingredientId;
		log_message('debug', "IngredientModel.getIngredientFromId : " . $query);
		$result = $this->db->query($query);
		
		$this->load->library('IngredientLib');
		
		$row = $result->row();
		
		$this->ingredientLib->ingredientId = $row->ingredient_id;
		$this->ingredientLib->ingredientName = $row->ingredient_name;
		$this->ingredientLib->ingredientTypeId = $row->ingredient_type_id;
		$this->ingredientLib->vegetableTypeId = $row->vegetable_type_id;
		$this->ingredientLib->meatTypeId = $row->meat_type_id;
		$this->ingredientLib->fruitTypeId = $row->fruit_type_id;
		$this->ingredientLib->plantId = $row->plant_id;
		
		return $this->ingredientLib;
	}
	
	function updateIngredient() {
		$return = true;
		
		$query = "SELECT * FROM ingredient WHERE ingredient_name = \"" . $this->input->post('ingredientName') . "\" AND ingredient_id <> " . $this->input->post('ingredientId');
		
		log_message('debug', 'IngredientModel.updateIngredient : Try to get Duplicate record : ' . $query);
			
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$ingredientTypeId = $this->input->post('ingredientTypeId');
			$vegetableTypeId = $this->input->post('vegetableTypeId');
			$meatTypeId = $this->input->post('meatTypeId');
			$fruitTypeId = $this->input->post('fruitTypeId');
			$plantId = $this->input->post('plantId');
			
			$data = array(
					'ingredient_name' => $this->input->post('ingredientName'),
					'ingredient_type_id' => ( (empty($ingredientTypeId) || $ingredientTypeId == 'NULL') ? NULL : $ingredientTypeId ),
					'vegetable_type_id' => ( (empty($vegetableTypeId) || $vegetableTypeId == 'NULL') ? NULL : $vegetableTypeId ),
					'meat_type_id' => ( (empty($meatTypeId) || $meatTypeId == 'NULL') ? NULL : $meatTypeId ),
					'fruit_type_id' => ( (empty($fruitTypeId) || $fruitTypeId == 'NULL') ? NULL : $fruitTypeId ),
					'plant_id' => ( (empty($plantId) || $plantId == 'NULL') ? NULL : $plantId ),
				);
			
			
			$where = "ingredient_id = " . $this->input->post('ingredientId');
			$query = $this->db->update_string('ingredient', $data, $where);
			
			if ( $this->db->query($query) ) {
				$return = true;
			} else {
				$return = false;
			}
			
			log_message('debug', 'IngredientModel.updateIngredient : ' . $query);
			
		} else {
			$GLOBALS['error'] = 'duplicate';
			$return = false;
		}
			
		return $return;
	}
	
	
}



?>