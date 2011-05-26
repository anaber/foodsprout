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
	
	
	function getProducersByUserJson($producerType) {
		global $PER_PAGE;
		
		$p = $this->input->post('p'); // Page
		$pp = $this->input->post('pp'); // Per Page
		$sort = $this->input->post('sort');
		$order = $this->input->post('order');
		
		$q = $this->input->post('q'); // User ID
		
		if ($q == '0') {
			$q = '';
		}
		
		//$status = 'queue';
		$userId  = $this->session->userdata['userId'];
		
		/** $base_query_count */
		$query = 'SELECT count(*) AS num_records' 
				. ' FROM producer' 
				. ' WHERE user_id = '.$userId
				.' AND is_' . $producerType . ' = 1';
		
		$result = $this->db->query($query);
		$row = $result->row();
		$numResults = $row->num_records;
		
		/** $base_query*/
		$base_query = 'SELECT * ' .
				' FROM producer'; 
		
		$where = ' WHERE is_'.$producerType.' = 1' .
				' AND producer.user_id = '. $userId;
		
		$query = $base_query . $where;	
		
		$start = 0;
		$page = 0;
		
		if ( empty($sort) ) {
			$sort_query = ' ORDER BY producer.producer_id';
			
			$sort = 'producer_id';
		} else {
			$sort_query = ' ORDER BY ' . $sort;
		}
		
		if ( empty($order) ) {
			$order = 'ASC';
		}
		
		$query = $query . ' ' . $sort_query . ' ' . $order;
		
		if (!empty($pp) && $pp != 'all' ) {
			$PER_PAGE = $pp;
		}
		
		if (!empty($pp) && $pp == 'all') {
			// NO NEED TO LIMIT THE CONTENT
		} else {
			
			if (!empty($p) || $p != 0) {
				$page = $p;
				$p = $p * $PER_PAGE;
				$query .= " LIMIT $p, " . $PER_PAGE;
				$start = $p;
				
			} else {
				$query .= " LIMIT 0, " . $PER_PAGE;
			}
		}
		
		log_message('debug', "ProducerModel.getProducersByUserJson : " . $query);
		$result = $this->db->query($query);
		
		$producers = array();
		$CI =& get_instance();
		$CI->load->model('CustomUrlModel','',true);
		$CI->load->model('AddressModel','',true);
		
		foreach ($result->result_array() as $row) {
			
			$this->load->library('ProducerLib');
			unset($this->ProducerLib);
			
			$this->ProducerLib->producerId = $row['producer_id'];
			$this->ProducerLib->producer = $row['producer'];
			
			$addresses = $CI->AddressModel->getAddressForProducer($row['producer_id']);
			$this->ProducerLib->addresses = $addresses;
			
			$this->ProducerLib->customUrl = '';
			$firstAddressId = '';
			
			foreach ($addresses as $key => $address) {
				$firstAddressId = $address->addressId;
				break;
			}
			
			if ($firstAddressId != '') {
				$customUrl = $CI->CustomUrlModel->getCustomUrlForProducerAddress($row['producer_id'], $firstAddressId);
				$this->ProducerLib->customUrl = $customUrl;
			}
			
			
			if ( $row['is_' . $producerType] == '1' ) {
				$this->ProducerLib->type = $producerType;
			} 
			
			
			$this->ProducerLib->userId = $row['user_id'];
			$this->ProducerLib->email = $row['email'];
			$this->ProducerLib->ip = $row['track_ip'];
			$this->ProducerLib->status = $row['status'];
			
			$producers[] = $this->ProducerLib;
			unset($this->ProducerLib);
		}
		
		
		if (!empty($pp) && $pp == 'all') {
			$PER_PAGE = $numResults;
		}
		
		$totalPages = ceil($numResults/$PER_PAGE);
		$first = 0;
		if ($totalPages > 0) {
			$last = $totalPages - 1;
		} else {
			$last = 0;
		}
		
		$params = requestToParams($numResults, $start, $totalPages, $first, $last, $page, $sort, $order, $q, '', '');
		$arr = array(
			'results'    => $producers,
			'param'      => $params,
	    );
	    return $arr;
	    
	}
	
	function getProducerFromId($producerId) {
		$query = 'SELECT producer.* ' .
				' FROM producer' .
				' WHERE producer.producer_id = ' . $producerId;
		
		log_message('debug', "ProducerModel.getProducerFromIdAndAddressId : " . $query);
		$result = $this->db->query($query);
		$row = $result->row();
		$this->load->library('ProducerLib');		
		if ($row) {
			
			$this->ProducerLib->producerId = $row->producer_id;
			$this->ProducerLib->producer = $row->producer;
			
			return $this->ProducerLib;
		} else {
			return false;
		}
	}

        function insertProducerFromFile(array $data, $test=false)
        {
            $table = ($test) ? 'producer_bk' : 'producer';
            
            $this->db->insert($table,$data);

            return $this->db->insert_id();
        }

        function checkIfOtherBranchesExist($producer_slug, $test=false)
        {
            $table = ($test) ? 'producer_bk' : 'producer';

            $this->db->from($table)->where('custom_url', $producer_slug);

            return $this->db->count_all_results();
        }

        function checkIfProducerExists($producer, $city_id, $state_id, $address, $test=false)
        {
            $producer_table = ($test) ? 'producer_bk' : 'producer';
            $address_table = ($test) ? 'address_bk' : 'address';
            
            $this->db->where('pd.producer', $producer)->from("$producer_table AS pd");

            if ($address)
            {
                $this->db->join("$address_table AS ad", 'pd.producer_id=ad.producer_id');

                if ($city_id)
                {
                    $this->db->where('ad.city_id', $city_id);
                }

                if ($state_id)
                {
                    $this->db->where('ad.state_id', $state_id);
                }
            }

            return (bool)$this->db->count_all_results();
        }
        
	function getProducersWithNoAddressJson()
	{
		global $PER_PAGE;
		
		$p = $this->input->post('p'); // Page
		$pp = $this->input->post('pp'); // Per Page
		$sort = $this->input->post('sort');
		$order = $this->input->post('order');
		
		$q = $this->input->post('q'); 
		
		if ($q == '0') {
			$q = '';
		}
				
		$query = 'SELECT count(*) AS num_records
				  FROM producer
				  LEFT JOIN address
				  ON producer.producer_id = address.producer_id
				  WHERE address.producer_id IS NULL AND is_restaurant_chain IS NULL';
		
		$result = $this->db->query($query);
		$row = $result->row();
		$numResults = $row->num_records;
		
		
		$base_query = 'SELECT producer.* 
					   FROM producer
					   LEFT JOIN address
					   ON producer.producer_id = address.producer_id';
		
		$where = ' WHERE address.producer_id IS NULL AND is_restaurant_chain IS NULL'; 
	
		
		$query = $base_query . $where;	
		
		$start = 0;
		$page = 0;
		
		if ( empty($sort) ) {
			$sort_query = ' ORDER BY producer.producer_id';
			
			$sort = 'producer_id';
		} else {
			$sort_query = ' ORDER BY ' . $sort;
		}
		
		if ( empty($order) ) {
			$order = 'ASC';
		}
		
		$query = $query . ' ' . $sort_query . ' ' . $order;
		
		if (!empty($pp) && $pp != 'all' ) {
			$PER_PAGE = $pp;
		}
		
		if (!empty($pp) && $pp == 'all') {
			// NO NEED TO LIMIT THE CONTENT
		} else {
			
			if (!empty($p) || $p != 0) {
				$page = $p;
				$p = $p * $PER_PAGE;
				$query .= " LIMIT $p, " . $PER_PAGE;
				$start = $p;
				
			} else {
				$query .= " LIMIT 0, " . $PER_PAGE;
			}
		}
		
		log_message('debug', "ProducerModel.getProducersWithNoAddressJson : " . $query);
		$result = $this->db->query($query);
		
		$producers = array();
		
		foreach ($result->result_array() as $row) {
			
			$this->load->library('ProducerLib');
			unset($this->ProducerLib);
			
			$this->ProducerLib->producerId = $row['producer_id'];
			$this->ProducerLib->producer = $row['producer'];
			$this->ProducerLib->status = $row['status'];
					
			if ($row['is_restaurant'] == 1)
			{
				$this->ProducerLib->restaurantURL = 'restaurant';
			}
			
			if ($row['is_farm'] == 1)
			{
				$this->ProducerLib->restaurantURL = 'farm';
			}
			
			if ($row['is_farmers_market'] == 1)
			{
				$this->ProducerLib->restaurantURL = 'farmersmarket';
			}
			
			if ($row['is_manufacture'] == 1)
			{
				$this->ProducerLib->restaurantURL = 'manufacture';
			}
			
		
			if ($row['is_distributor'] == 1)
			{
				$this->ProducerLib->restaurantURL = 'distributor';
			}
			 	 	 	 	 	
			
			$producers[] = $this->ProducerLib;
			unset($this->ProducerLib);
		}
		
		
		if (!empty($pp) && $pp == 'all') {
			$PER_PAGE = $numResults;
		}
		
		$totalPages = ceil($numResults/$PER_PAGE);
		$first = 0;
		if ($totalPages > 0) {
			$last = $totalPages - 1;
		} else {
			$last = 0;
		}
		
		$params = requestToParams($numResults, $start, $totalPages, $first, $last, $page, $sort, $order, $q, '', '');
		$arr = array(
			'results'    => $producers,
			'param'      => $params,
	    );
	    return $arr;
	}
	
	function getRecentProducersByUser($userId, $limit) {
		global $PER_PAGE;
		
		/** $base_query_count */
		$query = 'SELECT *' 
				. ' FROM producer' 
				. ' WHERE user_id = '.$userId
				. ' ORDER BY creation_date DESC '
				. ' LIMIT 0, ' . $limit;
		
		$result = $this->db->query($query);
		
		log_message('debug', "ProducerModel.getProducersByUserJson : " . $query);
		$result = $this->db->query($query);
		
		$producers = array();
		$CI =& get_instance();
		$CI->load->model('CustomUrlModel','',true);
		//$CI->load->model('AddressModel','',true);
		
		foreach ($result->result_array() as $row) {
			
			$this->load->library('ProducerLib');
			unset($this->ProducerLib);
			
			$this->ProducerLib->producerId = $row['producer_id'];
			$this->ProducerLib->producer = $row['producer'];
			$this->ProducerLib->userId = $row['user_id'];
			$this->ProducerLib->email = $row['email'];
			$this->ProducerLib->ip = $row['track_ip'];
			$this->ProducerLib->dateAdded = date("F d, Y", strtotime($row['creation_date']));
			$this->ProducerLib->status = $row['status'];
			
			$producers[] = $this->ProducerLib;
			unset($this->ProducerLib);
		}
		
	    return $producers;	    
	}
}



?>