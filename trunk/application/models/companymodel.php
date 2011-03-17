<?php

class CompanyModel extends Model{
	
	function addCompany($companyName) {
		$return = true;
		
		$query = "SELECT * FROM company WHERE company_name = \"" . $companyName . "\"";
		log_message('debug', 'CompanyModel.addCompany : Try to get duplicate Company record : ' . $query);
		
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$query = "INSERT INTO company (company_id, company_name, creation_date)" .
					" values (NULL, \"" . $companyName . "\", NOW() )";
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
		
		$query = "SELECT * FROM company WHERE company_name = \"" . $companyName . "\"";
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
	
	function getCompanyBasedOnType ($producerType, $q) {

		$originalQ = $q;
		$q = strtolower($q);
		$query = 'SELECT ' .
				' producer_id, producer' .
				' FROM producer' .
				' WHERE ' .
				' producer like "%'.$q.'%"';
			if ($producerType == 'farm') {
				$query .= ' AND is_farm = 1';
			} else if ($producerType == 'restaurant') {
				$query .= ' AND is_restaurant = 1';
			} else if ($producerType == 'distributor') {
				$query .= ' AND is_distributor = 1';
			} else if ($producerType == 'manufacture') {
				$query .= ' AND is_manufacture = 1';
			} 
				
		$query .= ' ORDER BY producer';
		
		$producers = '';
		
		log_message('debug', "CompanyModel.getCompanyBasedOnTypeFrontEnd : " . $query);
		$result = $this->db->query($query);
		
		if ( $result->num_rows() > 0) {
			foreach ($result->result_array() as $row) {
				$producers .= $row['producer']."|".$row['producer_id']."\n";
			}
		} else {
			$producers .= 'Create "'.$originalQ.'"|' . $originalQ;
		}
		
		return $producers;
		
	}
	
	function getCompanyBasedOnTypeFrontEnd ($companyType, $q) {
		$originalQ = $q;
		$q = strtolower($q);
		$query = 'SELECT ' . $companyType . '_id, ' . $companyType . '_name
					FROM ' . $companyType .'
					WHERE ' . $companyType.'_name like "%'.$q.'%"
					ORDER BY ' . $companyType.'_name ';
		
		$companies = '';
		
		log_message('debug', "CompanyModel.getCompanyBasedOnTypeFrontEnd : " . $query);
		$result = $this->db->query($query);
		
		if ( $result->num_rows() > 0) {
			foreach ($result->result_array() as $row) {
				$companies .= $row[$companyType . '_name']."|".$row[$companyType . '_id']."\n";
			}
		} else {
			$companies .= 'Create "'.$originalQ.'"|' . $originalQ;
		}
		
		return $companies;
	}
	
	function updateCompany() {
		$return = true;
		
		$query = "SELECT * FROM company WHERE company_name = \"" . $this->input->post('companyName') . "\" AND company_id <> " . $this->input->post('companyId');
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
	
	function getCompaniesJsonAdmin() {
		global $PER_PAGE;
		
		$p = $this->input->post('p'); // Page
		$pp = $this->input->post('pp'); // Per Page
		$sort = $this->input->post('sort');
		$order = $this->input->post('order');
		
		$q = $this->input->post('q');
		
		if ($q == '0') {
			$q = '';
		}
		
		$start = 0;
		$page = 0;
		
		
		$base_query = 'SELECT *' .
				' FROM company';
		
		$base_query_count = 'SELECT count(*) AS num_records' .
				' FROM company';
		
		$where = ' WHERE ';
		
		$where .= ' (' 
				. '	company.company_name like "%' .$q . '%"'
				. ' OR company.company_id like "%' . $q . '%"';
		$where .= ' )';
		
		$base_query_count = $base_query_count . $where;
		
		$query = $base_query_count;
		
		$result = $this->db->query($query);
		$row = $result->row();
		$numResults = $row->num_records;
		
		$query = $base_query . $where;
		
		if ( empty($sort) ) {
			$sort_query = ' ORDER BY company_name';
			$sort = 'company_name';
		} else {
			$sort_query = ' ORDER BY ' . $sort;
		}
		
		if ( empty($order) ) {
			$order = 'ASC';
		}
		
		$query = $query . ' ' . $sort_query . ' ' . $order;
		
		if (!empty($pp) && $pp != 'all' ) {
			$PER_PAGE = $pp;
		}
		
		if (!empty($pp) && $pp == 'all') {
			// NO NEED TO LIMIT THE CONTENT
		} else {
			
			if (!empty($p) || $p != 0) {
				$page = $p;
				$p = $p * $PER_PAGE;
				$query .= " LIMIT $p, " . $PER_PAGE;
				$start = $p;
				
			} else {
				$query .= " LIMIT 0, " . $PER_PAGE;
			}
		}
		
		log_message('debug', "CompanyModel.getCompaniesJsonAdmin : " . $query);
		$result = $this->db->query($query);
		
		$companies = array();
		
		$CI =& get_instance();
		
		$geocodeArray = array();
		foreach ($result->result_array() as $row) {
			
			$this->load->library('CompanyLib');
			unset($this->CompanyLib);
			
			$this->CompanyLib->companyId = $row['company_id'];
			$this->CompanyLib->companyName = $row['company_name'];
			
			$companies[] = $this->CompanyLib;
			unset($this->CompanyLib);
		}
		
		if (!empty($pp) && $pp == 'all') {
			$PER_PAGE = $numResults;
		}
		
		$totalPages = ceil($numResults/$PER_PAGE);
		$first = 0;
		if ($totalPages > 0) {
			$last = $totalPages - 1;
		} else {
			$last = 0;
		}
		
		
		$params = requestToParams($numResults, $start, $totalPages, $first, $last, $page, $sort, $order, $q, '', '');
		$arr = array(
			'results'    => $companies,
			'param'      => $params,
			'geocode'	 => $geocodeArray,
	    );
	    
	    return $arr;
	}
	
}



?>