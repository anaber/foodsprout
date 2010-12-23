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
				
			} else if ($categotyType == 'RESTAURANT') {
				
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
	
}



?>