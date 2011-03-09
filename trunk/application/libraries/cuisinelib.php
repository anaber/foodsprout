<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class CuisineLib {
	
	var $cuisineId;
	var $cuisineName;
	var $cuisineProductCategoryId;
		
	function cuisineLib() {
		$this->cuisineId = '';
		$this->cuisineName = '';
		$this->cuisineProductCategoryId = '';
	}
}
?>
