<?php

class ProducerCategoryGroupModel extends Model{

	function getProducerCategoryGroupFromId($id) {

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

			$producerCategories[] = $this->ProducerCategoryLib;
			unset($this->ProducerCategoryLib);
		}
		
		return $producerCategories[0];
	}
	
	function listProducerCategoryGroupAdmin() {

		$result = $this->db->get('producer_category_group');
		log_message('debug', "ProducerCategoryGroupModel.listProducerCategoryGroupAdmin : " . $this->db->last_query());
		
		$ProducerCategoryGroups = array();
		
		foreach ($result->result_array() as $row) {

			$this->load->library('ProducerCategoryGroupLib');

			$this->ProducerCategoryGroupLib->producerCategoryGroupId = $row['producer_category_group_id'];
			$this->ProducerCategoryGroupLib->producerCategoryGroup = $row['producer_category_group'];

			$ProducerCategoryGroups[] = $this->ProducerCategoryGroupLib;
			unset($this->ProducerCategoryGroupLib);
		}
		
		return $ProducerCategoryGroups;
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