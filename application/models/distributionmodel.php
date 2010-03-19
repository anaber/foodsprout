<?php

class DistributionModel extends Model{
	
	// Create a simple list of all the distributions
	function list_distribution()
	{
		$query = "SELECT distribution_center.* " .
				" FROM distribution_center " .
				" ORDER BY distribution_center";
		
		log_message('debug', "DistributionModel.list_distribution : " . $query);
		$result = $this->db->query($query);
		
		$distributions = array();
		
		foreach ($result->result_array() as $row) {
			
			$this->load->library('DistributionLib');
			unset($this->distributionLib);
			
			$this->distributionLib->distributionId = $row['distribution_center_id'];
			$this->distributionLib->distributionName = $row['distribution_center'];
			$this->distributionLib->creationDate = $row['creation_date'];
			
			$distributions[] = $this->distributionLib;
			unset($this->distributionLib);
		}
		
		return $distributions;
	}
	
	// Insert the new distribution data into the database
	function addDistribution() {
		$return = true;
		
		$query = "SELECT * FROM distribution_center WHERE distribution_center = '" . $this->input->post('distributionName') . "'";
		log_message('debug', 'DistributionModel.addDistribution : Try to get duplicate Distribution record : ' . $query);
		
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$query = "INSERT INTO distribution_center (distribution_center_id, distribution_center, creation_date)" .
					" values (NULL, '" . $this->input->post('distributionName') . "', NOW() )";
			log_message('debug', 'DistributionModel.addDistribution : Insert Distribution : ' . $query);
			
			if ( $this->db->query($query) ) {
				$new_distribution_id = $this->db->insert_id();
				
				$CI =& get_instance();
				$CI->load->model('AddressModel','',true);
				$address = $CI->AddressModel->prepareAddress($this->input->post('streetNumber'), $this->input->post('street'), $this->input->post('city'), $this->input->post('stateId'), $this->input->post('countryId'), $this->input->post('zipcode') );
			
				$CI->load->model('GoogleMapModel','',true);
				$latLng = $CI->GoogleMapModel->geoCodeAddress($address);
				
				$query = "INSERT INTO address (address_id, street_number, street, city, state_id, zipcode, country_id, latitude , longitude, distribution_center_id)" .
						" values (NULL, '" . $this->input->post('streetNumber') . "', '" . $this->input->post('street') . "', '" . $this->input->post('city') . "', '" . $this->input->post('stateId') . "', '" . $this->input->post('zipcode') . "', '" . $this->input->post('countryId') . "', '" . ( isset($latLng['latitude']) ? $latLng['latitude']:'' ) . "', '" . ( isset($latLng['longitude']) ? $latLng['longitude']:'' ) . "', $new_distribution_id )";
				
			log_message('debug', 'DistributionModel.addDistribution : Insert Distribution : ' . $query);
			
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
	
	// Get all the information about one specific distribution from an ID
	function getDistributionFromId($distributionId) {
		
		$query = "SELECT distribution_center.*, address.* FROM distribution_center, address WHERE distribution_center.distribution_center_id = address.distribution_center_id AND distribution_center.distribution_center_id = " . $distributionId;
		log_message('debug', "DistributionModel.getDistributionFromId : " . $query);
		$result = $this->db->query($query);
		
		$distribution = array();
		
		$this->load->library('DistributionLib');
		
		$row = $result->row();
		
		$this->distributionLib->distributionId = $row->distribution_center_id;
		$this->distributionLib->distributionName = $row->distribution_center;
		$this->distributionLib->streetNumber = $row->street_number;
		$this->distributionLib->street = $row->street;
		$this->distributionLib->city = $row->city;
		$this->distributionLib->stateId = $row->state_id;
		$this->distributionLib->countryId = $row->country_id;
		$this->distributionLib->zipcode = $row->zipcode;
		
		return $this->distributionLib;
	}
	
	function updateDistribution() {
		$return = true;
		
		$query = "SELECT * FROM distribution WHERE distribution_name = '" . $this->input->post('distributionName') . "' AND distribution_id <> " . $this->input->post('distributionId');
		log_message('debug', 'DistributionModel.updateDistribution : Try to get Duplicate record : ' . $query);
			
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$CI =& get_instance();
			$CI->load->model('AddressModel','',true);
			
			$address = $CI->AddressModel->prepareAddress($this->input->post('streetNumber'), $this->input->post('street'), $this->input->post('city'), $this->input->post('stateId'), $this->input->post('countryId'), $this->input->post('zipcode') );
			
			$CI->load->model('GoogleMapModel','',true);
			$latLng = $CI->GoogleMapModel->geoCodeAddress($address);
			
			$data = array(
						'distribution_name' => $this->input->post('distributionName'), 
					);
			$where = "distribution_id = " . $this->input->post('distributionId');
			$query = $this->db->update_string('distribution', $data, $where);
			
			log_message('debug', 'DistributionModel.updateDistribution : ' . $query);
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
				$where = "distribution_id = " . $this->input->post('distributionId');
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