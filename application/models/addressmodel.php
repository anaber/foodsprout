<?php

class AddressModel extends Model{
	
	function prepareAddress($streetNumber, $street, $city, $state_id, $country_id, $zipcode) {
		$CI =& get_instance();
		$CI->load->model('StateModel','',true);
		$arrState = $CI->StateModel->getStateFromId($state_id);
		
		$CI->load->model('CountryModel','',true);
		$arrCountry = $CI->CountryModel->getCountryFromId($country_id);
		
		$address = $streetNumber . ' ' . $street . ' ' . $city . ' ' . $arrState->stateName . ' ' . $arrCountry->countryName . ' ' . $zipcode;
		
		return $address;
	}
	
	
}



?>