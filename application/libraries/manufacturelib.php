<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class ManufactureLib {
	
	var $manufactureId;
	var $manufactureName;
	var $streetNumber;
	var $street;
	var $city;
	var $stateId;
	var $state;
	var $countryId;
	var $country;
	var $zipcode;
	var $creationDate;
		
	function ManufactureLib() {
		$this->manufactureId = '';
		$this->manufactureName = '';
		$this->streetNumber = '';
		$this->street = '';
		$this->city = '';
		$this->stateId = '';
		$this->state = '';
		$this->countryId = '';
		$this->country = '';		
		$this->zipcode = '';
		$this->creationDate = '';
	}
}
?>
