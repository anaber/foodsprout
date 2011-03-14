<?php

class SupplierModel extends Model{
	
	/**
	 * Migration: 		Done
	 * Migrated by: 	Deepak
	 * 
	 * Verified: 		Yes
	 * Verified By: 	Deepak
	 */
	function addSupplierIntermediate() {
		global $GLOBALS;
		$return = true;
		
		$supplierType = $this->input->post('supplierType');
		
		$restaurantId = $this->input->post('restaurantId');
		$farmId = $this->input->post('farmId');
		$manufactureId = $this->input->post('manufactureId');
		$distributorId = $this->input->post('distributorId');
		$restaurantChainId = $this->input->post('restaurantChainId');
		$farmersMarketId = $this->input->post('farmersMarketId');
		
		$supplierId = $this->input->post('companyId');
		$companyName = $this->input->post('companyName');
		
		$supplierRestaurantId = '';
		$supplierFarmId = '';
		$supplierManufactureId = '';
		$supplierDistributorId = '';
		
		if ( !empty($restaurantId) ) {
			$tableName = 'supplier';
			$idFieldName = 'supplier_id';
			
			$supplierFieldName = 'supplier';
			
			$supplieeFieldName = 'suppliee';
			$supplieeFieldValue = $restaurantId;
		} else if ( !empty($farmId) ) {
			$tableName = 'supplier';
			$idFieldName = 'supplier_id';
			
			$supplierFieldName = 'supplier';
			
			$supplieeFieldName = 'suppliee';
			$supplieeFieldValue = $farmId;
		} else if ( !empty($manufactureId) ) {
			$tableName = 'supplier';
			$idFieldName = 'supplier_id';
			
			$supplierFieldName = 'supplier';
			
			$supplieeFieldName = 'suppliee';
			$supplieeFieldValue = $manufactureId;
		} else if ( !empty($distributorId) ) {
			$tableName = 'supplier';
			$idFieldName = 'supplier_id';
			
			$supplierFieldName = 'supplier';
			
			$supplieeFieldName = 'suppliee';
			$supplieeFieldValue = $distributorId;
		} else if ( !empty($restaurantChainId) ) {
			$tableName = 'supplier';
			$idFieldName = 'supplier_id';
			
			$supplierFieldName = 'supplier';
			
			$supplieeFieldName = 'suppliee';
			$supplieeFieldValue = $restaurantChainId;
		} else if ( !empty($farmersMarketId) ) {
			/*
			$tableName = 'farmers_market_supplier';
			$idFieldName = 'farmers_market_supplier_id';
			
			$supplierFieldName = 'producer_id';
			
			$supplieeFieldName = 'farmers_market_id';
			*/
			$tableName = 'supplier';
			$idFieldName = 'supplier_id';
			
			$supplierFieldName = 'supplier';
			
			$supplieeFieldName = 'suppliee';
			$supplieeFieldValue = $farmersMarketId;
		} 
		
		if (empty($supplierId) && empty($companyName) ) {
			$GLOBALS['error'] = 'no_name';
			$return = false;
		} else {
		
			$CI =& get_instance();
			if (empty($supplierId) ) {
				$CI->load->model('ProducerModel','',true);
				$supplierId = $CI->ProducerModel->addProducerWithNameOnly($companyName, $supplierType);
			}
			
			if ( empty($supplierId) ) {
				$return = false;
			}
			
			if ( $return ) {
				if ($this->addSupplier($tableName, $idFieldName, $supplierFieldName, $supplierId, $supplieeFieldName, $supplieeFieldValue) ) {
					$return = true;
				} else {
					$return = false;
				}
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
	function addSupplier($tableName, $idFieldName, $supplierFieldName, $supplierId, $supplieeFieldName, $supplieeFieldValue) {
		
		$return = true;
		
		$query = 'SELECT * FROM ' . $tableName .
				' WHERE ' .
				$supplieeFieldName .' = ' .$supplieeFieldValue .
				' AND '. $supplierFieldName . ' = ' . $supplierId;
		
		log_message('debug', 'SupplierModel.addSupplier : Try to get duplicate supplier record : ' . $query);
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			$userGroup = $this->session->userdata['userGroup'];
			
			$query = 'INSERT INTO '. $tableName . '('.$idFieldName .', '.$supplierFieldName . ', '.$supplieeFieldName . ', user_id, status, track_ip )';
			$query .= ' values (NULL, ' . $supplierId . ', ' . $supplieeFieldValue;
			
			$query .= ', ' . $this->session->userdata['userId'];
			
			if ( $userGroup != 'admin') {
				$query .= ', \'queue\'';
			} else {
				$query .= ', \'live\'';
			}
			$query .= ', \'' . getRealIpAddr() . '\' )';
			
			log_message('debug', 'SupplierModel.addSupplier : Insert Supplier : ' . $query);
			
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
	
	function getSupplierForCompany($restaurantId, $farmId, $manufactureId, $distributorId, $restaurantChainId, $farmersMarketId) {
		global $SUPPLIER_TYPES_2;
		
		$where = "WHERE supplier.suppliee=".$restaurantId;
		
/*		if ( !empty($restaurantId) ) {
			$where .= ;
		} else if ( !empty($farmId) ) {
			$where .= 'supplier.suppliee='.$farmId;
		} else if ( !empty($manufactureId) ) {
			$where .= 'supplier.suppliee='.$manufactureId;
		} else if ( !empty($distributorId) ) {
			$where .= 'supplier.suppliee='.$distributorId;
		} else if ( !empty($restaurantChainId) ) {
			$where .= 'supplier.suppliee='.$restaurantChainId;			
		} else if ( !empty($farmersMarketId) ) {
			$where .= 'supplier.suppliee='.$farmersMarketId;
		} 
*/
		$suppliers = array();

		$query = "SELECT * FROM supplier LEFT JOIN producer ON supplier.supplier=producer.producer_id $where 
					GROUP BY supplier.supplier ORDER BY producer ASC";
		
		
		log_message('debug', "SupplierModel.getSupplierForCompany : " . $query);
		$result = $this->db->query($query);

		foreach ($result->result_array() as $row) {

			$this->load->library('SupplierLib');
			unset($this->supplierLib);
			
			$this->supplierLib->supplierId = $row['supplier'];
			if (isset( $row['is_restaurant']) ) {
				$this->supplierLib->supplierType = 'restaurant';
				$this->supplierLib->supplierName = $row['producer'];
			} else if ( isset($row['is_farm']) ) {
				$this->supplierLib->supplierType = 'farm';
				$this->supplierLib->supplierName = $row['producer'];
			} else if ( isset($row['is_manufacture']) ) {
				$this->supplierLib->supplierType = 'manufacture';
				$this->supplierLib->supplierName = $row['producer'];
			} else if ( isset($row['is_distributor']) ) {
				$this->supplierLib->supplierType = 'distributor';
				$this->supplierLib->supplierName = $row['producer'];
			}
			
			$suppliers[] = $this->supplierLib;
			unset($this->supplierLib);
		}

		return $suppliers;
	}
	
	function getSupplierForCompany_old($restaurantId, $farmId, $manufactureId, $distributorId, $restaurantChainId, $farmersMarketId) {
		global $SUPPLIER_TYPES_2;
		
		$fieldName = '';
		$fieldValue = '';
		
		if ( !empty($restaurantId) ) {
			$tableName = 'restaurant_supplier';
			$idFieldName = 'restaurant_supplier_id';
			$fieldName = 'restaurant_id';
			$fieldValue = $restaurantId;
		} else if ( !empty($farmId) ) {
			$tableName = 'farm_supplier';
			$idFieldName = 'farm_supplier_id';
			$fieldName = 'farm_id';
			$fieldValue = $farmId;
		} else if ( !empty($manufactureId) ) {
			$tableName = 'manufacture_supplier';
			$idFieldName = 'manufacture_supplier_id';
			$fieldName = 'manufacture_id';
			$fieldValue = $manufactureId;
		} else if ( !empty($distributorId) ) {
			$tableName = 'distributor_supplier';
			$idFieldName = 'distributor_supplier_id';
			$fieldName = 'distributor_id';
			$fieldValue = $distributorId;
		} else if ( !empty($restaurantChainId) ) {
			$tableName = 'restaurant_chain_supplier';
			$idFieldName = 'restaurant_chain_supplier_id';
			$fieldName = 'restaurant_chain_id';
			$fieldValue = $restaurantChainId;
		} else if ( !empty($farmersMarketId) ) {
			$tableName = 'farmers_market_supplier';
			$idFieldName = 'farmers_market_supplier_id';
			$fieldName = 'farmers_market_id';
			$fieldValue = $farmersMarketId;
		} 
		
		$suppliers = array();
		
		$query = 'SELECT ' . $tableName . '.*';
			foreach ($SUPPLIER_TYPES_2[$tableName] as $key => $value) {
				$query .= ', '. $key .'.'.$key.'_name';
			}
			
			$query .= ' FROM '.$tableName;
						
			foreach ($SUPPLIER_TYPES_2[$tableName] as $key => $value) {
				$query .= ' LEFT JOIN ' . $key .
				' ON ' . $tableName . '.supplier_' . $key . '_id = ' . $key . '.' . $key . '_id';
			}
			$query .= 
				' WHERE '.$tableName . '.' .$fieldName . ' = ' . $fieldValue;
		//echo $query . "<BR /><BR />";
		
		
		log_message('debug', "SupplierModel.getSupplierForCompany : " . $query);
		$result = $this->db->query($query);
		
		foreach ($result->result_array() as $row) {
			
			$this->load->library('SupplierLib');
			unset($this->supplierLib);
			
			$this->supplierLib->supplierId = $row[$idFieldName];
			if (isset( $row['restaurant_name']) ) {
				$this->supplierLib->supplierType = 'restaurant';
				$this->supplierLib->supplierName = $row['restaurant_name'];
			} else if ( isset($row['farm_name']) ) {
				$this->supplierLib->supplierType = 'farm';
				$this->supplierLib->supplierName = $row['farm_name'];
			} else if ( isset($row['manufacture_name']) ) {
				$this->supplierLib->supplierType = 'manufacture';
				$this->supplierLib->supplierName = $row['manufacture_name'];
			} else if ( isset($row['distributor_name']) ) {
				$this->supplierLib->supplierType = 'distributor';
				$this->supplierLib->supplierName = $row['distributor_name'];
			}
			
			$suppliers[] = $this->supplierLib;
			unset($this->supplierLib);
		}
		
		return $suppliers;
	}
	
	function getSupplierFromId($supplierId, $supplierType) {
		
		$tableName = 'supplier';//$supplierType . '_supplier';
		$idFieldName = 'supplier';//$supplierType . '_supplier_id';
		$fieldName = 'supplier';//$supplierType . '_id';
		
		$query = "SELECT * FROM producer, supplier WHERE supplier.supplier=".$supplierId." AND supplier.supplier=producer.producer_id GROUP BY supplier ORDER BY producer";

		/*
		$query = 'SELECT ' . $tableName . '.*, ' . $supplierType.'.'.$supplierType . '_name ' .
				' FROM '.$tableName .', '. $supplierType .
				' WHERE ' . $tableName . '.' . $idFieldName . ' = ' . $supplierId . 
				' AND ' . $tableName . '.' . 'supplier_'.$supplierType.'_id = ' . $supplierType . '.' . $supplierType . '_id';
		*/
		
		log_message('debug', "SupplierModel.getSupplierFromId : " . $query);
		$result = $this->db->query($query);
		
		$this->load->library('SupplierLib');
		
		$row = $result->row();
		
		$this->supplierLib->supplierId = $row->$idFieldName;

/*		if ($row->supplier) {
			if ( !empty($row->is_manufacture) ) {
				$this->supplierLib->manufactureId = $row->$fieldName;
			} elseif ( !empty($row->is_farm) ) {
				$this->supplierLib->farmId = $row->$fieldName;
			} elseif ( !empty($row->is_restaurant) ) {
				$this->supplierLib->restaurantId = $row->$fieldName;
			} elseif ( !empty($row->is_distributor) ) {
				$this->supplierLib->distributorId = $row->$fieldName;
			} elseif ( !empty($row->is_restaurant_chain) ) {
				$this->supplierLib->restaurantChainId = $row->$fieldName;
			} elseif (  !empty($row->is_farmers_market) ) {
				$this->supplierLib->farmersMarketId = $row->$fieldName;
			} 
		}
*/
		$CI =& get_instance();
		
		if ($row->is_farm ) {
			$this->supplierLib->companyId = $row->$fieldName;
			$this->supplierLib->supplierType = 'farm';
			
			$CI->load->model('FarmModel','',true);
			$farm = $CI->FarmModel->getFarmFromId( $row->$fieldName );
			$this->supplierLib->companyName = $farm->farmName;
			
		} else if ($row->is_manufacture ) {
			$this->supplierLib->companyId = $row->$fieldName;
			$this->supplierLib->supplierType = 'manufacture';
			
			$CI->load->model('ManufactureModel','',true);
			$farm = $CI->ManufactureModel->getManufactureFromId( $row->$fieldName );
			$this->supplierLib->companyName = $farm->manufactureName;
			
		} else if ($row->is_distributor ) {
			$this->supplierLib->companyId = $row->$fieldName;
			$this->supplierLib->supplierType = 'distributor';
			
			$CI->load->model('DistributorModel','',true);
			$farm = $CI->DistributorModel->getDistributorFromId( $row->$fieldName );
			$this->supplierLib->companyName = $farm->distributorName;
			
		} else if ($row->is_restaurant ) {
			$this->supplierLib->companyId = $row->$fieldName;
			$this->supplierLib->supplierType = 'restaurant';
			
			$CI->load->model('RestaurantModel','',true);
			$farm = $CI->RestaurantModel->getRestaurantFromId( $row->$fieldName );
			$this->supplierLib->companyName = $farm->restaurantName;
		}

		$this->supplierLib->status = $row->status;

		return $this->supplierLib;
		
	}
	
	function updateSupplierIntermediate() {
		global $GLOBALS;
		$return = true;
		
		$supplierType = $this->input->post('supplierType');
		$supplierId = $this->input->post('supplierId');
		$status = $this->input->post('status');
		
		$restaurantId = $this->input->post('restaurantId');
		$farmId = $this->input->post('farmId');
		$manufactureId = $this->input->post('manufactureId');
		$distributorId = $this->input->post('distributorId');
		$restaurantChainId = $this->input->post('restaurantChainId');
		$farmersMarketId = $this->input->post('farmersMarketId');
		
		$companyId = $this->input->post('companyId');
		$companyName = $this->input->post('companyName');
		
		$supplierRestaurantId = '';
		$supplierFarmId = '';
		$supplierManufactureId = '';
		$supplierDistributorId = '';

		$tableName = 'supplier';
		$idFieldName = 'supplier';
		$fieldName = 'supplier';
		
		if ( !empty($restaurantId) ) {
			$fieldValue = $restaurantId;
		} else if ( !empty($farmId) ) {
			$fieldValue = $farmId;
		} else if ( !empty($manufactureId) ) {
			$fieldValue = $manufactureId;
		} else if ( !empty($distributorId) ) {
			$fieldValue = $distributorId;
		} else if ( !empty($restaurantChainId) ) {
			$fieldValue = $restaurantChainId;
		} else if ( !empty($farmersMarketId) ) {
			$fieldValue = $farmersMarketId;
		} 
		
		if (empty($companyId) && empty($companyName) ) {
			$GLOBALS['error'] = 'no_name';
			$return = false;
		} else {
		
			$CI =& get_instance();
			
			if ( $supplierType == 'restaurant' ) {
				if (empty($companyId) ) {
					$CI->load->model('RestaurantModel','',true);
					$companyId = $CI->RestaurantModel->addRestaurantWithNameOnly($companyName);
				}
				
				if ($companyId) {
					$supplierRestaurantId = $companyId;
				} else {
					$return = false;
				}
			} else if ( $supplierType == 'farm' ) {
				if (empty($companyId) ) {
					$CI->load->model('FarmModel','',true);
					$companyId = $CI->FarmModel->addFarmWithNameOnly($companyName);
				}
				
				if ($companyId) {
					$supplierFarmId = $companyId;
				} else {
					$return = false;
				}
			} else if ( $supplierType == 'manufacture' ) {
				if (empty($companyId) ) {
					$CI->load->model('ManufactureModel','',true);
					$companyId = $CI->ManufactureModel->addManufactureWithNameOnly($companyName);
				}
				
				if ($companyId) {
					$supplierManufactureId = $companyId;
				} else {
					$return = false;
				}
			} else if ( $supplierType == 'distributor' ) {
				if (empty($companyId) ) {
					$CI->load->model('DistributorModel','',true);
					$companyId = $CI->DistributorModel->addDistributorWithNameOnly($companyName);
				}
				
				if ($companyId) {
					$supplierDistributorId = $companyId;
				} else {
					$return = false;
				}
			}
			
			if ( $return ) {
				if ($this->updateSuppluer($tableName, $idFieldName, $fieldName, $fieldValue, $supplierRestaurantId, $supplierFarmId, $supplierManufactureId, $supplierDistributorId, $supplierId, $status ) ) {
					$return = true;
				} else {
					$return = false;
				}
			}
		}
		
		return $return;
		
	}
	
	function updateSuppluer($tableName, $idFieldName, $fieldName, $fieldValue, $supplierRestaurantId, $supplierFarmId, $supplierManufactureId, $supplierDistributorId, $supplierId, $status) {
		
		$return = true;
		
		$query = "SELECT * FROM $tableName ".
				" WHERE $fieldName = $fieldValue";

/*		if ( !empty($supplierRestaurantId) ) {
			$query .= 'supplier_restaurant_id';
		} else if ( !empty($supplierFarmId) ) {
			$query .= 'supplier_farm_id';
		} else if ( !empty($supplierManufactureId) ) {
			$query .= 'supplier_manufacture_id';
		} else if ( !empty($supplierDistributorId) ) {
			$query .= 'supplier_distributor_id';
		}
		$query .= ' = ';
		if ( !empty($supplierRestaurantId) ) {
			$query .= $supplierRestaurantId;
		} else if ( !empty($supplierFarmId) ) {
			$query .= $supplierFarmId;
		} else if ( !empty($supplierManufactureId) ) {
			$query .= $supplierManufactureId;
		} else if ( !empty($supplierDistributorId) ) {
			$query .= $supplierDistributorId;
		}
*/
		$query .= ' AND ' . $idFieldName . ' <> ' . $supplierId;
		
		log_message('debug', 'SupplierModel.updateSuppluer : Try to get duplicate supplier record : ' . $query);
		$result = $this->db->query($query);

		if ($result->num_rows() == 0) {
			$query = "UPDATE $tableName SET supplier";
/*			if ( !empty($supplierRestaurantId) ) {
				$query .= 'supplier';
			} else if ( !empty($supplierFarmId) ) {
				$query .= 'supplier';
			} else if ( !empty($supplierManufactureId) ) {
				$query .= 'supplier';
			} else if ( !empty($supplierDistributorId) ) {
				$query .= 'supplier';
			}
*/
			$query .= " = ";
			
			if ( !empty($supplierRestaurantId) ) {
				$query .= $supplierRestaurantId;
			} else if ( !empty($supplierFarmId) ) {
				$query .= $supplierFarmId;
			} else if ( !empty($supplierManufactureId) ) {
				$query .= $supplierManufactureId;
			} else if ( !empty($supplierDistributorId) ) {
				$query .= $supplierDistributorId;
			}
			
			$query .= ", status='$status'";
			
			$query .= " WHERE $idFieldName = $supplierId";
			
			log_message('debug', 'SupplierModel.updateSuppluer : Update Suppluer : ' . $query);

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
	
	function getCompaniesForSupplier($restaurantId, $farmId, $manufactureId, $distributorId) {
		global $SUPPLIER_TYPES_2;
		$tables = array();
		
		if ( !empty($restaurantId) ) {
			$keyToSearch = 'restaurant';
			$fieldValue = $restaurantId;
		} else if ( !empty($farmId) ) {
			$keyToSearch = 'farm';
			$fieldValue = $farmId;
		} else if ( !empty($manufactureId) ) {
			$keyToSearch = 'manufacture';
			$fieldValue = $manufactureId;
		} else if ( !empty($distributorId) ) {
			$keyToSearch = 'distributor';
			$fieldValue = $distributorId;
		} 
		
		$supplierFieldName = 'supplier_' . $keyToSearch . '_id';
		
		foreach ($SUPPLIER_TYPES_2 as $key => $value) {
			if (array_key_exists($keyToSearch, $value)) {
				$arr = explode('_', $key);
				array_pop($arr);
				$tableName = implode('_', $arr);
				
				$tables[$key] = array(
								'supplierIdField' => $key . '_id',
								'supplierFieldName' => $supplierFieldName,
								'joinTable' => $tableName,
								'joinIdField' => $tableName . '_id',
								'joinNameField' => ($tableName == 'restaurant_chain' ? $tableName :  $tableName . '_name')
							);
			}
		}
		
		$companies = array();
		
		foreach ($tables as $supplierTable => $tableParam) {
			
			
			$query = 'SELECT '
					. $supplierTable . '.' . $tableParam['supplierIdField'] . ', ' . $supplierTable . '.'.$tableParam['joinIdField'].', '.$tableParam['joinTable'].'.'.$tableParam['joinNameField']
					. ' FROM ' . $supplierTable.', '.$tableParam['joinTable']
					. ' WHERE '.$supplierTable. '.' . $tableParam['supplierFieldName'] . ' = ' . $fieldValue
					. ' AND '.$supplierTable.'.'.$tableParam['joinIdField'].' = '.$tableParam['joinTable'].'.' . $tableParam['joinIdField'];
			
			//echo $query . "<br /><br />";
			
			log_message('debug', "SupplierModel.getCompaniesForSupplier : " . $query);
			$result = $this->db->query($query);
			
			foreach ($result->result_array() as $row) {
				$this->load->library('CompanyLib');
				
				$this->CompanyLib->companyId = $row[ $tableParam['joinIdField'] ];
				$this->CompanyLib->companyName = $row[ $tableParam['joinNameField'] ];
				
				$companies[ $tableParam['joinTable'] ][] = $this->CompanyLib;
				unset($this->CompanyLib);
			}
		}
		
		return $companies;
	}
	
	
	function getSupplierForCompanyJson($restaurantId, $farmId, $manufactureId, $distributorId, $restaurantChainId, $farmersMarketId) {
		global $SUPPLIER_TYPES_2, $PER_PAGE;
		
		$p = $this->input->post('p'); // Page
		$pp = $this->input->post('pp'); // Per Page
		$sort = $this->input->post('sort');
		$order = $this->input->post('order');
		
		$fieldName = '';
		$fieldValue = '';
		
		if ( !empty($restaurantId) ) {
			$tableName = 'supplier';
			$idFieldName = 'restaurant_supplier_id';
			$fieldName = 'restaurant_id';
			$fieldValue = $restaurantId;
		} else if ( !empty($farmId) ) {
			$tableName = 'farm_supplier';
			$idFieldName = 'farm_supplier_id';
			$fieldName = 'farm_id';
			$fieldValue = $farmId;
		} else if ( !empty($manufactureId) ) {
			$tableName = 'manufacture_supplier';
			$idFieldName = 'manufacture_supplier_id';
			$fieldName = 'manufacture_id';
			$fieldValue = $manufactureId;
		} else if ( !empty($distributorId) ) {
			$tableName = 'distributor_supplier';
			$idFieldName = 'distributor_supplier_id';
			$fieldName = 'distributor_id';
			$fieldValue = $distributorId;
		} else if ( !empty($restaurantChainId) ) {
			$tableName = 'restaurant_chain_supplier';
			$idFieldName = 'restaurant_chain_supplier_id';
			$fieldName = 'restaurant_chain_id';
			$fieldValue = $restaurantChainId;
		} else if ( !empty($farmersMarketId) ) {
			$tableName = 'farmers_market_supplier';
			$idFieldName = 'farmers_market_supplier_id';
			$fieldName = 'farmers_market_id';
			$fieldValue = $farmersMarketId;
		} 
		
		$start = 0;
		$page = 0;
		
		/** $base_query*/
		$base_query = 'SELECT ' . $tableName . '.*';
			foreach ($SUPPLIER_TYPES_2[$tableName] as $key => $value) {
				$base_query .= ', '. $key .'.'.$key.'_name';
			}
			
			$base_query .= ' FROM '.$tableName;
						
			foreach ($SUPPLIER_TYPES_2[$tableName] as $key => $value) {
				$base_query .= ' LEFT JOIN ' . $key .
				' ON ' . $tableName . '.supplier_' . $key . '_id = ' . $key . '.' . $key . '_id';
			}
		/** $base_query */
		
		/** $base_query_count */
		$base_query_count = 'SELECT count(*) AS num_records';
			
			$base_query_count .= ' FROM '.$tableName;
						
			foreach ($SUPPLIER_TYPES_2[$tableName] as $key => $value) {
				$base_query_count .= ' LEFT JOIN ' . $key .
				' ON ' . $tableName . '.supplier_' . $key . '_id = ' . $key . '.' . $key . '_id';
			}
		/** $base_query_count */
		
		
		$where = 
				' WHERE '.$tableName . '.' .$fieldName . ' = ' . $fieldValue . 
				' AND '.$tableName.'.status = \'live\'';
		
		$base_query_count = $base_query_count . $where;
		
		$query = $base_query_count;
		
		$result = $this->db->query($query);
		$row = $result->row();
		$numResults = $row->num_records;
		
		$query = $base_query . $where;
		
		if ( empty($sort) ) {
			$sort_query = ' ORDER BY ' . $idFieldName;
			$sort = $idFieldName;
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
		
		log_message('debug', "SupplierModel.getSupplierForCompanyJson : " . $query);
		$result = $this->db->query($query);
		
		$suppliers = array();
		$CI =& get_instance();
		
		foreach ($result->result_array() as $row) {
			
			$this->load->library('SupplierLib');
			unset($this->supplierLib);
			
			$CI->load->model('AddressModel','',true);
			
			$this->supplierLib->supplierId = $row[$idFieldName];
			if (isset( $row['restaurant_name']) ) {
				$this->supplierLib->supplierType = 'restaurant';
				$this->supplierLib->supplierName = $row['restaurant_name'];
				$this->supplierLib->supplierReferenceId = $row['supplier_restaurant_id'];
				
				$addresses = $CI->AddressModel->getAddressForCompany( $row['supplier_restaurant_id'], '', '', '', '', '', '', '');
				$this->supplierLib->addresses = $addresses;
				
			} else if ( isset($row['farm_name']) ) {
				$this->supplierLib->supplierType = 'farm';
				$this->supplierLib->supplierName = $row['farm_name'];
				$this->supplierLib->supplierReferenceId = $row['supplier_farm_id'];
				
				$addresses = $CI->AddressModel->getAddressForCompany( '', $row['supplier_farm_id'], '', '', '', '', '', '');
				$this->supplierLib->addresses = $addresses;
				
			} else if ( isset($row['manufacture_name']) ) {
				$this->supplierLib->supplierType = 'manufacture';
				$this->supplierLib->supplierName = $row['manufacture_name'];
				$this->supplierLib->supplierReferenceId = $row['supplier_manufacture_id'];
				
				$addresses = $CI->AddressModel->getAddressForCompany( '', '', $row['supplier_manufacture_id'], '', '', '', '', '');
				$this->supplierLib->addresses = $addresses;
				
			} else if ( isset($row['distributor_name']) ) {
				$this->supplierLib->supplierType = 'distributor';
				$this->supplierLib->supplierName = $row['distributor_name'];
				$this->supplierLib->supplierReferenceId = $row['supplier_distributor_id'];
				
				$addresses = $CI->AddressModel->getAddressForCompany( '', '', '', $row['supplier_distributor_id'], '', '', '', '');
				$this->supplierLib->addresses = $addresses;
				
			}
			
			$suppliers[] = $this->supplierLib;
			unset($this->supplierLib);
		}
		
		
		if (!empty($pp) && $pp == 'all') {
			$PER_PAGE = $numResults;
		}
		
		$totalPages = ceil($numResults/$PER_PAGE);
		$first = 0;
		$last = $totalPages - 1;		
		
		$params = requestToParams($numResults, $start, $totalPages, $first, $last, $page, $sort, $order, $fieldValue, '', '');
		$arr = array(
			'results'    => $suppliers,
			'param'      => $params,
	    );
	    
	    return $arr;
	}
	
	
	// Get the suppliers for a producer
	
	function getSupplierForProducerJson($producerId, $addressId = '') {
		global $SUPPLIER_TYPES_2, $PER_PAGE;
		
		$p = $this->input->post('p'); // Page
		$pp = $this->input->post('pp'); // Per Page
		$sort = $this->input->post('sort');
		$order = $this->input->post('order');
		
		$start = 0;
		$page = 0;
		
		/** $base_query_count */
		$base_query_count = 'SELECT count(*) AS num_records';
		$base_query_count .= ' FROM supplier';
		$base_query_count .= ' WHERE suppliee='.$producerId;
		
		/** $base_query*/
		$base_query = 'SELECT supplier.*, producer.producer, producer.producer_id, ' 
					. ' is_restaurant, is_farm, is_manufacture, is_distributor'; 
		$base_query .= ' FROM supplier, producer';
		
		$where = ' WHERE supplier.suppliee = '.$producerId   
			   . ' AND supplier.supplier = producer.producer_id';
		
		$query = $base_query_count;
		
		$result = $this->db->query($query);
		$row = $result->row();
		$numResults = $row->num_records;
		
		$query = $base_query . $where;	
		$sort_query = ' ORDER BY producer.producer';
		
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
		
		log_message('debug', "SupplierModel.getSupplierForCompanyJson : " . $query);
		//echo $query;
		$result = $this->db->query($query);
		
		$geocodeArray = array();
		$suppliers = array();
		$CI =& get_instance();
		$i = 1;
		
		/**
		 * If we decide to add bigger map on farm page, 
		 * We will need similar piece of code in get suppliee method  
		 */
		if ($addressId) {
			$CI->load->model('ProducerModel','',true);
			$producer = $CI->ProducerModel->getProducerFromIdAndAddressId($producerId, $addressId);
			if ($producer) {
				$arrLatLng = array();
				
				$arrLatLng['latitude'] = $producer->latitude;
				$arrLatLng['longitude'] = $producer->longitude;
				$arrLatLng['address'] = ''; //$producer->completeAddress;
				
				$arrLatLng['addressLine1'] = $producer->address;
				$arrLatLng['addressLine2'] = $producer->city . ' ' . $producer->state;
				$arrLatLng['addressLine3'] = $producer->country . ' ' . $producer->zipcode;
					
				$arrLatLng['supplierName'] = $producer->producer;
				$arrLatLng['id'] = $producer->addressId;
				//$geocodeArray['suppliee'] = $arrLatLng;
				$geocodeArray[0] = $arrLatLng;
			}
		}
		//print_r_pre($geocodeArray);
		
		foreach ($result->result_array() as $row) {
			
			$this->load->library('SupplierLib');
			unset($this->supplierLib);
			
			$CI->load->model('AddressModel','',true);
			
			$this->supplierLib->supplierId = $row['supplier'];
			
			$this->supplierLib->supplierName = $row['producer'];
			$this->supplierLib->supplierReferenceId = $row['suppliee'];
			
			$addresses = $CI->AddressModel->getAddressForProducer($row['supplier']);
			$this->supplierLib->addresses = $addresses;
			
			$this->supplierLib->customUrl = '';
			$firstAddressId = '';
			
			if ( $row['is_restaurant'] == '1' ) {
				$this->supplierLib->supplierType = 'restaurant';
			} else if ( $row['is_farm'] == '1' ) {
				$this->supplierLib->supplierType = 'farm';
			} else if ( $row['is_manufacture'] == '1' ) {
				$this->supplierLib->supplierType = 'manufacture';
			} else if ( $row['is_distributor'] == '1' ) {
				$this->supplierLib->supplierType = 'distributor';
			}
			
			
			foreach ($addresses as $key => $address) {
				$arrLatLng = array();
				
				$arrLatLng['latitude'] = $address->latitude;
				$arrLatLng['longitude'] = $address->longitude;
				$arrLatLng['address'] = $address->completeAddress;
				
				$arrLatLng['addressLine1'] = $address->address;
				$arrLatLng['addressLine2'] = $address->city . ' ' . $address->state;
				$arrLatLng['addressLine3'] = $address->country . ' ' . $address->zipcode;
					
				$arrLatLng['supplierName'] = $this->supplierLib->supplierName;
				$arrLatLng['id'] = $address->addressId;
				$geocodeArray[$i] = $arrLatLng;
				
				$firstAddressId = $address->addressId;
				$i++;
				break;
			}
			
			if ($firstAddressId != '') {
				$CI->load->model('CustomUrlModel','',true);
				$customUrl = $CI->CustomUrlModel->getCustomUrlForProducerAddress($row['supplier'], $firstAddressId);
				$this->supplierLib->customUrl = $customUrl;
			}
			
			
			$suppliers[] = $this->supplierLib;
			unset($this->supplierLib);
		}
		
		
		if (!empty($pp) && $pp == 'all') {
			$PER_PAGE = $numResults;
		}
		
		$totalPages = ceil($numResults/$PER_PAGE);
		$first = 0;
		$last = $totalPages - 1;		
		
		$params = requestToParams($numResults, $start, $totalPages, $first, $last, $page, $sort, $order, '', '', '');
		$arr = array(
			'results'    => $suppliers,
			'param'      => $params,
			'geocode'	 => $geocodeArray,
	    );
	    //print_r_pre($arr);
	    return $arr;
	}
	
	
	// Get all the farms for a farmers market
	
	function getSupplierForFarmersMarketJson($farmersMarketId) {
		global $SUPPLIER_TYPES_2, $PER_PAGE;
		
		$p = $this->input->post('p'); // Page
		$pp = $this->input->post('pp'); // Per Page
		$sort = $this->input->post('sort');
		$order = $this->input->post('order');
		
		$fieldName = '';
		$fieldValue = '';
		
		$tableName = 'producer_supplier';
		$idFieldName = 'producer_id';    			// supplier
		$fieldName = 'farmers_market_id';			// suppliee
		$fieldValue = $farmersMarketId; 
		
		$start = 0;
		$page = 0;
		
		/** $base_query*/
		$base_query = 'SELECT ' . $tableName . '.*';
			foreach ($SUPPLIER_TYPES_2[$tableName] as $key => $value) {
				$base_query .= ', '. $key .'.'.$key;
			}
			
			$base_query .= ' FROM '.$tableName;
						
			foreach ($SUPPLIER_TYPES_2[$tableName] as $key => $value) {
				$base_query .= ' LEFT JOIN ' . $key .
				' ON ' . $tableName . '.' . $key . '_id = ' . $key . '.' . $key . '_id';
			}
		/** $base_query */
		
		/** $base_query_count */
		$base_query_count = 'SELECT count(*) AS num_records';
			
			$base_query_count .= ' FROM '.$tableName;
						
			foreach ($SUPPLIER_TYPES_2[$tableName] as $key => $value) {
				$base_query_count .= ' LEFT JOIN ' . $key .
				' ON ' . $tableName . '.' . $key . '_id = ' . $key . '.' . $key . '_id';
			}
		/** $base_query_count */
		
		
		$where = 
				' WHERE '.$tableName . '.' .$fieldName . ' = ' . $fieldValue . 
				' AND '.$tableName.'.status = \'live\'';
		
		$base_query_count = $base_query_count . $where;
		
		$query = $base_query_count;
		
		$result = $this->db->query($query);
		$row = $result->row();
		$numResults = $row->num_records;
		
		$query = $base_query . $where;
		
		if ( empty($sort) ) {
			$sort_query = ' ORDER BY ' . $idFieldName;
			$sort = $idFieldName;
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
		
		log_message('debug', "SupplierModel.getSupplierForCompanyJson : " . $query);
		$result = $this->db->query($query);
		
		$suppliers = array();
		$CI =& get_instance();
		
		foreach ($result->result_array() as $row) {
			
			$this->load->library('SupplierLib');
			unset($this->supplierLib);
			
			$CI->load->model('AddressModel','',true);
			
			$this->supplierLib->supplierId = $row[$idFieldName];
			if (isset( $row['restaurant_name']) ) {
				$this->supplierLib->supplierType = 'restaurant';
				$this->supplierLib->supplierName = $row['restaurant_name'];
				$this->supplierLib->supplierReferenceId = $row['supplier_restaurant_id'];
				
				$addresses = $CI->AddressModel->getAddressForCompany( $row['supplier_restaurant_id'], '', '', '', '', '', '', '');
				$this->supplierLib->addresses = $addresses;
				
			} else if ( isset($row['farm_name']) ) {
				$this->supplierLib->supplierType = 'farm';
				$this->supplierLib->supplierName = $row['farm_name'];
				$this->supplierLib->supplierReferenceId = $row['supplier_farm_id'];
				
				$addresses = $CI->AddressModel->getAddressForCompany( '', $row['supplier_farm_id'], '', '', '', '', '', '');
				$this->supplierLib->addresses = $addresses;
				
			} else if ( isset($row['manufacture_name']) ) {
				$this->supplierLib->supplierType = 'manufacture';
				$this->supplierLib->supplierName = $row['manufacture_name'];
				$this->supplierLib->supplierReferenceId = $row['supplier_manufacture_id'];
				
				$addresses = $CI->AddressModel->getAddressForCompany( '', '', $row['supplier_manufacture_id'], '', '', '', '', '');
				$this->supplierLib->addresses = $addresses;
				
			} else if ( isset($row['distributor_name']) ) {
				$this->supplierLib->supplierType = 'distributor';
				$this->supplierLib->supplierName = $row['distributor_name'];
				$this->supplierLib->supplierReferenceId = $row['supplier_distributor_id'];
				
				$addresses = $CI->AddressModel->getAddressForCompany( '', '', '', $row['supplier_distributor_id'], '', '', '', '');
				$this->supplierLib->addresses = $addresses;
				
			}
			
			$suppliers[] = $this->supplierLib;
			unset($this->supplierLib);
		}
		
		
		if (!empty($pp) && $pp == 'all') {
			$PER_PAGE = $numResults;
		}
		
		$totalPages = ceil($numResults/$PER_PAGE);
		$first = 0;
		$last = $totalPages - 1;		
		
		$params = requestToParams($numResults, $start, $totalPages, $first, $last, $page, $sort, $order, $fieldValue, '', '');
		$arr = array(
			'results'    => $suppliers,
			'param'      => $params,
	    );
	    
	    return $arr;
	}
	
	
	/* This is a SPECIAL case
	 * If restaurant belongs to a chain, we need to get suppliers of that chain as well
	 * So, need to merge records from two table, restaurant_supplier and restaurant_chain_supplier
	 */
	function getSupplierForRestaurantAndChainJson($restaurantId, $restaurantChainId) {
		global $PER_PAGE;
		
		$p = $this->input->post('p'); // Page
		$pp = $this->input->post('pp'); // Per Page
		$sort = $this->input->post('sort');
		$order = $this->input->post('order');
		
		$q = $this->input->post('q');
		
		if ($q == '0') {
			$q = '';
		}
		
		
		$query_count = 'SELECT (
							SELECT count(*)
							FROM restaurant_supplier 
							LEFT JOIN farm 
								ON restaurant_supplier.supplier_farm_id = farm.farm_id 
							LEFT JOIN distributor 
								ON restaurant_supplier.supplier_distributor_id = distributor.distributor_id 
							LEFT JOIN manufacture 
								ON restaurant_supplier.supplier_manufacture_id = manufacture.manufacture_id 
							WHERE 
								restaurant_supplier.restaurant_id = '.$restaurantId.' 
								AND restaurant_supplier.status = \'live\')  
							
							+
							
							(SELECT 
								count(*)
							FROM restaurant_chain_supplier 
							LEFT JOIN farm 
								ON restaurant_chain_supplier.supplier_farm_id = farm.farm_id 
							LEFT JOIN distributor 
								ON restaurant_chain_supplier.supplier_distributor_id = distributor.distributor_id 
							LEFT JOIN manufacture 
								ON restaurant_chain_supplier.supplier_manufacture_id = manufacture.manufacture_id 
							WHERE 
								restaurant_chain_supplier.restaurant_chain_id = '.$restaurantChainId.' 
								AND restaurant_chain_supplier.status = \'live\')  
							
							AS num_records
							';
		$result = $this->db->query($query_count);
		$row = $result->row();
		$numResults = $row->num_records;
		
		
		/*
		 * this query may look weird, but there is no other option.
		 * Using CONCAT to know if record belongs to rstaurant or restaurant_chain
		 */
		$query = '(SELECT 
						restaurant_supplier.restaurant_supplier_id as supplier_id , restaurant_supplier.restaurant_id, CONCAT(\'restaurant\') AS type,
						restaurant_supplier.supplier_farm_id, restaurant_supplier.supplier_manufacture_id, restaurant_supplier.supplier_distributor_id, 
						farm.farm_name, distributor.distributor_name, manufacture.manufacture_name 
					FROM restaurant_supplier 
					LEFT JOIN farm 
						ON restaurant_supplier.supplier_farm_id = farm.farm_id 
					LEFT JOIN distributor 
						ON restaurant_supplier.supplier_distributor_id = distributor.distributor_id 
					LEFT JOIN manufacture 
						ON restaurant_supplier.supplier_manufacture_id = manufacture.manufacture_id 
					WHERE 
						restaurant_supplier.restaurant_id = '.$restaurantId.' 
						AND restaurant_supplier.status = \'live\')  
					
					UNION
					
					(SELECT 
						restaurant_chain_supplier.restaurant_chain_supplier_id as supplier_id , restaurant_chain_supplier.restaurant_chain_id, CONCAT(\'restaurant_chain\') AS type,
						restaurant_chain_supplier.supplier_farm_id, restaurant_chain_supplier.supplier_manufacture_id, restaurant_chain_supplier.supplier_distributor_id, 
						farm.farm_name, distributor.distributor_name, manufacture.manufacture_name 
					FROM restaurant_chain_supplier 
					LEFT JOIN farm 
						ON restaurant_chain_supplier.supplier_farm_id = farm.farm_id 
					LEFT JOIN distributor 
						ON restaurant_chain_supplier.supplier_distributor_id = distributor.distributor_id 
					LEFT JOIN manufacture 
						ON restaurant_chain_supplier.supplier_manufacture_id = manufacture.manufacture_id 
					WHERE 
						restaurant_chain_supplier.restaurant_chain_id = '.$restaurantChainId.' 
						AND restaurant_chain_supplier.status = \'live\')  
					';
		
		$start = 0;
		$page = 0;
		
		
		if ( empty($sort) ) {
			$sort_query = ' ORDER BY supplier_id';
			$sort = 'supplier_id';
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
		
		log_message('debug', "SupplierModel.getSupplierForRestaurantAndChainJson : " . $query);
		$result = $this->db->query($query);
		
		
		$suppliers = array();
		$CI =& get_instance();
		
		foreach ($result->result_array() as $row) {
			
			$this->load->library('SupplierLib');
			unset($this->supplierLib);
			
			$CI->load->model('AddressModel','',true);
			
			$this->supplierLib->supplierId = $row['restaurant_id'];
			if (isset( $row['restaurant_name']) ) {
				$this->supplierLib->supplierType = 'restaurant';
				$this->supplierLib->supplierName = $row['restaurant_name'];
				$this->supplierLib->supplierReferenceId = $row['supplier_restaurant_id'];
				
				$addresses = $CI->AddressModel->getAddressForCompany( $row['supplier_restaurant_id'], '', '', '', '', '', '', '');
				$this->supplierLib->addresses = $addresses;
				
			} else if ( isset($row['farm_name']) ) {
				$this->supplierLib->supplierType = 'farm';
				$this->supplierLib->supplierName = $row['farm_name'];
				$this->supplierLib->supplierReferenceId = $row['supplier_farm_id'];
				
				$addresses = $CI->AddressModel->getAddressForCompany( '', $row['supplier_farm_id'], '', '', '', '', '', '');
				$this->supplierLib->addresses = $addresses;
				
			} else if ( isset($row['manufacture_name']) ) {
				$this->supplierLib->supplierType = 'manufacture';
				$this->supplierLib->supplierName = $row['manufacture_name'];
				$this->supplierLib->supplierReferenceId = $row['supplier_manufacture_id'];
				
				$addresses = $CI->AddressModel->getAddressForCompany( '', '', $row['supplier_manufacture_id'], '', '', '', '', '');
				$this->supplierLib->addresses = $addresses;
				
			} else if ( isset($row['distributor_name']) ) {
				$this->supplierLib->supplierType = 'distributor';
				$this->supplierLib->supplierName = $row['distributor_name'];
				$this->supplierLib->supplierReferenceId = $row['supplier_distributor_id'];
				
				$addresses = $CI->AddressModel->getAddressForCompany( '', '', '', $row['supplier_distributor_id'], '', '', '', '');
				$this->supplierLib->addresses = $addresses;
				
			}
			
			$suppliers[] = $this->supplierLib;
			unset($this->supplierLib);
		}
		
		
		
		if (!empty($pp) && $pp == 'all') {
			$PER_PAGE = $numResults;
		}
		
		$totalPages = ceil($numResults/$PER_PAGE);
		$first = 0;
		$last = $totalPages - 1;		
		
		$params = requestToParams($numResults, $start, $totalPages, $first, $last, $page, $sort, $order, $q, '', '');
		$arr = array(
			'results'    => $suppliers,
			'param'      => $params,
	    );
	    
	    return $arr;
	}
	
	function getCompaniesForSupplierJson($restaurantId, $farmId, $manufactureId, $distributorId) {
		global $SUPPLIER_TYPES_2, $PER_PAGE;
		
		$p = $this->input->post('p'); // Page
		$pp = $this->input->post('pp'); // Per Page
		$sort = $this->input->post('sort');
		$order = $this->input->post('order');
		
		$q = $this->input->post('q');
		
		if ($q == '0') {
			$q = '';
		}
		
		$tables = array();
		
		if ( !empty($restaurantId) ) {
			$keyToSearch = 'restaurant';
			$fieldValue = $restaurantId;
		} else if ( !empty($farmId) ) {
			$keyToSearch = 'farm';
			$fieldValue = $farmId;
		} else if ( !empty($manufactureId) ) {
			$keyToSearch = 'manufacture';
			$fieldValue = $manufactureId;
		} else if ( !empty($distributorId) ) {
			$keyToSearch = 'distributor';
			$fieldValue = $distributorId;
		} 
		
		$supplierFieldName = 'supplier_' . $keyToSearch . '_id';
		
		foreach ($SUPPLIER_TYPES_2 as $key => $value) {
			if (array_key_exists($keyToSearch, $value)) {
				$arr = explode('_', $key);
				array_pop($arr);
				$tableName = implode('_', $arr);
				
				$tables[$key] = array(
								'supplierIdField' => $key . '_id',
								'supplierFieldName' => $supplierFieldName,
								'joinTable' => $tableName,
								'joinIdField' => $tableName . '_id',
								'joinNameField' => ($tableName == 'restaurant_chain' ? $tableName :  $tableName . '_name')
							);
			}
		}
		
		$companies = array();
		
		$arrQueryCount = array();
		$arrQuery = array();
		
		foreach ($tables as $supplierTable => $tableParam) {
			
			$query_count = 'SELECT count(*) '
					. ' FROM ' . $supplierTable.', '.$tableParam['joinTable']
					. ' WHERE '.$supplierTable. '.' . $tableParam['supplierFieldName'] . ' = ' . $fieldValue
					. ' AND '.$supplierTable.'.'.$tableParam['joinIdField'].' = '.$tableParam['joinTable'].'.' . $tableParam['joinIdField'];
			
			//echo $query_count . "<br /><br />";
			$arrQueryCount[] = $query_count;
			
			$query = 'SELECT '
					//. $supplierTable . '.' . $tableParam['supplierIdField'] . ', ' . $supplierTable . '.'.$tableParam['joinIdField'].', '.$tableParam['joinTable'].'.'.$tableParam['joinNameField']
					. $supplierTable . '.' . $tableParam['supplierIdField'] . ' as id, ' . $supplierTable . '.'.$tableParam['joinIdField'].' as company_id, '.$tableParam['joinTable'].'.'.$tableParam['joinNameField'] . ' as company_name, CONCAT(\''.$tableParam['joinTable'].'\') AS type'
					. ' FROM ' . $supplierTable.', '.$tableParam['joinTable']
					. ' WHERE '.$supplierTable. '.' . $tableParam['supplierFieldName'] . ' = ' . $fieldValue
					. ' AND '.$supplierTable.'.'.$tableParam['joinIdField'].' = '.$tableParam['joinTable'].'.' . $tableParam['joinIdField'];
			
			//echo $query . "<br /><br />";
			$arrQuery[] = $query;
		}
		
		
		$query_count = 'SELECT';
		$i = 0;
		foreach ($arrQueryCount as $query) {
			if ($i != 0) {
				$query_count .= ' + (' . $query . ') ';
			} else {
				$query_count .= ' (' . $query . ') ';
			}
			
			$i++;
		}
							
		$query_count .= ' AS num_records';
		
		$result = $this->db->query($query_count);
		$row = $result->row();
		$numResults = $row->num_records;
		
		/*
		 * this query may look weird, but there is no other option.
		 * Using CONCAT to know if record belongs to rstaurant or restaurant_chain
		 */
		 
		$query = '';
		$i = 0;
		foreach ($arrQuery as $qr) {
			if ($i != 0) {
				$query .= ' UNION (' . $qr . ') ';
			} else {
				$query .= ' (' . $qr . ') ';
			}
			$i++;
		}
		
		$start = 0;
		$page = 0;
		
		if ( empty($sort) ) {
			$sort_query = ' ORDER BY company_name';
			$sort = 'company_name';
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
		
		log_message('debug', "SupplierModel.getCompaniesForSupplierJson : " . $query);
		$result = $this->db->query($query);
		
		
		$companies = array();
		$CI =& get_instance();
		
		foreach ($result->result_array() as $row) {
			
			$this->load->library('CompanyLib');
			unset($this->companyLib);
			
			$CI->load->model('AddressModel','',true);
			
			$this->companyLib->companyId = $row['company_id'];
			$this->companyLib->companyName = $row['company_name'];
			if ( $row['type'] == 'restaurant' ) {
				$this->companyLib->type = 'restaurant';
				
				$addresses = $CI->AddressModel->getAddressForCompany( $row['company_id'], '', '', '', '', '', '', '');
				$this->companyLib->addresses = $addresses;
				
			} else if ( $row['type'] == 'farm' ) {
				$this->companyLib->type = 'farm';
				
				$addresses = $CI->AddressModel->getAddressForCompany( '', $row['company_id'], '', '', '', '', '', '');
				$this->companyLib->addresses = $addresses;
				
			} else if ( $row['type'] == 'manufacture' ) {
				$this->companyLib->type = 'manufacture';
				
				$addresses = $CI->AddressModel->getAddressForCompany( '', '', $row['company_id'], '', '', '', '', '');
				$this->companyLib->addresses = $addresses;
				
			} else if ( $row['type'] == 'distributor' ) {
				$this->companyLib->type = 'distributor';
				
				$addresses = $CI->AddressModel->getAddressForCompany( '', '', '', $row['company_id'], '', '', '', '');
				$this->companyLib->addresses = $addresses;
				
			} else if ( $row['type'] == 'farmers_market' ) {
				$this->companyLib->type = 'farmersmarket';
				
				$addresses = $CI->AddressModel->getAddressForCompany( '', '', '', '', $row['company_id'], '', '', '');
				$this->companyLib->addresses = $addresses;
				
			} else if ( $row['type'] == 'restaurant_chain' ) {
				$this->companyLib->type = 'chain';
				$this->companyLib->addresses = '';
			} 
			
			$companies[] = $this->companyLib;
			unset($this->companyLib);
		}
		
		
		
		if (!empty($pp) && $pp == 'all') {
			$PER_PAGE = $numResults;
		}
		
		$totalPages = ceil($numResults/$PER_PAGE);
		$first = 0;
		$last = $totalPages - 1;		
		
		$params = requestToParams($numResults, $start, $totalPages, $first, $last, $page, $sort, $order, $q, '', '');
		$arr = array(
			'results'    => $companies,
			'param'      => $params,
	    );
	    
	    return $arr;
	}
	
	/**
	 * Migration: 		Working
	 * Migrated by: 	Deepak
	 * 
	 * Verified: 		Yes
	 * Verified By: 	Deepak
	 */
	//function getSupplieeForSupplierJson($restaurantId, $farmId, $manufactureId, $distributorId) {
	function getSupplieeForSupplierJson($farmId) {
		global $SUPPLIER_TYPES_2, $PER_PAGE;
		
		$p = $this->input->post('p'); // Page
		$pp = $this->input->post('pp'); // Per Page
		$sort = $this->input->post('sort');
		$order = $this->input->post('order');
		
		$q = $this->input->post('q');
		
		if ($q == '0') {
			$q = '';
		}
		
		$tables = array();
		
		if ( !empty($farmId) ) {
			$keyToSearch = 'farm';
			$fieldValue = $farmId;
		}
		
		$supplierFieldName = 'supplier_' . $keyToSearch . '_id';
		
		$companies = array();
		
		$arrQueryCount = array();
		$arrQuery = array();
		
		$query_count = 'SELECT count(*) '
				. ' FROM supplier, producer'
				. ' WHERE supplier.supplier = ' . $fieldValue
				. ' AND supplier.suppliee = producer.producer_id';
		
		$arrQueryCount[] = $query_count;
		
		/*
		$query_count = 'SELECT count(*) '
				. ' FROM farmers_market_supplier, producer'
				. ' WHERE farmers_market_supplier.producer_id = ' . $fieldValue
				. ' AND farmers_market_supplier.producer_id = producer.producer_id';
		
		$arrQueryCount[] = $query_count;
		*/
		
		$query = 'SELECT supplier_id as id, supplier, suppliee, producer_id, producer, '
				. ' is_restaurant_chain, is_restaurant, is_farm, is_manufacture, is_distributor, is_farmers_market'
				. ' FROM supplier, producer'
				. ' WHERE supplier.supplier = ' . $fieldValue
				. ' AND supplier.suppliee = producer.producer_id';
		
		$arrQuery[] = $query;
		/*
		$query = 'SELECT farmers_market_supplier_id as id, farmers_market_supplier.producer_id as supplier, farmers_market_id as suppliee, producer.producer_id, producer.producer, '
				. ' NULL AS is_restaurant_chain, NULL AS is_restaurant, NULL AS is_farm, NULL AS is_manufacture, NULL AS is_distributor, 1 as is_farmers_market'
				. ' FROM farmers_market_supplier, producer'
				. ' WHERE farmers_market_supplier.producer_id = ' . $fieldValue
				. ' AND farmers_market_supplier.producer_id = producer.producer_id';
			
		$arrQuery[] = $query;
		*/
		$query_count = 'SELECT';
		$i = 0;
		foreach ($arrQueryCount as $query) {
			if ($i != 0) {
				$query_count .= ' + (' . $query . ') ';
			} else {
				$query_count .= ' (' . $query . ') ';
			}
			
			$i++;
		}
							
		$query_count .= ' AS num_records';
		
		$result = $this->db->query($query_count);
		$row = $result->row();
		$numResults = $row->num_records;
		
		/*
		 * this query may look weird, but there is no other option.
		 * Using CONCAT to know if record belongs to rstaurant or restaurant_chain
		 */
		 
		$query = '';
		$i = 0;
		foreach ($arrQuery as $qr) {
			if ($i != 0) {
				$query .= ' UNION (' . $qr . ') ';
			} else {
				$query .= ' (' . $qr . ') ';
			}
			$i++;
		}
		
		$start = 0;
		$page = 0;
		
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
		
		log_message('debug', "SupplierModel.getSupplieeForSupplierJson : " . $query);
		
		$result = $this->db->query($query);
		
		$companies = array();
		$CI =& get_instance();
		
		foreach ($result->result_array() as $row) {
			
			$this->load->library('CompanyLib');
			unset($this->companyLib);
			
			$CI->load->model('AddressModel','',true);
			
			$this->companyLib->companyId = $row['producer_id'];
			$this->companyLib->companyName = $row['producer'];
			
			$addresses = $CI->AddressModel->getAddressForProducer($row['producer_id'], '', '', '');
			$this->companyLib->addresses = $addresses;
			
			$this->companyLib->customUrl = '';
			$firstAddressId = '';
			
			if ( $row['is_restaurant'] == '1' ) {
				$this->companyLib->type = 'restaurant';
				
			} else if ( $row['is_farm'] == '1' ) {
				$this->companyLib->type = 'farm';
				
			} else if ( $row['is_manufacture'] == '1' ) {
				$this->companyLib->type = 'manufacture';
				
			} else if ( $row['is_distributor'] == '1' ) {
				$this->companyLib->type = 'distributor';
				
			} else if ( $row['is_farmers_market'] == '1' ) {
				$this->companyLib->type = 'farmersmarket';
				
			} else if ( $row['is_restaurant_chain'] == '1' ) {
				$this->companyLib->type = 'chain';
				$this->companyLib->addresses = '';
			} 
			
			foreach ($addresses as $key => $address) {
				$firstAddressId = $address->addressId;
				break;
			}
			
			if ($firstAddressId != '') {
				$CI->load->model('CustomUrlModel','',true);
				$customUrl = $CI->CustomUrlModel->getCustomUrlForProducerAddress($row['producer_id'], $firstAddressId);
				$this->companyLib->customUrl = $customUrl;
			}
			
			$companies[] = $this->companyLib;
			unset($this->companyLib);
		}
		
		if (!empty($pp) && $pp == 'all') {
			$PER_PAGE = $numResults;
		}
		
		$totalPages = ceil($numResults/$PER_PAGE);
		$first = 0;
		$last = $totalPages - 1;		
		
		$params = requestToParams($numResults, $start, $totalPages, $first, $last, $page, $sort, $order, $q, '', '');
		$arr = array(
			'results'    => $companies,
			'param'      => $params,
	    );
	    
	    return $arr;
	}
	
	function getQueueSuppliersJson() {
		global $PER_PAGE;
		
		$p = $this->input->post('p'); // Page
		$pp = $this->input->post('pp'); // Per Page
		$sort = $this->input->post('sort');
		$order = $this->input->post('order');
		
		$q = $this->input->post('q');
		
		$start = 0;
		$page = 0;
		
		if ($q == '0') {
			$q = '';
		}
		
		$query_count = 'SELECT count(*) AS num_records FROM supplier';
		
		$query = "SELECT supplier.*,producer.*,user.email AS email 
					FROM supplier LEFT JOIN producer ON supplier.supplier=producer.producer_id 
					LEFT JOIN user ON supplier.user_id=user.user_id ";		
		
		$where = ' WHERE supplier.status = \'queue\' ';

		if ( !empty($q) ) {
			$where .= ' AND (producer.producer like "%' .$q . '%")';
		}

		$query .= $where;
		$query_count .= $where;
		
		$result = $this->db->query($query_count);
		$row = $result->row();
		$numResults = $row->num_records;
		
		if ( empty($sort) ) {
			$sort_query = ' ORDER BY producer.producer';
			$sort = 'producer.producer';
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

		log_message('debug', "SupplierModel.getQueueSuppliersJson : " . $query);
		$result = $this->db->query($query);
		
		$suppliers = array();
		$CI =& get_instance();

		$x=0;
		$results = array();
		foreach ($result->result_array() as $row) {
			$query = "SELECT producer FROM producer WHERE producer_id=".$row['suppliee'];
			$rs = $this->db->query($query)->result_array();
			$results[] = $row;
			$results[$x]['suppliee_name'] = $rs[0]['producer'];
			$x++;
		}
		
		foreach ($results as $row) {
			
			$this->load->library('SupplierLib');
			unset($this->supplierLib);
			
			$CI->load->model('AddressModel','',true);
			
//			$this->supplierLib->supplierId = $row['supplier'];
//			$this->supplierLib->parentType = $row['type'];
//			$this->supplierLib->parentId = $row['id'];
//			$this->supplierLib->parentName = $row['parent_name'];
			$this->supplierLib->supplierName = $row['producer'];
			$this->supplierLib->supplieeName = $row['suppliee_name'];

			if (isset( $row['is_restaurant']) ) {
				$this->supplierLib->supplierType = 'restaurant';
//				$this->supplierLib->supplierReferenceId = $row['supplier_restaurant_id'];
				
			} else if ( isset($row['is_farm']) ) {
				$this->supplierLib->supplierType = 'farm';

//				$this->supplierLib->supplierReferenceId = $row['supplier_farm_id'];
				
			} else if ( isset($row['is_manufacture']) ) {
				$this->supplierLib->supplierType = 'manufacture';
//				$this->supplierLib->supplierReferenceId = $row['supplier_manufacture_id'];
				
			} else if ( isset($row['is_distributor']) ) {
				$this->supplierLib->supplierType = 'distributor';
//				$this->supplierLib->supplierReferenceId = $row['supplier_distributor_id'];
				
			}
			$this->supplierLib->userId = $row['user_id'];
			$this->supplierLib->email = $row['email'];
			$this->supplierLib->ip = $row['track_ip'];
			
			$suppliers[] = $this->supplierLib;
			unset($this->supplierLib);
		}
		
		
		
		if (!empty($pp) && $pp == 'all') {
			$PER_PAGE = $numResults;
		}
		
		$totalPages = ceil($numResults/$PER_PAGE);
		$first = 0;
		$last = $totalPages - 1;		
		
		$params = requestToParams($numResults, $start, $totalPages, $first, $last, $page, $sort, $order, $q, '', '');
		$arr = array(
			'results'    => $suppliers,
			'param'      => $params,
	    );
	    
	    return $arr;
	}
	
	
	function getQueueSuppliersJson_old() {
		global $PER_PAGE;
		
		$p = $this->input->post('p'); // Page
		$pp = $this->input->post('pp'); // Per Page
		$sort = $this->input->post('sort');
		$order = $this->input->post('order');
		
		$q = $this->input->post('q');
		
		if ($q == '0') {
			$q = '';
		}
		
		$status = 'queue';
		
		$query_count = 'SELECT 
							(SELECT count(*)
							FROM restaurant_supplier 
							LEFT JOIN farm 
								ON restaurant_supplier.supplier_farm_id = farm.farm_id 
							LEFT JOIN distributor 
								ON restaurant_supplier.supplier_distributor_id = distributor.distributor_id 
							LEFT JOIN manufacture 
								ON restaurant_supplier.supplier_manufacture_id = manufacture.manufacture_id 
							LEFT JOIN restaurant 
								ON restaurant_supplier.supplier_restaurant_id = restaurant.restaurant_id 
							WHERE restaurant_supplier.status = \''.$status.'\')  
							
							+
							
							(SELECT 
								count(*)
							FROM restaurant_chain_supplier 
							LEFT JOIN farm 
								ON restaurant_chain_supplier.supplier_farm_id = farm.farm_id 
							LEFT JOIN distributor 
								ON restaurant_chain_supplier.supplier_distributor_id = distributor.distributor_id 
							LEFT JOIN manufacture 
								ON restaurant_chain_supplier.supplier_manufacture_id = manufacture.manufacture_id 
							WHERE restaurant_chain_supplier.status = \''.$status.'\')  
							
							+
							
							(SELECT count(*)
							FROM distributor_supplier 
							LEFT JOIN farm 
								ON distributor_supplier.supplier_farm_id = farm.farm_id 
							LEFT JOIN distributor 
								ON distributor_supplier.supplier_distributor_id = distributor.distributor_id 
							LEFT JOIN manufacture 
								ON distributor_supplier.supplier_manufacture_id = manufacture.manufacture_id 
							LEFT JOIN restaurant 
								ON distributor_supplier.supplier_restaurant_id = restaurant.restaurant_id 
							WHERE distributor_supplier.status = \''.$status.'\')  
							
							+
							
							(SELECT count(*)
							FROM manufacture_supplier 
							LEFT JOIN farm 
								ON manufacture_supplier.supplier_farm_id = farm.farm_id 
							LEFT JOIN distributor 
								ON manufacture_supplier.supplier_distributor_id = distributor.distributor_id 
							LEFT JOIN manufacture 
								ON manufacture_supplier.supplier_manufacture_id = manufacture.manufacture_id 
							LEFT JOIN restaurant 
								ON manufacture_supplier.supplier_restaurant_id = restaurant.restaurant_id 
							WHERE manufacture_supplier.status = \''.$status.'\')  
							
							+
							
							(SELECT count(*)
							FROM farm_supplier 
							LEFT JOIN farm 
								ON farm_supplier.supplier_farm_id = farm.farm_id 
							LEFT JOIN distributor 
								ON farm_supplier.supplier_distributor_id = distributor.distributor_id 
							LEFT JOIN manufacture 
								ON farm_supplier.supplier_manufacture_id = manufacture.manufacture_id 
							LEFT JOIN restaurant 
								ON farm_supplier.supplier_restaurant_id = restaurant.restaurant_id 
							WHERE farm_supplier.status = \''.$status.'\')  
							
							+
							
							(SELECT count(*)
							FROM farmers_market_supplier 
							LEFT JOIN farm 
								ON farmers_market_supplier.supplier_farm_id = farm.farm_id 
							WHERE farmers_market_supplier.status = \''.$status.'\')  
							
							AS num_records
							';
		
		$result = $this->db->query($query_count);
		$row = $result->row();
		$numResults = $row->num_records;
		
		
		$query = '(SELECT 
						restaurant_supplier.restaurant_supplier_id as supplier_id, restaurant_supplier.restaurant_id AS id, CONCAT(\'restaurant\') AS type,
						restaurant_supplier.supplier_farm_id, farm.farm_name, 
						restaurant_supplier.supplier_manufacture_id, manufacture.manufacture_name, 
						restaurant_supplier.supplier_distributor_id, distributor.distributor_name,
						restaurant_supplier.supplier_restaurant_id, restaurant.restaurant_name,
						(
							SELECT restaurant_name 
							FROM restaurant
							WHERE restaurant.restaurant_id = restaurant_supplier.restaurant_id
						) AS parent_name,
						restaurant_supplier.user_id, restaurant_supplier.track_ip, user.email, user.first_name
					FROM restaurant_supplier 
					LEFT JOIN farm 
						ON restaurant_supplier.supplier_farm_id = farm.farm_id 
					LEFT JOIN distributor 
						ON restaurant_supplier.supplier_distributor_id = distributor.distributor_id 
					LEFT JOIN manufacture 
						ON restaurant_supplier.supplier_manufacture_id = manufacture.manufacture_id 
					LEFT JOIN restaurant 
						ON restaurant_supplier.supplier_restaurant_id = restaurant.restaurant_id 
					LEFT JOIN user 
						ON restaurant_supplier.user_id = user.user_id 
					WHERE restaurant_supplier.status = \''.$status.'\')  
					
					UNION
					
					(SELECT 
						restaurant_chain_supplier.restaurant_chain_supplier_id as supplier_id, restaurant_chain_supplier.restaurant_chain_id AS id, CONCAT(\'restaurantchain\') AS type,
						restaurant_chain_supplier.supplier_farm_id, farm.farm_name, 
						restaurant_chain_supplier.supplier_manufacture_id, manufacture.manufacture_name, 
						restaurant_chain_supplier.supplier_distributor_id, distributor.distributor_name,
						NULL AS supplier_restaurant_id, NULL AS restaurant_name,
						(
							SELECT restaurant_chain 
							FROM restaurant_chain
							WHERE restaurant_chain.restaurant_chain_id = restaurant_chain_supplier.restaurant_chain_id
						) AS parent_name,
						restaurant_chain_supplier.user_id, restaurant_chain_supplier.track_ip, user.email, user.first_name
					FROM restaurant_chain_supplier 
					LEFT JOIN farm 
						ON restaurant_chain_supplier.supplier_farm_id = farm.farm_id 
					LEFT JOIN distributor 
						ON restaurant_chain_supplier.supplier_distributor_id = distributor.distributor_id 
					LEFT JOIN manufacture 
						ON restaurant_chain_supplier.supplier_manufacture_id = manufacture.manufacture_id 
					LEFT JOIN user 
						ON restaurant_chain_supplier.user_id = user.user_id 
					WHERE restaurant_chain_supplier.status = \''.$status.'\')
					
					UNION
					
					(SELECT 
						distributor_supplier.distributor_supplier_id as supplier_id, distributor_supplier.distributor_id AS id, CONCAT(\'distributor\') AS type,
						distributor_supplier.supplier_farm_id, farm.farm_name, 
						distributor_supplier.supplier_manufacture_id, manufacture.manufacture_name, 
						distributor_supplier.supplier_distributor_id, distributor.distributor_name,
						distributor_supplier.supplier_restaurant_id, restaurant.restaurant_name,
						(
							SELECT distributor_name 
							FROM distributor
							WHERE distributor.distributor_id = distributor_supplier.distributor_id
						) AS parent_name,
						distributor_supplier.user_id, distributor_supplier.track_ip, user.email, user.first_name
					FROM distributor_supplier 
					LEFT JOIN farm 
						ON distributor_supplier.supplier_farm_id = farm.farm_id 
					LEFT JOIN distributor 
						ON distributor_supplier.supplier_distributor_id = distributor.distributor_id 
					LEFT JOIN manufacture 
						ON distributor_supplier.supplier_manufacture_id = manufacture.manufacture_id 
					LEFT JOIN restaurant 
						ON distributor_supplier.supplier_restaurant_id = restaurant.restaurant_id 
					LEFT JOIN user 
						ON distributor_supplier.user_id = user.user_id 
					WHERE distributor_supplier.status = \''.$status.'\')  
					
					UNION
					
					(SELECT 
						manufacture_supplier.manufacture_supplier_id as supplier_id, manufacture_supplier.manufacture_id AS id, CONCAT(\'manufacture\') AS type,
						manufacture_supplier.supplier_farm_id, farm.farm_name, 
						manufacture_supplier.supplier_manufacture_id, manufacture.manufacture_name, 
						manufacture_supplier.supplier_distributor_id, distributor.distributor_name,
						manufacture_supplier.supplier_restaurant_id, restaurant.restaurant_name,
						(
							SELECT manufacture_name 
							FROM manufacture
							WHERE manufacture.manufacture_id = manufacture_supplier.manufacture_id
						) AS parent_name,
						manufacture_supplier.user_id, manufacture_supplier.track_ip, user.email, user.first_name
					FROM manufacture_supplier 
					LEFT JOIN farm 
						ON manufacture_supplier.supplier_farm_id = farm.farm_id 
					LEFT JOIN distributor 
						ON manufacture_supplier.supplier_distributor_id = distributor.distributor_id 
					LEFT JOIN manufacture 
						ON manufacture_supplier.supplier_manufacture_id = manufacture.manufacture_id 
					LEFT JOIN restaurant 
						ON manufacture_supplier.supplier_restaurant_id = restaurant.restaurant_id 
					LEFT JOIN user 
						ON manufacture_supplier.user_id = user.user_id 
					WHERE manufacture_supplier.status = \''.$status.'\')  
					
					UNION
					
					(SELECT 
						farm_supplier.farm_supplier_id as supplier_id, farm_supplier.farm_id AS id, CONCAT(\'farm\') AS type,
						farm_supplier.supplier_farm_id, farm.farm_name, 
						farm_supplier.supplier_manufacture_id, manufacture.manufacture_name, 
						farm_supplier.supplier_distributor_id, distributor.distributor_name,
						farm_supplier.supplier_restaurant_id, restaurant.restaurant_name,
						(
							SELECT farm_name 
							FROM farm
							WHERE farm.farm_id = farm_supplier.farm_id
						) AS parent_name,
						farm_supplier.user_id, farm_supplier.track_ip, user.email, user.first_name
					FROM farm_supplier 
					LEFT JOIN farm 
						ON farm_supplier.supplier_farm_id = farm.farm_id 
					LEFT JOIN distributor 
						ON farm_supplier.supplier_distributor_id = distributor.distributor_id 
					LEFT JOIN manufacture 
						ON farm_supplier.supplier_manufacture_id = manufacture.manufacture_id 
					LEFT JOIN restaurant 
						ON farm_supplier.supplier_restaurant_id = restaurant.restaurant_id 
					LEFT JOIN user 
						ON farm_supplier.user_id = user.user_id 
					WHERE farm_supplier.status = \''.$status.'\')  
					
					UNION
					
					(SELECT 
						farmers_market_supplier.farmers_market_supplier_id as supplier_id, farmers_market_supplier.farmers_market_id AS id, CONCAT(\'farmersmarket\') AS type,
						farmers_market_supplier.supplier_farm_id, farm.farm_name, 
						NULL AS supplier_manufacture_id, NULL AS manufacture_name,
						NULL AS supplier_distributor_id, NULL AS distributor_name,
						NULL AS supplier_restaurant_id, NULL AS restaurant_name,
						(
							SELECT farmers_market_name 
							FROM farmers_market
							WHERE farmers_market.farmers_market_id = farmers_market_supplier.farmers_market_id
						) AS parent_name,
						farmers_market_supplier.user_id, farmers_market_supplier.track_ip, user.email, user.first_name
					FROM farmers_market_supplier 
					LEFT JOIN farm 
						ON farmers_market_supplier.supplier_farm_id = farm.farm_id 
					LEFT JOIN user 
						ON farmers_market_supplier.user_id = user.user_id 
					WHERE farmers_market_supplier.status = \''.$status.'\')      
					';
		
		$start = 0;
		$page = 0;
		
		if ( empty($sort) ) {
			$sort_query = ' ORDER BY supplier_id';
			$sort = 'supplier_id';
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
		
		log_message('debug', "SupplierModel.getQueueSuppliersJson : " . $query);
		$result = $this->db->query($query);
		
		$suppliers = array();
		$CI =& get_instance();
		
		foreach ($result->result_array() as $row) {
			
			$this->load->library('SupplierLib');
			unset($this->supplierLib);
			
			$CI->load->model('AddressModel','',true);
			
			$this->supplierLib->supplierId = $row['supplier_id'];
			$this->supplierLib->parentType = $row['type'];
			$this->supplierLib->parentId = $row['id'];
			$this->supplierLib->parentName = $row['parent_name'];
			
			if (isset( $row['restaurant_name']) ) {
				$this->supplierLib->supplierType = 'restaurant';
				$this->supplierLib->supplierName = $row['restaurant_name'];
				$this->supplierLib->supplierReferenceId = $row['supplier_restaurant_id'];
				
			} else if ( isset($row['farm_name']) ) {
				$this->supplierLib->supplierType = 'farm';
				$this->supplierLib->supplierName = $row['farm_name'];
				$this->supplierLib->supplierReferenceId = $row['supplier_farm_id'];
				
			} else if ( isset($row['manufacture_name']) ) {
				$this->supplierLib->supplierType = 'manufacture';
				$this->supplierLib->supplierName = $row['manufacture_name'];
				$this->supplierLib->supplierReferenceId = $row['supplier_manufacture_id'];
				
			} else if ( isset($row['distributor_name']) ) {
				$this->supplierLib->supplierType = 'distributor';
				$this->supplierLib->supplierName = $row['distributor_name'];
				$this->supplierLib->supplierReferenceId = $row['supplier_distributor_id'];
				
			}
			$this->supplierLib->userId = $row['user_id'];
			$this->supplierLib->email = $row['email'];
			$this->supplierLib->ip = $row['track_ip'];
			
			$suppliers[] = $this->supplierLib;
			unset($this->supplierLib);
		}
		
		
		
		if (!empty($pp) && $pp == 'all') {
			$PER_PAGE = $numResults;
		}
		
		$totalPages = ceil($numResults/$PER_PAGE);
		$first = 0;
		$last = $totalPages - 1;		
		
		$params = requestToParams($numResults, $start, $totalPages, $first, $last, $page, $sort, $order, $q, '', '');
		$arr = array(
			'results'    => $suppliers,
			'param'      => $params,
	    );
	    
	    return $arr;
	}
	
	
	function getSuppliersByUserJson() {
		global $PER_PAGE;
		
		$p = $this->input->post('p'); // Page
		$pp = $this->input->post('pp'); // Per Page
		$sort = $this->input->post('sort');
		$order = $this->input->post('order');
		
		$q = $this->input->post('q'); // User ID
		
		if ($q == '0') {
			$q = '';
		}
		
		//$status = 'queue';
		$userId  = $this->session->userdata['userId'];
		
		/** $base_query_count */
		$query = 'SELECT count(*) AS num_records' 
				. ' FROM supplier' 
				. ' WHERE user_id = '.$userId;
		
		$result = $this->db->query($query);
		$row = $result->row();
		$numResults = $row->num_records;
		
		/** $base_query*/
		$base_query = 'SELECT supplier.*, '
					. ' pr1.producer as supplier_name, pr1.producer_id as supplier_producer_id, ' 
					. ' pr1.is_restaurant as supplier_is_restaurant, pr1.is_farm as supplier_is_farm, pr1.is_manufacture as supplier_is_manufacture, pr1.is_distributor as supplier_is_distributor, ' 
					
					. ' pr2.producer as suppliee_name, pr2.producer_id as suppliee_producer_id,  '
					. ' pr2.is_restaurant as suppliee_is_restaurant, pr2.is_farm as suppliee_is_farm, pr2.is_manufacture as suppliee_is_manufacture, pr2.is_distributor as suppliee_is_distributor, pr2.is_restaurant_chain as suppliee_is_restaurant_chain, pr2.is_farmers_market as suppliee_is_farmers_market, '
				
					. ' user.email, user.first_name'
					
					. ' FROM supplier '
					. ' INNER JOIN producer pr1 ON supplier.supplier = pr1.producer_id ' 
					. ' INNER JOIN producer pr2 ON supplier.suppliee = pr2.producer_id '
					. ' INNER JOIN user ON supplier.user_id = user.user_id ';
					
		$where = ' WHERE supplier.user_id = ' . $userId;
		$query = $base_query . $where;	
		
		$start = 0;
		$page = 0;
		
		if ( empty($sort) ) {
			$sort_query = ' ORDER BY supplier_id';
			//$sort_query = ' ORDER BY producer.producer';
			
			$sort = 'supplier_id';
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
		
		log_message('debug', "SupplierModel.getQueueSuppliersJson : " . $query);
		$result = $this->db->query($query);
		
		$suppliers = array();
		$CI =& get_instance();
		$CI->load->model('CustomUrlModel','',true);
		$CI->load->model('AddressModel','',true);
		
		foreach ($result->result_array() as $row) {
			
			$this->load->library('SupplierLib');
			unset($this->supplierLib);
			
			$this->supplierLib->supplierId = $row['supplier'];
			$this->supplierLib->supplierName = $row['supplier_name'];
			
			if ( $row['supplier_is_restaurant'] == '1' ) {
				$this->supplierLib->supplierType = 'restaurant';
			} else if ( $row['supplier_is_farm'] == '1' ) {
				$this->supplierLib->supplierType = 'farm';
			} else if ( $row['supplier_is_manufacture'] == '1' ) {
				$this->supplierLib->supplierType = 'manufacture';
			} else if ( $row['supplier_is_distributor'] == '1' ) {
				$this->supplierLib->supplierType = 'distributor';
			}
			
			$addresses = $CI->AddressModel->getAddressForProducer($row['supplier']);
			$this->supplierLib->supplierAddresses = $addresses;
			
			$this->supplierLib->supplierCustomUrl = '';
			$firstAddressId = '';
			
			foreach ($addresses as $key => $address) {
				$firstAddressId = $address->addressId;
				break;
			}
			
			if ($firstAddressId != '') {
				$customUrl = $CI->CustomUrlModel->getCustomUrlForProducerAddress($row['supplier'], $firstAddressId);
				$this->supplierLib->supplierCustomUrl = $customUrl;
			}
			
			$this->supplierLib->parentId = $row['suppliee'];
			$this->supplierLib->parentName = $row['suppliee_name'];
			
			if ( $row['suppliee_is_restaurant'] == '1' ) {
				$this->supplierLib->parentType = 'restaurant';
			} else if ( $row['suppliee_is_farm'] == '1' ) {
				$this->supplierLib->parentType = 'farm';
			} else if ( $row['suppliee_is_manufacture'] == '1' ) {
				$this->supplierLib->parentType = 'manufacture';
			} else if ( $row['suppliee_is_distributor'] == '1' ) {
				$this->supplierLib->parentType = 'distributor';
			} else if ( $row['suppliee_is_restaurant_chain'] == '1' ) {
				$this->supplierLib->parentType = 'chain';
			} else if ( $row['suppliee_is_farmers_market'] == '1' ) {
				$this->supplierLib->parentType = 'farmersmarket';
			}
			
			$addresses = $CI->AddressModel->getAddressForProducer($row['suppliee']);
			$this->supplierLib->supplieeAddresses = $addresses;
			
			$this->supplierLib->supplieeCustomUrl = '';
			$firstAddressId = '';
			
			foreach ($addresses as $key => $address) {
				$firstAddressId = $address->addressId;
				break;
			}
			
			if ($firstAddressId != '') {
				$customUrl = $CI->CustomUrlModel->getCustomUrlForProducerAddress($row['suppliee'], $firstAddressId);
				$this->supplierLib->supplieeCustomUrl = $customUrl;
			}
			
			$this->supplierLib->userId = $row['user_id'];
			$this->supplierLib->email = $row['email'];
			$this->supplierLib->ip = $row['track_ip'];
			$this->supplierLib->status = $row['status'];
			
			$suppliers[] = $this->supplierLib;
			unset($this->supplierLib);
		}
		
		
		if (!empty($pp) && $pp == 'all') {
			$PER_PAGE = $numResults;
		}
		
		$totalPages = ceil($numResults/$PER_PAGE);
		$first = 0;
		$last = $totalPages - 1;		
		
		$params = requestToParams($numResults, $start, $totalPages, $first, $last, $page, $sort, $order, $q, '', '');
		$arr = array(
			'results'    => $suppliers,
			'param'      => $params,
	    );
	    return $arr;
	}
	
}



?>