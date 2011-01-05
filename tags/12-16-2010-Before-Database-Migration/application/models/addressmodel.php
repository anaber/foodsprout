<?php

class AddressModel extends Model{
	
	function prepareAddress($address, $city, $city_id, $state_id, $country_id, $zipcode) {
		$CI =& get_instance();
		
		if ( !empty($city_id) ) {
			$CI->load->model('CityModel','',true);
			$objCity = $CI->CityModel->getCityFromId($city_id);
			
			$city = $objCity->city;
		}
		
		$CI->load->model('StateModel','',true);
		$objState = $CI->StateModel->getStateFromId($state_id);
		
		$CI->load->model('CountryModel','',true);
		$objCountry = $CI->CountryModel->getCountryFromId($country_id);
		
		$address = $address . ' ' . $city . ' ' . $objState->stateName . ' ' . $objCountry->countryName . ' ' . $zipcode;
		
		return $address;
	}
	
	function prepareAddressToDisplay($address, $city, $city_id, $state_id, $country_id, $zipcode) {
		$CI =& get_instance();
		
		if ( !empty($city_id) ) {
			$CI->load->model('CityModel','',true);
			$objCity = $CI->CityModel->getCityFromId($city_id);
			
			$city = $objCity->city;
		}
		
		$CI->load->model('StateModel','',true);
		$objState = $CI->StateModel->getStateFromId($state_id);
		
		//$CI->load->model('CountryModel','',true);
		//$objCountry = $CI->CountryModel->getCountryFromId($country_id);
		
		$address = $address . '<br>' . $city . ', ' . $objState->stateName . ' ' . $zipcode; // $arrCountry->countryName;
		
		return $address;
	}
	
	function getAddressForCompany($restaurantId, $farmId, $manufactureId, $distributorId, $farmersMarketId, $zipcode, $city, $citySearch) {
		
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
		} elseif (!empty($farmersMarketId) ) {
			$query .= "farmers_market_id = " . $farmersMarketId;
		}
		
		if (!empty($zipcode) ) {
			$city = $this->getCityFromZipcode($zipcode);
			if (!empty($city) ) {
				$query .= ' AND ( address.city_id IN (' . $city . ') OR address.zipcode = \'' . $zipcode . '\')';
			}
		} else if (!empty($city) ) {
			$query .= ' AND address.city_id IN (' . $city . ')';
		} else if ( !empty($citySearch) ) {
			//$query	.= ' AND address.city_id = ' . $citySearch . ' AND address.claims_sustainable = 1 ';
			$query	.= ' AND address.city_id = ' . $citySearch;
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
			$this->addressLib->address = $row['address'];
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
			$this->addressLib->claimsSustainable = $row['claims_sustainable'];
			
			$this->addressLib->completeAddress = $this->prepareAddress($row['address'], $row['city'], $row['city_id'], $row['state_id'], $row['country_id'], $row['zipcode']);
			$this->addressLib->displayAddress = $this->prepareAddressToDisplay($row['address'], $row['city'], $row['city_id'], $row['state_id'], $row['country_id'], $row['zipcode']);
			
			$addresses[] = $this->addressLib;
			unset($this->addressLib);
		}
		
		return $addresses;
		
	}
	
	function getCityFromZipcode($zipcode) {
		
		$query = "SELECT distinct city_id FROM address WHERE zipcode = " . $zipcode;
		log_message('debug', "AddressModel.getCityFromZipcode : " . $query);
		$result = $this->db->query($query);
		
		$this->load->library('AddressLib');
		
		$row = $result->row();
		if ($row) {
			return $row->city_id;
		} else {
			return '';	
		} 
	}
	
	// Get all the information about one specific manufacture from an ID
	function getAddressFromId($addressId) {
		
		$query = "SELECT 
				address.*, city.city as city_name
			FROM address 
			LEFT JOIN city 
				ON address.city_id = city.city_id 
			WHERE 
				address.address_id = " . $addressId;
				
		log_message('debug', "AddressModel.getAddressFromId : " . $query);
		$result = $this->db->query($query);
		
		$this->load->library('AddressLib');
		
		$row = $result->row();
		
		$this->addressLib->addressId = $row->address_id;
		$this->addressLib->address = $row->address;
		$this->addressLib->city = $row->city;
		$this->addressLib->stateId = $row->state_id;
		$this->addressLib->countryId = $row->country_id;
		$this->addressLib->zipcode = $row->zipcode;
		$this->addressLib->cityId = $row->city_id;
		$this->addressLib->cityName = $row->city_name;
		
		$this->addressLib->farmId = $row->farm_id;
		$this->addressLib->restaurantId = $row->restaurant_id;
		$this->addressLib->manufactureId = $row->manufacture_id;
		$this->addressLib->distributorId = $row->distributor_id;
		$this->addressLib->farmersMarketId = $row->farmers_market_id;
		$this->addressLib->claimsSustainable = $row->claims_sustainable;
		
		return $this->addressLib;
	}
	
	function addAddress($restaurantId, $farmId, $manufactureId, $distributorId, $farmersMarketId, $companyId) {
		global $ACTIVITY_LEVEL_DB;
		$return = true;
		$CI =& get_instance();
		
		$stateId = $this->input->post('stateId');
		$cityId = $this->input->post('cityId');
		$cityName = $this->input->post('cityName');
		
		if ( !empty ($cityName) && empty ($cityId)  ) {
			$CI->load->model('CityModel','',true);
			$cityId = $CI->CityModel->addCity($cityName, $stateId);
		}
		
		$address = $this->prepareAddress($this->input->post('address'), $this->input->post('city'), $this->input->post('cityId'), $this->input->post('stateId'), $this->input->post('countryId'), $this->input->post('zipcode') );
		
		$CI->load->model('GoogleMapModel','',true);
		
		$latLng = $CI->GoogleMapModel->geoCodeAddressV3($address);
		
		$claimsSustainable = $this->input->post('claimsSustainable');
		
		$query = "INSERT INTO address (address_id, address, city, city_id, state_id, zipcode, country_id, latitude , longitude, ";
		if ( !empty($restaurantId) ) {
			$query .= 'restaurant_id';
		} else if ( !empty($farmId) ) {
			$query .= 'farm_id';
		} else if ( !empty($manufactureId) ) {
			$query .= 'manufacture_id';
		} else if ( !empty($distributorId) ) {
			$query .= 'distributor_id';
		} else if ( !empty($farmersMarketId) ) {
			$query .= 'farmers_market_id';
		}
		$query .= ", company_id, geocoded, claims_sustainable)" .
				" values (NULL, \"" . $this->input->post('address') . "\", \"" . $this->input->post('city') . "\", '" . $cityId . "', '" . $stateId . "', '" . $this->input->post('zipcode') . "', '" . $this->input->post('countryId') . "', '" . ( isset($latLng['latitude']) ? $latLng['latitude']:'' ) . "', '" . ( isset($latLng['longitude']) ? $latLng['longitude']:'' ) . "', ";
		if ( !empty($restaurantId) ) {
			$query .= $restaurantId;
		} else if ( !empty($farmId) ) {
			$query .= $farmId;
		} else if ( !empty($manufactureId) ) {
			$query .= $manufactureId;
		} else if ( !empty($distributorId) ) {
			$query .= $distributorId;
		} else if ( !empty($farmersMarketId) ) {
			$query .= $farmersMarketId;
		}
		
		if (!empty ($companyId) ) {
			$query .= ", '$companyId'";
		} else {
			$query .= ", NULL ";
		}
		
		if ( isset($latLng['latitude']) && isset($latLng['longitude']) ) {
			$query .= ", 1";
		} else {
			$query .= ", 0";
		}
		$query .= ", '". (!empty ($claimsSustainable) ? $ACTIVITY_LEVEL_DB[$claimsSustainable] : '0') ."')";
		
		log_message('debug', 'AddressModel.addAddress : Insert Address : ' . $query);
		
		if ( $this->db->query($query) ) {
			
			if ( !empty($restaurantId) ) {
				if ( $claimsSustainable == 'active') {
					$CI->RestaurantModel->updateRestaurantSustainable($restaurantId, 1);
				}
			}
			
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
		$farmersMarketId =$this->input->post('farmersMarketId');
		
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
			$distributor = $CI->DistributorModel->getDistributorFromId($distributorId);
			$companyId = $distributor->companyId;
		} else if ( !empty($farmersMarketId) ) {
			//$CI->load->model('FarmersMarketModel','',true);
			//$farmersMarket = $CI->FarmersMarketModel->getDistributorFromId($distributorId);
			$companyId = '';
		}
		
		if ($this->addAddress($restaurantId, $farmId, $manufactureId, $distributorId, $farmersMarketId, $companyId) ) {
			$return = true;
		} else {
			$return = false;
		}
		
		return $return;
		
	}
	
	function updateAddress() {
		global $ACTIVITY_LEVEL_DB;
		$return = true;
		
		$CI =& get_instance();
		
		$stateId = $this->input->post('stateId');
		$cityId = $this->input->post('cityId');
		$cityName = $this->input->post('cityName');
		$addressId = $this->input->post('addressId');
		
		if ( !empty ($cityName) && empty ($cityId)  ) {
			$CI->load->model('CityModel','',true);
			$cityId = $CI->CityModel->addCity($cityName, $stateId);
		}
		
		$address = $this->prepareAddress($this->input->post('address'), $this->input->post('city'), $this->input->post('cityId'), $this->input->post('stateId'), $this->input->post('countryId'), $this->input->post('zipcode') );
				
		$CI->load->model('GoogleMapModel','',true);
		
		$latLng = $CI->GoogleMapModel->geoCodeAddressV3($address);
		
		$claimsSustainable = $this->input->post('claimsSustainable');
		
		$data = array(
					'address' => $this->input->post('address'), 
					'city' => $this->input->post('city'),
					'city_id' => $cityId,
					'state_id' => $stateId,
					'country_id' => $this->input->post('countryId'),
					'zipcode' => $this->input->post('zipcode'),
					'latitude' => ( isset($latLng['latitude']) ? $latLng['latitude']:'' ),
					'longitude' => ( isset($latLng['longitude']) ? $latLng['longitude']:'' ),
					'claims_sustainable' => (!empty ($claimsSustainable) ? $ACTIVITY_LEVEL_DB[$claimsSustainable] : '0'),
				);
		$where = "address_id = " . $addressId;
		$query = $this->db->update_string('address', $data, $where);
		
		log_message('debug', 'AddressModel.updateAddress : ' . $query);
		if ( $this->db->query($query) ) {
			$restaurantId = $this->getRestaurantFromAddressId( $addressId );
			
			if ($restaurantId) {
				$sustainableCount = $this->getSustainableAddressForRestaurantExceptGiven( $restaurantId, $addressId );
				$CI->load->model('RestaurantModel','',true);
				if ($sustainableCount == 0) {
					// Set as 1
					if ( $claimsSustainable == 'active') {
						$CI->RestaurantModel->updateRestaurantSustainable($restaurantId, 1);
					} else {
						
						$CI->RestaurantModel->updateRestaurantSustainable($restaurantId, 0);
					} 
				} else if ($sustainableCount > 0) {
					// Don't do aything
				}
			}
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
	
	function getRestaurantFromAddressId($addressId) {
		
		$query = "SELECT * FROM address WHERE address_id = " . $addressId;
		log_message('debug', "AddressModel.getRestaurantFromAddressId : " . $query);
		$result = $this->db->query($query);
		
		$row = $result->row();
		
		return $row->restaurant_id;
	}
	
	function getSustainableAddressForRestaurantExceptGiven($restaurantId, $addressId) {
		
		$query = "SELECT count(*) as num_row FROM address WHERE restaurant_id = " . $restaurantId . " AND address_id <> " . $addressId . ' AND 	claims_sustainable = 1';
		log_message('debug', "AddressModel.getRestaurantFromAddressId : " . $query);
		$result = $this->db->query($query);
		
		$row = $result->row();
		
		return $row->num_row;
	}
	
}



?>