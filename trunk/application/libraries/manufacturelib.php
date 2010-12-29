<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class ManufactureLib {
	
	var $manufactureId;
	var $manufactureName;
	var $address;
	var $customURL;
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
		$this->customURL = '';
		$this->address = '';
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
