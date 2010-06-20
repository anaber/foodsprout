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
		
		return $return;
	}
	
	function getSupplierForCompany($restaurantId, $farmId, $manufactureId, $distributorId) {
		
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
		}
		
		$suppliers = array();
		
		$query = "SELECT $tableName.*, manufacture.manufacture_name, farm.farm_name, restaurant.restaurant_name, distributor.distributor_name" .
				" FROM $tableName " .
				" LEFT JOIN manufacture" .
				" ON $tableName.supplier_manufacture_id = manufacture.manufacture_id" .
				" LEFT JOIN farm" .
				" ON $tableName.supplier_farm_id = farm.farm_id" .
				" LEFT JOIN restaurant" .
				" ON $tableName.supplier_restaurant_id = restaurant.restaurant_id" .
				" LEFT JOIN distributor" .
				" ON $tableName.supplier_distributor_id = distributor.distributor_id" .
				" WHERE $tableName.$fieldName = $fieldValue";
		//echo $query . "<BR /><BR />";
		
		
		log_message('debug', "AddressModel.getAddressForCompany : " . $query);
		$result = $this->db->query($query);
		
		foreach ($result->result_array() as $row) {
			
			$this->load->library('SupplierLib');
			unset($this->supplierLib);
			
			$this->supplierLib->supplierId = $row[$idFieldName];
			if ($row['restaurant_name']) {
				$this->supplierLib->supplierType = 'restaurant';
				$this->supplierLib->supplierName = $row['restaurant_name'];
			} else if ($row['farm_name']) {
				$this->supplierLib->supplierType = 'farm';
				$this->supplierLib->supplierName = $row['farm_name'];
			} else if ($row['manufacture_name']) {
				$this->supplierLib->supplierType = 'manufacture';
				$this->supplierLib->supplierName = $row['manufacture_name'];
			} else if ($row['distributor_name']) {
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
		
		//$query = "SELECT * FROM $tableName WHERE $idFieldName = " . $supplierId;
		
		$query = 'SELECT ' . $tableName . '.*, ' . $supplierType.'.'.$supplierType . '_name ' .
				' FROM '.$tableName .', '. $supplierType .
				' WHERE ' . $tableName . '.' . $idFieldName . ' = ' . $supplierId . 
				' AND ' . $tableName . '.' . 'supplier_'.$supplierType.'_id = ' . $supplierType . '.' . $supplierType . '_id';
		
		
		log_message('debug', "SupplierModel.getSupplierFromId : " . $query);
		$result = $this->db->query($query);
		
		$this->load->library('SupplierLib');
		
		$row = $result->row();
		
		$this->supplierLib->supplierId = $row->$idFieldName;
		$str = $supplierType . '_name';
		$this->supplierLib->companyName = $row->$str;
		
		if ($row->$fieldName) {
			if ($supplierType == 'manufacture') {
				$this->supplierLib->manufactureId = $row->$fieldName;
			} else if ($supplierType == 'farm') {
				$this->supplierLib->farmId = $row->$fieldName;
			} else if ($supplierType == 'restaurant') {
				$this->supplierLib->restaurantId = $row->$fieldName;
			} else if ($supplierType == 'distributor') {
				$this->supplierLib->distributorId = $row->$fieldName;
			}
		}
		
		if ($row->supplier_farm_id ) {
			$this->supplierLib->companyId = $row->supplier_farm_id;
			$this->supplierLib->supplierType = 'farm';
		} else if ($row->supplier_manufacture_id ) {
			$this->supplierLib->companyId = $row->supplier_manufacture_id;
			$this->supplierLib->supplierType = 'manufacture';
		} else if ($row->supplier_distributor_id ) {
			$this->supplierLib->companyId = $row->supplier_distributor_id;
			$this->supplierLib->supplierType = 'distributor';
		} else if ($row->supplier_restaurant_id ) {
			$this->supplierLib->companyId = $row->supplier_restaurant_id;
			$this->supplierLib->supplierType = 'restaurant';
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
		
		return $return;
	}
	
}



?>