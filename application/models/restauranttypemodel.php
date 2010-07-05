<?php

class RestaurantTypeModel extends Model{
	
	// List all the restauranttype in the database
	function listRestaurantType()
	{
		$query = "SELECT * FROM restaurant_type ORDER BY restaurant_type";
		
		log_message('debug', "RestaurantTypeModel.listRestaurantType : " . $query);
		$result = $this->db->query($query);
		
		$restaurantTypes = array();
		
		foreach ($result->result_array() as $row) {
			
			$this->load->library('RestaurantTypeLib');
			unset($this->restaurantTypeLib);
			
			$this->restaurantTypeLib->restaurantTypeId = $row['restaurant_type_id'];
			$this->restaurantTypeLib->restaurantTypeName = $row['restaurant_type'];
			
			$restaurantTypes[] = $this->restaurantTypeLib;
			unset($this->restaurantTypeLib);
		}
		return $restaurantTypes;
	}
	
	// Add the restauranttype to the database
	function addRestaurantType() {
		$return = true;
		
		$query = "SELECT * FROM restaurant_type WHERE restaurant_type = \"" . $this->input->post('restauranttypeName') . "\"";
		log_message('debug', 'RestaurantTypeModel.addRestaurantType : Try to get duplicate Restaurant Type record : ' . $query);
		
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$query = "INSERT INTO restaurant_type (restaurant_type_id, restaurant_type)" .
					" values (NULL, \"" . $this->input->post('restauranttypeName') . "\")";
			log_message('debug', 'RestaurantTypeModel.addRestaurantType : Insert Restauranttype : ' . $query);
			
			if ( $this->db->query($query) ) {
				$return = true;
			} else {
				$return = false;
			}
			
			$return = true;
		} else {
			$GLOBALS['error'] = 'duplicate';
			$return = false;
		}
		
		return $return;	
	}
	
	function getRestaurantTypeFromId($restaurantTypeId) {
		
		$query = "SELECT * FROM restaurant_type WHERE restaurant_type_id = " . $restaurantTypeId;
		log_message('debug', "RestaurantTypeModel.getRestaurantTypeFromId : " . $query);
		$result = $this->db->query($query);
		
		$restaurantType = array();
		
		$this->load->library('RestaurantTypeLib');
		
		$row = $result->row();
		
		$this->restaurantTypeLib->restaurantTypeId = $row->restaurant_type_id;
		$this->restaurantTypeLib->restaurantType = $row->restaurant_type;
		
		return $this->restaurantTypeLib;
	}
	
	function updateRestaurantType() {
		$return = true;
		
		$query = "SELECT * FROM restaurant_type WHERE restaurant_type = \"" . $this->input->post('restauranttypeName') . "\" AND restaurant_type_id <> " . $this->input->post('restauranttypeId');
		log_message('debug', 'RestauranttypeModel.updateRestauranttype : Try to get Duplicate record : ' . $query);
			
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$data = array(
						'restaurant_type' => $this->input->post('restauranttypeName'), 
					);
			$where = "restaurant_type_id = " . $this->input->post('restauranttypeId');
			$query = $this->db->update_string('restaurant_type', $data, $where);
			
			log_message('debug', 'RestauranttypeModel.updateRestauranttype : ' . $query);
			if ( $this->db->query($query) ) {
				$return = true;
			} else {
				$return = false;
			}
			
		} else {
			$GLOBALS['error'] = 'duplicate';
			$return = false;
		}
				
		return $return;
	}
	
}



?>