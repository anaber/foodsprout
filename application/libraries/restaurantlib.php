<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class RestaurantLib {
	
	var $restaurantId;
	var $restaurantName;
	var $restaurantChainId;
	var $restaurnatChain;
	var $restaurantTypeId;
	var $address;
	var $city;
	var $stateId;
	var $state;
	var $countryId;
	var $country;
	var $zipcode;
	var $creationDate;
	var $restaurantURL;
	var $restaurantProductCategoryId;

	function RestaurantLib() {
		$this->restaurantId = '';
		$this->restaurantName = '';
		$this->restaurantChainId = '';
		$this->restaurnatChain = '';
		$this->restaurantTypeId = '';
		$this->address = '';
		$this->city = '';
		$this->stateId = '';
		$this->state = '';
		$this->countryId = '';
		$this->country = '';		
		$this->zipcode = '';
		$this->creationDate = '';
		$this->restaurantURL = '';
		$this->restaurantProductCategoryId ='';
	}
}
?>