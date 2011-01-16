<?php

class ProducerModel extends Model{
	
	function getProducersBasedOnType ($producerType, $q) {
		$originalQ = $q;
		$q = strtolower($q);
		$query = 'SELECT ' .
				' producer_id, producer' .
				' FROM producer' .
				' WHERE ' .
				' producer like "%'.$q.'%"';
			if ($producerType == 'farm') {
				$query .= ' AND is_farm = 1';
			} else if ($producerType == 'restaurant') {
				$query .= ' AND is_restaurant = 1';
			} else if ($producerType == 'distributor') {
				$query .= ' AND is_distributor = 1';
			} else if ($producerType == 'manufacture') {
				$query .= ' AND is_manufacture = 1';
			} 
				
		$query .= ' ORDER BY producer';
		
		$producers = '';
		
		log_message('debug', "CompanyModel.getCompanyBasedOnTypeFrontEnd : " . $query);
		$result = $this->db->query($query);
		
		if ( $result->num_rows() > 0) {
			foreach ($result->result_array() as $row) {
				$producers .= $row['producer']."|".$row['producer_id']."\n";
			}
		} else {
			$producers .= 'Create "'.$originalQ.'"|' . $originalQ;
		}
		
		return $producers;
	}
	
	function addProducerWithNameOnly($producerName, $producerType) {
		global $ACTIVITY_LEVEL_DB;

		$return = true;

		$CI =& get_instance();

		if ( empty($producerName) ) {
			$GLOBALS['error'] = 'no_name';
			$return = false;
		} else {
			$query = 'INSERT INTO producer (producer_id, producer, creation_date, user_id, status, track_ip, ';
			if ($producerType == 'farm') {
				$query .= 'is_farm';
			} else if ($producerType == 'restaurant') {
				$query .= 'is_restaurant';
			} else if ($producerType == 'manufacture') {
				$query .= 'is_manufacture';
			} else if ($producerType == 'distributor') {
				$query .= 'is_distributor';
			}
			$query .= ')';
			$query .= ' values (NULL, "' . $producerName .'", NOW(), ' . $this->session->userdata['userId'] . ', \'live\', \'' . getRealIpAddr() . '\', 1)';
			
			log_message('debug', 'ProducerModel.addProducerWithNameOnly : Insert Producer : ' . $query);
			$return = true;

			if ( $this->db->query($query) ) {
				$newProducerId = $this->db->insert_id();
				$return = $newProducerId;
			} else {
				$return = false;
			}
		}

		return $return;
	}
	
	function getProducerFromIdAndAddressId($producerId, $addressId) {
		$query = 'SELECT producer.producer, address.*, state.state_code, state.state_name, country.country_name ' .
				' FROM producer, address, state, country' .
				' WHERE producer.producer_id = ' . $producerId .
				' AND address.producer_id = producer.producer_id' .
				' AND address.address_id = ' . $addressId . '' .
				' AND address.state_id = state.state_id ' .
				' AND address.country_id = country.country_id';
		
		log_message('debug', "ProducerModel.getProducerFromIdAndAddressId : " . $query);
		$result = $this->db->query($query);
		$row = $result->row();
		$this->load->library('ProducerLib');		
		if ($row) {
			
			$this->ProducerLib->producerId = $row->producer_id;
			$this->ProducerLib->producer = $row->producer;
			
			$this->ProducerLib->addressId = $row->address_id;
			$this->ProducerLib->address = $row->address;
			$this->ProducerLib->city = $row->city;
			$this->ProducerLib->cityId = $row->city_id;
			$this->ProducerLib->stateId = $row->state_id;
			$this->ProducerLib->state = $row->state_name;
			$this->ProducerLib->stateCode = $row->state_code;
			$this->ProducerLib->zipcode = $row->zipcode;
			$this->ProducerLib->country = $row->country_name;
			$this->ProducerLib->latitude = $row->latitude;
			$this->ProducerLib->longitude = $row->longitude;
			
			return $this->ProducerLib;
		} else {
			return;
		}
	}
	
}



?>