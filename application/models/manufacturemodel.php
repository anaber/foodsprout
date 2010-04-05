<?php

class ManufactureModel extends Model{
	
	// Create a simple list of all the manufactures
	function listManufacture()
	{
		$query = "SELECT manufacture.* " .
				" FROM manufacture " .
				" ORDER BY manufacture_name";
		
		log_message('debug', "ManufactureModel.list_manufacture : " . $query);
		$result = $this->db->query($query);
		
		$manufactures = array();
		
		foreach ($result->result_array() as $row) {
			
			$this->load->library('ManufactureLib');
			unset($this->manufactureLib);
			
			$this->manufactureLib->manufactureId = $row['manufacture_id'];
			$this->manufactureLib->manufactureName = $row['manufacture_name'];
			$this->manufactureLib->creationDate = $row['creation_date'];
			
			$manufactures[] = $this->manufactureLib;
			unset($this->manufactureLib);
		}
		
		return $manufactures;
	}
	
	// Insert the new manufacture data into the database
	function addManufacture() {
		$return = true;
		
		$query = "SELECT * FROM manufacture WHERE manufacture_name = '" . $this->input->post('manufactureName') . "'";
		log_message('debug', 'ManufactureModel.addManufacture : Try to get duplicate Manufacture record : ' . $query);
		
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$query = "INSERT INTO manufacture (manufacture_id, manufacture_name, creation_date)" .
					" values (NULL, '" . $this->input->post('manufactureName') . "', NOW() )";
			log_message('debug', 'ManufactureModel.addManufacture : Insert Manufacture : ' . $query);
			
			if ( $this->db->query($query) ) {
				$new_manufacture_id = $this->db->insert_id();
				
				$CI =& get_instance();
				$CI->load->model('AddressModel','',true);
				$address = $CI->AddressModel->prepareAddress($this->input->post('streetNumber'), $this->input->post('street'), $this->input->post('city'), $this->input->post('stateId'), $this->input->post('countryId'), $this->input->post('zipcode') );
			
				$CI->load->model('GoogleMapModel','',true);
				$latLng = $CI->GoogleMapModel->geoCodeAddress($address);
				
				$query = "INSERT INTO address (address_id, street_number, street, city, state_id, zipcode, country_id, latitude , longitude, manufacture_facility_id)" .
						" values (NULL, '" . $this->input->post('streetNumber') . "', '" . $this->input->post('street') . "', '" . $this->input->post('city') . "', '" . $this->input->post('stateId') . "', '" . $this->input->post('zipcode') . "', '" . $this->input->post('countryId') . "', '" . ( isset($latLng['latitude']) ? $latLng['latitude']:'' ) . "', '" . ( isset($latLng['longitude']) ? $latLng['longitude']:'' ) . "', $new_manufacture_id )";
				
			log_message('debug', 'ManufactureModel.addManufacture : Insert Manufacture : ' . $query);
			
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
	
	// Get all the information about one specific manufacture from an ID
	function getManufactureFromId($manufactureId) {
		
		$query = "SELECT manufacture.*, address.* FROM manufacture, address WHERE manufacture.manufacture_id = address.manufacture_id AND manufacture.manufacture_id = " . $manufactureId;
		log_message('debug', "ManufactureModel.getManufactureFromId : " . $query);
		$result = $this->db->query($query);
		
		$manufacture = array();
		
		$this->load->library('ManufactureLib');
		
		$row = $result->row();
		
		$this->manufactureLib->manufactureId = $row->manufacture_id;
		$this->manufactureLib->manufactureName = $row->manufacture_name;
		$this->manufactureLib->streetNumber = $row->street_number;
		$this->manufactureLib->street = $row->street;
		$this->manufactureLib->city = $row->city;
		$this->manufactureLib->stateId = $row->state_id;
		$this->manufactureLib->countryId = $row->country_id;
		$this->manufactureLib->zipcode = $row->zipcode;
		
		return $this->manufactureLib;
	}
	
	function updateManufacture() {
		$return = true;
		
		$query = "SELECT * FROM manufacture WHERE manufacture_name = '" . $this->input->post('manufactureName') . "' AND manufacture_id <> " . $this->input->post('manufactureId');
		log_message('debug', 'ManufactureModel.updateManufacture : Try to get Duplicate record : ' . $query);
		
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$CI =& get_instance();
			$CI->load->model('AddressModel','',true);
			
			$address = $CI->AddressModel->prepareAddress($this->input->post('streetNumber'), $this->input->post('street'), $this->input->post('city'), $this->input->post('stateId'), $this->input->post('countryId'), $this->input->post('zipcode') );
			
			$CI->load->model('GoogleMapModel','',true);
			$latLng = $CI->GoogleMapModel->geoCodeAddress($address);
			
			$data = array(
						'manufacture_facility_name' => $this->input->post('manufactureName'), 
					);
			$where = "manufacture_facility_id = " . $this->input->post('manufactureId');
			$query = $this->db->update_string('manufacture_facility', $data, $where);
			
			log_message('debug', 'ManufactureModel.updateManufacture : ' . $query);
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
				$where = "manufacture_facility_id = " . $this->input->post('manufactureId');
				$query = $this->db->update_string('address', $data, $where);
				if ( $this->db->query($query) ) {
					$return = true;
				} else {
					$return = false;
				}
				
				log_message('debug', 'ManufactureModel.updateManufacture : ' . $query);
				
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