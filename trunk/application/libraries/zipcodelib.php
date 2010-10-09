<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class ZipcodeLib {
	
	var $zipcode;
	var $latitude;
	var $longitude;
	var $approximate;
		
	function ZipcodeLib() {
		$this->zipcode = "";
		$this->latitude = "";
		$this->longitude = "";
		$this->approximate = "";
	}
}
?>
