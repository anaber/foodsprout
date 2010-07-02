<?php

class ProductTypeModel extends Model{
	
	// List all the producttype in the database
	function listProductType()
	{
		$query = "SELECT * FROM product_type ORDER BY product_type";
		
		log_message('debug', "ProducttypeModel.list_producttype : " . $query);
		$result = $this->db->query($query);
		
		$productTypes = array();
		
		foreach ($result->result_array() as $row) {
			
			$this->load->library('ProductTypeLib');
			unset($this->ProductTypeLib);
			
			$this->ProductTypeLib->productTypeId = $row['product_type_id'];
			$this->ProductTypeLib->productType = $row['product_type'];
			
			$productTypes[] = $this->ProductTypeLib;
			unset($this->ProductTypeLib);
		}
		return $productTypes;
	}
	
	// Add the producttype to the database
	function addProducttype() {
		$return = true;
		
		$query = "SELECT * FROM product_type WHERE product_type = '" . $this->input->post('producttypeName') . "'";
		log_message('debug', 'ProducttypeModel.addProducttype : Try to get duplicate Producttype record : ' . $query);
		
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$query = "INSERT INTO product_type (product_type_id, product_type)" .
					" values (NULL, '" . $this->input->post('producttypeName') . "')";
			log_message('debug', 'ProducttypeModel.addproducttype : Insert Producttype : ' . $query);
			
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
	
	// Get a specific product type from the database using its id
	function getProducttypeFromId($producttypeId) {
		
		$query = "SELECT * FROM product_type WHERE product_type_id = " . $producttypeId;
		log_message('debug', "ProducttypeModel.getProducttypeFromId : " . $query);
		$result = $this->db->query($query);
		
		$producttype = array();
		
		$this->load->library('ProducttypeLib');
		
		$row = $result->row();
		
		$this->producttypeLib->producttypeId = $row->product_type_id;
		$this->producttypeLib->producttypeName = $row->product_type;
		
		return $this->producttypeLib;
	}
	
	// Update a product type in the database
	function updateProducttype() {
		$return = true;
		
		$query = "SELECT * FROM product_type WHERE product_type = '" . $this->input->post('producttypeName') . "' AND product_type_id <> " . $this->input->post('producttypeId');
		log_message('debug', 'ProducttypeModel.updateProducttype : Try to get Duplicate record : ' . $query);
		
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$data = array(
						'product_type' => $this->input->post('producttypeName'), 
					);
			$where = "product_type_id = " . $this->input->post('producttypeId');
			$query = $this->db->update_string('product_type', $data, $where);
			
			log_message('debug', 'ProducttypeModel.updateProducttype : ' . $query);
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