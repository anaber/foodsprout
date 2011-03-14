<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class SupplierLib {
	
	var $supplierId;
	var $supplierType;
	var $supplierName;
	var $supplieeId;
		
	function SupplierLib() {
		$this->supplierId = '';
		$this->supplierType = '';
		$this->supplierName = '';
		$this->supplieeId = '';
		$this->status = '';
	}
}
?>
