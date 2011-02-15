<?php

class ProducerCategoryModel extends Model{
	
	/**
	 * Migration: 		Done
	 * Migrated by: 	Deepak
	 * 
	 * Verified: 		Yes
	 * Verified By: 	Deepak
	 */
	// List all the facility_type in the database
	function listProducerCategory($categotyType, $c) {
		global $PRODUCER_CATEGORY_GROUP;
		
		if ( isset($c) && !empty ($c) ) {
			$query = "SELECT * FROM producer_category WHERE category_group1 = " . $PRODUCER_CATEGORY_GROUP[$categotyType] . " ORDER BY producer_category LIMIT 0, $c";
		} else {
			$query = "SELECT * FROM producer_category WHERE category_group1 = " . $PRODUCER_CATEGORY_GROUP[$categotyType] . " ORDER BY producer_category";
		}
		
		log_message('debug', "ProducerCategoryModel.listProducerCategory : " . $query);
		$result = $this->db->query($query);
		
		$producerCategories = array();
		
		foreach ($result->result_array() as $row) {
			if ($categotyType == 'CUISINE') {
				$this->load->library('CuisineLib');
				unset($this->CuisineLib);
				
				$this->CuisineLib->cuisineId = $row['producer_category_id'];
				$this->CuisineLib->cuisineName = $row['producer_category'];
				
				$producerCategories[] = $this->CuisineLib;
				unset($this->CuisineLib);
			} else if ($categotyType == 'RESTAURANT') {
				$this->load->library('RestaurantTypeLib');
				unset($this->restaurantTypeLib);
				
				$this->restaurantTypeLib->restaurantTypeId = $row['producer_category_id'];
				$this->restaurantTypeLib->restaurantTypeName = $row['producer_category'];
				
				$producerCategories[] = $this->restaurantTypeLib;
			unset($this->restaurantTypeLib);
			} else if ($categotyType == 'FARM') {
				$this->load->library('FarmTypeLib');
				unset($this->farmTypeLib);
				
				$this->farmTypeLib->farmTypeId = $row['producer_category_id'];
				$this->farmTypeLib->farmType = $row['producer_category'];
				
				$producerCategories[] = $this->farmTypeLib;
				unset($this->farmTypeLib);
			} else if ($categotyType == 'MANUFACTURE') {
				
			}
		}
		return $producerCategories;
	}
	
	function listProducerCategoryAdmin() {
		
		$query = "SELECT * FROM producer_category ORDER BY producer_category";
		
		log_message('debug', "ProducerCategoryModel.listProducerCategoryAdmin : " . $query);
		$result = $this->db->query($query);
		
		$producerCategories = array();
		
		return $producerCategories;
	}
	
	function getCuisinesForRestaurant($producerId) {
		$query = "SELECT 
					producer_category.producer_category_id, 
					producer_category.producer_category 
				FROM 
					producer_category, producer_category_member 
				WHERE 
					producer_category_member.producer_category_id = producer_category.producer_category_id 
					AND producer_category.category_group1 = 1 
					AND producer_category_member.producer_id = $producerId";
		
		log_message('debug', "ProducerCategoryModel.getCuisinesForRestaurant : " . $query);
		$result = $this->db->query($query);

		$cuisines = array();

		foreach ($result->result_array() as $row) {

			$this->load->library('CuisineLib');
			unset($this->cuisineLib);

			$this->cuisineLib->cuisineId = $row['producer_category_id'];
			$this->cuisineLib->cuisine = $row['producer_category'];

			$cuisines[] = $this->cuisineLib;
			unset($this->cuisineLib);
		}

		return $cuisines;
	}
	
}



?>