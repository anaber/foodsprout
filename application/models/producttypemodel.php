<?php

class ProducttypeModel extends Model{
	
	// List all the producttype in the database
	function list_producttype()
	{
		$query = "SELECT * FROM product_type ORDER BY product_type";
		
		log_message('debug', "ProducttypeModel.list_producttype : " . $query);
		$result = $this->db->query($query);
		
		$producttypes = array();
		
		foreach ($result->result_array() as $row) {
			
			$this->load->library('ProducttypeLib');
			unset($this->producttypeLib);
			
			$this->producttypeLib->producttypeId = $row['product_type_id'];
			$this->producttypeLib->producttypeName = $row['product_type'];
			
			$producttypes[] = $this->producttypeLib;
			unset($this->producttypeLib);
		}
		return $producttypes;
	}
	
	// Add the producttype to the database
	function addProducttype() {
		$return = true;
		
		$query = "SELECT * FROM producttype WHERE producttype_name = '" . $this->input->post('producttypeName') . "'";
		log_message('debug', 'ProducttypeModel.addProducttype : Try to get duplicate Producttype record : ' . $query);
		
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$query = "INSERT INTO producttype (producttype_id, producttype_name)" .
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
	
	function getProducttypeFromId($producttypeId) {
		
		$query = "SELECT * FROM producttype WHERE producttype_id = " . $producttypeId;
		log_message('debug', "ProducttypeModel.getProducttypeFromId : " . $query);
		$result = $this->db->query($query);
		
		$producttype = array();
		
		$this->load->library('ProducttypeLib');
		
		$row = $result->row();
		
		$this->producttypeLib->producttypeId = $row->producttype_id;
		$this->producttypeLib->producttypeName = $row->producttype_name;
		
		return $this->producttypeLib;
	}
	
	function updateProducttype() {
		$return = true;
		
		$query = "SELECT * FROM producttype WHERE producttype_name = '" . $this->input->post('producttypeName') . "' AND producttype_id <> " . $this->input->post('producttypeId');
		log_message('debug', 'ProducttypeModel.updateProducttype : Try to get Duplicate record : ' . $query);
			
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$data = array(
						'producttype_name' => $this->input->post('producttypeName'), 
					);
			$where = "producttype_id = " . $this->input->post('producttypeId');
			$query = $this->db->update_string('producttype', $data, $where);
			
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