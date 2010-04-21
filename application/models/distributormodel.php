<?php

class DistributorModel extends Model{
	
	// Create a simple list of all the Distributor
	function listDistributor()
	{
		$query = "SELECT distributor.* " .
				" FROM distributor " .
				" ORDER BY distributor_name";
		
		log_message('debug', "DistributorModel.list_distributor : " . $query);
		$result = $this->db->query($query);
		
		$distributors = array();
		$CI =& get_instance();
		foreach ($result->result_array() as $row) {
			
			$this->load->library('DistributorLib');
			unset($this->DistributorLib);
			
			$this->DistributorLib->distributorId = $row['distributor_id'];
			$this->DistributorLib->distributorName = $row['distributor_name'];
			$this->DistributorLib->creationDate = $row['creation_date'];
			
			$CI->load->model('AddressModel','',true);
			$addresses = $CI->AddressModel->getAddressForCompany( '', '', '', $row['distributor_id']);
			$this->DistributorLib->addresses = $addresses;
			
			$CI->load->model('SupplierModel','',true);
			$suppliers = $CI->SupplierModel->getSupplierForCompany( '', '', '', $row['distributor_id']);
			$this->DistributorLib->suppliers = $suppliers;
			
			$distributors[] = $this->DistributorLib;
			unset($this->DistributorLib);
		}
		
		return $distributors;
	}
	
	// Insert the new Distributor data into the database
	function addDistributor() {
		global $ACTIVITY_LEVEL_DB;
		
		$return = true;
		
		$companyId = $this->input->post('companyId');
		$distributorName = $this->input->post('distributorName');
		
		$CI =& get_instance();
		
		if (empty($companyId) && empty($distributorName) ) {
			$GLOBALS['error'] = 'no_name';
			$return = false;
		} else {
			if ( empty($companyId) ) {
				// Enter distributor into company
				$CI->load->model('CompanyModel','',true);
				$companyId = $CI->CompanyModel->addCompany($this->input->post('distributorName'));
			} else {
				if (empty($distributorName) ) {
					// Consider company name as distributor name
					$CI->load->model('CompanyModel','',true);
					$company = $CI->CompanyModel->getCompanyFromId($companyId);
					$distributorName = $company->companyName;
				}
			}
			
			$query = "SELECT * FROM distributor WHERE distributor_name = '" . $distributorName . "'";
			log_message('debug', 'DistributorModel.addDistributor : Try to get duplicate Distributor record : ' . $query);
			
			$result = $this->db->query($query);
			
			if ($result->num_rows() == 0) {
				$query = "INSERT INTO distributor (distributor_id, company_id, distributor_name, creation_date, custom_url, is_active)" .
						" values (NULL, ".$companyId.", '" . $distributorName . "', NOW(), '" . $this->input->post('customUrl') . "', '" . $ACTIVITY_LEVEL_DB[$this->input->post('isActive')] . "' )";
				
				log_message('debug', 'DistributorModel.addDistributor : Insert Distributor : ' . $query);
				$return = true;
				
				if ( $this->db->query($query) ) {
					$newDistributorId = $this->db->insert_id();
					
					$CI->load->model('AddressModel','',true);
					$address = $CI->AddressModel->addAddress('', '', '', $newDistributorId, $companyId);
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
	
	// Get all the information about one specific Distributor from an ID
	function getDistributorFromId($distributorId) {
		
		$query = "SELECT * FROM distributor WHERE distributor_id = " . $distributorId;
		log_message('debug', "DistributorModel.getDistributorFromId : " . $query);
		$result = $this->db->query($query);
		
		$this->load->library('DistributorLib');
		
		$row = $result->row();
		
		$this->DistributorLib->distributorId = $row->distributor_id;
		$this->DistributorLib->companyId = $row->company_id;
		$this->DistributorLib->distributorName = $row->distributor_name;
		$this->DistributorLib->customUrl = $row->custom_url;
		$this->DistributorLib->isActive = $row->is_active;

		return $this->DistributorLib;
	}
	
	function updateDistributor() {
		global $ACTIVITY_LEVEL_DB;
		$return = true;
		
		$query = "SELECT * FROM distributor WHERE distributor_name = '" . $this->input->post('distributorName') . "' AND distributor_id <> " . $this->input->post('distributorId');
		log_message('debug', 'DistributorModel.updateDistributor : Try to get Duplicate record : ' . $query);
		
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$data = array(
						'company_id' => $this->input->post('companyId'), 
						'distributor_name' => $this->input->post('distributorName'),
						'custom_url' => $this->input->post('customUrl'),
						'is_active' => $ACTIVITY_LEVEL_DB[$this->input->post('isActive')],
					);
			$where = "distributor_id = " . $this->input->post('distributorId');
			$query = $this->db->update_string('distributor', $data, $where);
			
			log_message('debug', 'DistributorModel.updateDistributor : ' . $query);
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
	
	function addDistributorWithNameOnly($distributorName) {
		global $ACTIVITY_LEVEL_DB;
		
		$return = true;
		
		$companyId = '';
		
		$CI =& get_instance();
		
		if (empty($companyId) && empty($distributorName) ) {
			$GLOBALS['error'] = 'no_name';
			$return = false;
		} else {
			if ( empty($companyId) ) {
				$CI->load->model('CompanyModel','',true);
				$companyId = $CI->CompanyModel->addCompany($distributorName);
			} 
			
			if ($companyId) {
				$query = "SELECT * FROM distributor WHERE distributor_name = '" . $distributorName . "' AND company_id = '" . $companyId . "'";
				log_message('debug', 'DistributorModel.addDistributor : Try to get duplicate Distributor record : ' . $query);
				
				$result = $this->db->query($query);
				
				if ($result->num_rows() == 0) {
					$query = "INSERT INTO distributor (distributor_id, company_id, distributor_name, creation_date, custom_url, is_active)" .
							" values (NULL, ".$companyId.", '" . $distributorName . "', NOW(), NULL, '" . $ACTIVITY_LEVEL_DB['active'] . "' )";
					
					log_message('debug', 'DistributorModel.addDistributor : Insert Distributor : ' . $query);
					$return = true;
					
					if ( $this->db->query($query) ) {
						$newDistributorId = $this->db->insert_id();
						$return = $newDistributorId;
					} else {
						$return = false;
					}
					
				} else {
					$GLOBALS['error'] = 'duplicate';
					$return = false;
				}
			} else {
				//echo "DEEPAK IN FALSE";
				$return = false;
			}
			
		}
		
		return $return;	
	}
	
}

?>