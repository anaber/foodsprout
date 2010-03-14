<?php

class CompanyModel extends Model{
	
	// List all the products in the database
	function list_company()
	{
		$query = "SELECT company.*, state.state_name, country.country_name " .
				" FROM company, state, country " .
				" WHERE company.state_id = state.state_id" .
				" AND company.country_id = country.country_id " .
				" ORDER BY company_name";
		
		log_message('debug', "CompanyModel.list_company : " . $query);
		$result = $this->db->query($query);
		
		$companies = array();
		
		foreach ($result->result_array() as $row) {
			
			$this->load->library('CompanyLib');
			unset($this->companyLib);
			
			$this->companyLib->companyId = $row['company_id'];
			$this->companyLib->companyName = $row['company_name'];
			$this->companyLib->streetAddress = $row['street_address'];
			$this->companyLib->stateId = $row['state_id'];
			$this->companyLib->stateName = $row['state_name'];
			$this->companyLib->countryId = $row['country_id'];
			$this->companyLib->countryName = $row['country_name'];
			$this->companyLib->zipcode = $row['zipcode'];
			$this->companyLib->creationDate = $row['creation_date'];
			
			$companies[] = $this->companyLib;
			unset($this->companyLib);
		}
		
		return $companies;
	}
	
	function addCompany() {
		$return = true;
		
		$query = "SELECT * FROM company WHERE company_name = '" . $this->input->post('companyName') . "'";
		log_message('debug', 'CompanyModel.addCompany : Try to get duplicate Company record : ' . $query);
		
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$query = "INSERT INTO company (company_id, company_name, country_id, state_id, city, street_address, zipcode, creation_date)" .
					" values (NULL, '" . $this->input->post('companyName') . "', '" . $this->input->post('countryId') . "', '" . $this->input->post('stateId') . "', '" . $this->input->post('city') . "', '" . $this->input->post('streetAddress') . "', '" . $this->input->post('zipcode') . "', NOW() )";
			log_message('debug', 'CompanyModel.addCompany : Insert Company : ' . $query);
			
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
	
	function getCompanyFromId($companyId) {
		
		$query = "SELECT * FROM company WHERE company_id = " . $companyId;
		log_message('debug', "CompanyModel.getCompanyFromId : " . $query);
		$result = $this->db->query($query);
		
		$company = array();
		
		$this->load->library('CompanyLib');
		
		$row = $result->row();
		
		$this->companyLib->companyId = $row->company_id;
		$this->companyLib->companyName = $row->company_name;
		$this->companyLib->streetAddress = $row->street_address;
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