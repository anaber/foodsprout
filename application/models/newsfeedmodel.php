<?php
	class NewsfeedModel extends Model
	{
		function addNews()
		{
			$data = array(
				'news_feed_url' => $this->input->post('title'),
			   'news_feed_text' => $this->input->post('content'),
					  'user_id' => $this->session->userdata('userId'),
						 'date' => date('Y-m-d H:i:s', time()),
			);
			
			$this->db->insert('news_feed', $data);
			
		}
		
		function getNewsFeedJsonAdmin()
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
			
			$start = 0;
			$page = 0;
			
			$base_query = 'SELECT news_feed.*, user.first_name AS first_name, producer.producer AS producer, product.product_name AS product
						   FROM news_feed
						   JOIN user ON user.user_id = news_feed.user_id
						   LEFT JOIN producer ON producer.producer_id = news_feed.producer_id
						   LEFT JOIN product ON product.product_id = news_feed.product_id';
			
			$base_query_count = 'SELECT COUNT(*) AS num_records
						   FROM news_feed
						   JOIN user ON user.user_id = news_feed.user_id
						   LEFT JOIN producer ON producer.producer_id = news_feed.producer_id
						   LEFT JOIN product ON product.product_id = news_feed.product_id';
			
			/*$where = ' WHERE lottery.producer_id = producer.producer_id' .
					' AND lottery.city_id = city.city_id' .
					' AND city.state_id = state.state_id';*/
			$where = '';
			if (!empty ($q) ) {
			$where .= ' WHERE ' 
					. '	user.first_name like "%' .$q . '%"'
					. ' OR producer.producer like "%' . $q . '%"'
					. ' OR product.product_name like "%' . $q . '%"'
					. ' OR news_feed.news_feed_text like "%' . $q . '%"'
					. ' )';
			}
			
			$base_query_count = $base_query_count . $where;
			
			$query = $base_query_count;
			
			$result = $this->db->query($query);
			$row = $result->row();
			$numResults = $row->num_records;
			
			$query = $base_query . $where;
			
			if ( empty($sort) ) {
				$sort_query = ' ORDER BY news_feed.date';
				$sort = 'date';
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
			
			//echo $query;
			
			log_message('debug', "NewsfeedModel.getNewsFeedJsonAdmin : " . $query);
			$result = $this->db->query($query);
			
			$newsfeeds = array();
			
			$CI =& get_instance();
			
			$geocodeArray = array();
			foreach ($result->result() as $row) {
				$this->load->library('NewsfeedLib');
				unset($this->NewsfeedLib);
				
				$this->NewsfeedLib->newsFeedId = $row->news_feed_id;
				$this->NewsfeedLib->newsFeedTitle = $row->news_feed_url;
				$this->NewsfeedLib->newsFeedText = $row->news_feed_text;
				$this->NewsfeedLib->newsFeedProduct = $row->product;
				$this->NewsfeedLib->newsFeedProducer = $row->producer;
				$this->NewsfeedLib->newsFeedAuthor = $row->first_name;
				$this->NewsfeedLib->newsFeedDate = date('M d, Y', strtotime($row->date));
				
				$newsfeeds[] = $this->NewsfeedLib;
				unset($this->NewsfeedLib);
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
				'results'    => $newsfeeds,
				'param'      => $params,
				'geocode'	 => $geocodeArray,
		    );
		   
		    return $arr;
		}
	
	}
?>