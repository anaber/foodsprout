<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class ProducerLib {
	
	var $producerId;
	var $producer;
	var $address;
	var $city;
	var $stateId;
	var $state;
	var $countryId;
	var $country;
	var $zipcode;
	var $creationDate;
		
	function ProducerLib() {
		$this->producerId = '';
		$this->producer = '';
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