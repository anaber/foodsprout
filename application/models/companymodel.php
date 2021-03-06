<?php

class CompanyModel extends Model{
	
	function addCompany($companyName) {
		$return = true;
		
		// $query = "SELECT * FROM company WHERE company_name = \"" . $companyName . "\"";
		$query = "SELECT * FROM producer_conglomerate WHERE conglomerate_name = '".$companyName."'";
		log_message('debug', 'CompanyModel.addCompany : Try to get duplicate Company record : ' . $query);
		
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$query = "INSERT INTO producer_conglomerate (conglomerate_name)
					  VALUES ('".$companyName."')";
			/*$query = "INSERT INTO company (company_id, company_name, creation_date)" .
					" values (NULL, \"" . $companyName . "\", NOW() )";*/
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
		/*$query = "SELECT company.* " .
				 " FROM company " .
				 " ORDER BY company_name";*/
		$query = "SELECT * FROM producer_conglomerate ORDER BY conglomerate_name";
		
		log_message('debug', "CompanyModel.listCompany : " . $query);
		$result = $this->db->query($query);
		
		$companies = array();
		
		foreach ($result->result_array() as $row) {
			
			$this->load->library('CompanyLib');
			unset($this->companyLib);
			
			/*$this->companyLib->companyId = $row['company_id'];
			$this->companyLib->companyName = $row['company_name'];
			$this->companyLib->creationDate = $row['creation_date'];*/
			
			$this->companyLib->companyId = $row['producer_conglomerate_id'];
			$this->companyLib->companyName = $row['conglomerate_name'];
			
			$companies[] = $this->companyLib;
			unset($this->companyLib);
		}
		
		return $companies;
	}
	
	function getCompanyFromId($companyId) {
		
		/*$query = "SELECT * FROM company WHERE company_id = " . $companyId;*/
		$query = "SELECT * FROM producer_conglomerate WHERE producer_conglomerate_id = ".$companyId;
		log_message('debug', "CompanyModel.getCompanyFromId : " . $query);
		$result = $this->db->query($query);
		
		$company = array();
		
		$this->load->library('CompanyLib');
		
		$row = $result->row();
		
		/*$this->companyLib->companyId = $row->company_id;
		$this->companyLib->companyName = $row->company_name;*/
		$this->companyLib->companyId = $row->producer_conglomerate_id;
		$this->companyLib->companyName = $row->conglomerate_name;
		
		return $this->companyLib;
	}
	
	function getCompanyFromName($companyName) {
		
		/*$query = "SELECT * FROM company WHERE company_name = \"" . $companyName . "\"";*/
		$query = "SELECT * FROM producer_conglomerate WHERE conglomerate_name = '".$companyName."'";
		log_message('debug', "CompanyModel.getCompanyFromName : " . $query);
		$result = $this->db->query($query);
		
		$company = array();
		
		$this->load->library('CompanyLib');
		
		$row = $result->row();
		if ($row) {
			/*$this->companyLib->companyId = $row->company_id;
			$this->companyLib->companyName = $row->company_name;*/
			$this->companyLib->companyId = $row->producer_conglomerate_id;
			$this->companyLib->companyName = $row->conglomerate_name;
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
		
		/*$query = "SELECT * FROM company WHERE company_name = \"" . $this->input->post('companyName') . "\" AND company_id <> " . $this->input->post('companyId');*/
		$query = "SELECT * 
				  FROM producer_conglomerate
				  WHERE conglomerate_name = '".$this->input->post('companyName')."'
				  AND producer_conglomerate_id <> " . $this->input->post('companyId');
		log_message('debug', 'CompanyModel.updateCompany : Try to get Duplicate record : ' . $query);
			
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$data = array(
						'conglomerate_name' => $this->input->post('companyName')
						//'company_name' => $this->input->post('companyName'), 
					);
			//$where = "company_id = " . $this->input->post('companyId');
			$where = "producer_conglomerate_id = " . $this->input->post('companyId');
			//$query = $this->db->update_string('company', $data, $where);
			$query = $this->db->update_string('producer_conglomerate', $data, $where);
			
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
		/*$query = "SELECT company_id, company_name
					FROM company
					WHERE company_name like '$q%'
					ORDER BY company_name ";*/
		$query = "SELECT *
				  FROM producer_conglomerate
				  WHERE conglomerate_name like '$q%'
				  ORDER BY conglomerate_name ";
		$companies = array();
		log_message('debug', "CompanyModel.searchCompanies : " . $query);
		$result = $this->db->query($query);
		foreach ($result->result_array() as $row) {
			//$companies .= $row['company_name']."|".$row['company_id']."\n";
			$row['conglomerate_name'] = htmlentities(stripslashes($row['conglomerate_name']));
			$companies[] = $row;
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
		
		
		/*$base_query = 'SELECT *' .
				' FROM company';*/
		$base_query = 'SELECT * FROM producer_conglomerate';
		
		/*$base_query_count = 'SELECT count(*) AS num_records' .
				' FROM company';*/
		$base_query_count = 'SELECT COUNT(*) AS num_records FROM producer_conglomerate';
		
		$where = '';
		if ($q != '')
		{
			$where = ' WHERE ';
			
			/*$where .= ' (' 
					. '	company.company_name like "%' .$q . '%"'
					. ' OR company.company_id like "%' . $q . '%"';
			$where .= ' )';*/
			
			$where = '(
						conglomerate_name LIKE "%' .$q . '%" 
						OR producer_conglomerate_id LIKE "%' .$q . '%"
					  )';
		}
		
		$base_query_count = $base_query_count . $where;
		
		$query = $base_query_count;
		
		$result = $this->db->query($query);
		$row = $result->row();
		$numResults = $row->num_records;
		
		$query = $base_query . $where;
		
		if ( empty($sort) ) {
			/*$sort_query = ' ORDER BY company_name';
			$sort = 'company_name';*/
			$sort_query = " ORDER BY conglomerate_name";
			$sort = 'conglomerate_name';
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
			
			/*$this->CompanyLib->companyId = $row['company_id'];
			$this->CompanyLib->companyName = $row['company_name'];*/
			$this->CompanyLib->companyId = $row['producer_conglomerate_id'];
			$this->CompanyLib->companyName = $row['conglomerate_name'];
			
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
	
	function getProducerGroupsJsonAdmin() {
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
		
		
		/*$base_query = 'SELECT *' .
				' FROM company';*/
		$base_query = 'SELECT producer_conglomerate.producer_conglomerate_id, 
							  producer_conglomerate.conglomerate_name,
							  producer_group.producer_id,
							  producer.producer,
							  producer.is_restaurant_chain,
							  producer.is_restaurant,
							  producer.is_farm,
							  producer.is_farmers_market,
							  producer.is_manufacture,
							  producer.is_distributor
					   FROM producer_conglomerate
					   JOIN producer_group
					   ON producer_group.producer_conglomerate_id = producer_group.producer_conglomerate_id
					   JOIN producer
					   ON producer.producer_id = producer_group.producer_id';
		
		/*$base_query_count = 'SELECT count(*) AS num_records' .
				' FROM company';*/
		$base_query_count = 'SELECT COUNT(*) AS num_records
							 FROM producer_conglomerate
							 JOIN producer_group
					   		 ON producer_group.producer_conglomerate_id = producer_group.producer_conglomerate_id
					   		 JOIN producer
					   		 ON producer.producer_id = producer_group.producer_id';
		
		$where = '';
		if ($q != '')
		{
			$where = ' WHERE ';
			
			/*$where .= ' (' 
					. '	company.company_name like "%' .$q . '%"'
					. ' OR company.company_id like "%' . $q . '%"';
			$where .= ' )';*/
			
			$where = '(
						producer LIKE "%' .$q . '%"
						OR conglomerate_name LIKE "%' .$q . '%" 
						OR producer_conglomerate_id LIKE "%' .$q . '%"
					  )';
		}
		
		$base_query_count = $base_query_count . $where;
		
		$query = $base_query_count;
		
		$result = $this->db->query($query);
		$row = $result->row();
		$numResults = $row->num_records;
		
		$query = $base_query . $where;
		
		if ( empty($sort) ) {
			/*$sort_query = ' ORDER BY company_name';
			$sort = 'company_name';*/
			$sort_query = " ORDER BY conglomerate_name";
			$sort = 'conglomerate_name';
		} else {
			$sort_query = ' ORDER BY producer_conglomerate.' . $sort;
		}
		
		if ( empty($order) ) {
			$order = 'ASC';
		}
		
		$query = $query . ' ' . $sort_query . ' ' . $order . ', producer ASC';
		
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
		
		log_message('debug', "CompanyModel.getProducerGroupsJsonAdmin : " . $query);
		$result = $this->db->query($query);
		
		$companies = array();
		
		$CI =& get_instance();
		
		$geocodeArray = array();
		$temp = array();
		
		$temp_id = 0;
		foreach ($result->result_array() as $row)
		{						
			if ($temp_id != $row['producer_conglomerate_id'])
			{
				$temp[$row['producer_conglomerate_id']]['producers'] = "";
			}
			
			$temp[$row['producer_conglomerate_id']]['conglomerate_id'] = $row['producer_conglomerate_id'];
			$temp[$row['producer_conglomerate_id']]['conglomerate_name'] = $row['conglomerate_name'];
			$temp[$row['producer_conglomerate_id']]['producers'] .= "<div><a href=\"/admincp/";
			
			if ($row['is_restaurant'] == 1)
			{
				$temp[$row['producer_conglomerate_id']]['producers'] .= 'restaurant';
			}
			
			if ($row['is_farm'] == 1)
			{
				$temp[$row['producer_conglomerate_id']]['producers'] .=  'farm';
			}
			
			if ($row['is_farmers_market'] == 1)
			{
				$temp[$row['producer_conglomerate_id']]['producers'] .=  'farmersmarket';
			}
			
			if ($row['is_manufacture'] == 1)
			{
				$temp[$row['producer_conglomerate_id']]['producers'] .=  'manufacture';
			}			
		
			if ($row['is_distributor'] == 1)
			{
				$temp[$row['producer_conglomerate_id']]['producers'] .=  'distributor';
			}
			
			$temp[$row['producer_conglomerate_id']]['producers'] .= "/update/".$row['producer_id']."\">".$row['producer']."</a></div>";
			
			$temp_id = $row['producer_conglomerate_id'];
		}
		
		foreach ($temp as $row)
		{			
				
			$this->load->library('ProducerGroupLib');
			unset($this->ProducerGroupLib);			
			
			$this->ProducerGroupLib->companyId = $row['conglomerate_id'];
			$this->ProducerGroupLib->companyName = $row['conglomerate_name'];
			$this->ProducerGroupLib->producerName = $row['producers'];
			
			$companies[] = $this->ProducerGroupLib;
			unset($this->ProducerGroupLib);
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
	
 	function getProducers($q)
    {
        //$originalQ = $q;
        $q = strtolower($q);
        
        $query = 'SELECT producer_id, producer
				  FROM producer
				  WHERE producer LIKE "%'.$q.'%"
                  ORDER BY producer
                  LIMIT 20';

        $producers = array();

        log_message('debug', "CompanyModel.getProducers : " . $query);
        $result = $this->db->query($query);

        if ($result->num_rows() > 0)
        {
            foreach ($result->result_array() as $row)
            {
            	$row['producer'] = htmlentities(stripslashes($row['producer']));            	
            	$producers[] = $row;
            }
        } 

        return $producers;
    }
    
    function add_group()
    {
    	$producer_ids = explode("|",$this->input->post('producerId'));
    
    	foreach ($producer_ids AS $producer_id) 
    	{
    		if ($producer_id != "") 
    		{
		    	$data = array(
		    		'producer_conglomerate_id' => $this->input->post('companyId'),
		    		'producer_id' => $producer_id
		    	);
		    	
		    	$this->db->insert('producer_group', $data);
    		}
    	}
    	
    	return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }
}



?>