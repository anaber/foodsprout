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
		//$randomString = 't6jh91v8xzn4srpk';
		
		if (!empty($_FILES)) {
			
			$restaurantId = $this->input->post('restaurantId');
			$restaurantChainId = $this->input->post('restaurantChainId');
	        $manufactureId = $this->input->post('manufactureId');
	        $farmId = $this->input->post('farmId');
	        $farmersMarketId = $this->input->post('farmersMarketId');
	        $productId = $this->input->post('productId');
        	
			$tempFile = $_FILES['Filedata']['tmp_name'];
			
			if (!empty($restaurantId)) {
				$path = '/restaurant/photo/' . $restaurantId . '/';
			} else if (!empty($restaurantChainId)) {
	            $path = '/restaurant_chain/photo/' . $restaurantChainId . '/';
	        } else if (!empty($manufactureId)) {
	            $path = '/manufacture/photo/' . $manufactureId . '/';
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
			
			$originalPhotoName = $userId . '_' . $randomString . '_original' . '.png';
			$originalTargetFile = $originalTargetPath . $originalPhotoName;
			
			$mainPhotoName = $userId . '_' . $randomString . '.png';
			$mainTargetFile = $mainTargetPath . $mainPhotoName;
			
			$thumbPhotoName = $userId . '_' . $randomString . '_thumb' . '.png';
			$thumbTargetFile = $thumbTargetPath . $thumbPhotoName;
			//echo $originalTargetFile . "\n";
			//echo $thumbTargetFile . "\n";
			
			
			move_uploaded_file($tempFile, $originalTargetFile);
			copy($originalTargetFile, $mainTargetFile);
			//copy($originalTargetFile, $thumbTargetFile);
			//if ( createThumb($originalTargetFile, $thumbTargetFile,'300', '200') ) {
			if ( copy($originalTargetFile, $thumbTargetFile) ) {
			
				$arr = getimagesize($thumbTargetFile);
				$thumbWidth = $arr[0];
				$thumbHeight = $arr[1];
				
				$arr = getimagesize($mainTargetFile);
				$width = $arr[0];
				$height = $arr[1];
				$mime = $arr['mime'];
				
				
				$fileTypes  = str_replace('*.','',$_REQUEST['fileext']);
				$typesArray = explode(';',$fileTypes);
				$fileParts  = pathinfo($_FILES['Filedata']['name']);
				
				
				if (in_array($fileParts['extension'], $typesArray)) {
					
					$CI = & get_instance();
				
		            $query = 'INSERT INTO photo (photo_id, address_id, ';
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
		            } else if (!empty($farmId)) {
		                $query .= $farmId;
		            } else if (!empty($farmersMarketId)) {
		                $query .= $farmersMarketId;
		            } else if (!empty($productId)) {
		                $query .= $productId;
		            }
		            
		            $query .= ',  NULL, NULL, "' . $path . '", "' . $thumbPhotoName . '", "' . $mainPhotoName . '", "' . $originalPhotoName . '", "' . $fileParts['extension'] . '", "' . $mime . '", "' . $thumbHeight . '", "' . $thumbWidth . '", "' . $height . '", "' . $width . '", "' . $userId . '", "' . ( ($userGroup != 'admin') ? 'queue' : 'live' ) . '", "' . getRealIpAddr() . '", NOW() )';
		            
		            log_message('debug', 'CommentModel.addComemnt : Insert Comment : ' . $query);
		
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
	
	function getThumbPhotos($type, $id) {
		global $PER_PAGE;
		
		$query = 'SELECT photo.*' .
				' FROM photo' .
				' WHERE photo.'.$type.'_id  = ' . $id .
				' AND photo.status = \'live\'';
		
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
	
}



?>