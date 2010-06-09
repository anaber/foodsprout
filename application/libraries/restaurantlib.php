<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class RestaurantLib {
	
	var $restaurantId;
	var $restaurantName;
	var $address;
	var $city;
	var $stateId;
	var $state;
	var $countryId;
	var $country;
	var $zipcode;
	var $creationDate;
	var $restaurantURL;
		
	function RestaurantLib() {
		$this->restaurantId = '';
		$this->restaurantName = '';
		$this->address = '';
		$this->city = '';
		$this->stateId = '';
		$this->state = '';
		$this->countryId = '';
		$this->country = '';		
		$this->zipcode = '';
		$this->creationDate = '';
		$this->restaurantURL = '';
	}
}
?>