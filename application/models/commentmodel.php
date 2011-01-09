<?php

class CommentModel extends Model{
	
	/**
	 * Migration: 		Done
	 * Migrated by: 	Deepak
	 * 
	 * Verified: 		Yes
	 * Verified By: 	Deepak
	 */
	function getCommentsJson($type) {
		global $PER_PAGE;
		
		$p = $this->input->post('p'); // Page
		$pp = $this->input->post('pp'); // Per Page
		$sort = $this->input->post('sort');
		$order = $this->input->post('order');
		
		$q = $this->input->post('q');
		//$q = '174538';
		if ($q == '0') {
			$q = '';
		}
		
		$CI =& get_instance();
		
		//$CI->load->model('RestaurantModel');
		//$restaurant = $CI->RestaurantModel->getRestaurantFromId($q);
		//$restaurantChainId = $restaurant->restaurantChainId;
		
		$start = 0;
		$page = 0;
		
		$base_query = 'SELECT comment.*, user.email, user.first_name' .
				' FROM comment, user';
		
		$base_query_count = 'SELECT count(*) AS num_records' .
				' FROM comment, user';
				
		$where = ' WHERE ';
		$where .= ' comment.producer_id  = ' . $q;
		
		$where .= ' AND comment.status = \'live\'' .
				' AND comment.user_id = user.user_id ';
		
		$base_query_count = $base_query_count . $where;
		
		$query = $base_query_count;
		
		$result = $this->db->query($query);
		$row = $result->row();
		$numResults = $row->num_records;
		
		$query = $base_query . $where;
		
		if ( empty($sort) ) {
			$sort_query = ' ORDER BY added_on';
			$sort = 'added_on';
		} else {
			$sort_query = ' ORDER BY ' . $sort;
		}
		
		if ( empty($order) ) {
			$order = 'DESC';
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
		
		log_message('debug', "CommentModel.getCommentsJson : " . $query);
		$result = $this->db->query($query);
		
		$menu = array();
		
		foreach ($result->result_array() as $row) {
			
			$this->load->library('CommentLib');
			unset($this->CommentLib);
			
			$this->CommentLib->commentId = $row['comment_id'];
			$this->CommentLib->comment = nl2br($row['comment']);
			$this->CommentLib->userId = $row['user_id'];
			
			$firstName = $row['first_name'];
			$arrFirstName = explode(' ', $firstName);
			$this->CommentLib->firstName = $arrFirstName[0];
			
			$this->CommentLib->email = $row['email'];
			$this->CommentLib->ip = $row['track_ip'];
			$this->CommentLib->status = $row['status'];
			$this->CommentLib->addedOn = date('Y M, d H:i:s', strtotime ($row['added_on'] ) ) ;
			
			$menu[] = $this->CommentLib;
			unset($this->CommentLib);
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
	
	/**
	 * Migration: 		Done
	 * Migrated by: 	Deepak
	 * 
	 * Verified: 		Yes
	 * Verified By: 	Deepak
	 */
	function addComment() {

        $return = true;
        
        $restaurantId = $this->input->post('restaurantId');
        $restaurantChainId = $this->input->post('restaurantChainId');
        $manufactureId = $this->input->post('manufactureId');
        $farmId = $this->input->post('farmId');
        $farmersMarketId = $this->input->post('farmersMarketId');
        $userId = $this->session->userdata['userId'];
          
        $CI = & get_instance();

        $query = 'SELECT * FROM comment ' .
                ' WHERE' .
                ' comment = "' . $this->input->post('comment') . '"' .
                ' AND ';
        if (!empty($restaurantId)) {
            $query .= 'producer_id ';
        } else if (!empty($restaurantChainId)) {
            $query .= 'producer_id ';
        } else if (!empty($manufactureId)) {
            $query .= 'producer_id ';
        } else if (!empty($farmId)) {
            $query .= 'producer_id ';
        } else if (!empty($farmersMarketId)) {
            $query .= 'producer_id';
        }
        $query .= ' = ';
        if (!empty($restaurantId)) {
            $query .= $restaurantId;
        } else if (!empty($restaurantChainId)) {
            $query .= $restaurantChainId;
        } else if (!empty($manufactureId)) {
            $query .= $manufactureId;
        } else if (!empty($farmId)) {
            $query .= $farmId;
        } else if (!empty($farmersMarketId)) {
            $query .= $farmersMarketId;
        }
        $query .= ' AND user_id = ' . $userId;
        
        log_message('debug', 'CommentModel.addComment : Try to get duplicate comment record : ' . $query);
        $result = $this->db->query($query);	
			
        if ($result->num_rows() == 0) {
        
            $query = 'INSERT INTO comment (comment_id, address_id, ';
            if (!empty($restaurantId)) {
                $query .= 'producer_id';
            } else if (!empty($restaurantChainId)) {
                $query .= 'producer_id';
            } else if (!empty($manufactureId)) {
                $query .= 'producer_id';
            } else if (!empty($farmId)) {
                $query .= 'producer_id';
            } else if (!empty($farmersMarketId)) {
                $query .= 'producer_id';
            }
            
            $query .= ', comment, user_id, status, track_ip, added_on)' .
                    ' values (NULL, NULL, ';

            if (!empty($restaurantId)) {
                $query .= $restaurantId;
            } else if (!empty($restaurantChainId)) {
                $query .= $restaurantChainId;
            } else if (!empty($manufactureId)) {
                $query .= $manufactureId;
            } else if (!empty($farmId)) {
                $query .= $farmId;
            } else if (!empty($farmersMarketId)) {
                $query .= $farmersMarketId;
            }
            
            $userGroup = $this->session->userdata['userGroup'];
            
            $query .= ',  "' . $this->input->post('comment') . '", "' . $this->session->userdata('userId') . '", "' . ( ($userGroup != 'admin') ? 'queue' : 'live' ) . '", "' . getRealIpAddr() . '", NOW() )';
            
            log_message('debug', 'CommentModel.addComemnt : Insert Comment : ' . $query);

            if ($this->db->query($query)) {
                $newCommentId = $this->db->insert_id();
                $return = $newCommentId;
            } else {
                $return = false;
            }
        } else {
            $GLOBALS['error'] = 'duplicate';
            $return = false;
        }
		
        return $return;
        
    }
    
    /**
	 * Migration: 		Done
	 * Migrated by: 	Deepak
	 * 
	 * Verified: 		Yes
	 * Verified By: 	Deepak
	 */
    function getCommentFromId($commentId) {
		
		$query = 'SELECT comment.*, user.email, user.first_name' .
				' FROM comment, user' . 
				' WHERE comment.user_id = user.user_id ' .
				' AND comment.comment_id = ' . $commentId;
		
		log_message('debug', "CommentModel.getCommentFromId : " . $query);
		$result = $this->db->query($query);
		
		$comment = array();
		
		$this->load->library('CommentLib');
		
		$row = $result->row();
		
		$this->CommentLib->commentId = $row->comment_id;
		$this->CommentLib->comment = nl2br($row->comment);
		$this->CommentLib->userId = $row->user_id;
		
		$firstName = $row->first_name;
		$arrFirstName = explode(' ', $firstName);
		$this->CommentLib->firstName = $arrFirstName[0];
		
		$this->CommentLib->email = $row->email;
		$this->CommentLib->ip = $row->track_ip;
		$this->CommentLib->status = $row->status;
		$this->CommentLib->addedOn = date('Y M, d H:i:s', strtotime ($row->added_on ) ) ;
		
		return $this->CommentLib;
	}
	
}



?>