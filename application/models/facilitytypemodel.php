<?php

class FacilitytypeModel extends Model{
	
	// List all the facility_type in the database
	function list_facility_type()
	{
		$query = "SELECT * FROM processing_facility_type ORDER BY processing_facility_type";
		
		log_message('debug', "FacilitytypeModel.list_facility_type : " . $query);
		$result = $this->db->query($query);
		
		$facilitytypes = array();
		
		foreach ($result->result_array() as $row) {
			
			$this->load->library('FacilitytypeLib');
			unset($this->facilitytypeLib);
			
			$this->facilitytypeLib->facilitytypeId = $row['processing_facility_type_id'];
			$this->facilitytypeLib->facilitytypeName = $row['processing_facility_type'];
			
			$facilitytypes[] = $this->facilitytypeLib;
			unset($this->facilitytypeLib);
		}
		return $facilitytypes;
	}
	
	function addFacilitytype() {
		$return = true;
		
		$query = "SELECT * FROM facility_type WHERE facility_type_name = '" . $this->input->post('facility_typeName') . "'";
		log_message('debug', 'FacilitytypeModel.addFacilitytype : Try to get duplicate Facilitytype record : ' . $query);
		
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$query = "INSERT INTO facility_type (facility_type_id, facility_type_name)" .
					" values (NULL, '" . $this->input->post('facility_typeName') . "')";
			log_message('debug', 'FacilitytypeModel.addFacilitytype : Insert Facilitytype : ' . $query);
			
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
	
	function getFacilitytypeFromId($facility_typeId) {
		
		$query = "SELECT * FROM facility_type WHERE facility_type_id = " . $facility_typeId;
		log_message('debug', "FacilitytypeModel.getFarmFromId : " . $query);
		$result = $this->db->query($query);
		
		$facility_type = array();
		
		$this->load->library('FacilitytypeLib');
		
		$row = $result->row();
		
		$this->facility_typeLib->facility_typeId = $row->facility_type_id;
		$this->facility_typeLib->facility_typeName = $row->facility_type_name;
		
		return $this->facility_typeLib;
	}
	
	function updateFacilitytype() {
		$return = true;
		
		$query = "SELECT * FROM facility_type WHERE facility_type_name = '" . $this->input->post('facility_typeName') . "' AND facility_type_id <> " . $this->input->post('facility_typeId');
		log_message('debug', 'FacilitytypeModel.updateFacilitytype : Try to get Duplicate record : ' . $query);
			
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$data = array(
						'facility_type_name' => $this->input->post('facility_typeName'), 
					);
			$where = "facility_type_id = " . $this->input->post('facility_typeId');
			$query = $this->db->update_string('facility_type', $data, $where);
			
			log_message('debug', 'FacilitytypeModel.updateFacilitytype : ' . $query);
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