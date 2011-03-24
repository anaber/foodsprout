<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class ProductLib {
	
	var $productId;
	var $productName;
	var $producerId;
	var $companyId;
	var $companyName;
	var $restaurantId;
	var $restaurantName;
	var $restaurantChainId;
	var $restaurantChainName;
	var $manufactureId;
	var $manufactureName;
	var $productTypeId;
	var $productType;
	var $ingredient;
	var $brand;
	var $upc;
	var $status;
    var $hasFructose;
	var $userId;
	var $userName;
	var $creationDate;
	var $modifyDate;
	var $customURL;
		
	function ProductLib() {
		$this->productId = '';
		$this->productName = '';
		$this->producerId = '';
		$this->companyId = '';
		$this->companyName = '';
		$this->restaurantId = '';
		$this->restaurantName = '';
		$this->restaurantChainId = '';
		$this->restaurantChainName = '';
		$this->manufactureId = '';
		$this->manufactureName = '';
		$this->productTypeId = '';
		$this->productType = '';
		$this->ingredient = '';
		$this->brand = '';
		$this->upc = '';
		$this->status = '';
		$this->hasFructose = '';
		$this->userId = '';
		$this->userName = '';
		$this->creationDate = '';
		$this->modifyDate = '';
		$this->customURL = '';
	}
}
?>
