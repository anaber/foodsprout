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
		
		$state = array();
		
		$this->load->library('CountryLib');
		
		$row = $result->row();
		
		$this->countryLib->countryId = $row->country_id;
		$this->countryLib->countryName = $row->country_name;
		
		return $this->countryLib;
	}
	
}



?>