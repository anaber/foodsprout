<?php

class RestaurantChainModel extends Model{
	
	function searchRestaurantChains($q) {
		$query = "SELECT restaurant_chain_id, restaurant_chain
					FROM restaurant_chain
					WHERE restaurant_chain like '$q%'
					ORDER BY restaurant_chain ";
		$restaurantChains = '';
		log_message('debug', "RestaurantChainModel.searchRestaurantChains : " . $query);
		$result = $this->db->query($query);
		foreach ($result->result_array() as $row) {
			$restaurantChains .= $row['restaurant_chain']."|".$row['restaurant_chain_id']."\n";
		}
		
		return $restaurantChains;
	}
	
	
	function getRestaurantChainsJsonAdmin() {
		global $PER_PAGE;
		
		$p = $this->input->post('p'); // Page
		$pp = $this->input->post('pp'); // Per Page
		$sort = $this->input->post('sort');
		$order = $this->input->post('order');
		
		$q = $this->input->post('q');
		
		if ($q == '0') {
			$q = '';
		}
		
		$start = 0;
		$page = 0;
		
		$base_query = 'SELECT restaurant_chain.*, restaurant_type.restaurant_type' .
				' FROM restaurant_chain, restaurant_type';
		
		$base_query_count = 'SELECT count(*) AS num_records' .
				' FROM restaurant_chain, restaurant_type';
		
		$where = ' WHERE restaurant_chain.restaurant_type_id = restaurant_type.restaurant_type_id';
		
		$where .= ' AND (' 
				. '	restaurant_chain.restaurant_chain like "%' .$q . '%"'
				. ' OR restaurant_chain.restaurant_chain_id like "%' . $q . '%"'
				. ' OR restaurant_type.restaurant_type like "%' . $q . '%"';		
		$where .= ' )';
		
		$base_query_count = $base_query_count . $where;
		
		$query = $base_query_count;
		
		$result = $this->db->query($query);
		$row = $result->row();
		$numResults = $row->num_records;
		
		$query = $base_query . $where;
		
		if ( empty($sort) ) {
			$sort_query = ' ORDER BY restaurant_chain';
			$sort = 'restaurant_chain';
		} else {
			$sort_query = ' ORDER BY ' . $sort;
		}
		
		if ( empty($order) ) {
			$order = 'ASC';
		}
		
		$query = $query . ' ' . $sort_query . ' ' . $order;
		
		if (!empty($pp) && $pp != 'all' ) {
			$PER_PAGE = $pp;
		}
		
		if (!empty($pp) && $pp == 'all') {
			// NO NEED TO LIMIT THE CONTENT
		} else {
			
			if (!empty($p) || $p != 0) {
				$page = $p;
				$p = $p * $PER_PAGE;
				$query .= " LIMIT $p, " . $PER_PAGE;
				$start = $p;
				
			} else {
				$query .= " LIMIT 0, " . $PER_PAGE;
			}
		}
		
		log_message('debug', "RestaurantChainModel.getRestaurantChainsJsonAdmin : " . $query);
		$result = $this->db->query($query);
		
		$restaurantChains = array();
		
		$CI =& get_instance();
		
		$geocodeArray = array();
		foreach ($result->result_array() as $row) {
			
			$this->load->library('RestaurantLib');
			unset($this->RestaurantLib);
			
			$this->RestaurantLib->restaurantChainId = $row['restaurant_chain_id'];
			$this->RestaurantLib->restaurantChain = $row['restaurant_chain'];
			$this->RestaurantLib->restaurantTypeId = $row['restaurant_type_id'];
			$this->RestaurantLib->restaurantType = $row['restaurant_type'];
			
			$CI->load->model('SupplierModel','',true);
			$suppliers = $CI->SupplierModel->getSupplierForCompany( '', '', '', '', $row['restaurant_chain_id']);
			$this->RestaurantLib->suppliers = $suppliers;
			
			$restaurantChains[] = $this->RestaurantLib;
			unset($this->RestaurantLib);
		}
		
		if (!empty($pp) && $pp == 'all') {
			$PER_PAGE = $numResults;
		}
		
		$totalPages = ceil($numResults/$PER_PAGE);
		$first = 0;
		$last = $totalPages - 1;
		
		
		$params = requestToParams($numResults, $start, $totalPages, $first, $last, $page, $sort, $order, $q, '', '');
		$arr = array(
			'results'    => $restaurantChains,
			'param'      => $params,
			'geocode'	 => $geocodeArray,
	    );
	    
	    return $arr;
	}
	
	function getRestaurantChainFromId($restaurantChainId) {
		
		$query = "SELECT restaurant_chain.*, restaurant_type.restaurant_type" .
				" FROM restaurant_chain, restaurant_type" .
				" WHERE restaurant_chain.restaurant_chain_id = " . $restaurantChainId . 
				" AND restaurant_chain.restaurant_type_id = restaurant_type.restaurant_type_id";
		
		log_message('debug', "RestaurantChainModel.getRestaurantChainFromId : " . $query);
		$result = $this->db->query($query);
		
		$this->load->library('RestaurantChainLib');
		
		$row = $result->row();
		
		$this->restaurantChainLib->restaurantChainId = $row->restaurant_chain_id;
		$this->restaurantChainLib->restaurantChain = $row->restaurant_chain;
		
		$this->restaurantChainLib->matchString = $row->match_string;
		$this->restaurantChainLib->restaurantTypeId = $row->restaurant_type_id;
		
		return $this->restaurantChainLib;
	}
	
	function addRestaurantChain() {
		
		$return = true;
		
		$query = "SELECT * FROM restaurant_chain WHERE restaurant_chain = \"" . $this->input->post('restaurantChain') . "\" ";
		log_message('debug', 'RestaurantChainModel.addRestaurantChain : Try to get duplicate Restaurant record : ' . $query);
		
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			$query = "INSERT INTO restaurant (restaurant_chain_id, restaurant_chain, restaurant_type_id, match_string)" .
					" values (NULL, \"" . $this->input->post('restaurantChain') . "\", " . $this->input->post('restaurantTypeId') . ", \"" . $this->input->post('matchString') . "\")";
			
			log_message('debug', 'RestaurantChainModel.addRestaurantChain : Insert Restaurant Chain : ' . $query);
			$return = true;
			
			if ( $this->db->query($query) ) {
				$newRestaurantChainId = $this->db->insert_id();
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
	
	function updateRestaurantChain() {
		
		$return = true;
		
		$query = "SELECT * FROM restaurant_chain WHERE restaurant_chain = \"" . $this->input->post('restaurantName') . "\" AND restaurant_chain_id <> " . $this->input->post('restaurantChainId');
		log_message('debug', 'RestaurantModel.updateRestaurant : Try to get Duplicate record : ' . $query);
			
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			$restaurantChainId = $this->input->post('restaurantChainId');
			$data = array(
						'restaurant_chain' => $this->input->post('restaurantChain'), 
						'match_string' => $this->input->post('matchString'),
						'restaurant_type_id' => $this->input->post('restaurantTypeId'),
					);
			$where = "restaurant_chain_id = " . $this->input->post('restaurantChainId');
			$query = $this->db->update_string('restaurant_chain', $data, $where);
			
			log_message('debug', 'RestaurantChainModel.updateRestaurantChain : ' . $query);
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