<?php

class CompanyModel extends Model{
	
	// Generate a simple list of all the companies in the database
	function list_company()
	{
		$query = "SELECT company.* " .
				 " FROM company " .
				 " ORDER BY company_name";
		
		log_message('debug', "CompanyModel.list_company : " . $query);
		$result = $this->db->query($query);
		
		$companies = array();
		
		foreach ($result->result_array() as $row) {
			
			$this->load->library('CompanyLib');
			unset($this->companyLib);
			
			$this->companyLib->companyId = $row['company_id'];
			$this->companyLib->companyName = $row['company_name'];
			$this->companyLib->creationDate = $row['creation_date'];
			
			$companies[] = $this->companyLib;
			unset($this->companyLib);
		}
		
		return $companies;
	}
	
	// Generate a detailed list of all the companies in the database.
	function listCompanyMore()
	{
		
	}
	
	// Add the company data from the controller into the database
	function addCompany() {
		$return = true;
		
		$query = "SELECT * FROM company WHERE company_name = '" . $this->input->post('companyName') . "'";
		log_message('debug', 'CompanyModel.addCompany : Try to get duplicate Company record : ' . $query);
		
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$query = "INSERT INTO company (company_id, company_name, creation_date)" .
					" values (NULL, '" . $this->input->post('companyName') . "', NOW() )";
			log_message('debug', 'CompanyModel.addCompany : Insert Company : ' . $query);
			
			if ( $this->db->query($query) ) {
				
				$new_company_id = $this->db->insert_id();
				
				$query = "INSERT INTO address (address_id, street_number, street, city, state_id, zipcode, country_id, company_id)" .
						" values (NULL, '" . $this->input->post('streetNumber') . "', '" . $this->input->post('street') . "', '" . $this->input->post('city') . "', '" . $this->input->post('stateId') . "', '" . $this->input->post('zipcode') . "', '" . $this->input->post('countryId') . "', $new_company_id )";
				
			log_message('debug', 'CompanyModel.addCompany : Insert Company : ' . $query);
			
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
	
	// Get all the data for one specific company using company_id
	function getCompanyFromId($companyId) {
		
		$query = "SELECT company.*, address.* FROM company, address WHERE company.company_id = address.company_id AND company.company_id = " . $companyId;
		log_message('debug', "CompanyModel.getCompanyFromId : " . $query);
		$result = $this->db->query($query);
		
		$company = array();
		
		$this->load->library('CompanyLib');
		
		$row = $result->row();
		
		$this->companyLib->companyId = $row->company_id;
		$this->companyLib->companyName = $row->company_name;
		$this->companyLib->streetNumber = $row->street_number;
		$this->companyLib->street = $row->street;
		$this->companyLib->city = $row->city;
		$this->companyLib->stateId = $row->state_id;
		$this->companyLib->countryId = $row->country_id;
		$this->companyLib->zipcode = $row->zipcode;
		
		return $this->companyLib;
	}
	
	function updateCompany() {
		$return = true;
		
		$query = "SELECT * FROM company WHERE company_name = '" . $this->input->post('companyName') . "' AND company_id <> " . $this->input->post('companyId');
		log_message('debug', 'CompanyModel.updateCompany : Try to get Duplicate record : ' . $query);
			
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$data = array(
						'company_name' => $this->input->post('companyName'), 
						'street_address' => $this->input->post('streetAddress'),
						'city' => $this->input->post('city'),
						'state_id' => $this->input->post('stateId'),
						'country_id' => $this->input->post('countryId'),
						'zipcode' => $this->input->post('zipcode'),
						 
					);
			$where = "company_id = " . $this->input->post('companyId');
			$query = $this->db->update_string('company', $data, $where);
			
			log_message('debug', 'CompanyModel.updateCompany : ' . $query);
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