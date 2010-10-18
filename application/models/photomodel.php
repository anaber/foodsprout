<?php

class PhotoModel extends Model{
	
	function getPhotosJson($type) {
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
		
		$start = 0;
		$page = 0;
		
		$base_query = 'SELECT photo.*, user.email, user.first_name' .
				' FROM photo, user';
		
		$base_query_count = 'SELECT count(*) AS num_records' .
				' FROM photo, user';
		
		
		$where = '';
		$where = ' WHERE photo.'.$type.'_id  = ' . $q;
		
		$where .= ' AND photo.status = \'live\'' .
				' AND photo.user_id = user.user_id ';
		
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
		
		log_message('debug', "PhotoModel.getPhotosJson : " . $query);
		$result = $this->db->query($query);
		
		$menu = array();
		
		foreach ($result->result_array() as $row) {
			
			$this->load->library('PhotoLib');
			unset($this->PhotoLib);
			
			$this->PhotoLib->commentId = $row['comment_id'];
			$this->PhotoLib->comment = $row['comment'];
			$this->PhotoLib->userId = $row['user_id'];
			
			$firstName = $row['first_name'];
			$arrFirstName = explode(' ', $firstName);
			$this->PhotoLib->firstName = $arrFirstName[0];
			
			$this->PhotoLib->email = $row['email'];
			$this->PhotoLib->ip = $row['track_ip'];
			$this->PhotoLib->status = $row['status'];
			$this->PhotoLib->addedOn = date('Y M, d H:i:s', strtotime ($row['added_on'] ) ) ;
			
			$menu[] = $this->PhotoLib;
			unset($this->PhotoLib);
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
	
	function addPhoto() {
		global $UPLOAD_FOLDER;
		$return = true;
		
		$userId = $this->input->post('userId');
		$userGroup = $this->input->post('userGroup');
		
		$randomString = generateRandomString();
		$randomString = 'vz5hmxr04w9jysgc';
		
		if (!empty($_FILES)) {
			
			$restaurantId = $this->input->post('restaurantId');
			$restaurantChainId = $this->input->post('restaurantChainId');
	        $manufactureId = $this->input->post('manufactureId');
	        $farmId = $this->input->post('farmId');
	        $farmersMarketId = $this->input->post('farmersMarketId');
        	
			$tempFile = $_FILES['Filedata']['tmp_name'];
			
			if (!empty($restaurantId)) {
				$targetPath = $UPLOAD_FOLDER . '/restaurant/photo/' . $restaurantId . '/';
	        } else if (!empty($restaurantChainId)) {
	            $targetPath = $UPLOAD_FOLDER . '/restaurant_chain/photo/' . $restaurantChainId . '/';
	        } else if (!empty($manufactureId)) {
	            $targetPath = $UPLOAD_FOLDER . '/manufacture/photo/' . $manufactureId . '/';
	        } else if (!empty($farmId)) {
	            $targetPath = $UPLOAD_FOLDER . '/farm/photo/' . $farmId . '/';
	        } else if (!empty($farmersMarketId)) {
	            $targetPath = $UPLOAD_FOLDER . '/farmers_market/photo/' . $farmersMarketId . '/';
	        }
			
			$originalTargetPath = $targetPath . 'original/';
			$mainTargetPath = $targetPath . 'main/';
			$thumbTargetPath = $targetPath . 'thumb/';
			
			if ( !file_exists($originalTargetPath) ) {
				mkdir(str_replace('//','/',$originalTargetPath), 0755, true);
			}
			if ( !file_exists($mainTargetPath) ) {
				mkdir(str_replace('//','/',$mainTargetPath), 0755, true);
			}
			if ( !file_exists($thumbTargetPath) ) {
				mkdir(str_replace('//','/',$thumbTargetPath), 0755, true);
			}
			
			$originalTargetFile = $originalTargetPath . $userId . '_' . $randomString . '_original' . '.png';
			$mainTargetFile = $mainTargetPath . $userId . '_' . $randomString . '.png';
			$thumbTargetFile = $thumbTargetPath . $userId . '_' . $randomString . '_thumb' . '.png';
			
			//move_uploaded_file($tempFile, $originalTargetFile);
			//copy($originalTargetFile, $mainTargetFile);
			//copy($originalTargetFile, $thumbTargetFile);
			
			$arr = getimagesize($originalTargetFile);
			//print_r_pre($arr);
			$width = $arr[0];
			$height = $arr[1];
			$mime = $arr['mime'];
			return true;
			
			// $fileTypes  = str_replace('*.','',$_REQUEST['fileext']);
			// $fileTypes  = str_replace(';','|',$fileTypes);
			// $typesArray = split('\|',$fileTypes);
			// $fileParts  = pathinfo($_FILES['Filedata']['name']);
			
			//if (in_array($fileParts['extension'], $typesArray)) {
			//	return true;
			//} else {
			//	echo 'Invalid file type.';
			//}
		}
		
		/*
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
            $query .= 'restaurant_id';
        } else if (!empty($restaurantChainId)) {
            $query .= 'restaurant_chain_id';
        } else if (!empty($manufactureId)) {
            $query .= 'manufacture_id';
        } else if (!empty($farmId)) {
            $query .= 'farm_id';
        } else if (!empty($farmersMarketId)) {
            $query .= 'farmers_market_id';
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
                $query .= 'restaurant_id';
            } else if (!empty($restaurantChainId)) {
                $query .= 'restaurant_chain_id';
            } else if (!empty($manufactureId)) {
                $query .= 'manufacture_id';
            } else if (!empty($farmId)) {
                $query .= 'farm_id';
            } else if (!empty($farmersMarketId)) {
                $query .= 'farmers_market_id';
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
                $return = true;
            } else {
                $return = false;
            }
        } else {
            $GLOBALS['error'] = 'duplicate';
            $return = false;
        }
		*/
        return $return;
        
    }
	
}



?>