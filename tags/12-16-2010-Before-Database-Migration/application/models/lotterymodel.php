<?php

class LotteryModel extends Model{
	
	
	
	function getLotteriesJsonAdmin() {
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
		
		$base_query = 'SELECT lottery.*, restaurant.restaurant_name, city.city, state.state_code ' .
				' FROM lottery, restaurant, city, state';
		
		$base_query_count = 'SELECT count(*) AS num_records' .
				' FROM lottery, restaurant, city, state';
		
		$where = ' WHERE lottery.restaurant_id = restaurant.restaurant_id' .
				' AND lottery.city_id = city.city_id' .
				' AND city.state_id = state.state_id';
		
		if (! empty ($q) ) {
		$where .= ' AND (' 
				. '	lottery.lottery_name like "%' .$q . '%"'
				. ' OR restaurant.restaurant_name like "%' . $q . '%"'
				. ' OR state.state_code like "%' . $q . '%"'
				. ' OR city.city like "%' . $q . '%"'
				. ' )';
		}
		
		$base_query_count = $base_query_count . $where;
		
		$query = $base_query_count;
		
		$result = $this->db->query($query);
		$row = $result->row();
		$numResults = $row->num_records;
		
		$query = $base_query . $where;
		
		if ( empty($sort) ) {
			$sort_query = ' ORDER BY lottery_name';
			$sort = 'lottery_name';
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
		
		log_message('debug', "LotteryModel.getLotteriesJsonAdmin : " . $query);
		$result = $this->db->query($query);
		
		$lotteries = array();
		
		$CI =& get_instance();
		
		$geocodeArray = array();
		foreach ($result->result_array() as $row) {
			
			$this->load->library('LotteryLib');
			unset($this->LotteryLib);
			
			$this->LotteryLib->lotteryId = $row['lottery_id'];
			$this->LotteryLib->lotteryName = $row['lottery_name'];
			$this->LotteryLib->restaurantId = $row['restaurant_id'];
			$this->LotteryLib->restaurantName = $row['restaurant_name'];
			$this->LotteryLib->cityId = $row['city_id'];
			$this->LotteryLib->city = $row['city'];
			$this->LotteryLib->stateCode = $row['state_code'];
			
			
			$this->LotteryLib->startDate = ( $row['start_date'] ? date('m-d-Y', strtotime($row['start_date']) ) : '');
			$this->LotteryLib->endDate = ( $row['end_date'] ? date('m-d-Y', strtotime($row['end_date']) ) : '');
			$this->LotteryLib->drawDate = ( $row['draw_date'] ? date('m-d-Y', strtotime($row['draw_date']) ) : '');
			$this->LotteryLib->resultDate = ( $row['result_date'] ? date('m-d-Y', strtotime($row['result_date']) ) : '');
			
			$CI->load->model('PrizeModel','',true);
			$prizes = $CI->PrizeModel->getPrizesForLottery($row['lottery_id']);
			$this->LotteryLib->prizes = $prizes;
			
			$lotteries[] = $this->LotteryLib;
			unset($this->LotteryLib);
		}
		
		if (!empty($pp) && $pp == 'all') {
			$PER_PAGE = $numResults;
		}
		
		$totalPages = ceil($numResults/$PER_PAGE);
		$first = 0;
		$last = $totalPages - 1;
		
		
		$params = requestToParams($numResults, $start, $totalPages, $first, $last, $page, $sort, $order, $q, '', '');
		$arr = array(
			'results'    => $lotteries,
			'param'      => $params,
			'geocode'	 => $geocodeArray,
	    );
	    //print_r_pre($arr);
	    return $arr;
	}
	
	function addLottery() {
		$return = true;
		
		$restaurantId = $this->input->post('restaurantId');
		$lotteryName = $this->input->post('lotteryName');
		$mainPhotoName = $this->input->post('mainPhotoName');
		
		$CI =& get_instance();
		
		$query = "SELECT * FROM lottery WHERE lottery_name = \"" . $lotteryName . "\" AND restaurant_id = '" . $restaurantId . "'";
		log_message('debug', 'LotteryModel.addLottery : Try to get duplicate Lottery record : ' . $query);
		
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$startDate = $this->input->post('startDate');
			$endDate = $this->input->post('endDate');
			$drawDate = $this->input->post('drawDate');
			$resultDate = $this->input->post('resultDate');
			
			$query = "INSERT INTO lottery (lottery_id, lottery_name, restaurant_id, city_id, info, start_date, end_date, draw_date, result_date)" .
					" values (NULL, \"". $this->input->post('lotteryName') ."\", " . $this->input->post('restaurantId') . ", " . $this->input->post('cityId') . ", \"". $this->input->post('info') ."\", " . ($startDate ? "'". date("Y-m-d 00:00:00", strtotime($startDate)) ."'" : 'NULL'). ", " . ($endDate ? "'". date("Y-m-d 23:59:59", strtotime($endDate)) ."'" : 'NULL'). ", " . ($drawDate ? "'". date("Y-m-d 00:00:00", strtotime($drawDate)) ."'" : 'NULL'). ", " . ($resultDate ? "'". date("Y-m-d 00:00:00", strtotime($resultDate)) ."'" : 'NULL'). " )";
			
			log_message('debug', 'LotteryModel.addLottery : Insert Lottery : ' . $query);
			$return = true;
			
			if ( $this->db->query($query) ) {
				$newLotteryId = $this->db->insert_id();
				$CI->load->model('PhotoModel','',true);
				$CI->PhotoModel->addLotteryPhotoFromTemp($newLotteryId, $mainPhotoName);
				
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
	
	function getLotteryFromId($lotteryId) {
		
		$query = 'SELECT lottery.*, restaurant.restaurant_name, city.city, state.state_code ' .
				' FROM lottery, restaurant, city, state' .
				' WHERE lottery.lottery_id = ' . $lotteryId . 
				' AND lottery.restaurant_id = restaurant.restaurant_id' .
				' AND lottery.city_id = city.city_id' .
				' AND city.state_id = state.state_id';
		
		log_message('debug', "LotteryModel.getLotteryFromId : " . $query);
		$result = $this->db->query($query);
		
		$this->load->library('LotteryLib');
		
		$row = $result->row();
		
		if ($row) {
			$this->LotteryLib->lotteryId = $row->lottery_id;
			$this->LotteryLib->lotteryName = $row->lottery_name;
			$this->LotteryLib->restaurantId = $row->restaurant_id;
			$this->LotteryLib->restaurantName = $row->restaurant_name;
			$this->LotteryLib->cityId = $row->city_id;
			$this->LotteryLib->city = $row->city;
			$this->LotteryLib->stateCode = $row->state_code;
			$this->LotteryLib->info = $row->info;
			
			$this->LotteryLib->startDate = ( $row->start_date ? date('m/d/Y', strtotime($row->start_date) ) : '');
			$this->LotteryLib->endDate = ( $row->end_date ? date('m/d/Y', strtotime($row->end_date) ) : '');
			$this->LotteryLib->drawDate = ( $row->draw_date ? date('m/d/Y', strtotime($row->draw_date) ) : '');
			$this->LotteryLib->resultDate = ( $row->result_date ? date('m/d/Y', strtotime($row->result_date) ) : '');
			//print_r_pre($this->LotteryLib);die;
			
			$CI =& get_instance();
			
			$CI->load->model('PrizeModel','',true);
			$prizes = $CI->PrizeModel->getPrizesForLottery($row->lottery_id);
			$this->LotteryLib->prizes = $prizes;
			
			$CI->load->model('PhotoModel','',true);
			$prizes = $CI->PhotoModel->getLotteryPhotos($row->lottery_id);
			$this->LotteryLib->photos = $prizes;
			
			return $this->LotteryLib;
		} else {
			return;
		}
	}
	
	function updateLottery() {
		$return = true;
		
		$query = "SELECT * FROM lottery WHERE lottery_name = \"" . $this->input->post('lotteryName') . "\" AND restaurant_id = " . $this->input->post('restaurantId') . " AND lottery_id <> " . $this->input->post('lotteryId');
		log_message('debug', 'LotteryModel.updateLottery : Try to get Duplicate record : ' . $query);
		
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$startDate = $this->input->post('startDate');
			$endDate = $this->input->post('endDate');
			$drawDate = $this->input->post('drawDate');
			$resultDate = $this->input->post('resultDate');
			
			$query = "UPDATE lottery " .
					" SET " .
					" lottery_name = \"" . $this->input->post('lotteryName') . "\", " .
					" restaurant_id = " . $this->input->post('restaurantId') . ", " .
					" city_id = " . $this->input->post('cityId') . ", " .
					" info = \"" . $this->input->post('info') . "\", " .
					" start_date = " . ($startDate ? "'". date("Y-m-d 00:00:00", strtotime($startDate)) ."'" : 'NULL') . ", " . 
					" end_date = " . ($endDate ? "'". date("Y-m-d 23:59:59", strtotime($endDate)) ."'" : 'NULL') . ", " .
					" draw_date = " . ($drawDate ? "'". date("Y-m-d 00:00:00", strtotime($drawDate)) ."'" : 'NULL') . ", " .
					" result_date = " . ($resultDate ? "'". date("Y-m-d 00:00:00", strtotime($resultDate)) ."'" : 'NULL') .
					" WHERE " .
					" lottery_id = " . $this->input->post('lotteryId');
			
			log_message('debug', 'LotteryModel.updateLottery : ' . $query);
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
	
	function getLotteries() {
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
		
		$base_query = 'SELECT lottery.*, restaurant.restaurant_name, city.city, state.state_code ' .
				' FROM lottery, restaurant, city, state';
		
		$base_query_count = 'SELECT count(*) AS num_records' .
				' FROM lottery, restaurant, city, state';
		
		$where = ' WHERE lottery.restaurant_id = restaurant.restaurant_id' .
				' AND lottery.city_id = city.city_id' .
				' AND city.state_id = state.state_id' .
				' AND (start_date <= \''.date('Y-m-d').'\' AND end_date >= \''.date('Y-m-d').'\' )';
		
		/*
		if (! empty ($q) ) {
		$where .= ' AND (' 
				. '	lottery.lottery_name like "%' .$q . '%"'
				. ' OR restaurant.restaurant_name like "%' . $q . '%"'
				. ' OR state.state_code like "%' . $q . '%"'
				. ' OR city.city like "%' . $q . '%"'
				. ' )';
		}
		*/
		
		$base_query_count = $base_query_count . $where;
		
		$query = $base_query_count;
		
		$result = $this->db->query($query);
		$row = $result->row();
		$numResults = $row->num_records;
		
		$query = $base_query . $where;
		
		if ( empty($sort) ) {
			$sort_query = ' ORDER BY lottery_name';
			$sort = 'lottery_name';
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
		
		log_message('debug', "LotteryModel.getLotteriesJsonAdmin : " . $query);
		$result = $this->db->query($query);
		
		$lotteries = array();
		
		$CI =& get_instance();
		
		$geocodeArray = array();
		foreach ($result->result_array() as $row) {
			
			$this->load->library('LotteryLib');
			unset($this->LotteryLib);
			
			$this->LotteryLib->lotteryId = $row['lottery_id'];
			$this->LotteryLib->lotteryName = $row['lottery_name'];
			$this->LotteryLib->restaurantId = $row['restaurant_id'];
			$this->LotteryLib->restaurantName = $row['restaurant_name'];
			$this->LotteryLib->cityId = $row['city_id'];
			$this->LotteryLib->city = $row['city'];
			$this->LotteryLib->stateCode = $row['state_code'];
			
			
			$this->LotteryLib->startDate = ( $row['start_date'] ? date('m-d-Y', strtotime($row['start_date']) ) : '');
			$this->LotteryLib->endDate = ( $row['end_date'] ? date('m-d-Y', strtotime($row['end_date']) ) : '');
			$this->LotteryLib->drawDate = ( $row['draw_date'] ? date('m-d-Y', strtotime($row['draw_date']) ) : '');
			$this->LotteryLib->resultDate = ( $row['result_date'] ? date('m-d-Y', strtotime($row['result_date']) ) : '');
			
			$CI->load->model('PrizeModel','',true);
			$prizes = $CI->PrizeModel->getPrizesForLottery($row['lottery_id']);
			$this->LotteryLib->prizes = $prizes;
			
			$CI->load->model('PhotoModel','',true);
			$prizes = $CI->PhotoModel->getLotteryPhotos($row['lottery_id']);
			$this->LotteryLib->photos = $prizes;
			
			$lotteries[] = $this->LotteryLib;
			unset($this->LotteryLib);
		}
		
		if (!empty($pp) && $pp == 'all') {
			$PER_PAGE = $numResults;
		}
		
		$totalPages = ceil($numResults/$PER_PAGE);
		$first = 0;
		$last = $totalPages - 1;
		
		$params = requestToParams($numResults, $start, $totalPages, $first, $last, $page, $sort, $order, $q, '', '');
		$arr = array(
			'results'    => $lotteries,
			'param'      => $params,
		);
	    //print_r_pre($arr);
	    return $arr;
	}
	
	function enroll() {
		$return = true;
		
		$lotteryId = $this->input->post('lotteryId');
		$userId = $this->session->userdata('userId');
		$fbUserId = $this->input->post('fbUserId');
		$fbToken = $this->input->post('fbToken');
		
		if ($fbUserId) {
			
			$query = "SELECT * FROM lottery_entry WHERE lottery_id = " . $lotteryId . " AND facebook_user_id = " . $fbUserId;
			
			log_message('debug', 'LotteryModel.enroll : Try to get duplicate record : ' . $query);
			
			$result = $this->db->query($query);
			
			if ($result->num_rows() == 0) {
				$query = "INSERT INTO lottery_entry (entry_id, user_id, lottery_id, enrolled_on, facebook_user_id, facebook_token)" .
						" values (NULL, NULL, " . $lotteryId . ", NOW(), ".$fbUserId.",  '".$fbToken."')";
				
				log_message('debug', 'LotteryModel.enroll : Enroll : ' . $query);
				$return = true;
				
				if ( $this->db->query($query) ) {
					$return = true;
				} else {
					$return = false;
				}
				
			} else {
				$GLOBALS['error'] = 'already_enrolled';
				$return = false;
			}
			
		} else {
			$query = "SELECT * FROM lottery_entry WHERE lottery_id = " . $lotteryId . " AND user_id = " . $userId;
			log_message('debug', 'LotteryModel.enroll : Try to get duplicate record : ' . $query);
			
			$result = $this->db->query($query);
			
			if ($result->num_rows() == 0) {
				$query = "INSERT INTO lottery_entry (entry_id, user_id, lottery_id, enrolled_on, facebook_user_id, facebook_token)" .
						" values (NULL, ".$userId.", " . $lotteryId . ", NOW(), NULL, NULL )";
				
				log_message('debug', 'LotteryModel.enroll : Enroll : ' . $query);
				$return = true;
				
				if ( $this->db->query($query) ) {
					$return = true;
				} else {
					$return = false;
				}
				
			} else {
				$GLOBALS['error'] = 'already_enrolled';
				$return = false;
			}
		}
		
		return $return;
	}
	
	
}

?>