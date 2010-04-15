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
		$CI =& get_instance();
		foreach ($result->result_array() as $row) {
			
			$this->load->library('ManufactureLib');
			unset($this->manufactureLib);
			
			$this->manufactureLib->manufactureId = $row['manufacture_id'];
			$this->manufactureLib->manufactureName = $row['manufacture_name'];
			$this->manufactureLib->creationDate = $row['creation_date'];
			
			$CI->load->model('AddressModel','',true);
			$addresses = $CI->AddressModel->getAddressForCompany( '', '', $row['manufacture_id'], '' );
			
			$this->manufactureLib->addresses = $addresses;
			
			$manufactures[] = $this->manufactureLib;
			unset($this->manufactureLib);
		}
		
		return $manufactures;
	}
	
	// Insert the new manufacture data into the database
	function addManufacture() {
		global $ACTIVITY_LEVEL_DB;
		
		$return = true;
		
		$companyId = $this->input->post('companyId');
		$manufactureName = $this->input->post('manufactureName');
		
		$CI =& get_instance();
		
		if (empty($companyId) && empty($manufactureName) ) {
			$GLOBALS['error'] = 'no_name';
			$return = false;
		} else {
			if ( empty($companyId) ) {
				// Enter manufacture into company
				$CI->load->model('CompanyModel','',true);
				$companyId = $CI->CompanyModel->addCompany($this->input->post('manufactureName'));
			} else {
				if (empty($manufactureName) ) {
					// Consider company name as manufacture name
					$CI->load->model('CompanyModel','',true);
					$company = $CI->CompanyModel->getCompanyFromId($companyId);
					$manufactureName = $company->companyName;
				}
			}
			
			$query = "SELECT * FROM manufacture WHERE manufacture_name = '" . $manufactureName . "' AND company_id = '" . $companyId . "'";
			log_message('debug', 'ManufactureModel.addManufacture : Try to get duplicate Manufacture record : ' . $query);
			
			$result = $this->db->query($query);
			
			if ($result->num_rows() == 0) {
				$query = "INSERT INTO manufacture (manufacture_id, company_id, manufacture_type_id, manufacture_name, creation_date, custom_url, is_active)" .
						" values (NULL, ".$companyId.", " . $this->input->post('manufactureTypeId') . ", '" . $manufactureName . "', NOW(), '" . $this->input->post('customUrl') . "', '" . $ACTIVITY_LEVEL_DB[$this->input->post('isActive')] . "' )";
				
				log_message('debug', 'ManufactureModel.addManufacture : Insert Manufacture : ' . $query);
				$return = true;
				
				if ( $this->db->query($query) ) {
					$newManufactureId = $this->db->insert_id();
					
					$CI->load->model('AddressModel','',true);
					$address = $CI->AddressModel->addAddress('', '', $newManufactureId, '');
					/*
					$CI->load->model('AddressModel','',true);
					$address = $CI->AddressModel->prepareAddress($this->input->post('streetNumber'), $this->input->post('street'), $this->input->post('city'), $this->input->post('stateId'), $this->input->post('countryId'), $this->input->post('zipcode') );
				
					$CI->load->model('GoogleMapModel','',true);
					$latLng = $CI->GoogleMapModel->geoCodeAddress($address);
					
					$query = "INSERT INTO address (address_id, street_number, street, city, state_id, zipcode, country_id, latitude , longitude, manufacture_id, company_id)" .
							" values (NULL, '" . $this->input->post('streetNumber') . "', '" . $this->input->post('street') . "', '" . $this->input->post('city') . "', '" . $this->input->post('stateId') . "', '" . $this->input->post('zipcode') . "', '" . $this->input->post('countryId') . "', '" . ( isset($latLng['latitude']) ? $latLng['latitude']:'' ) . "', '" . ( isset($latLng['longitude']) ? $latLng['longitude']:'' ) . "', $newManufactureId, $companyId )";
					
					log_message('debug', 'ManufactureModel.addManufacture : Insert Manufacture : ' . $query);
				
					if ( $this->db->query($query) ) {
						$return = true;
					} else {
						$return = false;
					}
					*/
				} else {
					$return = false;
				}
				
			} else {
				$GLOBALS['error'] = 'duplicate';
				$return = false;
			}
			
		}
		
		return $return;	
	}
	
	// Get all the information about one specific manufacture from an ID
	function getManufactureFromId($manufactureId) {
		
		//$query = "SELECT manufacture.*, address.* FROM manufacture, address WHERE manufacture.manufacture_id = address.manufacture_id AND manufacture.manufacture_id = " . $manufactureId;
		$query = "SELECT * FROM manufacture WHERE manufacture_id = " . $manufactureId;
		log_message('debug', "ManufactureModel.getManufactureFromId : " . $query);
		$result = $this->db->query($query);
		
		$this->load->library('ManufactureLib');
		
		$row = $result->row();
		
		$this->manufactureLib->manufactureId = $row->manufacture_id;
		$this->manufactureLib->companyId = $row->company_id;
		$this->manufactureLib->manufactureTypeId = $row->manufacture_type_id;
		$this->manufactureLib->manufactureName = $row->manufacture_name;
		$this->manufactureLib->customUrl = $row->custom_url;
		$this->manufactureLib->isActive = $row->is_active;

		return $this->manufactureLib;
	}
	
	function updateManufacture() {
		global $ACTIVITY_LEVEL_DB;
		$return = true;
		
		$query = "SELECT * FROM manufacture WHERE manufacture_name = '" . $this->input->post('manufactureName') . "' AND manufacture_id <> " . $this->input->post('manufactureId');
		log_message('debug', 'ManufactureModel.updateManufacture : Try to get Duplicate record : ' . $query);
		
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$data = array(
						'company_id' => $this->input->post('companyId'), 
						'manufacture_name' => $this->input->post('manufactureName'),
						'custom_url' => $this->input->post('customUrl'),
						'manufacture_type_id' => $this->input->post('manufactureTypeId'),
						'is_active' => $ACTIVITY_LEVEL_DB[$this->input->post('isActive')],
					);
			$where = "manufacture_id = " . $this->input->post('manufactureId');
			$query = $this->db->update_string('manufacture', $data, $where);
			
			log_message('debug', 'ManufactureModel.updateManufacture : ' . $query);
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