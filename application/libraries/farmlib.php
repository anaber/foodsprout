<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class FarmLib {
	
	var $farmId;
	var $farmName;
	var $address;
	var $city;
	var $stateId;
	var $state;
	var $countryId;
	var $country;
	var $zipcode;
	var $creationDate;
	var $farmType;
	var $farmTypeId;
		
	function FarmLib() {
		$this->farmId = '';
		$this->farmName = '';
		$this->address = '';
		$this->city = '';
		$this->stateId = '';
		$this->state = '';
		$this->countryId = '';
		$this->country = '';		
		$this->zipcode = '';
		$this->creationDate = '';
		$this->farmType = '';
		$this->farmTypeId = '';
	}
}
?>
