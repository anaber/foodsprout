<?php

class PlantModel extends Model{
	
	// List all the plant in the database
	function list_plant()
	{
		$query = "SELECT plant.*, plant_group.plant_group_name FROM plant, plant_group WHERE plant.plant_group_id = plant_group.plant_group_id ORDER BY plant_name";
		
		log_message('debug', "PlantModel.list_plant : " . $query);
		$result = $this->db->query($query);
		
		$plants = array();
		
		foreach ($result->result_array() as $row) {
			
			$this->load->library('PlantLib');
			unset($this->plantLib);
			
			$this->plantLib->plantId = $row['plant_id'];
			$this->plantLib->plantName = $row['plant_name'];
			$this->plantLib->plantGroupId = $row['plant_group_id'];
			$this->plantLib->plantGroupName = $row['plant_group_name'];
			
			$plants[] = $this->plantLib;
			unset($this->plantLib);
		}
		return $plants;
	}
	
	// Insert the plant into the database
	function addPlant() {
		$return = true;
		
		$query = "SELECT * FROM plant WHERE plant_name = '" . $this->input->post('plantName') . "'";
		log_message('debug', 'PlantModel.addPlant : Try to get duplicate Plant record : ' . $query);
		
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$query = "INSERT INTO plant (plant_id, plant_name, plant_group_id)" .
					" values (NULL, '" . $this->input->post('plantName') . "', '" . $this->input->post('plantGroupId') . "')";
			log_message('debug', 'PlantModel.addPlant : Insert Plant : ' . $query);
			
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
	
	function getPlantFromId($plantId) {
		
		$query = "SELECT plant.*, plant_group.plant_group_name FROM plant, plant_group WHERE plant.plant_id = " . $plantId . " AND plant.plant_group_id = plant_group.plant_group_id";
		log_message('debug', "PlantModel.getPlantFromId : " . $query);
		$result = $this->db->query($query);
		
		$plant = array();
		
		$this->load->library('PlantLib');
		
		$row = $result->row();
		
		$this->plantLib->plantId = $row->plant_id;
		$this->plantLib->plantName = $row->plant_name;
		$this->plantLib->plantGroupId = $row->plant_group_id;
		$this->plantLib->plantGroupName = $row->plant_group_name;
		
		return $this->plantLib;
	}
	
	function updatePlant() {
		$return = true;
		
		$query = "SELECT * FROM plant WHERE plant_name = '" . $this->input->post('plantName') . "' AND plant_id <> " . $this->input->post('plantId');
		log_message('debug', 'PlantModel.updatePlant : Try to get Duplicate record : ' . $query);
			
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$data = array(
						'plant_name' => $this->input->post('plantName'), 
						'plant_group_id' => $this->input->post('plantGroupId'),
					);
			$where = "plant_id = " . $this->input->post('plantId');
			$query = $this->db->update_string('plant', $data, $where);
			
			log_message('debug', 'PlantModel.updatePlant : ' . $query);
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