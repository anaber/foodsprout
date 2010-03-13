<?php

class ProductModel extends Model{
	
	// List all the products in the database
	function list_product()
	{
		$products = array();
		
		$products['headers'] = array(
								'ID', 'NANE', 'Ingredients',
							);
		
		$products['list'] = array();
		$this->load->library('ProductLib');
		
		for($i = 0; $i < 5; $i++) {
			$this->ProductLib->id = $i+1;
			$this->ProductLib->productName = 'Product Name';
			$this->ProductLib->ingredients = 'Meat, Cheese etc...';
			
			$products['list'][] = $this->ProductLib;
			unset($this->ProductLib);
		}
		
		$products['links'] = array(
								'productName' 	=> '/product/detail', 
							);
		
		return $products;
	}
	
}



?>