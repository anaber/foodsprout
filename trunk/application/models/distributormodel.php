<?php

class DistributorModel extends Model{
	
	// Insert the new Distributor data into the database
	function addDistributor() {
		global $ACTIVITY_LEVEL_DB;
		
		$return = true;
		
//		$companyId = $this->input->post('companyId');
		$distributorName = $this->input->post('distributorName');
		
		$CI =& get_instance();
		
		if ( empty($distributorName) ) {
			$GLOBALS['error'] = 'no_name';
			$return = false;
		} else {
/*			if ( empty($companyId) ) {
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
*/			
			$query = "SELECT * FROM producer WHERE producer = \"" . $distributorName . "\" AND is_distributor = 1";
			log_message('debug', 'DistributorModel.addDistributor : Try to get duplicate Distributor record : ' . $query);
			
			$result = $this->db->query($query);
			
			if ($result->num_rows() == 0) {
				$query = "INSERT INTO producer (producer_id, producer, creation_date, custom_url, url, status, track_ip, user_id, facebook, twitter, is_distributor)" .
						" values (NULL, \"" . $distributorName . "\", NOW(), '" . $this->input->post('customUrl') . "', '" . $this->input->post('url') . "', '" . $this->input->post('status') . "', '" . getRealIpAddr() . "', " . $this->session->userdata['userId'] . ", '" . $this->input->post('facebook') . "', '" . $this->input->post('twitter') . "', 1)";
				
				log_message('debug', 'DistributorModel.addDistributor : Insert Distributor : ' . $query);
				$return = true;
				
				if ( $this->db->query($query) ) {
					$newDistributorId = $this->db->insert_id();

					$CI->load->model('AddressModel','',true);
					$addressId = $CI->AddressModel->addAddress($newDistributorId);
					
					if ($addressId) {
						$CI->load->model('CustomUrlModel','',true);
						$customUrlId = $CI->CustomUrlModel->generateCustomUrl($addressId);
					}

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
	
	function updateDistributor() {
		$return = true;
		
		$query = "SELECT * FROM producer WHERE producer = \"" . $this->input->post('distributorName') . "\" AND producer_id <> " . $this->input->post('distributorId')."  AND is_distributor = 1";
		log_message('debug', 'DistributorModel.updateDistributor : Try to get Duplicate record : ' . $query);
		
		$result = $this->db->query($query);

		if ($result->num_rows() == 0) {
			
			$data = array(
//						'company_id' => $this->input->post('companyId'), 
						'producer' => $this->input->post('distributorName'),
						'custom_url' => $this->input->post('customUrl'),
						'url' => $this->input->post('url'),
						'facebook' => $this->input->post('facebook'),
						'twitter' => $this->input->post('twitter'),
						'status' => $this->input->post('status')
					);
			$where = "producer_id = " . $this->input->post('distributorId');

			$query = $this->db->update_string('producer', $data, $where);

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
				log_message('debug', 'DistributorModel.addDistributorWithNameOnly : Try to get duplicate Distributor record : ' . $query);
				
				$result = $this->db->query($query);
				
				if ($result->num_rows() == 0) {
					$query = "INSERT INTO distributor (distributor_id, company_id, distributor_name, creation_date, custom_url, status, track_ip, user_id)" .
							" values (NULL, ".$companyId.", \"" . $distributorName . "\", NOW(), NULL, 'live', '" . getRealIpAddr() . "', " . $this->session->userdata['userId'] . " )";
					
					log_message('debug', 'DistributorModel.addDistributorWithNameOnly : Insert Distributor : ' . $query);
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
				' FROM producer';
		
		$base_query_count = 'SELECT count(*) AS num_records' .
				' FROM producer';
		
		$where = ' WHERE is_distributor = 1';
		
		if ( !empty($q) ) {

			$where  .= ' AND (producer.producer like "%' .$q . '%"'
			. ' OR producer.producer_id like "%' . $q . '%"';
			$where .= ' )';

		}
		
		$base_query_count = $base_query_count . $where;
		
		$query = $base_query_count;
		
		$result = $this->db->query($query);
		$row = $result->row();
		$numResults = $row->num_records;
		
		$query = $base_query . $where;
		
		if ( empty($sort) ) {
			$sort_query = ' ORDER BY producer';
			$sort = 'producer';
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
			
			$this->DistributorLib->distributorId = $row['producer_id'];
			$this->DistributorLib->distributorName = $row['producer'];
			
			$distributors[] = $this->DistributorLib;
			unset($this->DistributorLib);
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
			'results'    => $distributors,
			'param'      => $params,
			'geocode'	 => $geocodeArray,
	    );
	    
	    return $arr;
	}
	
	function getQueueDistributorJson() {
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
		
				
		$base_query = 'SELECT producer.*,user.email, user.first_name FROM producer LEFT JOIN user ON producer.user_id=user.user_id';


		$base_query_count = 'SELECT count(*) AS num_records FROM producer LEFT JOIN user ON producer.user_id=user.user_id';

		$where = ' WHERE producer.is_distributor=1 ' .
				' AND producer.status = \'queue\' ';

		if ( !empty($q) ) {

			$where .= ' AND (producer.producer like "%' .$q . '%")';

		}
		
		$base_query_count = $base_query_count . $where;
		
		$query = $base_query_count;
		
		$result = $this->db->query($query);
		$row = $result->row();
		$numResults = $row->num_records;
		
		$query = $base_query . $where;
		
		if ( empty($sort) ) {
			$sort_query = ' ORDER BY producer';
			$sort = 'producer';
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
		
		log_message('debug', "DistributorModel.getQueueDistributorJson : " . $query);
		$result = $this->db->query($query);
		
		$distributors = array();
		
		$CI =& get_instance();
		
		$geocodeArray = array();
		foreach ($result->result_array() as $row) {
			
			$this->load->library('DistributorLib');
			unset($this->DistributorLib);
			
			$this->DistributorLib->distributorId = $row['producer_id'];
			$this->DistributorLib->distributorName = $row['producer'];
			$this->DistributorLib->userId = $row['user_id'];
			$this->DistributorLib->email = $row['email'];
			$this->DistributorLib->ip = $row['track_ip'];
			$this->DistributorLib->dateAdded = date ("Y-m-d", strtotime($row['creation_date']) ) ;
			
			$distributors[] = $this->DistributorLib;
			unset($this->DistributorLib);
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
			'results'    => $distributors,
			'param'      => $params,
			'geocode'	 => $geocodeArray,
	    );
	    
	    return $arr;
	}
	
	// Used to build the sitemap.  Returns all the slugs
	function getDistributorCount() {
		$query = "SELECT count(*) as total FROM producer WHERE is_distributor = 1";
		$result = $this->db->query($query);
		
		$row = $result->row(); 
		return $row->total;
	}
	
	// Used to build the sitemap.  Returns all the slugs
	function getDistributorSitemap($start,$end) {
		$query = "SELECT creation_date,custom_url.custom_url
					FROM producer, custom_url WHERE is_distributor = 1 AND producer.producer_id=custom_url.producer_id LIMIT ".$start.", ".$end;

		log_message('debug', "DistributorModel.getDistributorSitemap : " . $query);
		$result = $this->db->query($query);

		$distributor = array();
		$CI =& get_instance();
		foreach ($result->result_array() as $row) {

			$this->load->library('DistributorLib');
			unset($this->DistributorLib);

			$this->DistributorLib->customURL = $row['custom_url'];
			$this->DistributorLib->creationDate = $row['creation_date'];

			$distributor[] = $this->DistributorLib;
			unset($this->DistributorLib);
		}

		return $distributor;	
	}
	
	// Pulls the data from the database for a specific distributor
	function getDistributorFromId($producerId, $addressId='') {

		$query = "SELECT 
					producer.*, producer_category.producer_category, producer_category.producer_category_id
				FROM 
					producer
				LEFT JOIN producer_category_member 
					ON producer.producer_id = producer_category_member.producer_id 
				LEFT JOIN producer_category
					ON producer_category_member.producer_category_id = producer_category.producer_category_id
				WHERE 
					producer.producer_id = " . $producerId;
		
		log_message('debug', "DistributorModel.getDistributorFromId : " . $query);
		$result = $this->db->query($query);

		$distributor = array();

		$this->load->library('DistributorLib');

		$row = $result->row();


		$city = '';
		$q = '';

		if ($row) {
			$geocodeArray = array();
			
			$this->distributorLib->distributorId = $row->producer_id;
			$this->distributorLib->distributorName = $row->producer;
			$this->distributorLib->distributorTypeId = $row->producer_category_id;
			$this->distributorLib->customUrl = $row->custom_url;
			$this->distributorLib->url = $row->url;
			$this->distributorLib->facebook = $row->facebook;
			$this->distributorLib->twitter = $row->twitter;
			$this->distributorLib->status = $row->status;
			
			
			$CI =& get_instance();
				
			$CI->load->model('AddressModel','',true);
			
			if(isset($addressId) && $addressId !=''){
				
				$addresses = $CI->AddressModel->getAddressForProducer($row->producer_id, '', '', '', $addressId);
				
			}else{
				$addresses = $CI->AddressModel->getAddressForProducer($row->producer_id, '', '', '');
			}
			$this->distributorLib->addresses = $addresses;
			
			foreach ($addresses as $key => $address) {
				$arrLatLng = array();
				
				$arrLatLng['latitude'] = $address->latitude;
				$arrLatLng['longitude'] = $address->longitude;
				$arrLatLng['address'] = $address->completeAddress;
				
				$arrLatLng['addressLine1'] = $address->address;
				$arrLatLng['addressLine2'] = $address->city . ' ' . $address->state;
				$arrLatLng['addressLine3'] = $address->country . ' ' . $address->zipcode;
				
				$arrLatLng['distributorName'] = $this->distributorLib->distributorName;
				$arrLatLng['id'] = $address->addressId;
				$geocodeArray[] = $arrLatLng;
			}
			$this->distributorLib->param->numResults = 2;
			$this->distributorLib->geocode = $geocodeArray;
			
			return $this->distributorLib;
		} else {
			return;
		}
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
		
		$where = ' WHERE distributor.status = \'live\' ';
		
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
		
		$distributors = array();
		
		foreach ($result->result_array() as $row) {
			
			$this->load->library('DistributorLib');
			unset($this->DistributorLib);
			
			$this->DistributorLib->distributorId = $row['distributor_id'];
			$this->DistributorLib->distributorName = $row['distributor_name'];
			
			$distributors[] = $this->DistributorLib;
			unset($this->DistributorLib);
		}
		
		if (!empty($pp) && $pp == 'all') {
			$PER_PAGE_2 = $numResults;
		}
		
		$totalPages = ceil($numResults/$PER_PAGE_2);
		$first = 0;
		if ($totalPages > 0) {
			$last = $totalPages - 1;
		} else {
			$last = 0;
		}
		
		
		$params = requestToParams2($numResults, $start, $totalPages, $first, $last, $page, $sort, $order, $q, '', '');
		$arr = array(
			'results'    => $distributors,
			'param'      => $params,
			
	    );
	    
	    return $arr;
	}
	
	function getDistributorMenusJson($producerId = null) {
		global $PER_PAGE;
		
		$p = $this->input->post('p'); 
		if (!$p) {
			$p = $this->input->get('p');
		}
		$pp = $this->input->post('pp'); 
		if (!$pp) {
			$pp = $this->input->get('pp');
		}
		$sort = $this->input->post('sort');
		if (!$sort) {
			$sort = $this->input->get('sort');
		}
		$order = $this->input->post('order');
		if (!$order) {
			$order = $this->input->get('order');
		}
		
		$q = $this->input->post('q');
		
		if ($q == '0') {
			$q = '';
		}
		if (!$q) {
			$q = $producerId;
		}
		
		$start = 0;
		$page = 0;
		
		$base_query = 'SELECT *' .
				' FROM product';
		
		$base_query_count = 'SELECT count(*) AS num_records' .
				' FROM product';
		
		$where = ' WHERE producer_id  = ' . $q . 
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
		
		log_message('debug', "DistributorModel.getDistributorMenusJson : " . $query);
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
		if ($totalPages > 0) {
			$last = $totalPages - 1;
		} else {
			$last = 0;
		}
		
		$params = requestToParams($numResults, $start, $totalPages, $first, $last, $page, $sort, $order, $q, '', '');
		$arr = array(
			'results'    => $menu,
			'param'      => $params,
	    );
	    
	    return $arr;
	}
	
	
}

?>