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

				$this->CuisineLib->cuisineProductCategoryId = $row['producer_category_id'];
				$this->CuisineLib->cuisineId = $row['cuisine_id'];
				$this->CuisineLib->cuisineName = $row['producer_category'];
				
				$producerCategories[] = $this->CuisineLib;
				unset($this->CuisineLib);
			} else if ($categotyType == 'RESTAURANT') {
				$this->load->library('RestaurantTypeLib');
				unset($this->restaurantTypeLib);

				$this->restaurantTypeLib->restaurantProductCategoryId = $row['producer_category_id'];
				$this->restaurantTypeLib->restaurantTypeId = $row['restaurant_type_id'];
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
				$this->load->library('ManufactureTypeLib');
				unset($this->manufactureTypeLib);

				$this->manufactureTypeLib->manufactureTypeId = $row['producer_category_id'];
				$this->manufactureTypeLib->manufactureType = $row['producer_category'];
				
				$producerCategories[] = $this->manufactureTypeLib;
				unset($this->farmTypeLib);
			}
		}
		return $producerCategories;
	}

	function getProducerCategoryFromId($id) {

		$this->db->select("producer_category.*, producer_category_group.producer_category_group");
		$this->db->from('producer_category');
		$this->db->join('producer_category_group', 'producer_category.category_group1 = producer_category_group.producer_category_group_id');
		$this->db->where('producer_category_id', $id);
		$this->db->group_by('producer_category.producer_category_id');
		$this->db->order_by('category_group1, producer_category');
		$result = $this->db->get();
		log_message('debug', "ProducerCategoryModel.listProducerCategoryAdmin : " . $this->db->last_query());
		
		$producerCategories = array();
		
		foreach ($result->result_array() as $row) {

			$this->load->library('ProducerCategoryLib');

			$this->ProducerCategoryLib->producerCategoryId = $row['producer_category_id'];
			$this->ProducerCategoryLib->producerCategory = $row['producer_category'];
			$this->ProducerCategoryLib->producerCategoryGroup = $row['producer_category_group'];
			$this->ProducerCategoryLib->producerCategoryGroupId = $row['category_group1'];
			
			if( !empty($row['cuisine_id']) )
				$this->ProducerCategoryLib->producerCategoryType = 'cuisine';
			elseif( !empty($row['restaurant_type_id']) )
				$this->ProducerCategoryLib->producerCategoryType = 'restaurant';
			elseif( !empty($row['farm_type_id']) )
				$this->ProducerCategoryLib->producerCategoryType = 'farm';
			elseif( !empty($row['manufacture_type_id']) )
				$this->ProducerCategoryLib->producerCategoryType = 'manufacture';

			$producerCategories[] = $this->ProducerCategoryLib;
			unset($this->ProducerCategoryLib);
		}
		
		return $producerCategories[0];
	}
	
	function listProducerCategoryAdmin() {

		$this->db->select("producer_category.*, producer_category_group.producer_category_group");
		$this->db->from('producer_category');
		$this->db->join('producer_category_group', 'producer_category.category_group1 = producer_category_group.producer_category_group_id');
		$this->db->group_by('producer_category.producer_category_id');
		$this->db->order_by('category_group1, producer_category');
		$result = $this->db->get();
		log_message('debug', "ProducerCategoryModel.listProducerCategoryAdmin : " . $this->db->last_query());
		
		$producerCategories = array();
		
		foreach ($result->result_array() as $row) {

			$this->load->library('ProducerCategoryLib');

			$this->ProducerCategoryLib->producerCategoryId = $row['producer_category_id'];
			$this->ProducerCategoryLib->producerCategory = $row['producer_category'];
			$this->ProducerCategoryLib->producerCategoryGroup = $row['producer_category_group'];
			$this->ProducerCategoryLib->producerCategoryGroupId = $row['category_group1'];
			
			if( !empty($row['cuisine_id']) )
				$this->ProducerCategoryLib->producerCategoryType = 'cuisine';
			elseif( !empty($row['restaurant_type_id']) )
				$this->ProducerCategoryLib->producerCategoryType = 'restaurant';
			elseif( !empty($row['farm_type_id']) )
				$this->ProducerCategoryLib->producerCategoryType = 'farm';
			elseif( !empty($row['manufacture_type_id']) )
				$this->ProducerCategoryLib->producerCategoryType = 'manufacture';


			$producerCategories[] = $this->ProducerCategoryLib;
			unset($this->ProducerCategoryLib);
		}
		
		return $producerCategories;
	}
	
	function addProducerCategory() {
		$rs = $this->db->get_where('producer_category', array("producer_category"=>$this->input->post('producerCategory')))->result_array();

		if( empty($rs) ) {
			log_message('debug', "ProducerCategoryModel.addProducerCategory, try to get duplicate : " . $this->db->last_query());
			
			$this->db->where('category_group1', $this->input->post('producerCategoryGroup'));
			$this->db->from('producer_category');
			$t_count = $this->db->count_all_results() + 1;

			if( $this->input->post('producerCategoryGroup') == 1 )		// CUISINE
				$data['cuisine_id'] = $t_count;
			elseif( $this->input->post('producerCategoryGroup') == 2 )	// RESTAURANT
				$data['restaurant_type_id'] = $t_count;
			elseif( $this->input->post('producerCategoryGroup') == 3 )	// FARM
				$data['farm_type_id'] = $t_count;
			elseif( $this->input->post('producerCategoryGroup') == 4 )	// MANUFACTURE
				$data['manufacture_type_id'] = $t_count;

			$data['producer_category'] = $this->input->post('producerCategory');
			$data['category_group1'] = $this->input->post('producerCategoryGroup');

			
			if( $this->db->insert('producer_category', $data) )
				$return = true;

		}else{
			$GLOBALS['error'] = 'duplicate';
			$return = false;
		}

		return $return;
	}
	
	function updateProducerCategory() {
		$rs = $this->db->get_where('producer_category', array("producer_category"=>$this->input->post('producerCategory'), "producer_category_id != "=>$this->input->post('producerCategoryId')))->result_array();

		if( empty($rs) ) {
			log_message('debug', "ProducerCategoryModel.addProducerCategory, try to get duplicate : " . $this->db->last_query());
			
			$producer_cat = $this->getProducerCategoryFromId($this->input->post('producerCategoryId'));			
			
			$this->db->where('category_group1', $this->input->post('producerCategoryGroup'));
			$this->db->from('producer_category');
			$t_count = $producer_cat->producerCategoryGroupId <> $this->input->post('producerCategoryGroup') ? $this->db->count_all_results() + 1 : $this->db->count_all_results();

			if( $producer_cat->producerCategoryType == 'cuisine' )			// CUISINE
				$data['cuisine_id'] = NULL;
			elseif( $producer_cat->producerCategoryType == 'restaurant' )	// RESTAURANT
				$data['restaurant_type_id'] = NULL;
			elseif( $producer_cat->producerCategoryType == 'farm' )			// FARM
				$data['farm_type_id'] = NULL;
			elseif( $producer_cat->producerCategoryType == 'manufacture' )	// MANUFACTURE
				$data['manufacture_type_id'] = NULL;

			 
			if( $this->input->post('producerCategoryGroup') == 1 )		// CUISINE
				$data['cuisine_id'] = $t_count;
			elseif( $this->input->post('producerCategoryGroup') == 2 )	// RESTAURANT
				$data['restaurant_type_id'] = $t_count;
			elseif( $this->input->post('producerCategoryGroup') == 3 )	// FARM
				$data['farm_type_id'] = $t_count;
			elseif( $this->input->post('producerCategoryGroup') == 4 )	// MANUFACTURE
				$data['manufacture_type_id'] = $t_count;

			$data['producer_category'] = $this->input->post('producerCategory');
			$data['category_group1'] = $this->input->post('producerCategoryGroup');

			$this->db->where(array('producer_category_id'=>$this->input->post('producerCategoryId')));

			if( $this->db->update('producer_category', $data) )
				$return = true;


		}else{
			$GLOBALS['error'] = 'duplicate';
			$return = false;
		}

		return $return;
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