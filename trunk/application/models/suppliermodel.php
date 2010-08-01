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
			$query .= " )";
			
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
		
		
		log_message('debug', "AddressModel.getAddressForCompany : " . $query);
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
		
		log_message('debug', 'SupplierModel.addSuppluer : Try to get duplicate supplier record : ' . $query);
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
	
}



?>