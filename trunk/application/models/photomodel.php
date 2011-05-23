<?php

class PhotoModel extends Model{
	
	/**
	 * Migration: 		Done
	 * Migrated by: 	Deepak
	 * 
	 * Verified: 		Yes
	 * Verified By: 	Deepak
	 */
	function getPhotosJson($type, $producerId = null) {
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
		if (!$q) {
			$q = $this->input->get('q');
		}
		//$q = '174538';
		if ($q == '0') {
			$q = '';
		}
		if (!$q) {
			$q = $producerId;
		}
		
		
		$CI =& get_instance();
		
		$start = 0;
		$page = 0;
		
		$base_query = 'SELECT photo.*, user.email, user.first_name' .
				' FROM photo, user';
		
		$base_query_count = 'SELECT count(*) AS num_records' .
				' FROM photo, user';
		
		
		$where = ' WHERE ';
		if ($type == 'product') {
			$where .= ' photo.product_id  = ' . $q;
		} else {
			$where .= ' photo.producer_id  = ' . $q;
		}
		
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
			$path = '/uploads' . $row['path'];
			$this->PhotoLib->photoId = $row['photo_id'];
			$this->PhotoLib->path = $path;
			
			$this->PhotoLib->thumbPhoto = $path . 'thumb/' . $row['thumb_photo_name'];
			$this->PhotoLib->thumbHeight = $row['thumb_height'];
			$this->PhotoLib->thumbWidth = $row['thumb_width'];
			
			$this->PhotoLib->photo = $path . 'main/' . $row['photo_name'];
			$this->PhotoLib->height = $row['height'];
			$this->PhotoLib->width = $row['width'];
			
			$this->PhotoLib->title = $row['title'];
			$this->PhotoLib->description = $row['description'];
			
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
	
	function getPhotosAdminJson($type) {
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
		
		if ($this->input->post('filter') && $this->input->post('filter') != "all") {
			$filter = $this->input->post('filter');
		} else {
			$filter = '';
		}
		
		
		$q = $this->input->post('q'); 
		if (!$q) {
			$q = $this->input->get('q');
		}
				
		
		$CI =& get_instance();
		
		$start = 0;
		$page = 0;
		
		$base_query = 'SELECT photo.*, user.email, user.first_name' .
				' FROM photo, user';
		
		$base_query_count = 'SELECT count(*) AS num_records' .
				' FROM photo, user';
		
		
		$where = ' WHERE ';
		
		if ($filter != '')
		{
			$where .= ' status = "'.$filter.'" AND';
		}
		
		$where .= ' photo.user_id = user.user_id ';
		
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
			$path = '/uploads' . $row['path'];
			$this->PhotoLib->photoId = $row['photo_id'];
			$this->PhotoLib->path = $path;
			
			$this->PhotoLib->thumbPhoto = $path . 'thumb/' . $row['thumb_photo_name'];
			$this->PhotoLib->thumbHeight = $row['thumb_height'];
			$this->PhotoLib->thumbWidth = $row['thumb_width'];
			
			$this->PhotoLib->photo = $path . 'main/' . $row['photo_name'];
			$this->PhotoLib->height = $row['height'];
			$this->PhotoLib->width = $row['width'];
			
			$this->PhotoLib->title = $row['title'];
			$this->PhotoLib->description = $row['description'];
			
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
	
	/**
	 * Migration: 		Done
	 * Migrated by: 	Deepak
	 * 
	 * Verified: 		Yes
	 * Verified By: 	Deepak
	 */
	function addPhoto() {
		global $UPLOAD_FOLDER;
		$return = true;
		
		$userId = $this->input->post('userId');
		$access = $this->input->post('access');
		
		$randomString = generateRandomString();
		//$randomString = 't6jh91v8xzn4srpk';
		
		if (!empty($_FILES)) {
			
			$restaurantId = $this->input->post('restaurantId');
			$restaurantChainId = $this->input->post('restaurantChainId');
	        $manufactureId = $this->input->post('manufactureId');
	        $distributorId = $this->input->post('distributorId');
	        $farmId = $this->input->post('farmId');
	        $farmersMarketId = $this->input->post('farmersMarketId');
	        $productId = $this->input->post('productId');
        	
			$tempFile = $_FILES['Filedata']['tmp_name'];
			$fileParts  = pathinfo($_FILES['Filedata']['name']);
			
			if (!empty($restaurantId)) {
				$path = '/restaurant/photo/' . $restaurantId . '/';
			} else if (!empty($restaurantChainId)) {
	            $path = '/restaurant_chain/photo/' . $restaurantChainId . '/';
	        } else if (!empty($manufactureId)) {
	            $path = '/manufacture/photo/' . $manufactureId . '/';
	        }  else if (!empty($distributorId)) {
	            $path = '/distributor/photo/' . $distributorId . '/';
	        } else if (!empty($farmId)) {
	            $path = '/farm/photo/' . $farmId . '/';
	        } else if (!empty($farmersMarketId)) {
	            $path = '/farmers_market/photo/' . $farmersMarketId . '/';
	        }
	        
			$targetPath = $UPLOAD_FOLDER . $path;
			
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
			
			$originalPhotoName = $userId . '_' . $randomString . '_original' . '.' . $fileParts['extension'];
			$originalTargetFile = $originalTargetPath . $originalPhotoName;
			
			$mainPhotoName = $userId . '_' . $randomString . '.' . $fileParts['extension'];
			$mainTargetFile = $mainTargetPath . $mainPhotoName;
			
			$thumbPhotoName = $userId . '_' . $randomString . '_thumb' . '.' . $fileParts['extension'];
			$thumbTargetFile = $thumbTargetPath . $thumbPhotoName;
			
			move_uploaded_file($tempFile, $originalTargetFile);
			copy($originalTargetFile, $mainTargetFile);
			
			$arr = getimagesize($mainTargetFile);
			$width = $arr[0];
			$height = $arr[1];
			$mime = $arr['mime'];
			
			//if ( createThumb($originalTargetFile, $thumbTargetFile,'300', '200', $width, $height) ) {
			//if ( copy($originalTargetFile, $thumbTargetFile) ) {
			if ( createThumb($originalTargetFile, $thumbTargetFile) ) {
				$arr = getimagesize($thumbTargetFile);
				$thumbWidth = $arr[0];
				$thumbHeight = $arr[1];
				
				$fileTypes  = str_replace('*.','',$_REQUEST['fileext']);
				$typesArray = explode(';',$fileTypes);
				
				if (in_array($fileParts['extension'], $typesArray)) {
					
					$CI = & get_instance();
				
		            $query = 'INSERT INTO photo (photo_id, address_id, ';
		            if (!empty($restaurantId)) {
		                $query .= 'producer_id';
		            } else if (!empty($restaurantChainId)) {
		                $query .= 'producer_id';
		            } else if (!empty($manufactureId)) {
		                $query .= 'producer_id';
		            } else if (!empty($distributorId)) {
		                $query .= 'producer_id';
		            } else if (!empty($farmId)) {
		                $query .= 'producer_id';
		            } else if (!empty($farmersMarketId)) {
		                $query .= 'producer_id';
		            } else if (!empty($productId)) {
		                $query .= 'product_id';
		            }
		            
		            $query .= ', title, description, path, thumb_photo_name, photo_name, original_photo_name, extension, mime_type, thumb_height, thumb_width, height, width, user_id, status, track_ip, added_on)' .
		                    ' values (NULL, NULL, ';
		
		            if (!empty($restaurantId)) {
		                $query .= $restaurantId;
		            } else if (!empty($restaurantChainId)) {
		                $query .= $restaurantChainId;
		            } else if (!empty($manufactureId)) {
		                $query .= $manufactureId;
		            } else if (!empty($distributorId)) {
		                $query .= $distributorId;
		            } else if (!empty($farmId)) {
		                $query .= $farmId;
		            } else if (!empty($farmersMarketId)) {
		                $query .= $farmersMarketId;
		            } else if (!empty($productId)) {
		                $query .= $productId;
		            }
		            
		            $query .= ',  NULL, NULL, "' . $path . '", "' . $thumbPhotoName . '", "' . $mainPhotoName . '", "' . $originalPhotoName . '", "' . $fileParts['extension'] . '", "' . $mime . '", "' . $thumbHeight . '", "' . $thumbWidth . '", "' . $height . '", "' . $width . '", "' . $userId . '", "' . ( ($access != 'admin') ? 'queue' : 'live' ) . '", "' . getRealIpAddr() . '", NOW() )';
		            
		            log_message('debug', 'PhotoModel.addPhoto : Insert Photo : ' . $query);
		
		            if ($this->db->query($query)) {
		                $newPhotoId = $this->db->insert_id();
		                
		                $array = array(
							'photoId' => $newPhotoId, 
							'thumbPhoto' =>  '/uploads' . $path . 'thumb/' .$thumbPhotoName,
							'thumbHeight' =>  $thumbHeight,
							'thumbWidth' =>  $thumbWidth,
							);
					
		                $return = $array;
		            } else {
		                $return = false;
		            }
					
				} else {
					$return = false;
				}
			} else {
				$return = false;
			}
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
    function updatePhotoTitle() {
		$return = true;
		
		$data = array(
					'title' => $this->input->post('photoTitle'), 
					'description' => $this->input->post('description'),
				);
		$where = "photo_id = " . $this->input->post('photoId');
		$query = $this->db->update_string('photo', $data, $where);
		
		log_message('debug', 'PhotoModel.updatePhotoTitle : ' . $query);
		if ( $this->db->query($query) ) {
			$return = true;
		} else {
			$return = false;
		}
				
		return $return;
	}
	
	function getThumbPhotos($type, $id = "") {
		global $PER_PAGE;
		
		$query = 'SELECT photo.*' .
				' FROM photo' .
				' WHERE photo.'.$type.'_id  = \'' . $id .
				'\' AND photo.status = \'live\'';
		
		$result = $this->db->query($query);
		
		if ( empty($sort) ) {
			$sort_query = ' ORDER BY added_on';
			$sort = 'added_on';
		}
		
		if ( empty($order) ) {
			$order = 'DESC';
		}
		
		$query = $query . ' ' . $sort_query . ' ' . $order;
		
		log_message('debug', "PhotoModel.getThumbPhotos : " . $query);
		$result = $this->db->query($query);
		
		$photos = array();
		
		foreach ($result->result_array() as $row) {
			
			$this->load->library('PhotoLib');
			unset($this->PhotoLib);
			$path = '/uploads' . $row['path'];
			$this->PhotoLib->photoId = $row['photo_id'];
			$this->PhotoLib->path = $path;
			
			$this->PhotoLib->thumbPhoto = $path . 'thumb/' . $row['thumb_photo_name'];
			$this->PhotoLib->thumbHeight = $row['thumb_height'];
			$this->PhotoLib->thumbWidth = $row['thumb_width'];
			
			$this->PhotoLib->title = $row['title'];
			
			
			$photos[] = $this->PhotoLib;
			unset($this->PhotoLib);
		}
		
		
	    return $photos;
	}
	
	function addLotteryPhotoFromTemp($lotteryId, $mainPhotoName) {
    	global $UPLOAD_FOLDER;
		$return = true;
		
    	$arr = explode('.', $mainPhotoName);
    	
    	$randomString = $arr[0];
    	$extension = $arr[1];
    	
    	$path = '/lottery/photo/' . $lotteryId . '/';
    	$targetPath = $UPLOAD_FOLDER . $path;
			
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
		$originalPhotoName = $lotteryId . '_' . $randomString . '_original' . '.' . $extension;
		$originalTargetFile = $originalTargetPath . $originalPhotoName;
		
		$mainPhotoName = $lotteryId . '_' . $randomString . '.' . $extension;
		$mainTargetFile = $mainTargetPath . $mainPhotoName;
		
		$thumbPhotoName = $lotteryId . '_' . $randomString . '_thumb' . '.' . $extension;
		$thumbTargetFile = $thumbTargetPath . $thumbPhotoName;
		
		$tempOriginalFileName = $UPLOAD_FOLDER . '/lottery/temp/original/' . $randomString . '_original' . '.' . $extension;
		$tempMainFileName = $UPLOAD_FOLDER . '/lottery/temp/main/' . $randomString . '.' . $extension;
		$tempThumbFileName = $UPLOAD_FOLDER . '/lottery/temp/thumb/' . $randomString . '_thumb' . '.' . $extension;
		
		rename($tempOriginalFileName, $originalTargetFile);
		rename($tempMainFileName, $mainTargetFile);
		rename($tempThumbFileName, $thumbTargetFile);
		
		$arr = getimagesize($mainTargetFile);
		$width = $arr[0];
		$height = $arr[1];
		$mime = $arr['mime'];
		
		$arr = getimagesize($thumbTargetFile);
		$thumbWidth = $arr[0];
		$thumbHeight = $arr[1];
		
		
		$query = 'INSERT INTO lottery_photo (lottery_photo_id, ';
        if (!empty($lotteryId)) {
            $query .= 'lottery_id';
        } 
        
        $query .= ', path, thumb_photo_name, photo_name, original_photo_name, extension, mime_type, thumb_height, thumb_width, height, width, added_on)' .
                ' values (NULL, ';

        if (!empty($lotteryId)) {
            $query .= $lotteryId;
        } 
        
        $query .= ', "' . $path . '", "' . $thumbPhotoName . '", "' . $mainPhotoName . '", "' . $originalPhotoName . '", "' . $extension . '", "' . $mime . '", "' . $thumbHeight . '", "' . $thumbWidth . '", "' . $height . '", "' . $width . '", NOW() )';
        
        log_message('debug', 'PhotoModel.addLotteryPhoto : Add Photo : ' . $query);
        if ($this->db->query($query)) {
            $return = true;
        } else {
            $return = false;
        }
    }
    
	function addUpdateLotteryPhoto() {
		global $UPLOAD_FOLDER;
		$return = true;
		
		$randomString = generateRandomString();
		
		if (!empty($_FILES)) {
			
			$lotteryId = $this->input->post('lotteryId');
			$photoId = $this->input->post('photoId');
			//echo "Lottery:" . $lotteryId . "\n";
			
			$tempFile = $_FILES['Filedata']['tmp_name'];
			$fileParts = pathinfo($_FILES['Filedata']['name']);
			
			if (!empty($lotteryId)) {
				$path = '/lottery/photo/' . $lotteryId . '/';
			} else if (empty($lotteryId)) {
	            $path = '/lottery/temp/';
	        } 
	        
			$targetPath = $UPLOAD_FOLDER . $path;
			
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
			
			if (!empty($lotteryId)) {
				$originalPhotoName = $lotteryId . '_' . $randomString . '_original' . '.' . $fileParts['extension'];
			} else {
				$originalPhotoName = $randomString . '_original' . '.' . $fileParts['extension'];
			}
			$originalTargetFile = $originalTargetPath . $originalPhotoName;
			
			if (!empty($lotteryId)) {
				$mainPhotoName = $lotteryId . '_' . $randomString . '.' . $fileParts['extension'];
			} else {
				$mainPhotoName = $randomString . '.' . $fileParts['extension'];
			}
			$mainTargetFile = $mainTargetPath . $mainPhotoName;
			
			if (!empty($lotteryId)) {
				$thumbPhotoName = $lotteryId . '_' . $randomString . '_thumb' . '.' . $fileParts['extension'];
			} else {
				$thumbPhotoName = $randomString . '_thumb' . '.' . $fileParts['extension'];
			}
			$thumbTargetFile = $thumbTargetPath . $thumbPhotoName;
			
			move_uploaded_file($tempFile, $originalTargetFile);
			copy($originalTargetFile, $mainTargetFile);
			$arr = getimagesize($mainTargetFile);
			$width = $arr[0];
			$height = $arr[1];
			$mime = $arr['mime'];
			
			//if ( createThumb($originalTargetFile, $thumbTargetFile,'300', '200', $width, $height) ) {
			//if ( copy($originalTargetFile, $thumbTargetFile) ) {
			if ( createThumb($originalTargetFile, $thumbTargetFile)) {
				$arr = getimagesize($thumbTargetFile);
				$thumbWidth = $arr[0];
				$thumbHeight = $arr[1];
				
				$fileTypes  = str_replace('*.','',$_REQUEST['fileext']);
				$typesArray = explode(';',$fileTypes);
				
				if (in_array($fileParts['extension'], $typesArray)) {
					if (!empty($lotteryId)) {
						$CI = & get_instance();
						
						$query = "SELECT * FROM lottery_photo WHERE lottery_id = '" . $lotteryId . "'";
						log_message('debug', 'PhotoModel.addLotteryPhoto : Try to get duplicate Lottery Photo record : ' . $query);
						
						$result = $this->db->query($query);
						
						if ($result->num_rows() > 0) {
							
							$row = $result->result_array();
							$oldThumbPhoto = $UPLOAD_FOLDER . $row[0]['path'] . 'thumb/' . $row[0]['thumb_photo_name'];
							$oldPhoto = $UPLOAD_FOLDER . $row[0]['path'] . 'main/' . $row[0]['photo_name'];
							$oldOriginalPhoto = $UPLOAD_FOLDER . $row[0]['path'] . 'original/' . $row[0]['original_photo_name'];
							
							$data = array(
										'thumb_photo_name' => $thumbPhotoName, 
										'photo_name' => $mainPhotoName,
										'original_photo_name' => $originalPhotoName,
										'extension' => $fileParts['extension'] ,
										'mime_type' => $mime,
										'thumb_height' => $thumbHeight,
										'thumb_width' => $thumbWidth,
										'height' => $height,
										'width' => $width,
									);
									
							$where = "lottery_id = " . $lotteryId;
							$query = $this->db->update_string('lottery_photo', $data, $where);
							
							log_message('debug', 'PhotoModel.updateLotteryPhoto : Add Photo : ' . $query);
				            if ($this->db->query($query)) {
				                $array = array(
									'photoId' => $row[0]['photo_id'], 
									'thumbPhoto' =>  '/uploads' . $path . 'thumb/' .$thumbPhotoName,
									'thumbHeight' =>  $thumbHeight,
									'thumbWidth' =>  $thumbWidth,
									'mainPhotoName' => $mainPhotoName,
									);
								unlink($oldThumbPhoto);
								unlink($oldPhoto);
								unlink($oldOriginalPhoto);
								
				                $return = $array;
				            } else {
				                $return = false;
				            }
						} else {
							$query = 'INSERT INTO lottery_photo (lottery_photo_id, ';
				            if (!empty($lotteryId)) {
				                $query .= 'lottery_id';
				            } 
				            
				            $query .= ', path, thumb_photo_name, photo_name, original_photo_name, extension, mime_type, thumb_height, thumb_width, height, width, added_on)' .
				                    ' values (NULL, ';
				
				            if (!empty($lotteryId)) {
				                $query .= $lotteryId;
				            } 
				            
				            $query .= ', "' . $path . '", "' . $thumbPhotoName . '", "' . $mainPhotoName . '", "' . $originalPhotoName . '", "' . $fileParts['extension'] . '", "' . $mime . '", "' . $thumbHeight . '", "' . $thumbWidth . '", "' . $height . '", "' . $width . '", NOW() )';
				            
				            log_message('debug', 'PhotoModel.addLotteryPhoto : Add Photo : ' . $query);
				            if ($this->db->query($query)) {
				                $newPhotoId = $this->db->insert_id();
				                
				                $array = array(
									'photoId' => $newPhotoId, 
									'thumbPhoto' =>  '/uploads' . $path . 'thumb/' .$thumbPhotoName,
									'thumbHeight' =>  $thumbHeight,
									'thumbWidth' =>  $thumbWidth,
									'mainPhotoName' => $mainPhotoName,
									);
							
				                $return = $array;
				            } else {
				                $return = false;
				            }
						}
					} else {
						 $array = array(
							'photoId' => '', 
							'thumbPhoto' =>  '/uploads' . $path . 'thumb/' .$thumbPhotoName,
							'thumbHeight' =>  $thumbHeight,
							'thumbWidth' =>  $thumbWidth,
							'mainPhotoName' => $mainPhotoName,
							);
					
		                $return = $array;
					}
				} else {
					$return = false;
				}
				
			} else {
				$return = false;
			}
			
		}
        return $return;
    }
    
    function getLotteryPhotos($lotteryId) {
    	$query = "SELECT * FROM lottery_photo WHERE lottery_id = " . $lotteryId .
				" ORDER BY lottery_photo_id DESC";
		
		log_message('debug', "PhotoModel.getLotteryPhotos : " . $query);
		$result = $this->db->query($query);
		
		$lotteryPhotos = array();
		
		foreach ($result->result_array() as $row) {
			
			$this->load->library('PhotoLib');
			unset($this->PhotoLib);
			$path = '/uploads' . $row['path'];
			$this->PhotoLib->photoId = $row['lottery_photo_id'];
			$this->PhotoLib->path = $path;
			
			$this->PhotoLib->description = $row['description'];
			$this->PhotoLib->thumbPhoto = $path . 'thumb/' . $row['thumb_photo_name'];
			$this->PhotoLib->thumbHeight = $row['thumb_height'];
			$this->PhotoLib->thumbWidth = $row['thumb_width'];
			
			$this->PhotoLib->photo = $path . 'main/' . $row['photo_name'];
			$this->PhotoLib->height = $row['height'];
			$this->PhotoLib->width = $row['width'];
			
			$this->PhotoLib->addedOn = date('Y M, d H:i:s', strtotime ($row['added_on'] ) ) ;
			
			$lotteryPhotos[] = $this->PhotoLib;
			unset($this->PhotoLib);
		}
		return $lotteryPhotos;
    }
    
    function getPhotoByPhotoId($photo_id)
    {
    	$this->db->select('photo_id, path, thumb_photo_name, photo_name, original_photo_name');
    	$query = $this->db->get_where('photo', array('photo_id' => $photo_id));
    	
    	if ($query->num_rows() > 0)
    	{
    		return $query->row();
    	}
    	
    	return FALSE;
    }
    
    function deletePhoto($photo_id)
    {
    	global $UPLOAD_FOLDER;
    	
    	$photoInfo = $this->getPhotoByPhotoId($photo_id);
    	
    	if ($photoInfo) 
    	{    		
	    	$this->db->where("photo_id", $photo_id);
	    	$this->db->delete("photo");
	    	
	    	unlink($UPLOAD_FOLDER.$photoInfo->path."thumb/".$photoInfo->thumb_photo_name);
    		unlink($UPLOAD_FOLDER.$photoInfo->path."main/".$photoInfo->photo_name);
    		unlink($UPLOAD_FOLDER.$photoInfo->path."original/".$photoInfo->original_photo_name);
    	}
    	
    	return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }
    
    function approvePhoto($photo_id)
    {
    	$this->db->where("photo_id", $photo_id);
    	$this->db->set("status", "live");
    	$this->db->update("photo");
    	
    	return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }
    
	
}



?>