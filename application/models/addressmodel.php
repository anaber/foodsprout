<?php

class AddressModel extends Model{
	
	function prepareAddress($street_address, $city, $state_id, $country_id, $zipcode) {
		$CI =& get_instance();
		$CI->load->model('StateModel','',true);
		$arrState = $CI->StateModel->getStateFromId($state_id);
		
		$CI->load->model('CountryModel','',true);
		$arrCountry = $CI->CountryModel->getCountryFromId($country_id);
		
		$address = $street_address . ' ' . $city . ' ' . $arrState->stateName . ' ' . $arrCountry->countryName . ' ' . $zipcode;
		
		return $address;
	}
	
	
}



?>