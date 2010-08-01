<?php

class DistributorModel extends Model{
	
	// Create a simple list of all the Distributor
	function listDistributor()
	{
		$query = "SELECT distributor.* " .
				" FROM distributor " .
				" ORDER BY distributor_name";
		
		log_message('debug', "DistributorModel.list_distributor : " . $query);
		$result = $this->db->query($query);
		
		$distributors = array();
		$CI =& get_instance();
		foreach ($result->result_array() as $row) {
			
			$this->load->library('DistributorLib');
			unset($this->DistributorLib);
			
			$this->DistributorLib->distributorId = $row['distributor_id'];
			$this->DistributorLib->distributorName = $row['distributor_name'];
			$this->DistributorLib->creationDate = $row['creation_date'];
			
			$CI->load->model('AddressModel','',true);
			$addresses = $CI->AddressModel->getAddressForCompany( '', '', '', $row['distributor_id'], '', '', '');
			$this->DistributorLib->addresses = $addresses;
			
			$CI->load->model('SupplierModel','',true);
			$suppliers = $CI->SupplierModel->getSupplierForCompany( '', '', '', $row['distributor_id'], '', '');
			$this->DistributorLib->suppliers = $suppliers;
			
			$distributors[] = $this->DistributorLib;
			unset($this->DistributorLib);
		}
		
		return $distributors;
	}
	
	// Insert the new Distributor data into the database
	function addDistributor() {
		global $ACTIVITY_LEVEL_DB;
		
		$return = true;
		
		$companyId = $this->input->post('companyId');
		$distributorName = $this->input->post('distributorName');
		
		$CI =& get_instance();
		
		if (empty($companyId) && empty($distributorName) ) {
			$GLOBALS['error'] = 'no_name';
			$return = false;
		} else {
			if ( empty($companyId) ) {
				// Enter distributor into company
				$CI->load->model('CompanyModel','',true);
				$companyId = $CI->CompanyModel->addCompany($this->input->post('distributorName'));
			} else {
				if (empty($distributorName) ) {
					// Consider company name as distributor name
					$CI->load->model('CompanyModel','',true);
					$company = $CI->CompanyModel->getCompanyFromId($companyId);
					$distributorName = $company->companyName;
				}
			}
			
			$query = "SELECT * FROM distributor WHERE distributor_name = \"" . $distributorName . "\"";
			log_message('debug', 'DistributorModel.addDistributor : Try to get duplicate Distributor record : ' . $query);
			
			$result = $this->db->query($query);
			
			if ($result->num_rows() == 0) {
				$query = "INSERT INTO distributor (distributor_id, company_id, distributor_name, creation_date, custom_url, url, is_active)" .
						" values (NULL, ".$companyId.", \"" . $distributorName . "\", NOW(), '" . $this->input->post('customUrl') . "', '" . $this->input->post('url') . "', '" . $ACTIVITY_LEVEL_DB[$this->input->post('isActive')] . "' )";
				
				log_message('debug', 'DistributorModel.addDistributor : Insert Distributor : ' . $query);
				$return = true;
				
				if ( $this->db->query($query) ) {
					$newDistributorId = $this->db->insert_id();
					
					$CI->load->model('AddressModel','',true);
					$address = $CI->AddressModel->addAddress('', '', '', $newDistributorId, '', $companyId);
				} else {
					$return = false;
				}
				
			} else {
				$GLOBALS['error'] = 'duplicate';
				$return = false;
			}
			
		}
		
		return $return;	
	}
	
	// Get all the information about one specific Distributor from an ID
	function getDistributorFromId($distributorId) {
		
		$query = "SELECT distributor.*, company.company_name " .
				" FROM distributor, company " .
				" WHERE distributor.distributor_id = " . $distributorId . 
				" AND distributor.company_id = company.company_id";
				
		log_message('debug', "DistributorModel.getDistributorFromId : " . $query);
		$result = $this->db->query($query);
		
		$this->load->library('DistributorLib');
		
		$row = $result->row();
		
		if ($row) {
			$geocodeArray = array();
				
			$this->DistributorLib->distributorId = $row->distributor_id;
			$this->DistributorLib->companyId = $row->company_id;
			$this->DistributorLib->companyName = $row->company_name;
			$this->DistributorLib->distributorName = $row->distributor_name;
			$this->DistributorLib->customUrl = $row->custom_url;
			$this->DistributorLib->url = $row->url;
			$this->DistributorLib->isActive = $row->is_active;
			
			$CI =& get_instance();
				
			$CI->load->model('AddressModel','',true);
			$addresses = $CI->AddressModel->getAddressForCompany( '', '', '', $row->distributor_id, '', '', '');
			$this->DistributorLib->addresses = $addresses;
			
			foreach ($addresses as $key => $address) {
				$arrLatLng = array();
				
				$arrLatLng['latitude'] = $address->latitude;
				$arrLatLng['longitude'] = $address->longitude;
				$arrLatLng['address'] = $address->completeAddress;
				
				$arrLatLng['addressLine1'] = $address->address;
				$arrLatLng['addressLine2'] = $address->city . ' ' . $address->state;
				$arrLatLng['addressLine3'] = $address->country . ' ' . $address->zipcode;
				
				$arrLatLng['distributorName'] = $this->DistributorLib->distributorName;
				$arrLatLng['id'] = $address->addressId;
				$geocodeArray[] = $arrLatLng;
			}
			$this->DistributorLib->param->numResults = 2;
			$this->DistributorLib->geocode = $geocodeArray;
			
			return $this->DistributorLib;
		} else {
			return false;
		}
	}
	
	function updateDistributor() {
		global $ACTIVITY_LEVEL_DB;
		$return = true;
		
		$query = "SELECT * FROM distributor WHERE distributor_name = \"" . $this->input->post('distributorName') . "\" AND distributor_id <> " . $this->input->post('distributorId');
		log_message('debug', 'DistributorModel.updateDistributor : Try to get Duplicate record : ' . $query);
		
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$data = array(
						'company_id' => $this->input->post('companyId'), 
						'distributor_name' => $this->input->post('distributorName'),
						'custom_url' => $this->input->post('customUrl'),
						'url' => $this->input->post('url'),
						'is_active' => $ACTIVITY_LEVEL_DB[$this->input->post('isActive')],
					);
			$where = "distributor_id = " . $this->input->post('distributorId');
			$query = $this->db->update_string('distributor', $data, $where);
			
			log_message('debug', 'DistributorModel.updateDistributor : ' . $query);
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
	
	function addDistributorWithNameOnly($distributorName) {
		global $ACTIVITY_LEVEL_DB;
		
		$return = true;
		
		$companyId = '';
		
		$CI =& get_instance();
		
		if (empty($companyId) && empty($distributorName) ) {
			$GLOBALS['error'] = 'no_name';
			$return = false;
		} else {
			if ( empty($companyId) ) {
				$CI->load->model('CompanyModel','',true);
				$companyId = $CI->CompanyModel->addCompany($distributorName);
			} 
			
			if ($companyId) {
				$query = "SELECT * FROM distributor WHERE distributor_name = \"" . $distributorName . "\" AND company_id = '" . $companyId . "'";
				log_message('debug', 'DistributorModel.addDistributor : Try to get duplicate Distributor record : ' . $query);
				
				$result = $this->db->query($query);
				
				if ($result->num_rows() == 0) {
					$query = "INSERT INTO distributor (distributor_id, company_id, distributor_name, creation_date, custom_url, is_active)" .
							" values (NULL, ".$companyId.", \"" . $distributorName . "\", NOW(), NULL, '" . $ACTIVITY_LEVEL_DB['active'] . "' )";
					
					log_message('debug', 'DistributorModel.addDistributor : Insert Distributor : ' . $query);
					$return = true;
					
					if ( $this->db->query($query) ) {
						$newDistributorId = $this->db->insert_id();
						$return = $newDistributorId;
					} else {
						$return = false;
					}
					
				} else {
					$GLOBALS['error'] = 'duplicate';
					$return = false;
				}
			} else {
				//echo "DEEPAK IN FALSE";
				$return = false;
			}
			
		}
		
		return $return;	
	}
	
	function getDistributorsJsonAdmin() {
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
		
				
		$base_query = 'SELECT *' .
				' FROM distributor';
		
		$base_query_count = 'SELECT count(*) AS num_records' .
				' FROM distributor';
		
		$where = ' WHERE ';
		
		$where .= ' (' 
				. '	distributor.distributor_name like "%' .$q . '%"'
				. ' OR distributor.distributor_id like "%' . $q . '%"';
		$where .= ' )';
		
		$base_query_count = $base_query_count . $where;
		
		$query = $base_query_count;
		
		$result = $this->db->query($query);
		$row = $result->row();
		$numResults = $row->num_records;
		
		$query = $base_query . $where;
		
		if ( empty($sort) ) {
			$sort_query = ' ORDER BY distributor_name';
			$sort = 'distributor_name';
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
		
		log_message('debug', "DistributorModel.getDistributorsJsonAdmin : " . $query);
		$result = $this->db->query($query);
		
		$distributors = array();
		
		$CI =& get_instance();
		
		$geocodeArray = array();
		foreach ($result->result_array() as $row) {
			
			$this->load->library('DistributorLib');
			unset($this->DistributorLib);
			
			$this->DistributorLib->distributorId = $row['distributor_id'];
			$this->DistributorLib->distributorName = $row['distributor_name'];
			
			$CI->load->model('SupplierModel','',true);
			$suppliers = $CI->SupplierModel->getSupplierForCompany( '', '', '', $row['distributor_id'], '', '');
			$this->DistributorLib->suppliers = $suppliers;
			
			$CI->load->model('AddressModel','',true);
			$addresses = $CI->AddressModel->getAddressForCompany( '', '', '', $row['distributor_id'], '', '', '');
			$this->DistributorLib->addresses = $addresses;
			
			$distributors[] = $this->DistributorLib;
			unset($this->DistributorLib);
		}
		
		if (!empty($pp) && $pp == 'all') {
			$PER_PAGE = $numResults;
		}
		
		$totalPages = ceil($numResults/$PER_PAGE);
		$first = 0;
		$last = $totalPages - 1;
		
		
		$params = requestToParams($numResults, $start, $totalPages, $first, $last, $page, $sort, $order, $q, '', '');
		$arr = array(
			'results'    => $distributors,
			'param'      => $params,
			'geocode'	 => $geocodeArray,
	    );
	    
	    return $arr;
	}
	
	function getDistributorsJson() {
		global $PER_PAGE_2;
		
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
		
		$base_query = 'SELECT *' .
				' FROM distributor';
		
		$base_query_count = 'SELECT count(*) AS num_records' .
				' FROM distributor';
		
		$where = '';
		
		$base_query_count = $base_query_count . $where;
		
		$query = $base_query_count;
		
		$result = $this->db->query($query);
		$row = $result->row();
		$numResults = $row->num_records;
		
		$query = $base_query . $where;
		
		if ( empty($sort) ) {
			$sort_query = ' ORDER BY distributor_name';
			$sort = 'distributor_name';
		} else {
			$sort_query = ' ORDER BY ' . $sort;
		}
		
		if ( empty($order) ) {
			$order = 'ASC';
		}
		
		$query = $query . ' ' . $sort_query . ' ' . $order;
		
		if (!empty($pp) && $pp != 'all' ) {
			$PER_PAGE_2 = $pp;
		}
		
		if (!empty($pp) && $pp == 'all') {
			// NO NEED TO LIMIT THE CONTENT
		} else {
			
			if (!empty($p) || $p != 0) {
				$page = $p;
				$p = $p * $PER_PAGE_2;
				$query .= " LIMIT $p, " . $PER_PAGE_2;
				$start = $p;
				
			} else {
				$query .= " LIMIT 0, " . $PER_PAGE_2;
			}
		}
		
		log_message('debug', "DistributorModel.getDistributorsJson : " . $query);
		$result = $this->db->query($query);
		
		$restaurantChains = array();
		
		foreach ($result->result_array() as $row) {
			
			$this->load->library('DistributorLib');
			unset($this->DistributorLib);
			
			$this->DistributorLib->distributorId = $row['distributor_id'];
			$this->DistributorLib->distributorName = $row['distributor_name'];
			
			$restaurantChains[] = $this->DistributorLib;
			unset($this->DistributorLib);
		}
		
		if (!empty($pp) && $pp == 'all') {
			$PER_PAGE_2 = $numResults;
		}
		
		$totalPages = ceil($numResults/$PER_PAGE_2);
		$first = 0;
		$last = $totalPages - 1;
		
		
		$params = requestToParams2($numResults, $start, $totalPages, $first, $last, $page, $sort, $order, $q, '', '');
		$arr = array(
			'results'    => $restaurantChains,
			'param'      => $params,
			
	    );
	    
	    return $arr;
	}
	
}

?>