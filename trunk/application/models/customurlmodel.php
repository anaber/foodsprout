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
		$query = 'SELECT custom_url.producer_id ' .
				' FROM custom_url, producer ' .
				' WHERE custom_url.custom_url = "' . $customUrl . '"' .
				' AND custom_url.producer_id = producer.producer_id ' .
				' AND producer.is_' . $producer_type . ' = 1';
		$result = $this->db->query($query);
		
		if ($result->num_rows() > 0) {
			$row = $result->row();
			return $row->producer_id;
		} else {
			return '';
		}
	}
}