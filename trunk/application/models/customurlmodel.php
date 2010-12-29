<?php

class CustomUrlModel extends Model{
	
	private $customUrlResource; 
	
	function check($customUrl){
		
		$results = $this->db->query("select * from custom_url where `custom_url` = '".$customUrl."' limit 1"); 
		
		
		if($results->num_rows() > 0 ){
			
			$this->customUrlResource = $results;
			return true;
			
		}else{
			
			return false;
			
		}
		
	}
	
	
	
	function isFarmersMarket(){
		$result  = $this->customUrlResource->result_array();

		if($result[0]['farmers_market_id'] != ""){
			
			return true;
			
		}else{
			
			return false;
			
		}
		
	}
	
	function isFarm(){
		$result  = $this->customUrlResource->result_array();

		if($result[0]['farm_id'] != ""){
			
			return true;
			
		}else{
			
			return false;
			
		}
		
	}
	
	
	function isManufacture(){
		$result  = $this->customUrlResource->result_array();

		if($result[0]['manufacture_id'] != ""){
			
			return true;
			
		}else{
			
			return false;
			
		}
		
	}
	
	
	function isRestaurant(){
		$result  = $this->customUrlResource->result_array();

		if($result[0]['restaurant_id'] != ""){
			
			return true;
			
		}else{
			
			return false;
			
		}
		
	}
	
	function urlID($producerType){
		
		$result  = $this->customUrlResource->result_array();
		
		return $result[0][$producerType];

	}
}