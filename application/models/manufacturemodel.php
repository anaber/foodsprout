<?php

class ManufactureModel extends Model{
	
	// Create a simple list of all the manufactures
	function listManufacture()
	{
		$query = "SELECT manufacture.* " .
				" FROM manufacture " .
				" ORDER BY manufacture_name";
		
		log_message('debug', "ManufactureModel.list_manufacture : " . $query);
		$result = $this->db->query($query);
		
		$manufactures = array();
		$CI =& get_instance();
		foreach ($result->result_array() as $row) {
			
			$this->load->library('ManufactureLib');
			unset($this->manufactureLib);
			
			$this->manufactureLib->manufactureId = $row['manufacture_id'];
			$this->manufactureLib->manufactureName = $row['manufacture_name'];
			$this->manufactureLib->creationDate = $row['creation_date'];
			
			$CI->load->model('AddressModel','',true);
			$addresses = $CI->AddressModel->getAddressForCompany( '', '', $row['manufacture_id'], '', '', '' );
			$this->manufactureLib->addresses = $addresses;
			
			$CI->load->model('SupplierModel','',true);
			$suppliers = $CI->SupplierModel->getSupplierForCompany( '', '', $row['manufacture_id'], '', '' );
			$this->manufactureLib->suppliers = $suppliers;
			
			$manufactures[] = $this->manufactureLib;
			unset($this->manufactureLib);
		}
		
		return $manufactures;
	}
	
	// Insert the new manufacture data into the database
	function addManufacture() {
		global $ACTIVITY_LEVEL_DB;
		
		$return = true;
		
		$companyId = $this->input->post('companyId');
		$manufactureName = $this->input->post('manufactureName');
		
		$CI =& get_instance();
		
		if (empty($companyId) && empty($manufactureName) ) {
			$GLOBALS['error'] = 'no_name';
			$return = false;
		} else {
			if ( empty($companyId) ) {
				// Enter manufacture into company
				$CI->load->model('CompanyModel','',true);
				$companyId = $CI->CompanyModel->addCompany($this->input->post('manufactureName'));
			} else {
				if (empty($manufactureName) ) {
					// Consider company name as manufacture name
					$CI->load->model('CompanyModel','',true);
					$company = $CI->CompanyModel->getCompanyFromId($companyId);
					$manufactureName = $company->companyName;
				}
			}
			
			$query = "SELECT * FROM manufacture WHERE manufacture_name = '" . $manufactureName . "' AND company_id = '" . $companyId . "'";
			log_message('debug', 'ManufactureModel.addManufacture : Try to get duplicate Manufacture record : ' . $query);
			
			$result = $this->db->query($query);
			
			if ($result->num_rows() == 0) {
				$query = "INSERT INTO manufacture (manufacture_id, company_id, manufacture_type_id, manufacture_name, creation_date, custom_url, url, is_active)" .
						" values (NULL, ".$companyId.", " . $this->input->post('manufactureTypeId') . ", '" . $manufactureName . "', NOW(), '" . $this->input->post('customUrl') . "', '" . $this->input->post('url') . "', '" . $ACTIVITY_LEVEL_DB[$this->input->post('isActive')] . "' )";
				
				log_message('debug', 'ManufactureModel.addManufacture : Insert Manufacture : ' . $query);
				$return = true;
				
				if ( $this->db->query($query) ) {
					$newManufactureId = $this->db->insert_id();
					
					$CI->load->model('AddressModel','',true);
					$address = $CI->AddressModel->addAddress('', '', $newManufactureId, '', $companyId);
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
	
	// Get all the information about one specific manufacture from an ID
	function getManufactureFromId($manufactureId) {
		
		//$query = "SELECT manufacture.*, address.* FROM manufacture, address WHERE manufacture.manufacture_id = address.manufacture_id AND manufacture.manufacture_id = " . $manufactureId;
		$query = "SELECT manufacture.*, company.company_name " .
				" FROM manufacture, company" .
				" WHERE manufacture.manufacture_id = " . $manufactureId .
				" AND manufacture.company_id = company.company_id";
		log_message('debug', "ManufactureModel.getManufactureFromId : " . $query);
		$result = $this->db->query($query);
		
		$this->load->library('ManufactureLib');
		
		$row = $result->row();
		
		$this->manufactureLib->manufactureId = $row->manufacture_id;
		$this->manufactureLib->companyId = $row->company_id;
		$this->manufactureLib->companyName = $row->company_name;
		$this->manufactureLib->manufactureTypeId = $row->manufacture_type_id;
		$this->manufactureLib->manufactureName = $row->manufacture_name;
		$this->manufactureLib->customUrl = $row->custom_url;
		$this->manufactureLib->url = $row->url;
		$this->manufactureLib->isActive = $row->is_active;

		return $this->manufactureLib;
	}
	
	function updateManufacture() {
		global $ACTIVITY_LEVEL_DB;
		$return = true;
		
		$query = "SELECT * FROM manufacture WHERE manufacture_name = '" . $this->input->post('manufactureName') . "' AND manufacture_id <> " . $this->input->post('manufactureId');
		log_message('debug', 'ManufactureModel.updateManufacture : Try to get Duplicate record : ' . $query);
		
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$data = array(
						'company_id' => $this->input->post('companyId'), 
						'manufacture_name' => $this->input->post('manufactureName'),
						'custom_url' => $this->input->post('customUrl'),
						'url' => $this->input->post('url'),
						'manufacture_type_id' => $this->input->post('manufactureTypeId'),
						'is_active' => $ACTIVITY_LEVEL_DB[$this->input->post('isActive')],
					);
			$where = "manufacture_id = " . $this->input->post('manufactureId');
			$query = $this->db->update_string('manufacture', $data, $where);
			
			log_message('debug', 'ManufactureModel.updateManufacture : ' . $query);
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
	
	function addManufactureWithNameOnly($manufactureName) {
		global $ACTIVITY_LEVEL_DB;
		
		$return = true;
		
		$companyId = '';
		
		$CI =& get_instance();
		
		if (empty($companyId) && empty($manufactureName) ) {
			$GLOBALS['error'] = 'no_name';
			$return = false;
		} else {
			if ( empty($companyId) ) {
				$CI->load->model('CompanyModel','',true);
				$companyId = $CI->CompanyModel->addCompany($manufactureName);
			} 
			
			if ($companyId) {
				$query = "SELECT * FROM manufacture WHERE manufacture_name = '" . $manufactureName . "' AND company_id = '" . $companyId . "'";
				log_message('debug', 'ManufactureModel.addManufacture : Try to get duplicate Manufacture record : ' . $query);
				
				$result = $this->db->query($query);
				
				if ($result->num_rows() == 0) {
					$query = "INSERT INTO manufacture (manufacture_id, company_id, manufacture_type_id, manufacture_name, creation_date, custom_url, is_active)" .
							" values (NULL, ".$companyId.", NULL, '" . $manufactureName . "', NOW(), NULL, '" . $ACTIVITY_LEVEL_DB['active'] . "' )";
					
					log_message('debug', 'ManufactureModel.addManufacture : Insert Manufacture : ' . $query);
					$return = true;
					
					if ( $this->db->query($query) ) {
						$newManufactureId = $this->db->insert_id();
						$return = $newManufactureId;
					} else {
						$return = false;
					}
					
				} else {
					$GLOBALS['error'] = 'duplicate';
					$return = false;
				}
			} else {
				$return = false;
			}
			
		}
		
		return $return;	
	}
	
	function getManufactureJsonAdmin() {
		global $PER_PAGE, $FARMER_TYPES;
		
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
		
		$base_query = 'SELECT manufacture.*, manufacture_type.manufacture_type' .
				' FROM manufacture, manufacture_type';
		
		$base_query_count = 'SELECT count(*) AS num_records' .
				' FROM manufacture, manufacture_type';
		
		$where = ' WHERE manufacture.manufacture_type_id = manufacture_type.manufacture_type_id';
		
		$where .= ' AND (' 
				. '	manufacture.manufacture_name like "%' .$q . '%"'
				. ' OR manufacture.manufacture_id like "%' . $q . '%"'
				. ' OR manufacture_type.manufacture_type like "%' . $q . '%"';		
		$where .= ' )';
		
		$base_query_count = $base_query_count . $where;
		
		$query = $base_query_count;
		
		$result = $this->db->query($query);
		$row = $result->row();
		$numResults = $row->num_records;
		
		$query = $base_query . $where;
		
		if ( empty($sort) ) {
			$sort_query = ' ORDER BY manufacture_name';
			$sort = 'farm_name';
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
		
		log_message('debug', "FarmModel.getFarmsJsonAdmin : " . $query);
		$result = $this->db->query($query);
		
		$manufactures = array();
		
		$CI =& get_instance();
		
		$geocodeArray = array();
		foreach ($result->result_array() as $row) {
			
			$this->load->library('ManufactureLib');
			unset($this->ManufactureLib);
			
			$this->ManufactureLib->manufactureId = $row['manufacture_id'];
			$this->ManufactureLib->manufactureName = $row['manufacture_name'];
			$this->ManufactureLib->manufactureTypeId = $row['manufacture_type_id'];
			$this->ManufactureLib->manufactureType = $row['manufacture_type'];
			
			$CI->load->model('SupplierModel','',true);
			$suppliers = $CI->SupplierModel->getSupplierForCompany( '', '', $row['manufacture_id'], '', '');
			$this->ManufactureLib->suppliers = $suppliers;
			
			$CI->load->model('AddressModel','',true);
			$addresses = $CI->AddressModel->getAddressForCompany( '', '', $row['manufacture_id'], '', '', '');
			$this->ManufactureLib->addresses = $addresses;
			
			$manufactures[] = $this->ManufactureLib;
			unset($this->ManufactureLib);
		}
		
		if (!empty($pp) && $pp == 'all') {
			$PER_PAGE = $numResults;
		}
		
		$totalPages = ceil($numResults/$PER_PAGE);
		$first = 0;
		$last = $totalPages - 1;
		
		
		$params = requestToParams($numResults, $start, $totalPages, $first, $last, $page, $sort, $order, $q, '', '');
		$arr = array(
			'results'    => $manufactures,
			'param'      => $params,
			'geocode'	 => $geocodeArray,
	    );
	    
	    return $arr;
	}
	
}

?>