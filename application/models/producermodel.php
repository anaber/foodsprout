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
	
}



?>