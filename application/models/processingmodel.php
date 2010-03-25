<?php

class ProcessingModel extends Model{
	
	// Create a simple list of all the processings
	function list_processing()
	{
		$query = "SELECT processing_facility.* " .
				" FROM processing_facility " .
				" ORDER BY processing_facility_name";
		
		log_message('debug', "ProcessingModel.list_processing : " . $query);
		$result = $this->db->query($query);
		
		$processings = array();
		
		foreach ($result->result_array() as $row) {
			
			$this->load->library('ProcessingLib');
			unset($this->processingLib);
			
			$this->processingLib->processingId = $row['processing_facility_id'];
			$this->processingLib->processingName = $row['processing_facility_name'];
			$this->processingLib->creationDate = $row['creation_date'];
			
			$processings[] = $this->processingLib;
			unset($this->processingLib);
		}
		
		return $processings;
	}
	
	// Insert the new processing data into the database
	function addProcessing() {
		$return = true;
		
		$query = "SELECT * FROM processing_facility WHERE processing_facility_name = '" . $this->input->post('processingName') . "'";
		log_message('debug', 'ProcessingModel.addProcessing : Try to get duplicate Processing record : ' . $query);
		
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$query = "INSERT INTO processing_facility (processing_facility_id, processing_facility_name, creation_date)" .
					" values (NULL, '" . $this->input->post('processingName') . "', NOW() )";
			log_message('debug', 'ProcessingModel.addProcessing : Insert Processing : ' . $query);
			
			if ( $this->db->query($query) ) {
				$new_processing_id = $this->db->insert_id();
				
				$CI =& get_instance();
				$CI->load->model('AddressModel','',true);
				$address = $CI->AddressModel->prepareAddress($this->input->post('streetNumber'), $this->input->post('street'), $this->input->post('city'), $this->input->post('stateId'), $this->input->post('countryId'), $this->input->post('zipcode') );
			
				$CI->load->model('GoogleMapModel','',true);
				$latLng = $CI->GoogleMapModel->geoCodeAddress($address);
				
				$query = "INSERT INTO address (address_id, street_number, street, city, state_id, zipcode, country_id, latitude , longitude, processing_facility_id)" .
						" values (NULL, '" . $this->input->post('streetNumber') . "', '" . $this->input->post('street') . "', '" . $this->input->post('city') . "', '" . $this->input->post('stateId') . "', '" . $this->input->post('zipcode') . "', '" . $this->input->post('countryId') . "', '" . ( isset($latLng['latitude']) ? $latLng['latitude']:'' ) . "', '" . ( isset($latLng['longitude']) ? $latLng['longitude']:'' ) . "', $new_processing_id )";
				
			log_message('debug', 'ProcessingModel.addProcessing : Insert Processing : ' . $query);
			
			$result = $this->db->query($query);
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
	
	// Get all the information about one specific processing from an ID
	function getProcessingFromId($processingId) {
		
		$query = "SELECT processing_facility.*, address.* FROM processing_facility, address WHERE processing_facility.processing_facility_id = address.processing_facility_id AND processing_facility.processing_facility_id = " . $processingId;
		log_message('debug', "ProcessingModel.getProcessingFromId : " . $query);
		$result = $this->db->query($query);
		
		$processing = array();
		
		$this->load->library('ProcessingLib');
		
		$row = $result->row();
		
		$this->processingLib->processingId = $row->processing_facility_id;
		$this->processingLib->processingName = $row->processing_facility_name;
		$this->processingLib->streetNumber = $row->street_number;
		$this->processingLib->street = $row->street;
		$this->processingLib->city = $row->city;
		$this->processingLib->stateId = $row->state_id;
		$this->processingLib->countryId = $row->country_id;
		$this->processingLib->zipcode = $row->zipcode;
		
		return $this->processingLib;
	}
	
	function updateProcessing() {
		$return = true;
		
		$query = "SELECT * FROM processing_facility WHERE processing_facility_name = '" . $this->input->post('processingName') . "' AND processing_facility_id <> " . $this->input->post('processingId');
		log_message('debug', 'ProcessingModel.updateProcessing : Try to get Duplicate record : ' . $query);
		
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$CI =& get_instance();
			$CI->load->model('AddressModel','',true);
			
			$address = $CI->AddressModel->prepareAddress($this->input->post('streetNumber'), $this->input->post('street'), $this->input->post('city'), $this->input->post('stateId'), $this->input->post('countryId'), $this->input->post('zipcode') );
			
			$CI->load->model('GoogleMapModel','',true);
			$latLng = $CI->GoogleMapModel->geoCodeAddress($address);
			
			$data = array(
						'processing_facility_name' => $this->input->post('processingName'), 
					);
			$where = "processing_facility_id = " . $this->input->post('processingId');
			$query = $this->db->update_string('processing_facility', $data, $where);
			
			log_message('debug', 'ProcessingModel.updateProcessing : ' . $query);
			if ( $this->db->query($query) ) {
				$return = true;
				
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
				$where = "processing_facility_id = " . $this->input->post('processingId');
				$query = $this->db->update_string('address', $data, $where);
				if ( $this->db->query($query) ) {
					$return = true;
				} else {
					$return = false;
				}
				
				log_message('debug', 'ProcessingModel.updateProcessing : ' . $query);
				
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