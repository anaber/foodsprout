<?php

class PlantGroupModel extends Model{
	
	// List all the fruittype in the database
	function list_plantGroup()
	{
		$query = "SELECT * FROM plant_group ORDER BY plant_group_name";
		
		log_message('debug', "PlantGroupModel.list_plantGroup : " . $query);
		$result = $this->db->query($query);
		
		$fruittypes = array();
		
		foreach ($result->result_array() as $row) {
			
			$this->load->library('PlantGroupLib');
			unset($this->plantGroupLib);
			
			$this->plantGroupLib->plantGroupId = $row['plant_group_id'];
			$this->plantGroupLib->plantGroupName = $row['plant_group_name'];
			$this->plantGroupLib->plantGroupSciName = $row['plant_group_sci_name'];
			
			$fruittypes[] = $this->plantGroupLib;
			unset($this->plantGroupLib);
		}
		return $fruittypes;
	}
	
	// Add the fruittype to the database
	function addPlantGroup() {
		$return = true;
		
		$query = "SELECT * FROM plant_group WHERE plant_group_name = \"" . $this->input->post('plantGroupName') . "\"";
		log_message('debug', 'PlantGroupModel.addPlantGroup : Try to get duplicate PlantGroup record : ' . $query);
		
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$query = "INSERT INTO plant_group (plant_group_id, plant_group_name, plant_group_sci_name)" .
					" values (NULL, \"" . $this->input->post('plantGroupName') . "\", \"" . $this->input->post('plantGroupSciName') . "\")";
			log_message('debug', 'PlantGroupModel.addPlantGroup : Insert Plant Group : ' . $query);
			
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
	
	// Get information from the database about a specific fruit type based on a specific id
	function getPlantGroupFromId($plantGroupId) {
		
		$query = "SELECT * FROM plant_group WHERE plant_group_id = " . $plantGroupId;
		log_message('debug', "PlantGroupModel.getPlantGroupFromId : " . $query);
		$result = $this->db->query($query);
		
		$fruittype = array();
		
		$this->load->library('PlantGroupLib');
		
		$row = $result->row();
		
		$this->plantGroupLib->plantGroupId = $row->plant_group_id;
		$this->plantGroupLib->plantGroupName = $row->plant_group_name;
		$this->plantGroupLib->plantGroupSciName = $row->plant_group_sci_name;
		
		return $this->plantGroupLib;
	}
	
	// Update the information in the database for a specific fruit type based on an 
	function updatePlantGroup() {
		$return = true;
		
		$query = "SELECT * FROM plant_group WHERE plant_group_name = \"" . $this->input->post('plantGroupName') . "\" AND plant_group_id <> " . $this->input->post('plantGroupId');
		log_message('debug', 'PlantGroupModel.updatePlantGroup : Try to get Duplicate record : ' . $query);
		
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$data = array(
						'plant_group_name' => $this->input->post('plantGroupName'), 
						'plant_group_sci_name' => $this->input->post('plantGroupSciName'),
					);
			$where = "plant_group_id = " . $this->input->post('plantGroupId');
			$query = $this->db->update_string('plant_group', $data, $where);
			
			log_message('debug', 'PlantGroupModel.updatePlantGroup : ' . $query);
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