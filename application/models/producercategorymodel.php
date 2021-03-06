<?php

class ProducerCategoryModel extends Model{
	
	/**
	 * Migration: 		Done
	 * Migrated by: 	Deepak
	 * 
	 * Verified: 		Yes
	 * Verified By: 	Deepak
	 */
	// List all the facility_type in the database
	function listProducerCategory($categotyType, $c) {
		global $PRODUCER_CATEGORY_GROUP;
		
		if ( isset($c) && !empty ($c) ) {
			$query = "SELECT * FROM producer_category WHERE category_group1 = " . $PRODUCER_CATEGORY_GROUP[$categotyType] . " ORDER BY producer_category LIMIT 0, $c";
		} else {
			$query = "SELECT * FROM producer_category WHERE category_group1 = " . $PRODUCER_CATEGORY_GROUP[$categotyType] . " ORDER BY producer_category";
		}

		log_message('debug', "ProducerCategoryModel.listProducerCategory : " . $query);
		$result = $this->db->query($query);
		
		$producerCategories = array();
		
		foreach ($result->result_array() as $row) {
			if ($categotyType == 'CUISINE') {
				$this->load->library('CuisineLib');
				unset($this->CuisineLib);

				$this->CuisineLib->cuisineProductCategoryId = $row['producer_category_id'];
				$this->CuisineLib->cuisineId = $row['cuisine_id'];
				$this->CuisineLib->cuisineName = $row['producer_category'];
				
				$producerCategories[] = $this->CuisineLib;
				unset($this->CuisineLib);
			} else if ($categotyType == 'RESTAURANT') {
				$this->load->library('RestaurantTypeLib');
				unset($this->restaurantTypeLib);

				$this->restaurantTypeLib->restaurantProductCategoryId = $row['producer_category_id'];
				$this->restaurantTypeLib->restaurantTypeId = $row['restaurant_type_id'];
				$this->restaurantTypeLib->restaurantTypeName = $row['producer_category'];
				
				$producerCategories[] = $this->restaurantTypeLib;
				unset($this->restaurantTypeLib);
			} else if ($categotyType == 'FARM') {
				$this->load->library('FarmTypeLib');
				unset($this->farmTypeLib);
				
				$this->farmTypeLib->farmTypeId = $row['producer_category_id'];
				$this->farmTypeLib->farmType = $row['producer_category'];
				
				$producerCategories[] = $this->farmTypeLib;
				unset($this->farmTypeLib);
			} else if ($categotyType == 'MANUFACTURE') {
				$this->load->library('ManufactureTypeLib');
				unset($this->manufactureTypeLib);

				$this->manufactureTypeLib->manufactureTypeId = $row['producer_category_id'];
				$this->manufactureTypeLib->manufactureType = $row['producer_category'];
				
				$producerCategories[] = $this->manufactureTypeLib;
				unset($this->manufactureTypeLib);
			} else if ($categotyType == 'FARM_CROP') {
				$this->load->library('FarmTypeLib');
				unset($this->farmTypeLib);

				$this->farmTypeLib->farmCropId = $row['producer_category_id'];
				$this->farmTypeLib->farmCrop = $row['producer_category'];
				
				$producerCategories[] = $this->farmTypeLib;
				unset($this->farmTypeLib);
			} else if ($categotyType == 'CERTIFICATION') {
				$this->load->library('FarmTypeLib');
				unset($this->farmTypeLib);

				$this->farmTypeLib->certificationId = $row['producer_category_id'];
				$this->farmTypeLib->certification = $row['producer_category'];
				
				$producerCategories[] = $this->farmTypeLib;
				unset($this->farmTypeLib);
			}
		}
		return $producerCategories;
	}
	
	
	function listProducerCategoryAdmin() {

		$this->db->select("producer_category.*, producer_category_group.producer_category_group");
		$this->db->from('producer_category');
		$this->db->join('producer_category_group', 'producer_category.category_group1 = producer_category_group.producer_category_group_id');
		$this->db->group_by('producer_category.producer_category_id');
		$this->db->order_by('producer_category_group');
		$result = $this->db->get();
		log_message('debug', "ProducerCategoryModel.listProducerCategoryAdmin : " . $this->db->last_query());
		
		$producerCategories = array();
		
		foreach ($result->result_array() as $row) {

			$this->load->library('ProducerCategoryLib');

			$this->ProducerCategoryLib->producerCategoryId = $row['producer_category_id'];
			$this->ProducerCategoryLib->producerCategory = $row['producer_category'];
			$this->ProducerCategoryLib->producerCategoryGroup = $row['producer_category_group'];
			$this->ProducerCategoryLib->producerCategoryGroupId = $row['category_group1'];
			
			if( !empty($row['cuisine_id']) )
				$this->ProducerCategoryLib->producerCategoryType = 'cuisine';
			elseif( !empty($row['restaurant_type_id']) )
				$this->ProducerCategoryLib->producerCategoryType = 'restaurant';
			elseif( !empty($row['farm_type_id']) )
				$this->ProducerCategoryLib->producerCategoryType = 'farm';
			elseif( !empty($row['manufacture_type_id']) )
				$this->ProducerCategoryLib->producerCategoryType = 'manufacture';


			$producerCategories[] = $this->ProducerCategoryLib;
			unset($this->ProducerCategoryLib);
		}
		
		return $producerCategories;
	}
	
	// need to add comments
	function listProducerCategoryGroupAdmin() {

		$this->db->select("producer_category_group.*");
		$this->db->from('producer_category_group');
		$this->db->order_by('producer_category_group');
		$result = $this->db->get();
		log_message('debug', "ProducerCategoryModel.listProducerCategoryGroupAdmin : " . $this->db->last_query());
		
		$producerCategoryGroups = array();
		
		foreach ($result->result_array() as $row) {

			$this->load->library('ProducerCategoryGroupLib');

			$this->ProducerCategoryGroupLib->producerCategoryGroupId = $row['producer_category_group_id'];
			$this->ProducerCategoryGroupLib->producerCategoryGroup = $row['producer_category_group'];

			$producerCategoryGroups[] = $this->ProducerCategoryGroupLib;
			unset($this->ProducerCategoryGroupLib);
		}
		
		return $producerCategoryGroups;
	}
	
	function addProducerCategory() {
		$rs = $this->db->get_where('producer_category', array("producer_category"=>$this->input->post('producerCategory')))->result_array();

		if( empty($rs) ) {
			log_message('debug', "ProducerCategoryModel.addProducerCategory, try to get duplicate : " . $this->db->last_query());
			
			$this->db->where('category_group1', $this->input->post('producerCategoryGroup'));
			$this->db->from('producer_category');
			$t_count = $this->db->count_all_results() + 1;

			if( $this->input->post('producerCategoryGroup') == 1 )		// CUISINE
				$data['cuisine_id'] = $t_count;
			elseif( $this->input->post('producerCategoryGroup') == 2 )	// RESTAURANT
				$data['restaurant_type_id'] = $t_count;
			elseif( $this->input->post('producerCategoryGroup') == 3 )	// FARM
				$data['farm_type_id'] = $t_count;
			elseif( $this->input->post('producerCategoryGroup') == 4 )	// MANUFACTURE
				$data['manufacture_type_id'] = $t_count;

			$data['producer_category'] = $this->input->post('producerCategory');
			$data['category_group1'] = $this->input->post('producerCategoryGroup');

			
			if( $this->db->insert('producer_category', $data) )
				$return = true;

		}else{
			$GLOBALS['error'] = 'duplicate';
			$return = false;
		}

		return $return;
	}
	
	// This will insert a new producer category group into the database
	function addProducerCategoryGroup() {
		$rs = $this->db->get_where('producer_category_group', array("producer_category_group"=>$this->input->post('producerCategoryGroup')))->result_array();
		
		if( empty($rs) ) {
			log_message('debug', "ProducerCategoryModel.addProducerCategoryGroup, tried to add a duplicate : " . $this->db->last_query());

			$data['producer_category_group'] = $this->input->post('producerCategoryGroup');
			
			if($this->db->insert('producer_category_group', $data) )
				$return = true;

		}else{
			$GLOBALS['error'] = 'duplicate';
			$return = false;
		}

		return $return;
	}
	
	
	function updateProducerCategory() {
		$rs = $this->db->get_where('producer_category', array("producer_category"=>$this->input->post('producerCategory'), "producer_category_id != "=>$this->input->post('producerCategoryId')))->result_array();

		if( empty($rs) ) {
			log_message('debug', "ProducerCategoryModel.updateProducerCategory, try to get duplicate : " . $this->db->last_query());
			
			$data['producer_category'] = $this->input->post('producerCategory');
			$data['category_group1'] = $this->input->post('producerCategoryGroup');

			$this->db->where(array('producer_category_id'=>$this->input->post('producerCategoryId')));

			if( $this->db->update('producer_category', $data) )
				$return = true;


		} else {
			$GLOBALS['error'] = 'duplicate';
			$return = false;
		}

		return $return;
	}

	function updateProducerCategoryGroup() {
		$rs = $this->db->get_where('producer_category_group', array("producer_category_group"=>$this->input->post('producerCategoryGroup'), "producer_category_group_id != "=>$this->input->post('producerCategoryGroupId')))->result_array();

		if( empty($rs) ) {
			log_message('debug', "ProducerCategoryModel.updateProducerCategoryGroup, try to get duplicate : " . $this->db->last_query());
			
			$data['producer_category_group'] = $this->input->post('producerCategoryGroup');

			$this->db->where(array('producer_category_group_id'=>$this->input->post('producerCategoryGroupId')));

			if( $this->db->update('producer_category_group', $data) )
				$return = true;

		}else{
			$GLOBALS['error'] = 'duplicate';
			$return = false;
		}

		return $return;
	}
	
	function getProducerCategoryFromId($id) {

		$this->db->select("producer_category.*, producer_category_group.producer_category_group");
		$this->db->from('producer_category');
		$this->db->join('producer_category_group', 'producer_category.category_group1 = producer_category_group.producer_category_group_id');
		$this->db->where('producer_category_id', $id);
		$this->db->group_by('producer_category.producer_category_id');
		$this->db->order_by('category_group1, producer_category');
		$result = $this->db->get();
		log_message('debug', "ProducerCategoryModel.listProducerCategoryAdmin : " . $this->db->last_query());
		
		$producerCategories = array();
		
		foreach ($result->result_array() as $row) {

			$this->load->library('ProducerCategoryLib');

			$this->ProducerCategoryLib->producerCategoryId = $row['producer_category_id'];
			$this->ProducerCategoryLib->producerCategory = $row['producer_category'];
			$this->ProducerCategoryLib->producerCategoryGroup = $row['producer_category_group'];
			$this->ProducerCategoryLib->producerCategoryGroupId = $row['category_group1'];

			$producerCategories[] = $this->ProducerCategoryLib;
			unset($this->ProducerCategoryLib);
		}
		
		return $producerCategories[0];
	}
	
	function getProducerCategoryGroupFromId($id) {

		$this->db->select('producer_category_group.*');
		$this->db->from('producer_category_group');
		$this->db->where('producer_category_group_id', $id);
		$result = $this->db->get();
		log_message('debug', "ProducerCategoryModel.getProducerCategoryGroupFromId : " . $this->db->last_query());
		
		$producerCategoryGroup = array();
		
		foreach ($result->result_array() as $row) {

			$this->load->library('ProducerCategoryGroupLib');

			$this->ProducerCategoryGroupLib->producerCategoryGroupId = $row['producer_category_group_id'];
			$this->ProducerCategoryGroupLib->producerCategoryGroup = $row['producer_category_group'];

			$producerCategoryGroup[] = $this->ProducerCategoryGroupLib;
			unset($this->ProducerCategoryGroupLib);
		}
		
		return $producerCategoryGroup[0];
	}
	
	function getCuisinesForRestaurant($producerId) {
		global $PRODUCER_CATEGORY_GROUP;
		$query = 'SELECT 
					producer_category.producer_category_id, 
					producer_category.producer_category 
				FROM 
					producer_category, producer_category_member 
				WHERE 
					producer_category_member.producer_category_id = producer_category.producer_category_id 
					AND producer_category.category_group1 = '.$PRODUCER_CATEGORY_GROUP['CUISINE'].'
					AND producer_category_member.producer_id = '. $producerId;
		
		log_message('debug', "ProducerCategoryModel.getCuisinesForRestaurant : " . $query);
		$result = $this->db->query($query);

		$producerCategories = array();

		foreach ($result->result_array() as $row) {

			$this->load->library('CuisineLib');
			unset($this->cuisineLib);

			$this->cuisineLib->cuisineId = $row['producer_category_id'];
			$this->cuisineLib->cuisine = $row['producer_category'];

			$producerCategories[] = $this->cuisineLib;
			unset($this->cuisineLib);
		}

		return $producerCategories;
	}


        function getProducerCategoryIDFromName(array $categoryNames)
        {
            $this->db->select('producer_category_id');

            foreach ($categoryNames as $category)
            {
                $this->db->or_where('producer_category', trim($category));
            }

            $query = $this->db->get('producer_category');

            return ($query->num_rows > 0) ? $query->result() : null;
        }
        
        function insertProducerCategoryMemberFromFile(array $member_data,$test=false)
        {
            $table = ($test) ? 'producer_category_member_bk':
                'producer_category_member';
            
            $this->db->insert($table, $member_data);

            return $this->db->insert_id();
        }
        
	function getCuisineIdsForRestaurant($producerId) {
		global $PRODUCER_CATEGORY_GROUP;
		$query = 'SELECT 
					producer_category.producer_category_id, 
					producer_category.producer_category 
				FROM 
					producer_category, producer_category_member 
				WHERE 
					producer_category_member.producer_category_id = producer_category.producer_category_id 
					AND producer_category.category_group1 = '.$PRODUCER_CATEGORY_GROUP['CUISINE'].'
					AND producer_category_member.producer_id = '. $producerId;
		
		log_message('debug', "ProducerCategoryModel.getCuisinesForRestaurant : " . $query);
		$result = $this->db->query($query);

		$producerCategories = array();

		foreach ($result->result_array() as $row) {
			$producerCategories[] = $row['producer_category_id'];
		}

		return $producerCategories;
	}
	
	function getFarmTypesForFarm($producerId) {
		global $PRODUCER_CATEGORY_GROUP;
		
		$query = 'SELECT 
					producer_category.producer_category_id, 
					producer_category.producer_category 
				FROM 
					producer_category, producer_category_member 
				WHERE 
					producer_category_member.producer_category_id = producer_category.producer_category_id 
					AND producer_category.category_group1 = '.$PRODUCER_CATEGORY_GROUP['FARM'].' 
					AND producer_category_member.producer_id = ' . $producerId;
		
		log_message('debug', "ProducerCategoryModel.getCuisinesForRestaurant : " . $query);
		$result = $this->db->query($query);

		$producerCategories = array();

		foreach ($result->result_array() as $row) {

			$this->load->library('FarmTypeLib');
			unset($this->farmTypeLib);

			$this->farmTypeLib->farmTypeId = $row['producer_category_id'];
			$this->farmTypeLib->farmType = $row['producer_category'];
			
			$producerCategories[] = $this->farmTypeLib;
		}

		return $producerCategories;
	}
	
	function getFarmCropsForFarm($producerId) {
		global $PRODUCER_CATEGORY_GROUP;
		
		$query = 'SELECT 
					producer_category.producer_category_id, 
					producer_category.producer_category 
				FROM 
					producer_category, producer_category_member 
				WHERE 
					producer_category_member.producer_category_id = producer_category.producer_category_id 
					AND producer_category.category_group1 = '.$PRODUCER_CATEGORY_GROUP['FARM_CROP'].' 
					AND producer_category_member.producer_id = ' . $producerId;
		
		log_message('debug', "ProducerCategoryModel.getCuisinesForRestaurant : " . $query);
		$result = $this->db->query($query);

		$producerCategories = array();

		foreach ($result->result_array() as $row) {

			$this->load->library('FarmTypeLib');
			unset($this->farmTypeLib);

			$this->farmTypeLib->farmCropId = $row['producer_category_id'];
			$this->farmTypeLib->farmCrop = $row['producer_category'];
			
			$producerCategories[] = $this->farmTypeLib;
		}

		return $producerCategories;
	}
	
	function getCertificationsForFarm($producerId) {
		global $PRODUCER_CATEGORY_GROUP;
		
		$query = 'SELECT 
					producer_category.producer_category_id, 
					producer_category.producer_category 
				FROM 
					producer_category, producer_category_member 
				WHERE 
					producer_category_member.producer_category_id = producer_category.producer_category_id 
					AND producer_category.category_group1 = '.$PRODUCER_CATEGORY_GROUP['CERTIFICATION'].' 
					AND producer_category_member.producer_id = ' . $producerId;
		
		log_message('debug', "ProducerCategoryModel.getCuisinesForRestaurant : " . $query);
		$result = $this->db->query($query);

		$producerCategories = array();

		foreach ($result->result_array() as $row) {

			$this->load->library('FarmTypeLib');
			unset($this->farmTypeLib);

			$this->farmTypeLib->certificationId = $row['producer_category_id'];
			$this->farmTypeLib->certification = $row['producer_category'];
			
			$producerCategories[] = $this->farmTypeLib;
		}

		return $producerCategories;
	}
	
	function getCertificationIdsForFarm($producerId) {
		global $PRODUCER_CATEGORY_GROUP;
		
		$query = 'SELECT 
					producer_category.producer_category_id, 
					producer_category.producer_category 
				FROM 
					producer_category, producer_category_member 
				WHERE 
					producer_category_member.producer_category_id = producer_category.producer_category_id 
					AND producer_category.category_group1 = '.$PRODUCER_CATEGORY_GROUP['CERTIFICATION'].' 
					AND producer_category_member.producer_id = ' . $producerId;
		
		log_message('debug', "ProducerCategoryModel.getCuisinesForRestaurant : " . $query);
		$result = $this->db->query($query);

		$producerCategories = array();

		foreach ($result->result_array() as $row) {
			$producerCategories[] = $row['producer_category_id'];
		}

		return $producerCategories;
	}
	
	function updateProducerCategoryForProducer($producerId, $producerCategory, $producerCategoryGroupId, $isMultiple = false) {
		
		$return = true;
		
		$query = 'SELECT producer_category_member.producer_category_member_id, producer_category_member.producer_category_id' .
				' FROM producer_category_member, producer_category' .
				' WHERE producer_category_member.producer_id = ' . $producerId . 
				' AND producer_category_member.producer_category_id = producer_category.producer_category_id' .
				' AND producer_category.category_group1 = ' . $producerCategoryGroupId;
		
		$result = $this->db->query($query);
		
		if ($isMultiple) {
			if ($result->num_rows() == 0) {
				foreach($producerCategory as $key => $value) {
					$query = 'INSERT INTO producer_category_member(producer_category_member_id, producer_category_id, producer_id, address_id) ' .
						' VALUES (NULL, ' . $value . ', ' . $producerId . ', NULL) ';
					log_message('debug', 'ProducerCategoryModel.updateProducerCategoryForProducer : Insert new producer category : ' . $query);
					if ( $this->db->query($query) ) {
						$return = true;
					} else {
						$return = false;
					}
				}
			} else {
				foreach ($result->result_array() as $row) {
					$existingProducerCategories[] = $row['producer_category_id'];
				}
				
				$action = array();
				
				foreach($producerCategory as $key => $value) {
					
					if(!empty($value)) {
						if ( !(in_array($value, $existingProducerCategories) ) ) {
							$query = "INSERT INTO producer_category_member (producer_category_member_id, producer_category_id, producer_id, address_id)" .
								" VALUES (NULL, " . $value . ", " . $producerId . ", NULL )";
							
							log_message('debug', 'ProducerCategoryModel.updateProducerCategoryForProducer : Insert new producer category : ' . $query);
							
							if ( $this->db->query($query) ) {
								$return = true;
							} else {
								$return = false;
							}
							
						} else {
							$action[$value] = 'update';
						}
					}
				}
				
				foreach ($existingProducerCategories as $existingProducerCategoryId) {
					if (array_key_exists ($existingProducerCategoryId, $action) ) {
						// Do nothing...
					} else {
						$query = 'DELETE FROM producer_category_member WHERE producer_id = ' . $producerId . ' AND producer_category_id = ' . $existingProducerCategoryId;
						
						log_message('debug', 'ProducerCategoryModel.updateProducerCategoryForProducer : delete producer category : ' . $query);
						
						if ( $this->db->query($query) ) {
							$return = true;
						} else {
							$return = false;
						}
						
					}
				}				
			}
			
		} else {
			
			if ($result->num_rows() == 0) {
				$query = 'INSERT INTO producer_category_member(producer_category_member_id, producer_category_id, producer_id, address_id) ' .
						' VALUES (NULL, ' . $producerCategory[0] . ', ' . $producerId . ', NULL) ';
				log_message('debug', 'ProducerCategoryModel.updateProducerCategoryForProducer : Insert new producer category : ' . $query);
				if ( $this->db->query($query) ) {
					$return = true;
				} else {
					$return = false;
				}
			} else {
				$row = $result->row();
				$data = array(
					'producer_category_id' => $producerCategory[0], 
				);
				$where = "producer_category_member_id = " . $row->producer_category_member_id;
				$query = $this->db->update_string('producer_category_member', $data, $where);
				log_message('debug', 'ProducerCategoryModel.updateProducerCategoryForProducer : Update producer category : ' . $query);
				if ( $this->db->query($query) ) {
					$return = true;
				} else {
					$return = false;
				}
			}
		}
		
		return $return;
	}
	
	function addProducerCategoryForProducer($producerId, $producerCategory) {
		$return = true;
		
		foreach($producerCategory as $key => $value) {
			$query = 'INSERT INTO producer_category_member(producer_category_member_id, producer_category_id, producer_id, address_id) ' .
				' VALUES (NULL, ' . $value . ', ' . $producerId . ', NULL) ';
			log_message('debug', 'ProducerCategoryModel.addProducerCategoryForProducer : Insert new producer category : ' . $query);
			if ( $this->db->query($query) ) {
				$return = true;
			} else {
				$return = false;
			}
		}
		
		return $return;
	}
	
	
}



?>