<?php

class FarmModel extends Model{
	
	// List all the products in the database
	function list_farm()
	{
		$query = "SELECT farm.*, state.state_name, country.country_name " .
				" FROM farm, state, country " .
				" WHERE farm.state_id = state.state_id" .
				" AND farm.country_id = country.country_id " .
				" ORDER BY farm_name";
		
		log_message('debug', "FarmModel.list_farm : " . $query);
		$result = $this->db->query($query);
		
		$farms = array();
		
		foreach ($result->result_array() as $row) {
			
			$this->load->library('FarmLib');
			unset($this->farmLib);
			
			$this->farmLib->farmId = $row['farm_id'];
			$this->farmLib->farmName = $row['farm_name'];
			$this->farmLib->streetAddress = $row['street_address'];
			$this->farmLib->stateId = $row['state_id'];
			$this->farmLib->stateName = $row['state_name'];
			$this->farmLib->countryId = $row['country_id'];
			$this->farmLib->countryName = $row['country_name'];
			$this->farmLib->zipcode = $row['zipcode'];
			$this->farmLib->creationDate = $row['creation_date'];
			
			$farms[] = $this->farmLib;
			unset($this->farmLib);
		}
		
		return $farms;
	}
	
	function addFarm() {
		$return = true;
		
		$query = "SELECT * FROM farm WHERE farm_name = '" . $this->input->post('farmName') . "'";
		log_message('debug', 'FarmModel.addFarm : Try to get duplicate Farm record : ' . $query);
		
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$query = "INSERT INTO farm (farm_id, farm_name, country_id, state_id, street_address, zipcode, creation_date, custom_url)" .
					" values (NULL, '" . $this->input->post('farmName') . "', '" . $this->input->post('countryId') . "', '" . $this->input->post('stateId') . "', '" . $this->input->post('streetAddress') . "', '" . $this->input->post('zipcode') . "', NOW(), '" . $this->input->post('customUrl') . "' )";
			log_message('debug', 'FarmModel.addFarm : Insert Farm : ' . $query);
			
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
	
	function getFarmFromId($farmId) {
		
		$query = "SELECT * FROM farm WHERE farm_id = " . $farmId;
		log_message('debug', "FarmModel.getFarmFromId : " . $query);
		$result = $this->db->query($query);
		
		$company = array();
		
		$this->load->library('FarmLib');
		
		$row = $result->row();
		
		$this->farmLib->farmId = $row->farm_id;
		$this->farmLib->farmName = $row->farm_name;
		$this->farmLib->streetAddress = $row->street_address;
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
			
			$data = array(
						'farm_name' => $this->input->post('farmName'), 
						'street_address' => $this->input->post('streetAddress'),
						'state_id' => $this->input->post('stateId'),
						'country_id' => $this->input->post('countryId'),
						'zipcode' => $this->input->post('zipcode'),
						'custom_url' => $this->input->post('customUrl'),
					);
			$where = "farm_id = " . $this->input->post('farmId');
			$query = $this->db->update_string('farm', $data, $where);
			
			log_message('debug', 'FarmModel.updateFarm : ' . $query);
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