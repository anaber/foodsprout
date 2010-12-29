<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class FarmersMarketLib {
	
	var $farmersMarketId;
	var $farmersMarketName;
	var $customURL;
	var $address;
	var $cityId;
	var $city;
	var $stateId;
	var $state;
	var $countryId;
	var $country;
	var $zipcode;
	var $suppliers;
		
	function FarmersMarketLib() {
		$this->farmersMarketId = '';
		$this->farmersMarketName = '';
		$this->customURL = '';
		$this->address = '';
		$this->cityId = '';
		$this->city = '';
		$this->stateId = '';
		$this->state = '';
		$this->countryId = '';
		$this->country = '';		
		$this->zipcode = '';
		$this->suppliers = '';
	}
}
?>
