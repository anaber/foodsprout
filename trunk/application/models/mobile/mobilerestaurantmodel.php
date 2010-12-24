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
	
	function getRestaurantsByCityId($cityId, $start = 0, $stop = 10){
		
		$query = "SELECT
				city.city,
				address.address,
				address.address_id,
				producer.producer_id,
				producer.producer
				FROM
				city ,
				address ,
				producer
				WHERE
				city.city_id =  address.city_id AND
				address.producer_id =  producer.producer_id AND
				producer.is_restaurant =  '1' AND
				city.city_id =  '".$cityId."'
				ORDER BY
				producer.producer ASC
				limit ".$start.",  ".$stop."
				"; 
		
		$results = $this->db->query($query)->result_array(); 
		
		
		$query2 = "SELECT
				city.city,
				address.address,
				address.address_id,
				producer.producer_id,
				producer.producer
				FROM
				city ,
				address ,
				producer
				WHERE
				city.city_id =  address.city_id AND
				address.producer_id =  producer.producer_id AND
				producer.is_restaurant =  '1' AND
				city.city_id =  '".$cityId."'
				ORDER BY
				producer.producer ASC"; 
		
		$numRows = $this->db->query($query2)->num_rows();
		
		$new_results = array();
		$new_results['totalrecords'] = $numRows;		
		
		if(sizeof($results) > 0 ){
			$i = 0;
			foreach($results as $producer){
				$new_results['data'][$i]['city'] = $producer['city'];
				$new_results['data'][$i]['address_id'] = $producer['address_id'];
				$new_results['data'][$i]['address'] = $producer['address'];
				$new_results['data'][$i]['producer_id'] = $producer['producer_id'];
				$new_results['data'][$i]['producer'] = $producer['producer'];
				$new_results['data'][$i]['cuisine'] = $this->getCuisnesByProducerId($producer['producer_id']);
				$i++;
			}
		}	
		
		return $new_results;
	}
	
	
	function getCuisnesByProducerId($producerId){
		
		$cuisine_query = "SELECT
								producer_category.producer_category as cuisine_name
									FROM
										producer ,
										producer_category ,
										producer_category_member
									WHERE
									producer.producer_id =  producer_category_member.producer_id AND
									producer_category_member.producer_category_id =  producer_category.producer_category_id AND
									producer.producer_id =  '".$producerId."' AND
									producer_category.cuisine_id IS NOT NULL  AND
									producer.is_restaurant =  1";
		
		$cuisine_results  = $this->db->query($cuisine_query)->result_array();
		
		$cuisines = '';
		if(sizeof($cuisine_results) > 0 ){
			foreach($cuisine_results as  $cuisine){
				
				$cuisines .= $cuisine['cuisine_name'].",";

			}
			
		}
		
		return $cuisines;
	}
}