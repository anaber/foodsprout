<?php
class MobileFarmsModel extends Model{
	
	
	function getFarmByCoordinates($latitude = '', $longitude = '', $distance = ''){
		
			$query_zips = 'SELECT address_id, ( 3959 * acos( cos( radians("'.$latitude.'") ) * cos( radians( latitude ) ) *
								cos( radians( longitude ) - radians("'.$longitude.'") ) + sin( radians("'.$latitude.'") ) * 
								sin( radians( latitude ) ) ) ) AS distance FROM address HAVING distance <= '.$distance.' ORDER BY distance';

			
			$proximity_zips = $this->db->query($query_zips)->result_array();
			
			if(sizeof($proximity_zips) > 0){

				$address_ids = array();
				
				foreach($proximity_zips as $zip){
					$address_ids[] = "'".$zip['address_id']."'";	
				}
				
				$ids = implode(",", $address_ids);
				
				$query = "SELECT
							address.address_id,
							address.producer_id,
							address.address,
							address.city,
							address.zipcode,
							producer.producer,
							producer.phone,
							producer.fax,
							producer.email,
							producer.url,
							producer.facebook,
							producer.twitter,
							producer.description,
							custom_url.custom_url
							FROM
							address ,
							producer ,
							custom_url
							WHERE
							address.producer_id =  producer.producer_id AND
							producer.is_farm =  '1' AND
							address.address_id IN  (".$ids.") AND
							producer.status =  'live' AND
							address.address_id =  custom_url.address_id";
				
				$farmersmarket = $this->db->query($query)->result_array();
					
				return $farmersmarket;
			}//end else initial zips 
			else{
				//no zip found in proximity
				return false;
			}
			
		
	}

	function getFarmsByZipCode($zipcode='', $distance =''){
		
		$zip_query = 'select * from zipcode where `zipcode` = "'.$zipcode.'"';
		$zip_code_info = $this->db->query($zip_query)->result_array();
		
		
		if(sizeof($zip_code_info) > 0 ){
			//query to find all zips near this zip
			$latitude = $zip_code_info[0]['latitude'];
			$longitude = $zip_code_info[0]['longitude'];
			
		}else{
			return false;
		}

		$query_zips = 'SELECT address_id, ( 3959 * acos( cos( radians("'.$latitude.'") ) * cos( radians( latitude ) ) *
								cos( radians( longitude ) - radians("'.$longitude.'") ) + sin( radians("'.$latitude.'") ) * 
								sin( radians( latitude ) ) ) ) AS distance FROM address HAVING distance <= '.$distance.' ORDER BY distance';

		$proximity_zips = $this->db->query($query_zips)->result_array();
				
		if(sizeof($proximity_zips) > 0){

				$address_ids = array();
				
				foreach($proximity_zips as $zip){
					$address_ids[] = "'".$zip['address_id']."'";	
				}
				
				$ids = implode(",", $address_ids);
				
				$query = "SELECT
							address.address_id,
							address.producer_id,
							address.address,
							address.city,
							address.zipcode,
							producer.producer,
							producer.phone,
							producer.fax,
							producer.email,
							producer.url,
							producer.facebook,
							producer.twitter,
							producer.description,
							custom_url.custom_url
							FROM
							address ,
							producer ,
							custom_url
							WHERE
							address.producer_id =  producer.producer_id AND
							producer.is_farm =  '1' AND
							address.address_id IN  (".$ids.") AND
							producer.status =  'live' AND
							address.address_id =  custom_url.address_id";
				
				$farmersmarket = $this->db->query($query)->result_array();
			
				return $farmersmarket;
			}//end else initial zips 
			else{
				//no zip found in +proximity
				return false;
			}
	}
	
	
	function getFarmsByCity($cityId = ''){
		

		if($cityId != ''){

				
			$query = "SELECT
							producer.producer_id,
							address.address_id,
							producer.producer,
							address.address,
							address.city,
							producer.phone,
							producer.fax,
							producer.email,
							producer.url,
							producer.status,
							producer.facebook,
							address.zipcode,
							custom_url.custom_url
							FROM
							address ,
							producer ,
							custom_url
							WHERE
							address.producer_id =  producer.producer_id AND
							producer.is_farm =  '1' AND
							address.producer_id =  custom_url.producer_id AND
							address.address_id =  custom_url.address_id AND
							address.city_id =  '".mysql_real_escape_string($cityId)."'";
				
				$farmersmarket = $this->db->query($query)->result_array();
			
				return $farmersmarket;
			}
			else{
				return false;
			}
	}
	
	function getCity($cityName){
		
		$query = "SELECT city_id, city FROM city where city LIKE '%".$cityName."%'"; 
				
		$results = $this->db->query($query)->result_array();
		
		if(sizeof($results) > 0 ){
					
			return $results;
			
		}else{
			
			return false;
			
		}
		
		
	}
	
	
}