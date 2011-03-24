<?php

class RestaurantChainModel extends Model{
	
	function searchRestaurantChains($q) {
		$query = "SELECT restaurant_chain_id, restaurant_chain
					FROM restaurant_chain
					WHERE restaurant_chain like \"$q%\"
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
		
		$base_query = 'SELECT producer.*,producer_category.producer_category,producer_category.producer_category_id FROM producer
				LEFT JOIN producer_category_member ON producer.producer_id=producer_category_member.producer_id
				LEFT JOIN producer_category ON producer_category_member.producer_category_id=producer_category.producer_category_id';
				 
		$base_query_count = 'SELECT count(*) AS num_records FROM producer';
		
		$where = ' WHERE is_restaurant_chain = 1';
		
		if ( !empty($q) ) {

			$where  .= ' AND (producer.producer like "%' .$q . '%"'
			. ' OR producer.producer_id like "%' . $q . '%"';
			$where .= ' )';

		}
		
		$base_query_count = $base_query_count . $where;
		
		$query = $base_query_count;
		
		$result = $this->db->query($query);
		$row = $result->row();
		$numResults = $row->num_records;
		
		$query = $base_query . $where;
		
		if ( empty($sort) ) {
			$sort_query = ' ORDER BY producer';
			$sort = 'producer';
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
			
			$this->RestaurantLib->restaurantChainId = $row['producer_id'];
			$this->RestaurantLib->restaurantChain = $row['producer'];
			$this->RestaurantLib->restaurantTypeId = $row['producer_category_id'];
			$this->RestaurantLib->restaurantType = $row['producer_category'];
			
			$CI->load->model('SupplierModel','',true);
			$suppliers = $CI->SupplierModel->getSupplierForCompany( '', '', '', '', $row['producer_id'], '');
			$this->RestaurantLib->suppliers = $suppliers;
			
			$restaurantChains[] = $this->RestaurantLib;
			unset($this->RestaurantLib);
		}
		
		if (!empty($pp) && $pp == 'all') {
			$PER_PAGE = $numResults;
		}
		
		$totalPages = ceil($numResults/$PER_PAGE);
		$first = 0;
		if ($totalPages > 0) {
			$last = $totalPages - 1;
		} else {
			$last = 0;
		}
		
		
		$params = requestToParams($numResults, $start, $totalPages, $first, $last, $page, $sort, $order, $q, '', '');
		$arr = array(
			'results'    => $restaurantChains,
			'param'      => $params,
			'geocode'	 => $geocodeArray,
	    );
	    
	    return $arr;
	}
	
	function getRestaurantChainFromId($restaurantChainId) {
		
		$query = "SELECT 
					producer.*, producer_category.producer_category, producer_category.producer_category_id
				FROM 
					producer
				LEFT JOIN producer_category_member 
					ON producer.producer_id = producer_category_member.producer_id 
				LEFT JOIN producer_category
					ON producer_category_member.producer_category_id = producer_category.producer_category_id
				WHERE 
					producer.producer_id = " . $restaurantChainId;
		
		log_message('debug', "RestaurantChainModel.getRestaurantChainFromId : " . $query);
		$result = $this->db->query($query);
		
		$this->load->library('RestaurantChainLib');
		
		$row = $result->row();
		
		$this->restaurantChainLib->restaurantChainId = $row->producer_id;
		$this->restaurantChainLib->restaurantChain = $row->producer;
		
//		$this->restaurantChainLib->matchString = $row->match_string;
		$this->restaurantChainLib->restaurantTypeId = $row->producer_category_id;
		$this->restaurantChainLib->status = $row->status;
		
		return $this->restaurantChainLib;
	}
	
	function addRestaurantChain() {
		
		$return = true;
		
		$query = "SELECT * FROM producer WHERE producer = \"" . $this->input->post('restaurantChain') . "\" AND is_restaurant_chain = 1";
		log_message('debug', 'RestaurantChainModel.addRestaurantChain : Try to get duplicate Chain record : ' . $query);
		
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			$query = "INSERT INTO producer (producer_id, producer, creation_date, status, track_ip, user_id, is_restaurant_chain)" .
					" values (NULL, \"" . $this->input->post('restaurantChain') . "\", NOW(), '" . $this->input->post('status') . "', '" . getRealIpAddr() . "', " . $this->session->userdata['userId'] . ", 1)";
			
			log_message('debug', 'RestaurantChainModel.addRestaurantChain : Insert Restaurant Chain : ' . $query);
			$return = true;
			
			if ( $this->db->query($query) ) {
				$newRestaurantChainId = $this->db->insert_id();
				
				//SAVE RESTAURANT TYPE
				$restaurantTypeId = $this->input->post('restaurantTypeId');
				if ($restaurantTypeId) {
					$query = "INSERT INTO producer_category_member (producer_category_member_id, producer_category_id, producer_id, address_id)" .
					" values (NULL, " . $restaurantTypeId . ", " . $newRestaurantChainId . ", NULL )";

					$this->db->query($query);
				}
				
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

		$query = "SELECT * FROM producer WHERE producer = \"" . $this->input->post('restaurantChain') . "\" AND producer_id <> " . $this->input->post('restaurantChainId'). " AND is_restaurant_chain = 1";
		log_message('debug', 'RestaurantChainModel.updateRestaurantChain : Try to get Duplicate record : ' . $query);
			
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			$restaurantChainId = $this->input->post('restaurantChainId');
			$data = array(
						'producer' => $this->input->post('restaurantChain'), 
//						'match_string' => $this->input->post('matchString'),
//						'restaurant_type_id' => $this->input->post('restaurantTypeId'),
						'status' => $this->input->post('status'),
					);
			$where = "producer_id = " . $this->input->post('restaurantChainId');
			$query = $this->db->update_string('producer', $data, $where);
			
			log_message('debug', 'RestaurantChainModel.updateRestaurantChain : ' . $query);
			if ( $this->db->query($query) ) {
				$return = true;
				
				//update restaurant type
				$this->updateRestaurantType($this->input->post('restaurantChainId'), $this->input->post('restaurantTypeId'));

			} else {
				$return = false;
			}
			
		} else {
			$GLOBALS['error'] = 'duplicate';
			$return = false;
		}
				
		return $return;
	}
	
	function updateRestaurantType($restaurantId, $restaurantTypeId) {
	
		$query = "SELECT producer_category_id FROM producer_category WHERE producer_category_id IN (SELECT producer_category_id 
				FROM producer_category_member WHERE producer_id=$restaurantId) AND restaurant_type_id IS NOT NULL";
		log_message('debug', 'RestaurantModel.updateCuisines : get existing cuisines : ' . $query);

		$result = $this->db->query($query)->result_array();

		if( !empty($result) ) {
			$oldRestaurantTypeId = $result[0]['producer_category_id'];
	
			$where = "producer_id = " . $restaurantId;

			if( !empty($oldRestaurantTypeId) )
				$where .= " AND producer_category_id=".$oldRestaurantTypeId;
		
			$this->db->update('producer_category_member', array('producer_category_id'=>$restaurantTypeId), $where);
		}else{
		
			$data = array(
						'producer_category_id' => $restaurantTypeId,
						'producer_id' => $restaurantId
						);
		
			$this->db->insert('producer_category_member', $data);
		
		}
	}
	
	function getRestaurantChainsJson() {
		global $PER_PAGE_2;
		
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
		
		$base_query = 'SELECT *' .
				' FROM restaurant_chain';
		
		$base_query_count = 'SELECT count(*) AS num_records' .
				' FROM restaurant_chain';
		
		$where = ' WHERE restaurant_chain.status = \'live\' ';
		
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
			$PER_PAGE_2 = $pp;
		}
		
		if (!empty($pp) && $pp == 'all') {
			// NO NEED TO LIMIT THE CONTENT
		} else {
			
			if (!empty($p) || $p != 0) {
				$page = $p;
				$p = $p * $PER_PAGE_2;
				$query .= " LIMIT $p, " . $PER_PAGE_2;
				$start = $p;
				
			} else {
				$query .= " LIMIT 0, " . $PER_PAGE_2;
			}
		}
		
		log_message('debug', "RestaurantChainModel.getRestaurantChainsJson : " . $query);
		$result = $this->db->query($query);
		
		$restaurantChains = array();
		
		$CI =& get_instance();
		
		$geocodeArray = array();
		foreach ($result->result_array() as $row) {
			
			$this->load->library('RestaurantChainLib');
			unset($this->RestaurantChainLib);
			
			$this->RestaurantChainLib->restaurantChainId = $row['restaurant_chain_id'];
			$this->RestaurantChainLib->restaurantChain = $row['restaurant_chain'];
			
			$restaurantChains[] = $this->RestaurantChainLib;
			unset($this->RestaurantChainLib);
		}
		
		if (!empty($pp) && $pp == 'all') {
			$PER_PAGE_2 = $numResults;
		}
		
		$totalPages = ceil($numResults/$PER_PAGE_2);
		$first = 0;
		if ($totalPages > 0) {
			$last = $totalPages - 1;
		} else {
			$last = 0;
		}
		
		
		$params = requestToParams2($numResults, $start, $totalPages, $first, $last, $page, $sort, $order, $q, '', '');
		$arr = array(
			'results'    => $restaurantChains,
			'param'      => $params,
			'geocode'	 => $geocodeArray,
	    );
	    
	    return $arr;
	}
	
	// Get chains
	function getRestaurantChains($page,$perpage) {
		global $PER_PAGE_2;
		
		$CI =& get_instance();
		
		$p = $page; // Page
		$pp = $perpage; // Per Page
		$sort = $this->input->post('sort');
		$order = $this->input->post('order');
		$filter = $this->input->post('f');
		
		if ($filter == false) {
			$filter = '';
		}
		
		$q = $this->input->post('q');
		
		if ($q == '0') {
			$q = '';
		}
		
		$start = 0;
		$page = 0;
		
		$base_query = 'SELECT *' .
				' FROM producer';
		
		$base_query_count = 'SELECT count(*) AS num_records' .
				' FROM producer';
		
		$where = ' WHERE is_restaurant_chain = 1' .
				' AND producer.status = \'live\' ';
		
		$base_query_count = $base_query_count . $where;
		
		$query = $base_query_count;
		
		$result = $this->db->query($query);
		$row = $result->row();
		$numResults = $row->num_records;
		
		$query = $base_query . $where;
		
		if ( empty($sort) ) {
			$sort_query = ' ORDER BY producer';
			$sort = 'producer';
		} else {
			$sort_query = ' ORDER BY ' . $sort;
		}
		
		if ( empty($order) ) {
			$order = 'ASC';
		}
		
		$query = $query . ' ' . $sort_query . ' ' . $order;
		
		if (!empty($pp) && $pp != 'all' ) {
			$PER_PAGE_2 = $pp;
		}
		
		if (!empty($pp) && $pp == 'all') {
			// NO NEED TO LIMIT THE CONTENT
		} else {
			
			if (!empty($p) || $p != 0) {
				$page = $p;
				$p = $p * $PER_PAGE_2;
				$query .= " LIMIT $p, " . $PER_PAGE_2;
				$start = $p;
				
			} else {
				$query .= " LIMIT 0, " . $PER_PAGE_2;
			}
		}
		
		log_message('debug', "RestaurantChainModel.getRestaurantChains : " . $query);
		$result = $this->db->query($query);
		
		$restaurantChains = array();
		
		foreach ($result->result_array() as $row) {
			
			$this->load->library('RestaurantChainLib');
			unset($this->RestaurantChainLib);
			
			$this->RestaurantChainLib->restaurantChainId = $row['producer_id'];
			$this->RestaurantChainLib->restaurantChain = $row['producer'];
			
			$CI->load->model('CustomUrlModel','',true);
			$customUrl = $CI->CustomUrlModel->getCustomUrlForProducerAddress($row['producer_id'], '');
			$this->RestaurantChainLib->customUrl = $customUrl;
			
			
			$restaurantChains[] = $this->RestaurantChainLib;
			unset($this->RestaurantChainLib);
		}
	    
	    if (!empty($pp) && $pp == 'all') {
			$PER_PAGE_2 = $numResults;
		}
		
		$totalPages = ceil($numResults/$PER_PAGE_2);
		$first = 0;
		if ($totalPages > 0) {
			$last = $totalPages - 1;
		} else {
			$last = 0;
		}
		
		
		$params = requestToParams2($numResults, $start, $totalPages, $first, $last, $page, $sort, $order, $q, $filter, '');
		$arr = array(
			'results'    => $restaurantChains,
			'param'      => $params,
	    );
	    
	    return $arr;
	}
	
	// Get Restaurant Chain Menu
	function getRestaurantChainMenu($restaurantChainId){
		$query = "SELECT * FROM product WHERE restaurant_chain_id = " . $restaurantChainId;
		
		log_message('debug', "RestaurantChainModel.getRestaurantChainMenu : " . $query);
		$result = $this->db->query($query);
		
		$menu = array();
		
		foreach ($result->result_array() as $row) {
			
			$this->load->library('ProductLib');
			unset($this->productLib);
			
			$this->productLib->productId = $row['product_id'];
			$this->productLib->productName = $row['product_name'];
			$this->productLib->ingredient = $row['ingredient_text'];
			
			$menu[] = $this->productLib;
			unset($this->productLib);
		}
		return $menu;
	}
	
	function getRestaurantChainMenusJson($producerId = null) {
		global $PER_PAGE;
		
		$p = $this->input->post('p'); 
		if (!$p) {
			$p = $this->input->get('p');
		}
		$pp = $this->input->post('pp'); 
		if (!$pp) {
			$pp = $this->input->get('pp');
		}
		$sort = $this->input->post('sort');
		if (!$sort) {
			$sort = $this->input->get('sort');
		}
		$order = $this->input->post('order');
		if (!$order) {
			$order = $this->input->get('order');
		}
		
		$q = $this->input->post('q');
		
		if ($q == '0') {
			$q = '';
		}
		if (!$q) {
			$q = $producerId;
		}
		
		$start = 0;
		$page = 0;
		
		$base_query = 'SELECT *' .
				' FROM product';
		
		$base_query_count = 'SELECT count(*) AS num_records' .
				' FROM product';
		
		$where = ' WHERE producer_id  = ' . $q . 
				 ' AND product.status = \'live\' ';
		
		$base_query_count = $base_query_count . $where;
		
		$query = $base_query_count;
		
		$result = $this->db->query($query);
		$row = $result->row();
		$numResults = $row->num_records;
		
		$query = $base_query . $where;
		
		if ( empty($sort) ) {
			$sort_query = ' ORDER BY product_name';
			$sort = 'product_name';
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
		
		log_message('debug', "RestaurantChainModel.getRestaurantChainMenusJson : " . $query);
		$result = $this->db->query($query);
		
		$menu = array();
		
		$CI =& get_instance();
		
		foreach ($result->result_array() as $row) {
			
			$this->load->library('ProductLib');
			unset($this->productLib);
			
			$this->productLib->productId = $row['product_id'];
			$this->productLib->productName = $row['product_name'];
			$this->productLib->ingredient = $row['ingredient_text'];
			$this->productLib->image = '';
			
			$menu[] = $this->productLib;
			unset($this->productLib);
		}
		
		if (!empty($pp) && $pp == 'all') {
			$PER_PAGE = $numResults;
		}
		
		$totalPages = ceil($numResults/$PER_PAGE);
		$first = 0;
		if ($totalPages > 0) {
			$last = $totalPages - 1;
		} else {
			$last = 0;
		}
		
		$params = requestToParams($numResults, $start, $totalPages, $first, $last, $page, $sort, $order, $q, '', '');
		$arr = array(
			'results'    => $menu,
			'param'      => $params,
	    );
	    
	    return $arr;
	}
	
}



?>