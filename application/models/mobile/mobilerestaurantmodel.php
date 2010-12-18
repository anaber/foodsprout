<?php

class MobileRestaurantModel extends Model{

	function getAllCountrys(){

		$this->db->order_by("country_name", "asc");
		$q = $this->db->get('country');

		if($q->num_rows() > 0) {
			return $q->result_array();
		}else{
			return false();
		}

	}


	function getStatesByCountryId($countryId){

		$q = $this->db->query("SELECT DISTINCT
									state.state_id,
									state.state_name
									FROM
									state ,
									address
									WHERE
									state.state_id =  address.state_id AND
									address.country_id =  '".$countryId."'
									ORDER BY
									state.state_name ASC");

		if($q->num_rows() > 0) {
			return $q->result_array();
		}else{
			return FALSE;
		}


	}

	function getCitiesByCountryId($countryId){

		$q = $this->db->query("SELECT DISTINCT
									city.city_id,
									city.city
									FROM
									city ,
									address
									WHERE
									city.city_id =  address.city_id AND
									address.country_id =  '".$countryId."'
									ORDER BY
									city.city ASC");

		if($q->num_rows() > 0) {
			return $q->result_array();
		}else{
			return FALSE;
		}


	}

	function getCitiesByStateId($stateId){

		$q = $this->db->query("SELECT DISTINCT
									city.city_id,
									city.city
									FROM
									city 
									WHERE
									city.state_id =  '".$stateId."'
									ORDER BY
									city.city ASC");

		if($q->num_rows() > 0) {
			return $q->result_array();
		}else{
			return FALSE;
		} 


	}


	function getCitiesByKey($keyword){

		$q = $this->db->query("SELECT DISTINCT city.city_id, city.city
									FROM
									city 
									WHERE
									city.city like '%".$keyword."%'
									ORDER BY
									city.city ASC");

		if($q->num_rows() > 0) {
			return $q->result_array();
		}else{
			return FALSE;
		}

	}



}