<?php

class FarmModel extends Model{
	
	// Create a simple list of all the farms
	function listFarm()
	{
		$query = "SELECT farm.* " .
				" FROM farm " .
				" ORDER BY farm_name";
		
		log_message('debug', "FarmModel.listFarm : " . $query);
		$result = $this->db->query($query);
		
		$farms = array();
		
		foreach ($result->result_array() as $row) {
			
			$this->load->library('FarmLib');
			unset($this->FarmLib);
			
			$this->FarmLib->farmId = $row['farm_id'];
			$this->FarmLib->farmName = $row['farm_name'];
			$this->FarmLib->creationDate = $row['creation_date'];
			
			$farms[] = $this->FarmLib;
			unset($this->FarmLib);
		}
		
		return $farms;
	}
	
	// Insert the new farm data into the database
	function addFarm() {
		$return = true;
		
		$query = "SELECT * FROM farm WHERE farm_name = '" . $this->input->post('farmName') . "'";
		log_message('debug', 'FarmModel.addFarm : Try to get duplicate Farm record : ' . $query);
		
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$query = "INSERT INTO farm (farm_id, farm_name, creation_date)" .
					" values (NULL, '" . $this->input->post('farmName') . "', NOW() )";
			log_message('debug', 'FarmModel.addFarm : Insert Farm : ' . $query);
			
			if ( $this->db->query($query) ) {
				$new_farm_id = $this->db->insert_id();
				
				$CI =& get_instance();
				$CI->load->model('AddressModel','',true);
				$address = $CI->AddressModel->prepareAddress($this->input->post('streetNumber'), $this->input->post('street'), $this->input->post('city'), $this->input->post('stateId'), $this->input->post('countryId'), $this->input->post('zipcode') );
			
				$CI->load->model('GoogleMapModel','',true);
				$latLng = $CI->GoogleMapModel->geoCodeAddress($address);
				
				$query = "INSERT INTO address (address_id, street_number, street, city, state_id, zipcode, country_id, latitude , longitude, farm_id)" .
						" values (NULL, '" . $this->input->post('streetNumber') . "', '" . $this->input->post('street') . "', '" . $this->input->post('city') . "', '" . $this->input->post('stateId') . "', '" . $this->input->post('zipcode') . "', '" . $this->input->post('countryId') . "', '" . ( isset($latLng['latitude']) ? $latLng['latitude']:'' ) . "', '" . ( isset($latLng['longitude']) ? $latLng['longitude']:'' ) . "', $new_farm_id )";
				
			log_message('debug', 'FarmModel.addFarm : Insert Farm : ' . $query);
			
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
	
	// Get all the information about one specific farm from an ID
	function getFarmFromId($farmId) {
		
		$query = "SELECT farm.*, address.* FROM farm, address WHERE farm.farm_id = address.farm_id AND farm.farm_id = " . $farmId;
		log_message('debug', "FarmModel.getFarmFromId : " . $query);
		$result = $this->db->query($query);
		
		$farm = array();
		
		$this->load->library('FarmLib');
		
		$row = $result->row();
		
		$this->farmLib->farmId = $row->farm_id;
		$this->farmLib->farmName = $row->farm_name;
		$this->farmLib->streetNumber = $row->street_number;
		$this->farmLib->street = $row->street;
		$this->farmLib->city = $row->city;
		$this->farmLib->stateId = $row->state_id;
		$this->farmLib->countryId = $row->country_id;
		$this->farmLib->zipcode = $row->zipcode;
		$this->farmLib->customUrl = $row->custom_url;
		
		return $this->farmLib;
	}
	
	function updateFarm() {
		$return = true;
		
		$query = "SELECT * FROM farm WHERE farm_name = '" . $this->input->post('farmName') . "' AND farm_id <> " . $this->input->post('farmId');
		log_message('debug', 'FarmModel.updateFarm : Try to get Duplicate record : ' . $query);
			
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$CI =& get_instance();
			$CI->load->model('AddressModel','',true);
			
			$address = $CI->AddressModel->prepareAddress($this->input->post('streetNumber'), $this->input->post('street'), $this->input->post('city'), $this->input->post('stateId'), $this->input->post('countryId'), $this->input->post('zipcode') );
			
			$CI->load->model('GoogleMapModel','',true);
			$latLng = $CI->GoogleMapModel->geoCodeAddress($address);
			
			$data = array(
						'farm_name' => $this->input->post('farmName'), 
					);
			$where = "farm_id = " . $this->input->post('farmId');
			$query = $this->db->update_string('farm', $data, $where);
			
			log_message('debug', 'FarmModel.updateFarm : ' . $query);
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
				$where = "farm_id = " . $this->input->post('farmId');
				$query = $this->db->update_string('address', $data, $where);
				if ( $this->db->query($query) ) {
					$return = true;
				} else {
					$return = false;
				}
				
				log_message('debug', 'CompanyModel.updateCompany : ' . $query);
				
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