<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class PlantLib {
	
	var $plantId;
	var $plantName;
	var $plantGroupId;
	var $plantGroupName;
		
	function PlantLib() {
		$this->plantId = '';
		$this->plantName = '';
		$this->plantGroupId = '';
		$this->plantGroupName = '';
	}
}
?>