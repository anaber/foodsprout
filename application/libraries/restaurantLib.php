<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class RestaurantLib {
	
	var $restaurantId;
	var $restaurantName;
	var $streetNumber;
	var $street;
	var $city;
	var $stateId;
	var $state;
	var $countryId;
	var $country;
	var $zipcode;
	var $creationDate;
		
	function RestaurantLib() {
		$this->restaurantId = '';
		$this->restaurantName = '';
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
