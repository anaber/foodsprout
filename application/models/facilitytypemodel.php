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
	
	// Insert facility data into the database
	function addFacilitytype() {
		$return = true;
		
		$query = "SELECT * FROM processing_facility_type WHERE processing_facility_type = '" . $this->input->post('facilitytypeName') . "'";
		log_message('debug', 'FacilitytypeModel.addFacilitytype : Try to get duplicate Facilitytype record : ' . $query);
		
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$query = "INSERT INTO processing_facility_type (processing_facility_type_id, processing_facility_type)" .
					" values (NULL, '" . $this->input->post('facilitytypeName') . "')";
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
	
	// Get a specific processing facility type from an id
	function getFacilitytypeFromId($facilitytypeId) {
		
		$query = "SELECT * FROM processing_facility_type WHERE processing_facility_type_id = " . $facilitytypeId;
		log_message('debug', "FacilitytypeModel.getFacilitytypeFromId : " . $query);
		$result = $this->db->query($query);
		
		$facility_type = array();
		
		$this->load->library('FacilitytypeLib');
		
		$row = $result->row();
		
		$this->facilitytypeLib->facilitytypeId = $row->processing_facility_type_id;
		$this->facilitytypeLib->facilitytypeName = $row->processing_facility_type;
		
		return $this->facilitytypeLib;
	}
	
	// Update a facility based on a specific id
	function updateFacilitytype() {
		$return = true;
		
		$query = "SELECT * FROM processing_facility_type WHERE processing_facility_type = '" . $this->input->post('facilitytypeName') . "' AND processing_facility_type_id <> " . $this->input->post('facilitytypeId');
		log_message('debug', 'FacilitytypeModel.updateFacilitytype : Try to get Duplicate record : ' . $query);
			
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$data = array(
						'processing_facility_type' => $this->input->post('facilitytypeName'), 
					);
			$where = "processing_facility_type_id = " . $this->input->post('facilitytypeId');
			$query = $this->db->update_string('processing_facility_type', $data, $where);
			
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