<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class CompanyLib {
	
	var $companyId;
	var $companyName;
	var $address;
	var $city;
	var $stateId;
	var $state;
	var $countryId;
	var $country;
	var $customURL;
	var $zipcode;
	var $creationDate;
		
	function CompanyLib() {
		$this->companyId = '';
		$this->companyName = '';
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
