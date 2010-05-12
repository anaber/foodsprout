<?php

class AddressModel extends Model{
	
	function prepareAddress($streetNumber, $street, $city, $state_id, $country_id, $zipcode) {
		$CI =& get_instance();
		$CI->load->model('StateModel','',true);
		$arrState = $CI->StateModel->getStateFromId($state_id);
		
		$CI->load->model('CountryModel','',true);
		$arrCountry = $CI->CountryModel->getCountryFromId($country_id);
		
		$address = $streetNumber . ' ' . $street . ' ' . $city . ' ' . $arrState->stateName . ' ' . $arrCountry->countryName . ' ' . $zipcode;
		
		return $address;
	}
	
	function getAddressForCompany($restaurantId, $farmId, $manufactureId, $distributorId) {
		
		$addresses = array();
		
		$query = "SELECT address.*, state.state_code, state.state_name, country.country_name" .
				" FROM address, state, country " .
				" WHERE ";
		if (!empty($restaurantId) ) {
			$query .= "restaurant_id = " . $restaurantId;
		} elseif (!empty($farmId) ) {
			$query .= "farm_id = " . $farmId;
		} elseif (!empty($manufactureId) ) {
			$query .= "manufacture_id = " . $manufactureId;
		} elseif (!empty($distributorId) ) {
			$query .= "distributor_id = " . $distributorId;
		}
			$query .= " AND address.state_id = state.state_id" .
					" AND address.country_id = country.country_id" .
					" ORDER BY address_id";
		
		log_message('debug', "AddressModel.getAddressForCompany : " . $query);
		$result = $this->db->query($query);
		
		foreach ($result->result_array() as $row) {
			
			$this->load->library('AddressLib');
			unset($this->addressLib);
			
			$this->addressLib->addressId = $row['address_id'];
			$this->addressLib->streetNumber = $row['street_number'];
			$this->addressLib->street = $row['street'];
			$this->addressLib->city = $row['city'];
			$this->addressLib->cityId = $row['city_id'];
			$this->addressLib->stateId = $row['state_id'];
			$this->addressLib->state = $row['state_name'];
			$this->addressLib->stateCode = $row['state_code'];
			$this->addressLib->zipcode = $row['zipcode'];
			$this->addressLib->countryId = $row['country_id'];
			$this->addressLib->country = $row['country_name'];
			$this->addressLib->latitude = $row['latitude'];
			$this->addressLib->longitude = $row['longitude'];
			
			$this->addressLib->completeAddress = $this->prepareAddress($row['street_number'], $row['street'], $row['city'], $row['state_id'], $row['country_id'], $row['zipcode']);
			
			$addresses[] = $this->addressLib;
			unset($this->addressLib);
		}
		
		return $addresses;
		
	}
	
	// Get all the information about one specific manufacture from an ID
	function getAddressFromId($addressId) {
		
		$query = "SELECT * FROM address WHERE address_id = " . $addressId;
		log_message('debug', "AddressModel.getAddressFromId : " . $query);
		$result = $this->db->query($query);
		
		$this->load->library('AddressLib');
		
		$row = $result->row();
		
		$this->addressLib->addressId = $row->address_id;
		$this->addressLib->streetNumber = $row->street_number;
		$this->addressLib->street = $row->street;
		$this->addressLib->city = $row->city;
		$this->addressLib->stateId = $row->state_id;
		$this->addressLib->countryId = $row->country_id;
		$this->addressLib->zipcode = $row->zipcode;
		
		
		$this->addressLib->farmId = $row->farm_id;
		$this->addressLib->restaurantId = $row->restaurant_id;
		$this->addressLib->manufactureId = $row->manufacture_id;
		$this->addressLib->distributorId = $row->distributor_id;
		
		
		return $this->addressLib;
	}
	
	function addAddress($restaurantId, $farmId, $manufactureId, $distributorId, $companyId) {
		$return = true;
		$CI =& get_instance();
		
		$address = $this->prepareAddress($this->input->post('streetNumber'), $this->input->post('street'), $this->input->post('city'), $this->input->post('stateId'), $this->input->post('countryId'), $this->input->post('zipcode') );
				
		$CI->load->model('GoogleMapModel','',true);
		
		$latLng = $CI->GoogleMapModel->geoCodeAddress($address);
		
		
		$query = "INSERT INTO address (address_id, street_number, street, city, state_id, zipcode, country_id, latitude , longitude, ";
		if ( !empty($restaurantId) ) {
			$query .= 'restaurant_id';
		} else if ( !empty($farmId) ) {
			$query .= 'farm_id';
		} else if ( !empty($manufactureId) ) {
			$query .= 'manufacture_id';
		} else if ( !empty($distributorId) ) {
			$query .= 'distributor_id';
		}
		$query .= ", company_id)" .
				" values (NULL, '" . $this->input->post('streetNumber') . "', '" . $this->input->post('street') . "', '" . $this->input->post('city') . "', '" . $this->input->post('stateId') . "', '" . $this->input->post('zipcode') . "', '" . $this->input->post('countryId') . "', '" . ( isset($latLng['latitude']) ? $latLng['latitude']:'' ) . "', '" . ( isset($latLng['longitude']) ? $latLng['longitude']:'' ) . "', ";
		if ( !empty($restaurantId) ) {
			$query .= $restaurantId;
		} else if ( !empty($farmId) ) {
			$query .= $farmId;
		} else if ( !empty($manufactureId) ) {
			$query .= $manufactureId;
		} else if ( !empty($distributorId) ) {
			$query .= $distributorId;
		}
		$query .= ", $companyId )";
		
		log_message('debug', 'AddressModel.addAddress : Insert Address : ' . $query);
		
		if ( $this->db->query($query) ) {
			$return = true;
		} else {
			$return = false;
		}
		
		return $return;
	}
	
	function addAddressIntermediate() {
		
		$return = true;
		
		$restaurantId = $this->input->post('restaurantId');
		$farmId = $this->input->post('farmId');
		$manufactureId = $this->input->post('manufactureId');
		$distributorId =$this->input->post('distributorId');
		
		$companyId = '';
		
		$CI =& get_instance();
		
		if ( !empty($restaurantId) ) {
			$CI->load->model('RestaurantModel','',true);
			$restaurant = $CI->RestaurantModel->getRestaurantFromId($restaurantId);
			$companyId = $restaurant->companyId;
			
		} else if ( !empty($farmId) ) {
			$CI->load->model('FarmModel','',true);
			$farm = $CI->FarmModel->getFarmFromId($farmId);
			$companyId = $farm->companyId;
			
		} else if ( !empty($manufactureId) ) {
			$CI->load->model('ManufactureModel','',true);
			
			$manufature = $CI->ManufactureModel->getManufactureFromId($manufactureId);
			$companyId = $manufature->companyId;
		} else if ( !empty($distributorId) ) {
			$CI->load->model('DistributorModel','',true);
			$distributor = $CI->DistributorModel->getCompanyFromId($distributorId);
			$companyId = $distributor->companyId;
		}
		
		if ($this->addAddress($restaurantId, $farmId, $manufactureId, $distributorId, $companyId) ) {
			$return = true;
		} else {
			$return = false;
		}
		
		return $return;
		
	}
	
	function updateAddress() {
		$return = true;
		/*
		$query = "SELECT * FROM farm_type WHERE farm_type = '" . $this->input->post('farmType') . "' AND farm_type_id <> " . $this->input->post('farmTypeId');
		log_message('debug', 'FarmTypeModel.updateFarmType : Try to get Duplicate record : ' . $query);
			
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
		*/	
			$data = array(
						'street_number' => $this->input->post('streetNumber'), 
						'street' => $this->input->post('street'),
						'city' => $this->input->post('city'),
						'state_id' => $this->input->post('stateId'),
						'country_id' => $this->input->post('countryId'),
						'zipcode' => $this->input->post('zipcode'),
					);
			$where = "address_id = " . $this->input->post('addressId');
			$query = $this->db->update_string('address', $data, $where);
			
			log_message('debug', 'AddressModel.updateAddress : ' . $query);
			if ( $this->db->query($query) ) {
				$return = true;
			} else {
				$return = false;
			}
		
		return $return;
	}
	
	function getManufactureFromAddressId($addressId) {
		
		$query = "SELECT * FROM address WHERE address_id = " . $addressId;
		log_message('debug', "AddressModel.getManufactureFromAddressId : " . $query);
		$result = $this->db->query($query);
		
		$row = $result->row();
		
		return $row->manufacture_id;
	}
	
}



?>