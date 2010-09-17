<?php

class SupplierModel extends Model{
	
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
		
		$companyId = $this->input->post('companyId');
		$companyName = $this->input->post('companyName');
		
		$supplierRestaurantId = '';
		$supplierFarmId = '';
		$supplierManufactureId = '';
		$supplierDistributorId = '';
		
		
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
				if ($this->addSuppluer($tableName, $idFieldName, $fieldName, $fieldValue, $supplierRestaurantId, $supplierFarmId, $supplierManufactureId, $supplierDistributorId) ) {
					$return = true;
				} else {
					$return = false;
				}
			}
		}
		
		return $return;
		
	}
	
	function addSuppluer($tableName, $idFieldName, $fieldName, $fieldValue, $supplierRestaurantId, $supplierFarmId, $supplierManufactureId, $supplierDistributorId) {
		
		$return = true;
		
		$query = "SELECT * FROM $tableName " .
				" WHERE" .
				" $fieldName = $fieldValue" .
				" AND ";
		if ( !empty($supplierRestaurantId) ) {
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
		log_message('debug', 'SupplierModel.addSuppluer : Try to get duplicate supplier record : ' . $query);
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			$query = "INSERT INTO $tableName ($idFieldName, $fieldName, ";
			if ( !empty($supplierRestaurantId) ) {
				$query .= 'supplier_restaurant_id';
			} else if ( !empty($supplierFarmId) ) {
				$query .= 'supplier_farm_id';
			} else if ( !empty($supplierManufactureId) ) {
				$query .= 'supplier_manufacture_id';
			} else if ( !empty($supplierDistributorId) ) {
				$query .= 'supplier_distributor_id';
			}
			
			$userGroup = $this->session->userdata['userGroup'];
			//if ( $userGroup != 'admin') {
				$query .= ', user_id';
			//}
			$query .= ', status, track_ip';
			
			$query .= ")" .
					" values (NULL, '" . $fieldValue . "', ";
			if ( !empty($supplierRestaurantId) ) {
				$query .= $supplierRestaurantId;
			} else if ( !empty($supplierFarmId) ) {
				$query .= $supplierFarmId;
			} else if ( !empty($supplierManufactureId) ) {
				$query .= $supplierManufactureId;
			} else if ( !empty($supplierDistributorId) ) {
				$query .= $supplierDistributorId;
			}
			//if ( $userGroup != 'admin') {
				$query .= ', ' . $this->session->userdata['userId'];
			//}
			
			if ( $userGroup != 'admin') {
				$query .= ', \'queue\'';
			} else {
				$query .= ', \'live\'';
			}
			$query .= ", '" . getRealIpAddr() . "' )";
			
			log_message('debug', 'SupplierModel.addSuppluer : Insert Suppluer : ' . $query);
			
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
		
		$tableName = $supplierType . '_supplier';
		$idFieldName = $supplierType . '_supplier_id';
		$fieldName = $supplierType . '_id';
		
		$query = "SELECT * FROM $tableName WHERE $idFieldName = " . $supplierId;
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
		
		if ($row->$fieldName) {
			if ($supplierType == 'manufacture') {
				$this->supplierLib->manufactureId = $row->$fieldName;
			} else if ($supplierType == 'farm') {
				$this->supplierLib->farmId = $row->$fieldName;
			} else if ($supplierType == 'restaurant') {
				$this->supplierLib->restaurantId = $row->$fieldName;
			} else if ($supplierType == 'distributor') {
				$this->supplierLib->distributorId = $row->$fieldName;
			} else if ($supplierType == 'restaurant_chain') {
				$this->supplierLib->restaurantChainId = $row->$fieldName;
			} else if ($supplierType == 'farmers_market') {
				$this->supplierLib->farmersMarketId = $row->$fieldName;
			} 
		}
		
		$CI =& get_instance();
		
		if ($row->supplier_farm_id ) {
			$this->supplierLib->companyId = $row->supplier_farm_id;
			$this->supplierLib->supplierType = 'farm';
			
			$CI->load->model('FarmModel','',true);
			$farm = $CI->FarmModel->getFarmFromId( $row->supplier_farm_id );
			$this->supplierLib->companyName = $farm->farmName;
			
		} else if ($row->supplier_manufacture_id ) {
			$this->supplierLib->companyId = $row->supplier_manufacture_id;
			$this->supplierLib->supplierType = 'manufacture';
			
			$CI->load->model('ManufactureModel','',true);
			$farm = $CI->ManufactureModel->getManufactureFromId( $row->supplier_manufacture_id );
			$this->supplierLib->companyName = $farm->manufactureName;
			
		} else if ($row->supplier_distributor_id ) {
			$this->supplierLib->companyId = $row->supplier_distributor_id;
			$this->supplierLib->supplierType = 'distributor';
			
			$CI->load->model('DistributorModel','',true);
			$farm = $CI->DistributorModel->getDistributorFromId( $row->supplier_distributor_id );
			$this->supplierLib->companyName = $farm->distributorName;
			
		} else if ($row->supplier_restaurant_id ) {
			$this->supplierLib->companyId = $row->supplier_restaurant_id;
			$this->supplierLib->supplierType = 'restaurant';
			
			$CI->load->model('RestaurantModel','',true);
			$farm = $CI->RestaurantModel->getRestaurantFromId( $row->supplier_restaurant_id );
			$this->supplierLib->companyName = $farm->restaurantName;
		}

		return $this->supplierLib;
		
	}
	
	function updateSupplierIntermediate() {
		global $GLOBALS;
		$return = true;
		
		$supplierType = $this->input->post('supplierType');
		$supplierId = $this->input->post('supplierId');
		
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
				if ($this->updateSuppluer($tableName, $idFieldName, $fieldName, $fieldValue, $supplierRestaurantId, $supplierFarmId, $supplierManufactureId, $supplierDistributorId, $supplierId ) ) {
					$return = true;
				} else {
					$return = false;
				}
			}
		}
		
		return $return;
		
	}
	
	function updateSuppluer($tableName, $idFieldName, $fieldName, $fieldValue, $supplierRestaurantId, $supplierFarmId, $supplierManufactureId, $supplierDistributorId, $supplierId) {
		
		$return = true;
		
		$query = "SELECT * FROM $tableName " .
				" WHERE" .
				" $fieldName = $fieldValue" .
				" AND ";
		if ( !empty($supplierRestaurantId) ) {
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
		$query .= ' AND ' . $idFieldName . ' <> ' . $supplierId;
		
		log_message('debug', 'SupplierModel.updateSuppluer : Try to get duplicate supplier record : ' . $query);
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			$query = "UPDATE $tableName SET ";
			if ( !empty($supplierRestaurantId) ) {
				$query .= 'supplier_restaurant_id';
			} else if ( !empty($supplierFarmId) ) {
				$query .= 'supplier_farm_id';
			} else if ( !empty($supplierManufactureId) ) {
				$query .= 'supplier_manufacture_id';
			} else if ( !empty($supplierDistributorId) ) {
				$query .= 'supplier_distributor_id';
			}		
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
				
				$addresses = $CI->AddressModel->getAddressForCompany( $row['supplier_restaurant_id'], '', '', '', '', '', '');
				$this->supplierLib->addresses = $addresses;
				
			} else if ( isset($row['farm_name']) ) {
				$this->supplierLib->supplierType = 'farm';
				$this->supplierLib->supplierName = $row['farm_name'];
				$this->supplierLib->supplierReferenceId = $row['supplier_farm_id'];
				
				$addresses = $CI->AddressModel->getAddressForCompany( '', $row['supplier_farm_id'], '', '', '', '', '');
				$this->supplierLib->addresses = $addresses;
				
			} else if ( isset($row['manufacture_name']) ) {
				$this->supplierLib->supplierType = 'manufacture';
				$this->supplierLib->supplierName = $row['manufacture_name'];
				$this->supplierLib->supplierReferenceId = $row['supplier_manufacture_id'];
				
				$addresses = $CI->AddressModel->getAddressForCompany( '', '', $row['supplier_manufacture_id'], '', '', '', '');
				$this->supplierLib->addresses = $addresses;
				
			} else if ( isset($row['distributor_name']) ) {
				$this->supplierLib->supplierType = 'distributor';
				$this->supplierLib->supplierName = $row['distributor_name'];
				$this->supplierLib->supplierReferenceId = $row['supplier_distributor_id'];
				
				$addresses = $CI->AddressModel->getAddressForCompany( '', '', '', $row['supplier_distributor_id'], '', '', '');
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
				
				$addresses = $CI->AddressModel->getAddressForCompany( $row['supplier_restaurant_id'], '', '', '', '', '', '');
				$this->supplierLib->addresses = $addresses;
				
			} else if ( isset($row['farm_name']) ) {
				$this->supplierLib->supplierType = 'farm';
				$this->supplierLib->supplierName = $row['farm_name'];
				$this->supplierLib->supplierReferenceId = $row['supplier_farm_id'];
				
				$addresses = $CI->AddressModel->getAddressForCompany( '', $row['supplier_farm_id'], '', '', '', '', '');
				$this->supplierLib->addresses = $addresses;
				
			} else if ( isset($row['manufacture_name']) ) {
				$this->supplierLib->supplierType = 'manufacture';
				$this->supplierLib->supplierName = $row['manufacture_name'];
				$this->supplierLib->supplierReferenceId = $row['supplier_manufacture_id'];
				
				$addresses = $CI->AddressModel->getAddressForCompany( '', '', $row['supplier_manufacture_id'], '', '', '', '');
				$this->supplierLib->addresses = $addresses;
				
			} else if ( isset($row['distributor_name']) ) {
				$this->supplierLib->supplierType = 'distributor';
				$this->supplierLib->supplierName = $row['distributor_name'];
				$this->supplierLib->supplierReferenceId = $row['supplier_distributor_id'];
				
				$addresses = $CI->AddressModel->getAddressForCompany( '', '', '', $row['supplier_distributor_id'], '', '', '');
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
				
				$addresses = $CI->AddressModel->getAddressForCompany( $row['company_id'], '', '', '', '', '', '');
				$this->companyLib->addresses = $addresses;
				
			} else if ( $row['type'] == 'farm' ) {
				$this->companyLib->type = 'farm';
				
				$addresses = $CI->AddressModel->getAddressForCompany( '', $row['company_id'], '', '', '', '', '');
				$this->companyLib->addresses = $addresses;
				
			} else if ( $row['type'] == 'manufacture' ) {
				$this->companyLib->type = 'manufacture';
				
				$addresses = $CI->AddressModel->getAddressForCompany( '', '', $row['company_id'], '', '', '', '');
				$this->companyLib->addresses = $addresses;
				
			} else if ( $row['type'] == 'distributor' ) {
				$this->companyLib->type = 'distributor';
				
				$addresses = $CI->AddressModel->getAddressForCompany( '', '', '', $row['company_id'], '', '', '');
				$this->companyLib->addresses = $addresses;
				
			} else if ( $row['type'] == 'farmers_market' ) {
				$this->companyLib->type = 'farmersmarket';
				
				$addresses = $CI->AddressModel->getAddressForCompany( '', '', '', '', $row['company_id'], '', '');
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
	
	function getQueueSuppliersJson() {
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
							WHERE restaurant_supplier.user_id = '.$q.')  
							
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
							WHERE restaurant_chain_supplier.user_id = '.$q.')  
							
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
							WHERE distributor_supplier.user_id = '.$q.')  
							
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
							WHERE manufacture_supplier.user_id = '.$q.')  
							
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
							WHERE farm_supplier.user_id = '.$q.')  
							
							+
							
							(SELECT count(*)
							FROM farmers_market_supplier 
							LEFT JOIN farm 
								ON farmers_market_supplier.supplier_farm_id = farm.farm_id 
							WHERE farmers_market_supplier.user_id = '.$q.')  
							
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
						restaurant_supplier.status,
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
					WHERE restaurant_supplier.user_id = '.$q.')  
					
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
						restaurant_chain_supplier.status,
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
					WHERE restaurant_chain_supplier.user_id = '.$q.')
					
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
						distributor_supplier.status,
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
					WHERE distributor_supplier.user_id = '.$q.')  
					
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
						manufacture_supplier.status,
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
					WHERE manufacture_supplier.user_id = '.$q.')  
					
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
						farm_supplier.status,
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
					WHERE farm_supplier.user_id = '.$q.')  
					
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
						farmers_market_supplier.status,
						farmers_market_supplier.user_id, farmers_market_supplier.track_ip, user.email, user.first_name
					FROM farmers_market_supplier 
					LEFT JOIN farm 
						ON farmers_market_supplier.supplier_farm_id = farm.farm_id 
					LEFT JOIN user 
						ON farmers_market_supplier.user_id = user.user_id 
					WHERE farmers_market_supplier.user_id = '.$q.')      
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