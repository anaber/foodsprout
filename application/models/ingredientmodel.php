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
		
		$query = "SELECT * FROM ingredient WHERE ingredient_name = '" . $this->input->post('ingredientName') . "'";
		log_message('debug', 'IngredientModel.addIngredient : Try to get duplicate Ingredient record : ' . $query);
		
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$query = "INSERT INTO ingredient (ingredient_id, ingredient_name, ingredient_type_id, vegetable_type_id, meat_type_id, fruit_type_id, plant_id)" .
					" values (NULL, '" . $this->input->post('ingredientName') . "', '" . $this->input->post('ingredienttypeId') . "', '" . $this->input->post('vegetabletypeId') . "', '" . $this->input->post('meattypeId') . "', '" . $this->input->post('fruittypeId') . "', '" . $this->input->post('plantId') . "' )";
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
		
		$query = "SELECT ingredient.*, address.* FROM ingredient, address WHERE ingredient.ingredient_id = address.ingredient_id AND ingredient.ingredient_id = " . $ingredientId;
		log_message('debug', "IngredientModel.getIngredientFromId : " . $query);
		$result = $this->db->query($query);
		
		$ingredient = array();
		
		$this->load->library('IngredientLib');
		
		$row = $result->row();
		
		$this->ingredientLib->ingredientId = $row->ingredient_id;
		$this->ingredientLib->ingredientName = $row->ingredient_name;
		$this->ingredientLib->streetNumber = $row->street_number;
		$this->ingredientLib->street = $row->street;
		$this->ingredientLib->city = $row->city;
		$this->ingredientLib->stateId = $row->state_id;
		$this->ingredientLib->countryId = $row->country_id;
		$this->ingredientLib->zipcode = $row->zipcode;
		
		return $this->ingredientLib;
	}
	
	function updateIngredient() {
		$return = true;
		
		$query = "SELECT * FROM ingredient WHERE ingredient_name = '" . $this->input->post('ingredientName') . "' AND ingredient_id <> " . $this->input->post('ingredientId');
		
		log_message('debug', 'IngredientModel.updateIngredient : Try to get Duplicate record : ' . $query);
			
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$CI =& get_instance();
			$CI->load->model('AddressModel','',true);
			
			$address = $CI->AddressModel->prepareAddress($this->input->post('streetNumber'), $this->input->post('street'), $this->input->post('city'), $this->input->post('stateId'), $this->input->post('countryId'), $this->input->post('zipcode') );
			
			$CI->load->model('GoogleMapModel','',true);
			$latLng = $CI->GoogleMapModel->geoCodeAddress($address);
			
			$data = array(
						'ingredient_name' => $this->input->post('ingredientName'), 
					);
			$where = "ingredient_id = " . $this->input->post('ingredientId');
			$query = $this->db->update_string('ingredient', $data, $where);
			
			log_message('debug', 'IngredientModel.updateIngredient : ' . $query);
			if ( $this->db->query($query) ) {
				
				$data = array(
						'street_number' => $this->input->post('streetNumber'),
						'street' => $this->input->post('street'),
						'city' => $this->input->post('city'),
						'state_id' => $this->input->post('stateId'),
						'country_id' => $this->input->post('countryId'),
						'zipcode' => $this->input->post('zipcode'),
						'latitude' => ( isset($latLng['latitude']) ? $latLng['latitude']:'' ) ,
						'longitude' => ( isset($latLng['longitude']) ? $latLng['longitude']:'' ),
						
					);
				$where = "ingredient_id = " . $this->input->post('ingredientId');
				$query = $this->db->update_string('address', $data, $where);
				if ( $this->db->query($query) ) {
					$return = true;
				} else {
					$return = false;
				}
				
				log_message('debug', 'IngredientModel.updateIngredient : ' . $query);
				
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