<?php

class AnimalModel extends Model{
	
	// List all the animal in the database
	function listAnimal()
	{
		$query = "SELECT * FROM animal ORDER BY animal_name";
		
		log_message('debug', "AnimalModel.listAnimal : " . $query);
		$result = $this->db->query($query);
		
		$animals = array();
		
		foreach ($result->result_array() as $row) {
			
			$this->load->library('AnimalLib');
			unset($this->animalData);
			
			$this->animalData->animalId = $row['animal_id'];
			$this->animalData->animalName = $row['animal_name'];
			
			$animals[] = $this->animalData;
			unset($this->animalData);
		}
		return $animals;
	}
	
	function addAnimal() {
		$return = true;
		
		$query = "SELECT * FROM animal WHERE animal_name = \"" . $this->input->post('animalName') . "\"";
		log_message('debug', 'AnimalModel.addAnimal : Try to get duplicate Animal record : ' . $query);
		
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$query = "INSERT INTO animal (animal_id, animal_name)" .
					" values (NULL, \"" . $this->input->post('animalName') . "\")";
			log_message('debug', 'AnimalModel.addAnimal : Insert Animal : ' . $query);
			
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
	
	function getAnimalFromId($animalId) {
		
		$query = "SELECT * FROM animal WHERE animal_id = " . $animalId;
		log_message('debug', "AnimalModel.getFarmFromId : " . $query);
		$result = $this->db->query($query);
		
		$animal = array();
		
		$this->load->library('AnimalLib');
		
		$row = $result->row();
		
		$this->animalLib->animalId = $row->animal_id;
		$this->animalLib->animalName = $row->animal_name;
		
		return $this->animalLib;
	}
	
	function updateAnimal() {
		$return = true;
		
		$query = "SELECT * FROM animal WHERE animal_name = \"" . $this->input->post('animalName') . "\" AND animal_id <> " . $this->input->post('animalId');
		log_message('debug', 'AnimalModel.updateAnimal : Try to get Duplicate record : ' . $query);
			
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$data = array(
						'animal_name' => $this->input->post('animalName'), 
					);
			$where = "animal_id = " . $this->input->post('animalId');
			$query = $this->db->update_string('animal', $data, $where);
			
			log_message('debug', 'AnimalModel.updateAnimal : ' . $query);
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