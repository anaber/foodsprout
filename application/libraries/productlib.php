<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class ProductLib {
	
	var $productId;
	var $companyId;
	var $restaurantId;
	var $restaurantChainId;
	var $manufactureId;
	var $productTypeId;
	var $productType;
	var $productName;
	var $ingredient;
	var $brand;
	var $upc;
	var $status;
	var $userId;
	var $creationDate;
	var $modifyDate;
	
		
	function ProductLib() {
		$this->productId = '';
		$this->restaurantId = '';
		$this->restaurantChainId = '';
		$this->manufactureId = '';
		$this->productTypeId = '';
		$this->productType = '';
		$this->productName = '';
		$this->ingredient = '';
		$this->brand = '';
		$this->upc = '';
		$this->status = '';
		$this->userId = '';
		$this->creationDate = '';
		$this->modifyDate = '';
	}
}
?>
