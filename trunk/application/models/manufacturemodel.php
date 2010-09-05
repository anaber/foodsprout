<?php

class ManufactureModel extends Model{
	
	function searchManufactures($q) {
		
		$arr_q = explode('___', $q);
		//print_r_pre($arr_q);
		$query = 'SELECT manufacture_id, manufacture_name
					FROM manufacture
					WHERE manufacture_name like "'.$arr_q[0].'%"
					ORDER BY manufacture_name ';
		$manufactures = '';
		log_message('debug', "ManufactureModel.searchManufactures : " . $query);
		$result = $this->db->query($query);
		foreach ($result->result_array() as $row) {
			$manufactures .= $row['manufacture_name']."|".$row['manufacture_id']."\n";
		}
		
		return $manufactures;
	}
	
	function searchManufacturesForAutoSuggest($q) {
		
		$query = 'SELECT manufacture_id, manufacture_name
					FROM manufacture
					WHERE manufacture_name like "'.$q.'%"
					ORDER BY manufacture_name ';
		$manufactures = '';
		log_message('debug', "ManufactureModel.searchManufacturesForAutoSuggest : " . $query);
		$result = $this->db->query($query);
		
		if ( $result->num_rows() > 0) {
			foreach ($result->result() as $row) {
				$manufactures .= $row->manufacture_name . "|" . $row->manufacture_id ."\n";
			}
		} else {
			$manufactures .= 'No Manufacture';
		}
		
		return $manufactures;
	}
	
	// Insert the new manufacture data into the database
	function addManufacture() {
		
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
			
			$query = "SELECT * FROM manufacture WHERE manufacture_name = \"" . $manufactureName . "\" AND company_id = '" . $companyId . "'";
			log_message('debug', 'ManufactureModel.addManufacture : Try to get duplicate Manufacture record : ' . $query);
			
			$result = $this->db->query($query);
			
			if ($result->num_rows() == 0) {
				$query = "INSERT INTO manufacture (manufacture_id, company_id, manufacture_type_id, manufacture_name, creation_date, custom_url, url, status, track_ip, user_id)" .
						" values (NULL, ".$companyId.", " . $this->input->post('manufactureTypeId') . ", \"" . $manufactureName . "\", NOW(), '" . $this->input->post('customUrl') . "', '" . $this->input->post('url') . "', '" . $this->input->post('status') . "', '" . getRealIpAddr() . "', " . $this->session->userdata['userId'] . " )";
				
				log_message('debug', 'ManufactureModel.addManufacture : Insert Manufacture : ' . $query);
				$return = true;
				
				if ( $this->db->query($query) ) {
					$newManufactureId = $this->db->insert_id();
					
					$CI->load->model('AddressModel','',true);
					$address = $CI->AddressModel->addAddress('', '', $newManufactureId, '', '', $companyId);
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
		
		if ($row) {
			$geocodeArray = array();
			
			$this->manufactureLib->manufactureId = $row->manufacture_id;
			$this->manufactureLib->companyId = $row->company_id;
			$this->manufactureLib->companyName = $row->company_name;
			$this->manufactureLib->manufactureTypeId = $row->manufacture_type_id;
			$this->manufactureLib->manufactureName = $row->manufacture_name;
			$this->manufactureLib->customUrl = $row->custom_url;
			$this->manufactureLib->url = $row->url;
			$this->manufactureLib->status = $row->status;
			
			
			$CI =& get_instance();
				
			$CI->load->model('AddressModel','',true);
			$addresses = $CI->AddressModel->getAddressForCompany( '', '', $row->manufacture_id, '', '', '', '');
			$this->manufactureLib->addresses = $addresses;
			
			foreach ($addresses as $key => $address) {
				$arrLatLng = array();
				
				$arrLatLng['latitude'] = $address->latitude;
				$arrLatLng['longitude'] = $address->longitude;
				$arrLatLng['address'] = $address->completeAddress;
				
				$arrLatLng['addressLine1'] = $address->address;
				$arrLatLng['addressLine2'] = $address->city . ' ' . $address->state;
				$arrLatLng['addressLine3'] = $address->country . ' ' . $address->zipcode;
				
				$arrLatLng['manufactureName'] = $this->manufactureLib->manufactureName;
				$arrLatLng['id'] = $address->addressId;
				$geocodeArray[] = $arrLatLng;
			}
			$this->manufactureLib->param->numResults = 2;
			$this->manufactureLib->geocode = $geocodeArray;
			
			return $this->manufactureLib;
		} else {
			return;
		}
	}
	
	// Update the manufactures information in the database
	function updateManufacture() {
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
						'status' => $this->input->post('status'),
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
				$query = "SELECT * FROM manufacture WHERE manufacture_name = \"" . $manufactureName . "\" AND company_id = '" . $companyId . "'";
				log_message('debug', 'ManufactureModel.addManufacture : Try to get duplicate Manufacture record : ' . $query);
				
				$result = $this->db->query($query);
				
				if ($result->num_rows() == 0) {
					$query = "INSERT INTO manufacture (manufacture_id, company_id, manufacture_type_id, manufacture_name, creation_date, custom_url, status, track_ip, user_id)" .
							" values (NULL, ".$companyId.", NULL, \"" . $manufactureName . "\", NOW(), NULL, 'live', '" . getRealIpAddr() . "', " . $this->session->userdata['userId'] . " )";
					
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
			$sort = 'manufacture_name';
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
			$suppliers = $CI->SupplierModel->getSupplierForCompany( '', '', $row['manufacture_id'], '', '', '');
			$this->ManufactureLib->suppliers = $suppliers;
			
			$CI->load->model('AddressModel','',true);
			$addresses = $CI->AddressModel->getAddressForCompany( '', '', $row['manufacture_id'], '', '', '', '');
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
	
	function getManufactureJson() {
		global $PER_PAGE, $FARMER_TYPES;
		
		$p = $this->input->post('p'); // Page
		$pp = $this->input->post('pp'); // Per Page
		$sort = $this->input->post('sort');
		$order = $this->input->post('order');
		$filter = $this->input->post('f');
		
		if ($filter == false) {
			$filter = '';
		}
		
		$q = $this->input->post('q');
		
		if ($q == '0') {
			$q = '';
		}
		//$filter = 8;
		//$q = 1;
		
		$start = 0;
		$page = 0;
		
		$base_query = 'SELECT manufacture.*, manufacture_type.manufacture_type' .
				' FROM manufacture, manufacture_type';
		
		$base_query_count = 'SELECT count(*) AS num_records' .
				' FROM manufacture, manufacture_type';
		
		$where = ' WHERE manufacture.manufacture_type_id = manufacture_type.manufacture_type_id' .
				' AND manufacture.status = \'live\' ';
		/*
		$where .= ' AND (' 
				. '	manufacture.manufacture_name like "%' .$q . '%"'
				. ' OR manufacture.manufacture_id like "%' . $q . '%"'
				. ' OR manufacture_type.manufacture_type like "%' . $q . '%"';		
		$where .= ' )';
		*/
		if (!empty($q) ) {
		$where .= ' AND (' 
				. '	manufacture.manufacture_id = ' . $q
				. ' )';
		}
		
		if (!empty($filter) ) {
		//if ( count($arr_filter) > 0 && $arr_filter[0] == 's' ) {
			if (!empty($where) ) {
				$where .= ' AND (';  
			} else {
				$where .= ' WHERE (';
			}
			
			$where	.= '		SELECT address.address_id' 
					. '			from address, state'
					. '			WHERE' 
					. '				address.manufacture_id = manufacture.manufacture_id'
					. '				AND address.state_id = state.state_id'
					. ' 			AND ('
					. '						address.state_id = "' . $filter . '"' 
					. '						OR state.state_name like "%' . $filter . '%"'
					. '						OR state.state_code like "%' . $filter . '%"'
					. '				)'
					. '				LIMIT 0, 1';
			$where .= ' )';
		}
		
		
		$base_query_count = $base_query_count . $where;
		
		$query = $base_query_count;
		
		$result = $this->db->query($query);
		$row = $result->row();
		$numResults = $row->num_records;
		
		$query = $base_query . $where;
		
		if ( empty($sort) ) {
			$sort_query = ' ORDER BY manufacture_name';
			$sort = 'manufacture_name';
		} else {
			$sort_query = ' ORDER BY ' . $sort;
		}
		
		if ( empty($order) ) {
			$order = 'ASC';
		}
		
		$query = $query . ' ' . $sort_query . ' ' . $order;
		
		//echo $query;
		//die;
		
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
			$suppliers = $CI->SupplierModel->getSupplierForCompany( '', '', $row['manufacture_id'], '', '', '');
			$this->ManufactureLib->suppliers = $suppliers;
			
			$CI->load->model('AddressModel','',true);
			$addresses = $CI->AddressModel->getAddressForCompany( '', '', $row['manufacture_id'], '', '', '', '');
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
		
		
		$params = requestToParams($numResults, $start, $totalPages, $first, $last, $page, $sort, $order, $q, $filter, '');
		$arr = array(
			'results'    => $manufactures,
			'param'      => $params,
			'geocode'	 => $geocodeArray,
	    );
	    
	    return $arr;
	}
	
	// Get all the manufacture's products from the database
	function getManufactureProducts($manufactureId) {
		$query = "SELECT * FROM product WHERE manufacture_id = " . $manufactureId;
		
		log_message('debug', "ManufactureModel.getManufactureProducts : " . $query);
		$result = $this->db->query($query);
		
		$products = array();
		
		foreach ($result->result_array() as $row) {
			
			$this->load->library('ProductLib');
			unset($this->productLib);
			
			$this->productLib->productId = $row['product_id'];
			$this->productLib->productName = $row['product_name'];
			$this->productLib->ingredient = $row['ingredient_text'];
			
			$products[] = $this->productLib;
			unset($this->productLib);
		}
		return $products;
	}
	
	function getManufactureMenusJson() {
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
				' FROM product';
		
		$base_query_count = 'SELECT count(*) AS num_records' .
				' FROM product';
		
		$where = ' WHERE manufacture_id  = ' . $q . 
				 ' AND product.status = \'live\'';
		
		$base_query_count = $base_query_count . $where;
		
		$query = $base_query_count;
		
		$result = $this->db->query($query);
		$row = $result->row();
		$numResults = $row->num_records;
		
		$query = $base_query . $where;
		
		if ( empty($sort) ) {
			$sort_query = ' ORDER BY product_name';
			$sort = 'product_name';
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
		
		log_message('debug', "ManufactureModel.getManufactureMenusJson : " . $query);
		$result = $this->db->query($query);
		
		$menu = array();
		
		$CI =& get_instance();
		
		foreach ($result->result_array() as $row) {
			
			$this->load->library('ProductLib');
			unset($this->productLib);
			
			$this->productLib->productId = $row['product_id'];
			$this->productLib->productName = $row['product_name'];
			$this->productLib->ingredient = $row['ingredient_text'];
			$this->productLib->image = '';
			
			$menu[] = $this->productLib;
			unset($this->productLib);
		}
		
		if (!empty($pp) && $pp == 'all') {
			$PER_PAGE = $numResults;
		}
		
		$totalPages = ceil($numResults/$PER_PAGE);
		$first = 0;
		$last = $totalPages - 1;		
		
		$params = requestToParams($numResults, $start, $totalPages, $first, $last, $page, $sort, $order, $q, '', '');
		$arr = array(
			'results'    => $menu,
			'param'      => $params,
	    );
	    
	    return $arr;
	}
	
}

?>