<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class AddressLib {
	
	var $addressId;
	var $address;
	var $city;
	var $cityId;
	var $stateId;
	var $stateCode;
	var $state;
	var $zipcode;
	var $countryId;
	var $country;
	var $latitude;
	var $longitude;
		
	function AddressLib() {
		$this->addressId = '';
		$this->address = '';
		$this->city = '';
		$this->cityId = '';
		$this->stateId = '';
		$this->state = '';
		$this->stateCode = '';
		$this->zipcode = '';
		$this->countryId = '';
		$this->country = '';
		$this->latitude = '';
		$this->longitude = '';
	}
}
?>
