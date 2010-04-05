<?php

class DistributorModel extends Model{
	
	// Create a simple list of all the distributors
	function listDistributor()
	{
		$query = "SELECT distributor.* " .
				" FROM distributor " .
				" ORDER BY distributor_name";
		
		log_message('debug', "DistributorModel.listDistributor : " . $query);
		$result = $this->db->query($query);
		
		$distributors = array();
		
		foreach ($result->result_array() as $row) {
			
			$this->load->library('DistributorLib');
			unset($this->DistributorLib);
			
			$this->DistributorLib->distributorId = $row['distributor_id'];
			$this->DistributorLib->distributorName = $row['distributor_name'];
			$this->DistributorLib->creationDate = $row['creation_date'];
			
			$distributors[] = $this->DistributorLib;
			unset($this->DistributorLib);
		}
		
		return $distributors;
	}
	
	// Insert the new distributor data into the database
	function addDistributor() {
		$return = true;
		
		$query = "SELECT * FROM distributor_center WHERE distributor_center = '" . $this->input->post('distributorName') . "'";
		log_message('debug', 'DistributorModel.addDistributor : Try to get duplicate Distributor record : ' . $query);
		
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$query = "INSERT INTO distributor_center (distributor_center_id, distributor_center, creation_date)" .
					" values (NULL, '" . $this->input->post('distributorName') . "', NOW() )";
			log_message('debug', 'DistributorModel.addDistributor : Insert Distributor : ' . $query);
			
			if ( $this->db->query($query) ) {
				$new_distributor_id = $this->db->insert_id();
				
				$CI =& get_instance();
				$CI->load->model('AddressModel','',true);
				$address = $CI->AddressModel->prepareAddress($this->input->post('streetNumber'), $this->input->post('street'), $this->input->post('city'), $this->input->post('stateId'), $this->input->post('countryId'), $this->input->post('zipcode') );
			
				$CI->load->model('GoogleMapModel','',true);
				$latLng = $CI->GoogleMapModel->geoCodeAddress($address);
				
				$query = "INSERT INTO address (address_id, street_number, street, city, state_id, zipcode, country_id, latitude , longitude, distributor_center_id)" .
						" values (NULL, '" . $this->input->post('streetNumber') . "', '" . $this->input->post('street') . "', '" . $this->input->post('city') . "', '" . $this->input->post('stateId') . "', '" . $this->input->post('zipcode') . "', '" . $this->input->post('countryId') . "', '" . ( isset($latLng['latitude']) ? $latLng['latitude']:'' ) . "', '" . ( isset($latLng['longitude']) ? $latLng['longitude']:'' ) . "', $new_distributor_id )";
				
			log_message('debug', 'DistributorModel.addDistributor : Insert Distributor : ' . $query);
			
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
	
	// Get all the information about one specific distributor from an ID
	function getDistributorFromId($distributorId) {
		
		$query = "SELECT distributor_center.*, address.* FROM distributor_center, address WHERE distributor_center.distributor_center_id = address.distributor_center_id AND distributor_center.distributor_center_id = " . $distributorId;
		log_message('debug', "DistributorModel.getDistributorFromId : " . $query);
		$result = $this->db->query($query);
		
		$distributor = array();
		
		$this->load->library('DistributorLib');
		
		$row = $result->row();
		
		$this->distributorLib->distributorId = $row->distributor_center_id;
		$this->distributorLib->distributorName = $row->distributor_center;
		$this->distributorLib->streetNumber = $row->street_number;
		$this->distributorLib->street = $row->street;
		$this->distributorLib->city = $row->city;
		$this->distributorLib->stateId = $row->state_id;
		$this->distributorLib->countryId = $row->country_id;
		$this->distributorLib->zipcode = $row->zipcode;
		
		return $this->distributorLib;
	}
	
	function updateDistributor() {
		$return = true;
		
		$query = "SELECT * FROM distributor_center WHERE distributor_center = '" . $this->input->post('distributorName') . "' AND distributor_center_id <> " . $this->input->post('distributorId');
		log_message('debug', 'DistributorModel.updateDistributor : Try to get Duplicate record : ' . $query);
		
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$CI =& get_instance();
			$CI->load->model('AddressModel','',true);
			
			$address = $CI->AddressModel->prepareAddress($this->input->post('streetNumber'), $this->input->post('street'), $this->input->post('city'), $this->input->post('stateId'), $this->input->post('countryId'), $this->input->post('zipcode') );
			
			$CI->load->model('GoogleMapModel','',true);
			$latLng = $CI->GoogleMapModel->geoCodeAddress($address);
			
			$data = array(
						'distributor_center' => $this->input->post('distributorName'), 
					);
			$where = "distributor_center_id = " . $this->input->post('distributorId');
			$query = $this->db->update_string('distributor_center', $data, $where);
			
			log_message('debug', 'DistributorModel.updateDistributor : ' . $query);
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
				$where = "distributor_center_id = " . $this->input->post('distributorId');
				$query = $this->db->update_string('address', $data, $where);
				if ( $this->db->query($query) ) {
					$return = true;
				} else {
					$return = false;
				}
				
				log_message('debug', 'DistributorModel.updateDistributor : ' . $query);
				
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