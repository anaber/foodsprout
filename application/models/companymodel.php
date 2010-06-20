<?php

class CompanyModel extends Model{
	
	function addCompany($companyName) {
		$return = true;
		
		$query = "SELECT * FROM company WHERE company_name = '" . $companyName . "'";
		log_message('debug', 'CompanyModel.addCompany : Try to get duplicate Company record : ' . $query);
		
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$query = "INSERT INTO company (company_id, company_name, creation_date)" .
					" values (NULL, '" . $companyName . "', NOW() )";
			log_message('debug', 'CompanyModel.addCompany : Insert Company : ' . $query);
			
			if ( $this->db->query($query) ) {
				$new_company_id = $this->db->insert_id();

				$return = $new_company_id;
			} else {
				$return = false;
			}
		} else {
			$GLOBALS['error'] = 'duplicate_company';
			$return = false;
		}
		
		return $return;	
	}
	
	// Generate a simple list of all the companies in the database
	function listCompany()
	{
		$query = "SELECT company.* " .
				 " FROM company " .
				 " ORDER BY company_name";
		
		log_message('debug', "CompanyModel.listCompany : " . $query);
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
	
	function getCompanyFromId($companyId) {
		
		$query = "SELECT * FROM company WHERE company_id = " . $companyId;
		log_message('debug', "CompanyModel.getCompanyFromId : " . $query);
		$result = $this->db->query($query);
		
		$company = array();
		
		$this->load->library('CompanyLib');
		
		$row = $result->row();
		
		$this->companyLib->companyId = $row->company_id;
		$this->companyLib->companyName = $row->company_name;
		
		return $this->companyLib;
	}
	
	function getCompanyFromName($companyName) {
		
		$query = "SELECT * FROM company WHERE company_name = '" . $companyName . "'";
		log_message('debug', "CompanyModel.getCompanyFromName : " . $query);
		$result = $this->db->query($query);
		
		$company = array();
		
		$this->load->library('CompanyLib');
		
		$row = $result->row();
		if ($row) {
			$this->companyLib->companyId = $row->company_id;
			$this->companyLib->companyName = $row->company_name;
			return $this->companyLib;
		} else {
			return $company;
		}
	}
	
	function getCompanyBasedOnType ($companyType) {
		
		$query = "SELECT $companyType.* " .
				 " FROM $companyType " .
				 " ORDER BY $companyType" . "_name";
		
		log_message('debug', "CompanyModel.getCompanyBasedOnType : " . $query);
		$result = $this->db->query($query);
		
		$companies = array();
		
		foreach ($result->result_array() as $row) {
			
			$this->load->library('CompanyLib');
			unset($this->companyLib);
			
			$this->companyLib->id = $row[$companyType . '_id'];
			$this->companyLib->name = $row[$companyType . '_name'];
			
			$companies[] = $this->companyLib;
			unset($this->companyLib);
		}
		
		$arr = array(
			'results'    => $companies,
		);
		
		return $arr;
	}
	
	function updateCompany() {
		$return = true;
		
		$query = "SELECT * FROM company WHERE company_name = '" . $this->input->post('companyName') . "' AND company_id <> " . $this->input->post('companyId');
		log_message('debug', 'CompanyModel.updateCompany : Try to get Duplicate record : ' . $query);
			
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$data = array(
						'company_name' => $this->input->post('companyName'), 
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
	
	function searchCompanies($q) {
		$query = "SELECT company_id, company_name
					FROM company
					WHERE company_name like '$q%'
					ORDER BY company_name ";
		$companies = '';
		log_message('debug', "CompanyModel.searchCompanies : " . $query);
		$result = $this->db->query($query);
		foreach ($result->result_array() as $row) {
			$companies .= $row['company_name']."|".$row['company_id']."\n";
		}
		
		return $companies;
	}
	
}



?>