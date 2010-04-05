<?php

class ManufactureTypeModel extends Model{
	
	// List all the manufacture_type in the database
	function listManufactureType()
	{
		$query = "SELECT * FROM manufacture_type ORDER BY manufacture_type";
		
		log_message('debug', "ManufactureTypeModel.listManufactureType : " . $query);
		$result = $this->db->query($query);
		
		$manufactureTypes = array();
		
		foreach ($result->result_array() as $row) {
			
			$this->load->library('ManufactureTypeLib');
			unset($this->ManufactureTypeLib);
			
			$this->ManufactureTypeLib->manufactureTypeId = $row['manufacture_type_id'];
			$this->ManufactureTypeLib->manufactureType = $row['manufacture_type'];
			
			$manufactureTypes[] = $this->ManufactureTypeLib;
			unset($this->ManufactureTypeLib);
		}
		return $manufactureTypes;
	}
	
	// Insert manufacture data into the database
	function addManufacturetype() {
		$return = true;
		
		$query = "SELECT * FROM manufacture_type WHERE manufacture_type = '" . $this->input->post('manufacturetypeName') . "'";
		log_message('debug', 'ManufacturetypeModel.addManufacturetype : Try to get duplicate Manufacturetype record : ' . $query);
		
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$query = "INSERT INTO manufacture_type (manufacture_type_id, manufacture_type)" .
					" values (NULL, '" . $this->input->post('manufacturetypeName') . "')";
			log_message('debug', 'ManufacturetypeModel.addManufacturetype : Insert Manufacturetype : ' . $query);
			
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
	
	// Get a specific processing manufacture type from an id
	function getManufacturetypeFromId($manufacturetypeId) {
		
		$query = "SELECT * FROM manufacture_type WHERE manufacture_type_id = " . $manufacturetypeId;
		log_message('debug', "ManufacturetypeModel.getManufacturetypeFromId : " . $query);
		$result = $this->db->query($query);
		
		$manufactureType = array();
		
		$this->load->library('ManufacturetypeLib');
		
		$row = $result->row();
		
		$this->manufacturetypeLib->manufacturetypeId = $row->manufacture_type_id;
		$this->manufacturetypeLib->manufactureType = $row->manufacture_type;
		
		return $this->manufacturetypeLib;
	}
	
	// Update a manufacture based on a specific id
	function updateManufacturetype() {
		$return = true;
		
		$query = "SELECT * FROM manufacture_type WHERE manufacture_type = '" . $this->input->post('manufactureType') . "' AND manufacture_type_id <> " . $this->input->post('manufacturetypeId');
		log_message('debug', 'ManufacturetypeModel.updateManufacturetype : Try to get Duplicate record : ' . $query);
			
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$data = array(
						'manufacture_type' => $this->input->post('manufactureType'), 
					);
			$where = "manufacture_type_id = " . $this->input->post('manufacturetypeId');
			$query = $this->db->update_string('manufacture_type', $data, $where);
			
			log_message('debug', 'ManufacturetypeModel.updateManufacturetype : ' . $query);
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