<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class DistributorLib {
	
	var $distributorId;
	var $distributorName;
	var $address;
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
