<?php

class FarmTypeModel extends Model{
	
	// List all the facility_type in the database
	function listFarmType($c)
	{
		if ( isset($c) && !empty ($c) ) {
			$query = "SELECT * FROM farm_type ORDER BY farm_type LIMIT 0, $c";
		} else {
			$query = "SELECT * FROM farm_type ORDER BY farm_type";
		}
		
		log_message('debug', "FarmTypeModel.listFarmType : " . $query);
		$result = $this->db->query($query);
		
		$farmTypes = array();
		
		foreach ($result->result_array() as $row) {
			
			$this->load->library('FarmTypeLib');
			unset($this->farmTypeLib);
			
			$this->farmTypeLib->farmTypeId = $row['farm_type_id'];
			$this->farmTypeLib->farmType = $row['farm_type'];
			
			$farmTypes[] = $this->farmTypeLib;
			unset($this->farmTypeLib);
		}
		return $farmTypes;
	}
	
	// Insert facility data into the database
	function addFarmType() {
		$return = true;
		
		$query = "SELECT * FROM farm_type WHERE farm_type = \"" . $this->input->post('farmType') . "\"";
		log_message('debug', 'FarmTypeModel.addFarmType : Try to get duplicate FarmType record : ' . $query);
		
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$query = "INSERT INTO farm_type (farm_type_id, farm_type)" .
					" values (NULL, \"" . $this->input->post('farmType') . "\")";
			log_message('debug', 'FarmTypeModel.addFarmType : Insert FarmType : ' . $query);
			
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
	
	// Get a specific farm type from an id
	function getFarmTypeFromId($farmTypeId) {
		
		$query = "SELECT * FROM farm_type WHERE farm_type_id = " . $farmTypeId;
		log_message('debug', "FarmTypeModel.getFarmTypeFromId : " . $query);
		$result = $this->db->query($query);
		
		$this->load->library('FarmTypeLib');
		
		$row = $result->row();
		
		$this->farmTypeLib->farmTypeId = $row->farm_type_id;
		$this->farmTypeLib->farmType = $row->farm_type;
		
		return $this->farmTypeLib;
	}
	
	// Update a farm type based on a specific id
	function updateFarmType() {
		$return = true;
		
		$query = "SELECT * FROM farm_type WHERE farm_type = \"" . $this->input->post('farmType') . "\" AND farm_type_id <> " . $this->input->post('farmTypeId');
		log_message('debug', 'FarmTypeModel.updateFarmType : Try to get Duplicate record : ' . $query);
			
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$data = array(
						'farm_type' => $this->input->post('farmType'), 
					);
			$where = "farm_type_id = " . $this->input->post('farmTypeId');
			$query = $this->db->update_string('farm_type', $data, $where);
			
			log_message('debug', 'FarmTypeModel.updateFarmType : ' . $query);
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