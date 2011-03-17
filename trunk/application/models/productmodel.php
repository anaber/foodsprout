<?php

class ProductModel extends Model {

	// List the recent products
	function listNewProducts() {

		$query = "SELECT product.*, custom_url.custom_url AS slug 
					FROM product, producer, custom_url WHERE product_type_id <> 1 
					AND producer.producer_id = product.producer_id 
					AND custom_url.producer_id = producer.producer_id 
					ORDER BY product.product_id DESC LIMIT 10";

		log_message('debug', "ProductModel.listNewProducts : " . $query);
		$result = $this->db->query($query);

		$products = array();

		foreach ($result->result_array() as $row) {

			$this->load->library('ProductLib');
			unset($this->productLib);

			$this->productLib->productId = $row['product_id'];
			$this->productLib->productName = $row['product_name'];
			$this->productLib->producerId = $row['producer_id'];
			$this->productLib->customURL = $row['slug'];

			$products[] = $this->productLib;
			unset($this->productLib);
		}
		return $products;
	}

	function recentlyAddedProducts($limit = 5){

		$query = "SELECT
					product.product_name,
					custom_url.custom_url,
					`user`.first_name as user
					FROM
					product ,
					`user` ,
					custom_url
					WHERE
					product.product_id = custom_url.product_id AND
					product.user_id = `user`.user_id
					ORDER BY
					product.product_id DESC
					LIMIT ".$limit ;

		log_message('debug', "ProductModel.recentlyAddedProducts : " . $query);
		$result = $this->db->query($query);

		if ( $result->num_rows() > 0) {
				
			return $result->result();
			
		} else {
			$products = false;
		}
			
	}

	function recentlyEatenProducts($limit = 5){

		$query = "SELECT
						product.product_name,
						custom_url.custom_url,
						`user`.first_name as user
						FROM
						product_consumed ,
						product ,
						`user` ,
						custom_url
						WHERE
						product_consumed.product_id = product.product_id AND
						product_consumed.user_id = `user`.user_id AND
						product_consumed.product_id = custom_url.product_id
						ORDER BY
						product_consumed.product_consumed_id DESC
						LIMIT ".$limit ;

		log_message('debug', "ProductModel.recentlyEatenProducts : " . $query);
		$result = $this->db->query($query);

		if ( $result->num_rows() > 0) {
				
			return $result->result();
			
		} else {
			$products = false;
		}
			
	}
	
	// For product/search by name
	function searchProductsByName($q, $start, $offset) {

		$query = "SELECT product.product_name, custom_url.custom_url, product.brand AS producer_name, product_type.product_type, producer.producer
						FROM
						product ,
						custom_url, 
						product_type, 
						producer
						WHERE
						product.product_id = custom_url.product_id AND
						product.product_type_id = product_type.product_type_id AND
						product.producer_id = producer.producer_id AND
						UCASE(product.product_name) like UCASE('%".trim($q)."%') 
						limit ".$start.", ".$offset."
						";
		
		
		
		log_message('debug', "ProductModel.searchProductsByName : " . $query);
		$result = $this->db->query($query);

		if ( $result->num_rows() > 0) {
				
			return $result->result();
			
		} else {
			$products = false;
		}

	}

	function searchProductsByNameTotalRows($q) {

		$query = "SELECT product.product_name, custom_url.custom_url, product.brand AS producer_name
						FROM
						product ,
						custom_url
						WHERE
						product.product_id = custom_url.product_id AND
						UCASE(product.product_name) like UCASE('%".trim($q)."%') 
						";
		
		
		
		log_message('debug', "ProductModel.searchProductsByNameTotalRows : " . $query);
		
		$result = $this->db->query($query);

		if ( $result->num_rows() > 0) {
				
			return $result->num_rows();
			
		} else {
			return 0;
		}

	}

	function getProductFromId($productId) {

/*		$query = "SELECT product.*, custom_url.*, producer.*, product_type.*
						FROM
						product ,
						custom_url, 
						product_type, 
						producer
						WHERE
						product.product_id = custom_url.product_id AND
						product.product_type_id = product_type.product_type_id AND
						product.producer_id = producer.producer_id AND
						product.product_id = " . $productId;
*/
		$query = "SELECT product.*, producer.*, product_type.*
						FROM
						product ,
						product_type, 
						producer
						WHERE
						product.product_type_id = product_type.product_type_id AND
						product.producer_id = producer.producer_id AND
						product.product_id = " . $productId;

		log_message('debug', "ProductModel.getProductFromId : " . $query);
		$result = $this->db->query($query);

		if ( $result->num_rows() > 0) {
			
			$results = $result->result();
			return $results[0];
			
		} else {
			return 0;
		}
	}	

	function getAddressByProductId($productId ='') {

		$query = "SELECT
					address.*
					FROM
					product ,
					address
					WHERE
					product.producer_id = address.producer_id AND
					product.product_id = '" . $productId."'";
		
		
		log_message('debug', "ProductModel.getAddressByProductId : " . $query);
		$result = $this->db->query($query);

		if ( $result->num_rows() > 0) {
			
			return $result->result();
			
		} else {
			return false;
		}
		
	}

	function addProductIntermediate() {

		$return = true;

		$restaurantId = $this->input->post('restaurantId');
		$restaurantChainId = $this->input->post('restaurantChainId');
		$manufactureId = $this->input->post('manufactureId');

		$CI = & get_instance();

		$producerId = '';

		if (!empty($restaurantId)) {
			$producerId = $restaurantId;
		} else if (!empty($restaurantChainId)) {
			$producerId = $restaurantChainId;
		} else if (!empty($manufactureId)) {
			$producerId = $manufactureId;
		}

		if ($this->addProduct($producerId) ) {
			$return = true;
		} else {
			$return = false;
		}

		return $return;
	}

	function addProduct( $producerId ) {
		$return = true;
		$CI = & get_instance();

		$query = 'SELECT * FROM product ' .
                ' WHERE' .
                ' product_name = "' . $this->input->post('productName') . '"' .
                ' AND producer_id = ' . $producerId;

		log_message('debug', 'ProductModel.addProduct : Try to get duplicate product record : ' . $query);
		$result = $this->db->query($query);
			
		if ($result->num_rows() == 0) {

			$query = 'INSERT INTO product (product_id, producer_id, product_type_id, product_name, ingredient_text, brand, upc, status, has_fructose, user_id, creation_date, track_ip)' .
                    ' values (NULL, ' . $producerId;

			$userGroup = $this->session->userdata['userGroup'];

			if ( $userGroup != 'admin') {
				$query .= ',  ' . $this->input->post('productTypeId') . ', "' . $this->input->post('productName') . '", "' . $this->input->post('ingredient') . '", "' . $this->input->post('brand') . '", "' . $this->input->post('upc') . '", "queue", ' . $this->input->post('hasFructose') . ', ' . $this->session->userdata('userId') . ', NOW(), "' . getRealIpAddr() . '" )';
			} else {
				$query .= ',  ' . $this->input->post('productTypeId') . ', "' . $this->input->post('productName') . '", "' . $this->input->post('ingredient') . '", "' . $this->input->post('brand') . '", "' . $this->input->post('upc') . '", "live", ' . $this->input->post('hasFructose') . ', ' . $this->session->userdata('userId') . ', NOW(), "' . getRealIpAddr() . '" )';
			}

			log_message('debug', 'ProductModel.addProduct : Insert Product : ' . $query);

			if ($this->db->query($query)) {
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

	function getProductForCompany($restaurantId, $restaurantChainId, $manufactureId, $companyId) {

		$products = array();

		$query = "SELECT product.*, product_type.product_type" .
                " FROM product, product_type" .
                " WHERE ";
		if (!empty($restaurantId)) {
			$query .= "producer_id = " . $restaurantId;
		} elseif (!empty($restaurantChainId)) {
			$query .= "restaurant_chain_id = " . $restaurantChainId;
		} elseif (!empty($manufactureId)) {
			$query .= "manufacture_id = " . $manufactureId;
		}

		$query .= " AND product.product_type_id = product_type.product_type_id" .
                " ORDER BY product_name";

		log_message('debug', "ProductModel.getProductForCompany : " . $query);
		$result = $this->db->query($query);

		foreach ($result->result_array() as $row) {

			$this->load->library('ProductLib');
			unset($this->productLib);

			$this->productLib->productId = $row['product_id'];
			//$this->productLib->companyId = $row['company_id'];
			$this->productLib->restaurantId = $row['producer_id'];
			//$this->productLib->restaurantChainId = $row['restaurant_chain_id'];
			//$this->productLib->manufactureId = $row['manufacture_id'];
			$this->productLib->productTypeId = $row['product_type_id'];
			$this->productLib->productType = $row['product_type'];
			$this->productLib->productName = $row['product_name'];
			$this->productLib->ingredient = $row['ingredient_text'];
			$this->productLib->brand = $row['brand'];
			$this->productLib->upc = $row['upc'];
			$this->productLib->status = $row['status'];
			$this->productLib->fructose = $row['has_fructose'];
			$this->productLib->userId = $row['user_id'];
			$this->productLib->creationDate = $row['creation_date'];
			$this->productLib->modifyDate = $row['modify_date'];

			$products[] = $this->productLib;
			unset($this->productLib);
		}

		return $products;
	}

	function updateProduct() {
		$return = true;

		$restaurantId = $this->input->post('restaurantId');
		$restaurantChainId = $this->input->post('restaurantChainId');
		$manufactureId = $this->input->post('manufactureId');

		$query = 'SELECT * FROM product ' .
                ' WHERE' .
                ' product_name = "' . $this->input->post('productName') . '"' .
                ' AND ';
		if (!empty($restaurantId)) {
			$query .= 'producer_id';
		} else if (!empty($restaurantChainId)) {
			$query .= 'restaurant_chain_id';
		} else if (!empty($manufactureId)) {
			$query .= 'manufacture_id';
		}
		$query .= ' = ';
		if (!empty($restaurantId)) {
			$query .= $restaurantId;
		} else if (!empty($restaurantChainId)) {
			$query .= $restaurantChainId;
		} else if (!empty($manufactureId)) {
			$query .= $manufactureId;
		}
		$query .= ' AND product_id <> ' . $this->input->post('productId');
		log_message('debug', 'ProductModel.updateProduct : Try to get duplicate product record : ' . $query);
		$result = $this->db->query($query);

		if ($result->num_rows() == 0) {
			$data = array(
                'product_type_id' => $this->input->post('productTypeId'),
                'product_name' => $this->input->post('productName'),
                'ingredient_text' => $this->input->post('ingredient'),
                'brand' => $this->input->post('brand'),
                'upc' => $this->input->post('upc'),
                'status' => $this->input->post('status'),
                'has_fructose' => $this->input->post('hasFructose'),
                'modify_date' => date('Y-m-d')
			);
			$where = "product_id = " . $this->input->post('productId');
			$query = $this->db->update_string('product', $data, $where);

			log_message('debug', 'ProductModel.updateProduct : ' . $query);
			if ($this->db->query($query)) {
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

	/**
	 * Migration: 		Working
	 * Migrated by: 	Deepak
	 *
	 * Verified: 		Yes
	 * Verified By: 	Deepak
	 */
	function getProductJson() {
		global $PER_PAGE;

		$p = $this->input->post('p'); // Page
		$pp = $this->input->post('pp'); // Per Page
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
		//$filter = 8;
		//$q = 1;

		$start = 0;
		$page = 0;

		$base_query = 'SELECT product.*, product_type.product_type, ' .
        		' producer.producer, producer.is_restaurant, producer.is_restaurant_chain, producer.is_manufacture' .
				' FROM product';

		$base_query_count = 'SELECT count(*) AS num_records' .
				' FROM product';

		$where = ' LEFT JOIN product_type ON (product.product_type_id =  product_type.product_type_id)  ' .
				' LEFT JOIN producer ON (product.producer_id =  producer.producer_id) ' .
				' WHERE  ';

		if (!empty($filter) ) {
			$where .= ' product.has_fructose =  1 AND ';
		}

		$where .= ' product.status = \'live\' ';

		if (!empty($q) ) {
			$where .= ' AND ('
			. '	product.product_id = ' . $q
			. ' )';
		}

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

		log_message('debug', "ProductModel.getProductJson : " . $query);
		$result = $this->db->query($query);

		$products = array();

		$geocodeArray = array();
		foreach ($result->result() as $row) {

			$this->load->library('ProductLib');
			unset($this->productLib);

			$this->productLib->productId = $row->product_id;
			$this->productLib->productName = $row->product_name;
			$this->productLib->producerId = $row->producer_id;

			if ($row->is_manufacture) {
				$this->productLib->manufactureName = $row->producer;
			} else if ($row->is_restaurant) {
				$this->productLib->restaurantName = $row->producer;
			} else if ($row->is_restaurant_chain) {
				$this->productLib->restaurantChain = $row->producer;
			}

			$this->productLib->productTypeId = $row->product_type_id;
			$this->productLib->productType = $row->product_type;
			$this->productLib->ingredient = $row->ingredient_text;
			$this->productLib->brand = $row->brand;
			$this->productLib->upc = $row->upc;

			$products[] = $this->productLib;
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


		$params = requestToParams($numResults, $start, $totalPages, $first, $last, $page, $sort, $order, $q, $filter, '');
		$arr = array(
			'results'    => $products,
			'param'      => $params,
			'geocode'	 => $geocodeArray,
		);
		 
		return $arr;
	}

	/**
	 * Migration: 		Done
	 * Migrated by: 	Deepak
	 *
	 * Verified: 		Yes
	 * Verified By: 	Deepak
	 */
	// For Auto suggest
	function searchProducts($q) {

		$hasFructose = $_REQUEST['hasFructose'];

		$query = 'SELECT product_id, product_name' .
				' FROM product' .
				' WHERE product_name like "'.$q.'%" ';
		if ( $hasFructose ) {
			$query .= ' AND has_fructose = 1 ';
		}
		$query .= ' ORDER BY product_name';

		log_message('debug', "ProductModel.searchProducts : " . $query);
		$result = $this->db->query($query);
		$products = '';

		if ( $result->num_rows() > 0) {
			foreach ($result->result() as $row) {
				$products .= $row->product_name . "|" . $row->product_id . "\n";
			}
		} else {
			$products .= 'No Product';
		}

		return $products;

	}
	
	

	function getProductsJsonAdmin() {
		global $PER_PAGE;

		$p = $this->input->post('p'); // Page
		$pp = $this->input->post('pp'); // Per Page
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
		//$filter = 8;
		//$q = 1;

		$start = 0;
		$page = 0;

		$base_query = 'SELECT product.*, product_type.product_type, ' .
        		' producer.producer ' .
				' FROM product';

		$base_query_count = 'SELECT count(*) AS num_records' .
				' FROM product';

		$where = ' LEFT JOIN product_type ON (product.product_type_id =  product_type.product_type_id)  ' .
				' LEFT JOIN producer ON (product.producer_id =  producer.producer_id) ' .
				' WHERE  ';

		if (!empty($filter) ) {
			$where .= ' product.has_fructose =  1 AND ';
		}

		$where .= ' ('
		. '	product.product_name like "' .$q . '%"';
		$where .= ' )';

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

		log_message('debug', "ProductModel.getProductsJsonAdmin : " . $query);
		$result = $this->db->query($query);

		$products = array();

		$geocodeArray = array();
		foreach ($result->result() as $row) {

			$this->load->library('ProductLib');
			unset($this->productLib);

			$this->productLib->productId = $row->product_id;
			$this->productLib->productName = $row->product_name;
			$this->productLib->producderId = $row->producer_id;
			$this->productLib->producerName = $row->producer;
			$this->productLib->productTypeId = $row->product_type_id;
			$this->productLib->productType = $row->product_type;
			$this->productLib->ingredient = $row->ingredient_text;
			$this->productLib->brand = $row->brand;
			$this->productLib->upc = $row->upc;

			$products[] = $this->productLib;
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


		$params = requestToParams($numResults, $start, $totalPages, $first, $last, $page, $sort, $order, $q, $filter, '');
		$arr = array(
			'results'    => $products,
			'param'      => $params,
		);
		 
		return $arr;
	}


	function getQueueProductsJson() {
		global $PER_PAGE;

		$p = $this->input->post('p'); // Page
		$pp = $this->input->post('pp'); // Per Page
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
		//$filter = 8;
		//$q = 1;

		$start = 0;
		$page = 0;

		$base_query = "SELECT product.*, product_type.product_type,user.email,producer.producer 
						FROM product, product_type, producer, user 
						WHERE product.status ='queue' 
						AND product.product_type_id = product_type.product_type_id 
						AND product.user_id=user.user_id 
						AND product.producer_id=producer.producer_id ";

		$base_query_count = "SELECT count(*) AS num_records FROM product WHERE product.status='queue'";

		$where = "";

		if ( !empty($q) )
			$where .= " AND product.product_name like '%".$q."%' ";


		$base_query_count = $base_query_count;

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

		log_message('debug', "ProductModel.getQueueProductsJson : " . $query);
		$result = $this->db->query($query);

		$products = array();

		$geocodeArray = array();
		foreach ($result->result() as $row) {

			$this->load->library('ProductLib');
			unset($this->productLib);

			$this->productLib->productId = $row->product_id;
			$this->productLib->productName = $row->product_name;
			//$this->productLib->manufactureId = $row->manufacture_id;
			//$this->productLib->manufactureName = $row->manufacture_name;
			$this->productLib->restaurantId = $row->producer_id;
			$this->productLib->restaurantName = $row->producer;
			//$this->productLib->restaurantChainId = $row->restaurant_chain_id;
			//$this->productLib->restaurantChain = $row->restaurant_chain;
			$this->productLib->productTypeId = $row->product_type_id;
			$this->productLib->productType = $row->product_type;
			$this->productLib->ingredient = $row->ingredient_text;
			$this->productLib->brand = $row->brand;
			$this->productLib->creationDate = $row->creation_date;

			$this->productLib->userId = $row->user_id;
			$this->productLib->email = $row->email;
			$this->productLib->ip = $row->track_ip;

			$products[] = $this->productLib;
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


		$params = requestToParams($numResults, $start, $totalPages, $first, $last, $page, $sort, $order, $q, $filter, '');
		$arr = array(
			'results'    => $products,
			'param'      => $params,
			'geocode'	 => $geocodeArray,
		);
		 
		return $arr;
	}

	function getProductByUserJson() {
		global $PER_PAGE;

		$p = $this->input->post('p'); // Page
		$pp = $this->input->post('pp'); // Per Page
		$sort = $this->input->post('sort');
		$order = $this->input->post('order');

		$q = $this->input->post('q');

		if ($q == '0') {
			$q = '';
		}
		//$filter = 8;
		//$q = 1;

		$start = 0;
		$page = 0;

		//$status = 'queue';

		$base_query = 'SELECT product.*, product_type.product_type, ' .
        		' producer.producer, is_restaurant, is_manufacture, is_restaurant_chain, ' .
        		' user.email, user.first_name ' .
				' FROM product';

		$base_query_count = 'SELECT count(*) AS num_records' .
				' FROM product';

		$where = ' LEFT JOIN product_type ON (product.product_type_id =  product_type.product_type_id)  ' .
				' LEFT JOIN producer ON (product.producer_id =  producer.producer_id) ' .
				' LEFT JOIN user ON product.user_id = user.user_id' .  
				' WHERE  ';


		//$where .= ' product.status = \'' . $status . '\' ';

		if (!empty($q) ) {
			$where .= ' ('
			. '	product.user_id = ' . $q
			. ' )';
		}

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

		log_message('debug', "ProductModel.getProductJson : " . $query);
		$result = $this->db->query($query);

		$CI =& get_instance();
		$CI->load->model('CustomUrlModel','',true);
		$CI->load->model('AddressModel','',true);

		$products = array();

		$geocodeArray = array();
		foreach ($result->result() as $row) {

			$this->load->library('ProductLib');
			unset($this->productLib);

			$this->productLib->productId = $row->product_id;
			$this->productLib->productName = $row->product_name;

			if ( $row->is_restaurant == '1' ) {
				$this->productLib->producerType = 'restaurant';
			} else if ( $row->is_manufacture == '1' ) {
				$this->productLib->producerType = 'manufacture';
			} else if ( $row->is_restaurant_chain == '1' ) {
				$this->productLib->producerType = 'chain';
			}
			$this->productLib->producer = $row->producer;

			$addresses = $CI->AddressModel->getAddressForProducer($row->producer_id);
			//$this->productLib->addresses = $addresses;

			$this->productLib->customUrl = '';
			$firstAddressId = '';

			foreach ($addresses as $key => $address) {
				$firstAddressId = $address->addressId;
				break;
			}

			if ($firstAddressId != '') {
				$customUrl = $CI->CustomUrlModel->getCustomUrlForProducerAddress($row->producer_id, $firstAddressId);
				$this->productLib->customUrl = $customUrl;
			}

			$this->productLib->productTypeId = $row->product_type_id;
			$this->productLib->productType = $row->product_type;
			$this->productLib->ingredient = $row->ingredient_text;
			$this->productLib->brand = $row->brand;
			$this->productLib->upc = $row->upc;

			$this->productLib->userId = $row->user_id;
			$this->productLib->email = $row->email;
			$this->productLib->ip = $row->track_ip;
			$this->productLib->status = $row->status;

			$products[] = $this->productLib;
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
			'results'    => $products,
			'param'      => $params,
			'geocode'	 => $geocodeArray,
		);
		//print_r_pre($arr);die;
		return $arr;
	}

}
?>