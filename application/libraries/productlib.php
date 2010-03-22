<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class ProductLib {
	
	var $productId;
	var $companyId;
	var $productName;
	var $upc;
		
	function ProductLib() {
		$this->productId = '';
		$this->companyId = '';
		$this->productName = '';
		$this->upc = '';
	}
}
?>
