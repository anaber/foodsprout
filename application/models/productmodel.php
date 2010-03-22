<?php

class ProductModel extends Model{
	
	// List all the product in the database
	function list_product()
	{
		$query = "SELECT * FROM product ORDER BY product_name";
		
		log_message('debug', "ProductModel.list_product : " . $query);
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
	
	function getProductFromId($productId) {
		
		$query = "SELECT * FROM product WHERE product_id = " . $productId;
		log_message('debug', "ProductModel.getFarmFromId : " . $query);
		$result = $this->db->query($query);
		
		$product = array();
		
		$this->load->library('ProductLib');
		
		$row = $result->row();
		
		$this->productLib->productId = $row->product_id;
		$this->productLib->productName = $row->product_name;
		
		return $this->productLib;
	}
	
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
	
}



?>