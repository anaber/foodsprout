<?php

class CustomUrlModel extends Model{
	
	function getCustomUrlForProducerAddress($producer_id, $address_id) {
		$query = 'SELECT * ' .
				' FROM custom_url ' .
				' WHERE producer_id = ' . $producer_id;
		if ($address_id != '') {
			$query .= ' AND address_id = ' . $address_id;
		}
		$result = $this->db->query($query);
		
		if ($result->num_rows() > 0) {
			$row = $result->row();
			return $row->custom_url;
		} else {
			return '';
		}
	}
	
	function getProducerIdFromCustomUrl($customUrl, $producer_type) {
		$query = 'SELECT custom_url.producer_id, custom_url.address_id ' .
				' FROM custom_url, producer ' .
				' WHERE custom_url.custom_url = "' . $customUrl . '"' .
				' AND custom_url.producer_id = producer.producer_id ' .
				' AND producer.is_' . $producer_type . ' = 1';
		$result = $this->db->query($query);
		
		if ($result->num_rows() > 0) {
			$row = $result->row();
			
			$this->load->library('CustomUrlLib');
			unset($this->CustomUrlLib);
			
			$this->CustomUrlLib->producerId = $row->producer_id;
			$this->CustomUrlLib->addressId = $row->address_id;
			
			return $this->CustomUrlLib;
		} else {
			return '';
		}
	}
	
	
	function getProductIdFromCustomUrl($customUrl) {
		$query = "SELECT product_id FROM custom_url WHERE custom_url = '".$customUrl."'";
		$result = $this->db->query($query);
		
		if ($result->num_rows() > 0) {
			
			return $result->result();
			
		} else {
			return false;
		}
	}
	
	function generateCustomUrl($addressId) {
		$producer = $this->input->post('restaurantName');
		
		$producer_without_spaces = trimWhiteSpaces(trim($producer));
		$producer_slug = strtolower(str_replace(' ', '-', str_replace("'", '',$producer_without_spaces)));
		$producer_with_city = $producer_without_spaces;
		
		$CI =& get_instance();
		$CI->load->model('AddressModel','',true);
		$address = $CI->AddressModel->getAddressFromId($addressId);
		
		$producer_with_city .= '-'.trimWhiteSpaces(trim($address->cityName)); 
		
		$slug = $producer_with_city;
		$slug = strtolower(str_replace(' ', '-', str_replace("'", '',$slug))); 
		//echo $slug;
		
		$query = 'SELECT * FROM custom_url ' .
				' WHERE custom_url = "' . $slug . '"' .
				' AND city = "' . $address->cityName . '"';
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			$cityCounter = 1;
		} else {
			$row = $result->result_array();
		}
		
		$query = 'INSERT INTO custom_url (custom_url_id, custom_url, producer_id, address_id, city, city_counter, product_id, user_id)' .
				' VALUES (NULL, "'.$slug.'", '.$address->producerId.', '.$addressId.', "'.$address->cityName.'", '.$cityCounter.', NULL, NULL)';
		if ( $this->db->query($query) ) {
			$cuatomUrlId = mysql_insert_id();
			//$cuatomUrlId = 298848;
		}
		
	}
	
	
}