<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class IngredientLib {
	
	var $ingredientId;
	var $ingredientName;
	var $ingredientTypeId;
	//var $natural;
	//var $organic;
	//var $nonNatural;
	var $vegetableTypeId;
	var $meatTypeId;
	var $fruitTypeId;
	var $plantId;
		
	function IngredientLib() {
		$this->ingredientId = '';
		$this->ingredientName = '';
		$this->ingredientTypeId = '';
		//$this->natural = '';
		//$this->organic = '';
		//$this->nonNatural = '';
		$this->vegetableTypeId = '';
		$this->meatTypeId = '';
		$this->fruitTypeId = '';		
		$this->plantId = '';
	}
}
?>
