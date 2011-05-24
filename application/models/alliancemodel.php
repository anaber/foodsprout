<?php

class AllianceModel extends Model{
	
	function addAlliance($allianceName) {
		$return = true;
		
		$query = "SELECT * FROM alliance WHERE alliance_name = '".$allianceName."'";
		log_message('debug', 'allianceModel.addAlliance : Try to get duplicate alliance record : ' . $query);
		
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$query = "INSERT INTO alliance (alliance_name,alliance_info,custom_url)
					  VALUES ('".$allianceName."')";
			log_message('debug', 'allianceModel.addalliance : Insert alliance : ' . $query);
			
			if ( $this->db->query($query) ) {
				$new_alliance_id = $this->db->insert_id();

				$return = $new_alliance_id;
			} else {
				$return = false;
			}
		} else {
			$GLOBALS['error'] = 'duplicate_alliance';
			$return = false;
		}
		
		return $return;	
	}
	
	// Generate a simple list of all the companies in the database
	function listAlliance()
	{
		/*$query = "SELECT alliance.* " .
				 " FROM alliance " .
				 " ORDER BY alliance_name";*/
		$query = "SELECT * FROM alliance ORDER BY alliance_name";
		
		log_message('debug', "allianceModel.listalliance : " . $query);
		$result = $this->db->query($query);
		
		$companies = array();
		
		foreach ($result->result_array() as $row) {
			
			$this->load->library('allianceLib');
			unset($this->allianceLib);
			
			/*$this->allianceLib->allianceId = $row['alliance_id'];
			$this->allianceLib->allianceName = $row['alliance_name'];
			$this->allianceLib->creationDate = $row['creation_date'];*/
			
			$this->allianceLib->allianceId = $row['alliance_id'];
			$this->allianceLib->allianceName = $row['alliance_name'];
			
			$companies[] = $this->allianceLib;
			unset($this->allianceLib);
		}
		
		return $companies;
	}
	
	function getAllianceFromId($allianceId) {
		
		/*$query = "SELECT * FROM alliance WHERE alliance_id = " . $allianceId;*/
		$query = "SELECT * FROM alliance WHERE alliance_id = ".$allianceId;
		log_message('debug', "allianceModel.getallianceFromId : " . $query);
		$result = $this->db->query($query);
		
		$alliance = array();
		
		$this->load->library('allianceLib');
		
		$row = $result->row();
		
		/*$this->allianceLib->allianceId = $row->alliance_id;
		$this->allianceLib->allianceName = $row->alliance_name;*/
		$this->allianceLib->allianceId = $row->alliance_id;
		$this->allianceLib->allianceName = $row->alliance_name;
		
		return $this->allianceLib;
	}
	
	function getAllianceFromName($allianceName) {
		
		/*$query = "SELECT * FROM alliance WHERE alliance_name = \"" . $allianceName . "\"";*/
		$query = "SELECT * FROM alliance WHERE alliance_name = '".$allianceName."'";
		log_message('debug', "allianceModel.getallianceFromName : " . $query);
		$result = $this->db->query($query);
		
		$alliance = array();
		
		$this->load->library('allianceLib');
		
		$row = $result->row();
		if ($row) {
			/*$this->allianceLib->allianceId = $row->alliance_id;
			$this->allianceLib->allianceName = $row->alliance_name;*/
			$this->allianceLib->allianceId = $row->alliance_id;
			$this->allianceLib->allianceName = $row->alliance_name;
			return $this->allianceLib;
		} else {
			return $alliance;
		}
	}
	
	function updateAlliance() {
		$return = true;
		
		/*$query = "SELECT * FROM alliance WHERE alliance_name = \"" . $this->input->post('allianceName') . "\" AND alliance_id <> " . $this->input->post('allianceId');*/
		$query = "SELECT * 
				  FROM alliance
				  WHERE alliance_name = '".$this->input->post('allianceName')."'
				  AND alliance_id <> " . $this->input->post('allianceId');
		log_message('debug', 'allianceModel.updatealliance : Try to get Duplicate record : ' . $query);
			
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$data = array(
						'alliance_name' => $this->input->post('allianceName')
						//'alliance_name' => $this->input->post('allianceName'), 
					);
			//$where = "alliance_id = " . $this->input->post('allianceId');
			$where = "alliance_id = " . $this->input->post('allianceId');
			//$query = $this->db->update_string('alliance', $data, $where);
			$query = $this->db->update_string('alliance', $data, $where);
			
			log_message('debug', 'allianceModel.updatealliance : ' . $query);
			if ( $this->db->query($query) ) {
				$return = true;
			} else {
				$return = false;
			}
			
		} else {
			$GLOBALS['error'] = 'duplicate';
			$return = false;
		}
				
		return $return;
	}
	
	function searchAlliance($q) {
		$query = "SELECT *
				  FROM alliance
				  WHERE alliance_name like '$q%'
				  ORDER BY alliance_name ";
		$alliances = array();
		log_message('debug', "allianceModel.searchAlliance : " . $query);
		$result = $this->db->query($query);
		foreach ($result->result_array() as $row) {
			
			$row['alliance_name'] = htmlentities(stripslashes($row['alliance_name']));
			$alliances[] = $row;
		}
		
		return $alliances;
	}
		
	function getAlliancesJsonAdmin() {
		global $PER_PAGE;
		
		$p = $this->input->post('p'); // Page
		$pp = $this->input->post('pp'); // Per Page
		$sort = $this->input->post('sort');
		$order = $this->input->post('order');
		
		$q = $this->input->post('q');
		
		if ($q == '0') {
			$q = '';
		}
		
		$start = 0;
		$page = 0;
		
		
		/*$base_query = 'SELECT *' .
				' FROM alliance';*/
		$base_query = 'SELECT * FROM alliance';
		
		/*$base_query_count = 'SELECT count(*) AS num_records' .
				' FROM alliance';*/
		$base_query_count = 'SELECT COUNT(*) AS num_records FROM alliance';
		
		$where = '';
		if ($q != '')
		{
			$where = ' WHERE ';
			
			/*$where .= ' (' 
					. '	alliance.alliance_name like "%' .$q . '%"'
					. ' OR alliance.alliance_id like "%' . $q . '%"';
			$where .= ' )';*/
			
			$where = '(
						alliance_name LIKE "%' .$q . '%" 
						OR alliance_id LIKE "%' .$q . '%"
					  )';
		}
		
		$base_query_count = $base_query_count . $where;
		
		$query = $base_query_count;
		
		$result = $this->db->query($query);
		$row = $result->row();
		$numResults = $row->num_records;
		
		$query = $base_query . $where;
		
		if ( empty($sort) ) {
			/*$sort_query = ' ORDER BY alliance_name';
			$sort = 'alliance_name';*/
			$sort_query = " ORDER BY alliance_name";
			$sort = 'alliance_name';
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
		
		log_message('debug', "allianceModel.getCompaniesJsonAdmin : " . $query);
		$result = $this->db->query($query);
		
		$companies = array();
		
		$CI =& get_instance();
		
		$geocodeArray = array();
		foreach ($result->result_array() as $row) {
			
			$this->load->library('allianceLib');
			unset($this->allianceLib);
			
			/*$this->allianceLib->allianceId = $row['alliance_id'];
			$this->allianceLib->allianceName = $row['alliance_name'];*/
			$this->allianceLib->allianceId = $row['alliance_id'];
			$this->allianceLib->allianceName = $row['alliance_name'];
			
			$companies[] = $this->allianceLib;
			unset($this->allianceLib);
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
			'results'    => $companies,
			'param'      => $params,
			'geocode'	 => $geocodeArray,
	    );
	    
	    return $arr;
	}
	
	
 	function getProducers($q)
    {
        //$originalQ = $q;
        $q = strtolower($q);
        
        $query = 'SELECT producer_id, producer
				  FROM producer
				  WHERE producer LIKE "%'.$q.'%"
                  ORDER BY producer
                  LIMIT 20';

        $producers = array();

        log_message('debug', "allianceModel.getProducers : " . $query);
        $result = $this->db->query($query);

        if ($result->num_rows() > 0)
        {
            foreach ($result->result_array() as $row)
            {
            	$row['producer'] = htmlentities(stripslashes($row['producer']));            	
            	$producers[] = $row;
            }
        } 

        return $producers;
    }
    
    function add_group()
    {
    	$producer_ids = explode("|",$this->input->post('producerId'));
    
    	foreach ($producer_ids AS $producer_id) 
    	{
    		if ($producer_id != "") 
    		{
		    	$data = array(
		    		'alliance_id' => $this->input->post('allianceId'),
		    		'producer_id' => $producer_id
		    	);
		    	
		    	$this->db->insert('producer_group', $data);
    		}
    	}
    	
    	return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }
}



?>