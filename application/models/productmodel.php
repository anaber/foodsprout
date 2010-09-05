<?php

class ProductModel extends Model {

    // List all the product in the database
    function listProduct($hasFructose = 0) {
        if ($hasFructose == 1) {
            $query = "SELECT * FROM product WHERE has_fructose = 1 ORDER BY product_name";
        } else {
            $query = "SELECT * FROM product ORDER BY product_name";
        }


        log_message('debug', "ProductModel.listProduct : " . $query);
        $result = $this->db->query($query);

        $products = array();

        foreach ($result->result_array() as $row) {

            $this->load->library('ProductLib');
            unset($this->productLib);

            $this->productLib->productId = $row['product_id'];
            $this->productLib->productName = $row['product_name'];

            $products[] = $this->productLib;
            unset($this->productLib);
        }
        return $products;
    }


	// List the recent products
    function listNewProducts() {
        
        $query = "SELECT * FROM product WHERE product_type_id <> 1 ORDER BY product_id DESC LIMIT 5";

        log_message('debug', "ProductModel.listNewProducts : " . $query);
        $result = $this->db->query($query);

        $products = array();

        foreach ($result->result_array() as $row) {

            $this->load->library('ProductLib');
            unset($this->productLib);

            $this->productLib->productId = $row['product_id'];
            $this->productLib->productName = $row['product_name'];

            $products[] = $this->productLib;
            unset($this->productLib);
        }
        return $products;
    }

    // Insert the product into the database
    /*
      function addProduct() {
      $return = true;

      $query = "SELECT * FROM product WHERE product_name = '" . $this->input->post('productName') . "'";
      log_message('debug', 'ProductModel.addProduct : Try to get duplicate Product record : ' . $query);

      $result = $this->db->query($query);

      if ($result->num_rows() == 0) {

      $query = "INSERT INTO product (product_id, product_name)" .
      " values (NULL, '" . $this->input->post('productName') . "')";
      log_message('debug', 'ProductModel.addProduct : Insert Product : ' . $query);

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
     */



    function listProductDetails($hasFructose = 0,  $currentPage = 1, $dispPerPage = 10) {
        if ($hasFructose == 1) {
            $whereClause = " WHERE has_fructose = 1";
        } else {
            $whereClause = " ";
        }
        $query = "SELECT p.*,
                  c.company_name,
                  pt.product_type,
                  r.restaurant_name,
                  rc.restaurant_chain,
                  m.manufacture_name
                FROM product p ";
        
        $query = $query 
            . " LEFT JOIN company c ON (p.company_id =  c.company_id) "
            . " LEFT JOIN product_type pt ON (p.product_type_id =  pt.product_type_id) "
            . " LEFT JOIN restaurant r ON (p.restaurant_id =  r.restaurant_id) "
            . " LEFT JOIN restaurant_chain rc ON (p.restaurant_chain_id =  rc.restaurant_chain_id) "
            . " LEFT JOIN manufacture m ON (p.manufacture_id =  m.manufacture_id) "
            ;

        $startRecord = ($currentPage - 1) * $dispPerPage ;
        $query = $query . " $whereClause ORDER BY product_ID LIMIT $startRecord, $dispPerPage";


        log_message('debug', "ProductModel.listProductDetails : " . $query);
        $result = $this->db->query($query);

        $products = array();
        foreach ($result->result() as $row) {

            $this->load->library('ProductLib');
            unset($this->productLib);

            $this->productLib->productId = $row->product_id;
            $this->productLib->productName = $row->product_name;
            $this->productLib->companyId = $row->company_id;
            $this->productLib->companyName = $row->company_name;
            $this->productLib->restaurantId = $row->restaurant_id;
            $this->productLib->restaurantName = $row->restaurant_name;
            $this->productLib->restaurantChainId = $row->restaurant_chain_id;
            $this->productLib->restaurantChainName = $row->restaurant_chain;
            $this->productLib->manufactureId = $row->manufacture_id;
            $this->productLib->manufactureName = $row->manufacture_name;
            $this->productLib->productTypeId = $row->product_type_id;
            $this->productLib->productType = $row->product_type;
            $this->productLib->ingredient = $row->ingredient_text;
            $this->productLib->brand = $row->brand;
            $this->productLib->upc = $row->upc;
            $this->productLib->status = $row->status;
            $this->productLib->fructose = $row->has_fructose;
            $this->productLib->userId = $row->user_id;
            $this->productLib->creationDate = $row->creation_date;
            $this->productLib->modifyDate = $row->modify_date;

            $products[] = $this->productLib;
            unset($this->productLib);
        }
        return $products;
    }

    function getProductCount($hasFructose = 0) {
        if ($hasFructose == 1) {
            $whereClause = " WHERE has_fructose = 1";
        } else {
            $whereClause = " ";
        }
        $query = "SELECT count(*) as product_count
                FROM product p  $whereClause";


        log_message('debug', "ProductModel.getProductCount : " . $query);
        $result = $this->db->query($query);

        return $result->row()->product_count;
    }



    function getProductFromId($productId) {

        $query = "SELECT * FROM product WHERE product_id = " . $productId;
        log_message('debug', "ProductModel.getFarmFromId : " . $query);
        $result = $this->db->query($query);

        $product = array();

        $this->load->library('ProductLib');

        $row = $result->row();

        $this->productLib->productId = $row->product_id;
        $this->productLib->companyId = $row->company_id;
        $this->productLib->restaurantId = $row->restaurant_id;
        $this->productLib->restaurantChainId = $row->restaurant_chain_id;
        $this->productLib->manufactureId = $row->manufacture_id;
        $this->productLib->productTypeId = $row->product_type_id;
        //$this->productLib->productType = $row->product_type;
        $this->productLib->productName = $row->product_name;
        $this->productLib->ingredient = $row->ingredient_text;
        $this->productLib->brand = $row->brand;
        $this->productLib->upc = $row->upc;
        $this->productLib->status = $row->status;
        $this->productLib->fructose = $row->has_fructose;
        $this->productLib->userId = $row->user_id;
        $this->productLib->creationDate = $row->creation_date;
        $this->productLib->modifyDate = $row->modify_date;


        return $this->productLib;
    }

    /*
      function updateProduct() {
      $return = true;

      $query = "SELECT * FROM product WHERE product_name = '" . $this->input->post('productName') . "' AND product_id <> " . $this->input->post('productId');
      log_message('debug', 'ProductModel.updateProduct : Try to get Duplicate record : ' . $query);

      $result = $this->db->query($query);

      if ($result->num_rows() == 0) {

      $data = array(
      'product_name' => $this->input->post('productName'),
      );
      $where = "product_id = " . $this->input->post('productId');
      $query = $this->db->update_string('product', $data, $where);

      log_message('debug', 'ProductModel.updateProduct : ' . $query);
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
     */

    function addProductIntermediate() {

        $return = true;

        $restaurantId = $this->input->post('restaurantId');
        $restaurantChainId = $this->input->post('restaurantChainId');
        $manufactureId = $this->input->post('manufactureId');

        $companyId = '';

        $CI = & get_instance();

        if (!empty($restaurantId)) {
            $CI->load->model('RestaurantModel', '', true);
            $restaurant = $CI->RestaurantModel->getRestaurantFromId($restaurantId);
            $companyId = $restaurant->companyId;
        } else if (!empty($restaurantChainId)) {
            $companyId = '';
        } else if (!empty($manufactureId)) {
            $CI->load->model('ManufactureModel', '', true);
            $manufature = $CI->ManufactureModel->getManufactureFromId($manufactureId);
            $companyId = $manufature->companyId;
        }

        if ($this->addProduct($restaurantId, $restaurantChainId, $manufactureId, $companyId)) {
            $return = true;
        } else {
            $return = false;
        }

        return $return;
    }

    function addProduct($restaurantId, $restaurantChainId, $manufactureId, $companyId) {
        $return = true;
        $CI = & get_instance();

        $query = 'SELECT * FROM product ' .
                ' WHERE' .
                ' product_name = "' . $this->input->post('productName') . '"' .
                ' AND ';
        if (!empty($restaurantId)) {
            $query .= 'restaurant_id';
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
        log_message('debug', 'ProductModel.addProduct : Try to get duplicate product record : ' . $query);
        $result = $this->db->query($query);	
			
        if ($result->num_rows() == 0) {
            
		
            $query = 'INSERT INTO product (product_id, company_id, ';
            if (!empty($restaurantId)) {
                $query .= 'restaurant_id';
            } else if (!empty($restaurantChainId)) {
                $query .= 'restaurant_chain_id';
            } else if (!empty($manufactureId)) {
                $query .= 'manufacture_id';
            }
            
            $query .= ', product_type_id, product_name, ingredient_text, brand, upc, status, has_fructose, user_id, creation_date, track_ip)' .
                    ' values (NULL, ' . (!empty($companyId) ? $companyId : 'NULL' ) . ', ';

            if (!empty($restaurantId)) {
                $query .= $restaurantId;
            } else if (!empty($restaurantChainId)) {
                $query .= $restaurantChainId;
            } else if (!empty($manufactureId)) {
                $query .= $manufactureId;
            }
            
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
            $query .= "restaurant_id = " . $restaurantId;
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
            $this->productLib->companyId = $row['company_id'];
            $this->productLib->restaurantId = $row['restaurant_id'];
            $this->productLib->restaurantChainId = $row['restaurant_chain_id'];
            $this->productLib->manufactureId = $row['manufacture_id'];
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
            $query .= 'restaurant_id';
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
                'modify_date' => 'NOW()',
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
    
    function listFructose($currentPage = 1, $dispPerPage) {
        $query = "SELECT product.*,
                  product_type.product_type,
                  manufacture.manufacture_name
                FROM product";
        
        $query = $query 
            . " LEFT JOIN product_type ON (product.product_type_id =  product_type.product_type_id) "
            . " LEFT JOIN manufacture ON (product.manufacture_id =  manufacture.manufacture_id) ";

        $startRecord = ($currentPage - 1) * $dispPerPage;
        $query = $query . " WHERE has_fructose = 1 ORDER BY product_ID LIMIT $startRecord, $dispPerPage";

		
        log_message('debug', "ProductModel.listFructose : " . $query);
        $result = $this->db->query($query);

        $products = array();
        foreach ($result->result() as $row) {

            $this->load->library('ProductLib');
            unset($this->productLib);

            $this->productLib->productId = $row->product_id;
            $this->productLib->productName = $row->product_name;
            $this->productLib->manufactureId = $row->manufacture_id;
            $this->productLib->manufactureName = $row->manufacture_name;
            $this->productLib->productTypeId = $row->product_type_id;
            $this->productLib->productType = $row->product_type;
            $this->productLib->ingredient = $row->ingredient_text;
            $this->productLib->brand = $row->brand;
            $this->productLib->upc = $row->upc;
            $this->productLib->status = $row->status;
            $this->productLib->fructose = $row->has_fructose;
            $this->productLib->userId = $row->user_id;
            $this->productLib->creationDate = $row->creation_date;
            $this->productLib->modifyDate = $row->modify_date;

            $products[] = $this->productLib;
            unset($this->productLib);
        }
        return $products;
    }






	/**
	 * CHANGES BY DEEPAK
	 * I may remove almost complete code from above. I do not like them at all
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

        $base_query = 'SELECT product.*, product_type.product_type, manufacture.manufacture_name, manufacture.manufacture_id' .
				' FROM product';
		
		$base_query_count = 'SELECT count(*) AS num_records' .
				' FROM product';
		
		$where = ' LEFT JOIN product_type ON (product.product_type_id =  product_type.product_type_id)  ' .
				' LEFT JOIN manufacture ON (product.manufacture_id =  manufacture.manufacture_id) ' .
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
            $this->productLib->manufactureId = $row->manufacture_id;
            $this->productLib->manufactureName = $row->manufacture_name;
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
		$last = $totalPages - 1;
		
		
		$params = requestToParams($numResults, $start, $totalPages, $first, $last, $page, $sort, $order, $q, $filter, '');
		$arr = array(
			'results'    => $products,
			'param'      => $params,
			'geocode'	 => $geocodeArray,
	    );
	    
	    return $arr;
	}
	
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






}
?>