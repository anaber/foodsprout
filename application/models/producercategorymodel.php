<?php

class ProducerCategoryModel extends Model{
	
	/**
	 * Migration: 		Done
	 * Migrated by: 	Andrew
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
		
		log_message('debug', "FarmTypeModel.listFarmType : " . $query);
		$result = $this->db->query($query);
		
		$farmTypes = array();
		
		foreach ($result->result_array() as $row) {
			
			$this->load->library('FarmTypeLib');
			unset($this->farmTypeLib);
			
			$this->farmTypeLib->farmTypeId = $row['producer_category_id'];
			$this->farmTypeLib->farmType = $row['producer_category'];
			
			$farmTypes[] = $this->farmTypeLib;
			unset($this->farmTypeLib);
		}
		return $farmTypes;
	}
	
}



?>