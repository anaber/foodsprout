<?php

class CountryModel extends Model{
	
	// Add a country to the database
	function addCountry()
	{
		$insert_new_country = array(
			'country_name' => $this->input->post('country_name')
		);
		
		$insert = $this->db->insert('country', $insert_new_country);
		return $insert;
	}
	
	// Add a country to the database
	function updateCountry()
	{
		$country = array(
			'country_name' => $this->input->post('country_name')
		);
		
		$where = 'country_id='.$this->input->post('countryId');
		$query = $this->db->update_string('country', $country, $where);
		
		$update = $this->db->query($query);

		return $update;
	}
	
	// List all the country in the database
	function listCountry()
	{
		$countries = array();
		
		$this->db->order_by("country_name", "asc");
		$q = $this->db->get('country');
		
		if($q->num_rows() > 0) {
			foreach ($q->result() as $row) {
				$this->load->library('CountryLib');
				unset($this->CountryLib);
				
				$this->CountryLib->countryId = $row->country_id;
				$this->CountryLib->countryName = $row->country_name;
				
				$countries[] = $this->CountryLib;
				
				unset($this->CountryLib);
			}
		}
		
		return $countries;
	}
	
	function getCountryFromId($countryId) {
		
		$query = 'SELECT * FROM country WHERE country_id = '. $countryId;
		log_message('debug', "CountryModel.getCountryFromId : " . $query);
		$result = $this->db->query($query);
		
		$this->load->library('CountryLib');
		
		$row = $result->row();
		
		$this->countryLib->countryId = $row->country_id;
		$this->countryLib->countryName = $row->country_name;

		return $this->countryLib;
	}

	function getCountryJsonAdmin() {
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
		
		
		$base_query = 'SELECT country.*' .
				' FROM country';
		
		$base_query_count = 'SELECT count(country_id) AS num_records' .
				' FROM country';
		$where = '';
		if (! empty ($q) ) {
		$where .= ' WHERE' 
				. '	country_name like "%' .$q . '%"';
		}
		$base_query_count = $base_query_count . $where;
		
		$query = $base_query_count;
		
		$result = $this->db->query($query);
		$row = $result->row();
		$numResults = $row->num_records;
		
		$query = $base_query . $where;
		
		if ( empty($sort) ) {
			$sort_query = ' ORDER BY country_name';
			$sort = 'country_name';
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
		
		log_message('debug', "CountryModel.getCountryJsonAdmin : " . $query);
		$result = $this->db->query($query);
		
		$countries = array();
		
		$CI =& get_instance();
		
		foreach ($result->result_array() as $row) {
			
			$this->load->library('CountryLib');
			unset($this->CountryLib);
			
			$this->CountryLib->countryId = $row['country_id'];
			$this->CountryLib->country = $row['country_name'];
			
			$countries[] = $this->CountryLib;
			unset($this->CountryLib);
		}
		
		if (!empty($pp) && $pp == 'all') {
			$PER_PAGE = $numResults;
		}
		
		$totalPages = ceil($numResults/$PER_PAGE);
		$first = 0;
		$last = $totalPages - 1;		
		
		$params = requestToParams($numResults, $start, $totalPages, $first, $last, $page, $sort, $order, $q, '', '');
		$arr = array(
			'results'    => $countries,
			'param'      => $params,
	    );
	    
	    return $arr;
	}

}



?>