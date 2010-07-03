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
		$CI =& get_instance();
		foreach ($result->result_array() as $row) {
			
			$this->load->library('FarmLib');
			unset($this->FarmLib);
			
			$this->FarmLib->farmId = $row['farm_id'];
			$this->FarmLib->farmName = $row['farm_name'];
			$this->FarmLib->farmerType = $row['farmer_type'];
			$this->FarmLib->creationDate = $row['creation_date'];
			
			$CI->load->model('AddressModel','',true);
			$addresses = $CI->AddressModel->getAddressForCompany( '', $row['farm_id'], '', '', '', '' );
			$this->FarmLib->addresses = $addresses;
			
			$CI->load->model('SupplierModel','',true);
			$suppliers = $CI->SupplierModel->getSupplierForCompany( '', $row['farm_id'], '', '', '' );
			$this->FarmLib->suppliers = $suppliers;
			
			$farms[] = $this->FarmLib;
			unset($this->FarmLib);
		}
		
		return $farms;
	}
	
	// Insert the new farm data into the database
	function addFarm() {
		global $ACTIVITY_LEVEL_DB;
		
		$return = true;
		
		$companyId = $this->input->post('companyId');
		$farmName = $this->input->post('farmName');
		
		$CI =& get_instance();
		
		if (empty($companyId) && empty($farmName) ) {
			$GLOBALS['error'] = 'no_name';
			$return = false;
		} else {
			if ( empty($companyId) ) {
				// Enter manufacture into company
				$CI->load->model('CompanyModel','',true);
				$companyId = $CI->CompanyModel->addCompany($this->input->post('farmName'));
			} else {
				if (empty($farmName) ) {
					// Consider company name as manufacture name
					$CI->load->model('CompanyModel','',true);
					$company = $CI->CompanyModel->getCompanyFromId($companyId);
					$farmName = $company->companyName;
				}
			}
			
			$query = "SELECT * FROM farm WHERE farm_name = '" . $farmName . "' ";
			log_message('debug', 'FarmModel.addFarm : Try to get duplicate Farm record : ' . $query);
			
			$result = $this->db->query($query);
			
			if ($result->num_rows() == 0) {
				$query = "INSERT INTO farm (farm_id, company_id, farm_type_id, farmer_type, farm_name, creation_date, custom_url, url, is_active)" .
						" values (NULL, ".$companyId.", " . $this->input->post('farmTypeId') . ", '" . $this->input->post('farmerType') . "', \"" . $farmName . "\", NOW(), '" . $this->input->post('customUrl') . "', '" . $this->input->post('url') . "', '" . $ACTIVITY_LEVEL_DB[$this->input->post('isActive')] . "' )";
				
				log_message('debug', 'FarmModel.addManufacture : Insert Farm : ' . $query);
				$return = true;
				
				if ( $this->db->query($query) ) {
					$newFarmId = $this->db->insert_id();
					
					$CI->load->model('AddressModel','',true);
					$address = $CI->AddressModel->addAddress('', $newFarmId, '', '', $companyId);
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
	
	// Get all the information about one specific farm from an ID
	function getFarmFromId($farmId) {
		
		//$query = "SELECT manufacture.*, address.* FROM manufacture, address WHERE manufacture.manufacture_id = address.manufacture_id AND manufacture.manufacture_id = " . $manufactureId;
		$query = "SELECT farm.*, company.company_name " .
				" FROM farm, company " .
				" WHERE farm.farm_id = " . $farmId . 
				" AND farm.company_id = company.company_id";
		log_message('debug', "FarmModel.getFarmFromId : " . $query);
		$result = $this->db->query($query);
		
		$this->load->library('FarmLib');
		
		$row = $result->row();
		
		$this->FarmLib->farmId = $row->farm_id;
		$this->FarmLib->companyId = $row->company_id;
		$this->FarmLib->companyName = $row->company_name;
		$this->FarmLib->farmTypeId = $row->farm_type_id;
		$this->FarmLib->farmerType = $row->farmer_type;
		$this->FarmLib->farmName = $row->farm_name;
		$this->FarmLib->customUrl = $row->custom_url;
		$this->FarmLib->url = $row->url;
		$this->FarmLib->isActive = $row->is_active;

		return $this->FarmLib;
	}
	
	function updateFarm() {
		global $ACTIVITY_LEVEL_DB;
		$return = true;
		
		$query = "SELECT * FROM farm WHERE farm_name = '" . $this->input->post('farmName') . "' AND farm_id <> " . $this->input->post('farmId');
		log_message('debug', 'FarmModel.updateFarm : Try to get Duplicate record : ' . $query);
		
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$data = array(
						'company_id' => $this->input->post('companyId'), 
						'farm_name' => $this->input->post('farmName'),
						'custom_url' => $this->input->post('customUrl'),
						'url' => $this->input->post('url'),
						'farm_type_id' => $this->input->post('farmTypeId'),
						'farmer_type' => $this->input->post('farmerType'),
						'is_active' => $ACTIVITY_LEVEL_DB[$this->input->post('isActive')],
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
	
	function addFarmWithNameOnly($farmName) {
		global $ACTIVITY_LEVEL_DB;
		
		$return = true;
		
		$companyId = '';
		
		$CI =& get_instance();
		
		if (empty($companyId) && empty($farmName) ) {
			$GLOBALS['error'] = 'no_name';
			$return = false;
		} else {
			if ( empty($companyId) ) {
				$CI->load->model('CompanyModel','',true);
				$companyId = $CI->CompanyModel->addCompany($farmName);
			} 
			
			if ($companyId) {
				$query = "SELECT * FROM farm WHERE farm_name = '" . $farmName . "' AND company_id = '" . $companyId . "'";
				log_message('debug', 'FarmModel.addFarm : Try to get duplicate Farm record : ' . $query);
				
				$result = $this->db->query($query);
				
				if ($result->num_rows() == 0) {
					$query = "INSERT INTO farm (farm_id, company_id, farm_type_id, farm_name, creation_date, custom_url, is_active)" .
							" values (NULL, ".$companyId.", NULL, '" . $farmName . "', NOW(), NULL, '" . $ACTIVITY_LEVEL_DB['active'] . "' )";
					
					log_message('debug', 'FarmModel.addFarm : Insert Farm : ' . $query);
					$return = true;
					
					if ( $this->db->query($query) ) {
						$newFarmId = $this->db->insert_id();
						$return = $newFarmId;
					} else {
						$return = false;
					}
					
				} else {
					$GLOBALS['error'] = 'duplicate';
					$return = false;
				}
			} else {
				$return = false;
			}
			
		}
		
		return $return;	
	}
	
}

?>