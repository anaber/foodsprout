<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class DistributorLib {
	
	var $distributorId;
	var $distributorName;
	var $streetNumber;
	var $street;
	var $city;
	var $stateId;
	var $state;
	var $countryId;
	var $country;
	var $zipcode;
	var $creationDate;
		
	function DistributorLib() {
		$this->distributorId = '';
		$this->distributorName = '';
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
