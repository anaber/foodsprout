<?php

class RestauranttypeModel extends Model{
	
	// List all the restauranttype in the database
	function list_restauranttype()
	{
		$query = "SELECT * FROM restaurant_type ORDER BY restaurant_type";
		
		log_message('debug', "RestauranttypeModel.list_restauranttype : " . $query);
		$result = $this->db->query($query);
		
		$restauranttypes = array();
		
		foreach ($result->result_array() as $row) {
			
			$this->load->library('RestauranttypeLib');
			unset($this->restauranttypeLib);
			
			$this->restauranttypeLib->restauranttypeId = $row['restaurant_type_id'];
			$this->restauranttypeLib->restauranttypeName = $row['restaurant_type'];
			
			$restauranttypes[] = $this->restauranttypeLib;
			unset($this->restauranttypeLib);
		}
		return $restauranttypes;
	}
	
	// Add the restauranttype to the database
	function addRestauranttype() {
		$return = true;
		
		$query = "SELECT * FROM restaurant_type WHERE restaurant_type = '" . $this->input->post('restauranttypeName') . "'";
		log_message('debug', 'RestauranttypeModel.addRestauranttype : Try to get duplicate Restauranttype record : ' . $query);
		
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$query = "INSERT INTO restaurant_type (restaurant_type_id, restaurant_type)" .
					" values (NULL, '" . $this->input->post('restauranttypeName') . "')";
			log_message('debug', 'RestauranttypeModel.addrestauranttype : Insert Restauranttype : ' . $query);
			
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
	
	function getRestauranttypeFromId($restauranttypeId) {
		
		$query = "SELECT * FROM restaurant_type WHERE restaurant_type_id = " . $restauranttypeId;
		log_message('debug', "RestauranttypeModel.getRestauranttypeFromId : " . $query);
		$result = $this->db->query($query);
		
		$restauranttype = array();
		
		$this->load->library('RestauranttypeLib');
		
		$row = $result->row();
		
		$this->restauranttypeLib->restauranttypeId = $row->restaurant_type_id;
		$this->restauranttypeLib->restauranttypeName = $row->restaurant_type;
		
		return $this->restauranttypeLib;
	}
	
	function updateRestauranttype() {
		$return = true;
		
		$query = "SELECT * FROM restaurant_type WHERE restaurant_type = '" . $this->input->post('restauranttypeName') . "' AND restaurant_type_id <> " . $this->input->post('restauranttypeId');
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