<?php
class Test extends Controller{
	
	function Test(){
		
		parent::Controller(); 
		
	}
	
	
	function slug_names($start){
		
		/*
		 * trif_custom_url table 
		 * 
			 CREATE TABLE `trif_custom_url` (
				  `address_id` varchar(255) COLLATE utf8_bin DEFAULT NULL,
				  `producer_id` varchar(255) COLLATE utf8_bin DEFAULT NULL,
				  `slug` varchar(255) COLLATE utf8_bin DEFAULT NULL
				) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		 * 
		 */
		
		 /*
		  * trif_temp table
		  * 
				CREATE TABLE `trif_temp` (
					  `producer_id` varchar(255) COLLATE utf8_bin DEFAULT NULL,
					  `address_id` varchar(255) COLLATE utf8_bin DEFAULT NULL,
					  `producer_name` varchar(255) COLLATE utf8_bin DEFAULT NULL,
					  `city_name` varchar(255) COLLATE utf8_bin DEFAULT NULL
					) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin		  
		  * 
		  */
		
		
		
		
		
		/*
			sql query for copying data to trif_temp table 
			-------------------------------------------------------
			insert into trif_temp (producer_id, address_id, producer_name, city_name)
				SELECT
				address.producer_id,
				address.address_id,
				producer.producer,
				address.city
				FROM
				address ,
				producer
				WHERE
				address.producer_id =  producer.producer_id AND
				producer.is_restaurant =  '1'
			--------------------------------------------------------
		
		*/
		
		
		
		//trif_temp   - first table with data dumped from address and producer
		
		
		//limiting result to 40000 to avoid memory limit error 
		$results = $this->db->query("select * from trif_temp limit ".$start.", 39999" )->result_array(); 
		
		echo sizeof($results);
		
		$firstArray= array();
		$i = 0;

		
		//put all results in a new multidimensional array with each slug as key 
		foreach($results as $key=>$value){
			
			//remove white spaces
			$slug = $this->_trimWhiteSpaces(trim($value['producer_name'])); 
			
			if($value['city_name'] != ''){
				$slug .= '-'.$this->_trimWhiteSpaces(trim($value['city_name']));
			}
			$slug  = strtolower(str_replace(' ', '-', str_replace("'", '',$slug))); 
			$firstArray[$slug][$i]['address_id'] =  $value['address_id'];
			$firstArray[$slug][$i]['producer_id'] =  $value['producer_id'];
			$firstArray[$slug][$i]['value'] =  $slug;	
			
			
			//unset to avoid memory exceed error
			unset($results[$key]);
			$i++;
		}
		
		//create a new array with keys equal with address id and values equal with slug and position from first_array[slug] 
		$finalArray = array();
		foreach($firstArray as $slugPack){
				$k = 1; 
				foreach($slugPack as $slug){

					$finalArray[$slug['address_id']]['address_id'] = $slug['address_id']; 
					$finalArray[$slug['address_id']]['producer_id'] = $slug['producer_id']; 
					
					if($k == 1 ){
						$finalArray[$slug['address_id']]['slug'] = $slug['value'];
					}else{
						$finalArray[$slug['address_id']]['slug'] = $slug['value'].'-'.$k;
					}			
					$k++;
					unset($slug);
				}
				unset($slugPack);
			}			
		
			
		// insert foreach array from final array in second temporary table: trif_custom_url 
		foreach ($finalArray as $row){	
			$this->db->insert('trif_custom_url', $row);	
		}	
		echo 'Done';
		
		
		//if everything looks fine we can do a insert into ... select  to custom_url table. 
		
		/*
		 * 
		 -------------------------------------------------------------
			
			insert into custom_url (address_id, restaurant_id, custom_url )
			
			SELECT * FROM `trif_custom_url`;
			
		---------------------------------------------------------------
		 * 
		 */
	}
	
	function show_links(){
		
		
		//cause of memory limitation we can generate only 20 000  slugs at once
		
		echo '<a href=http://food.local/test/slug_names/0/ >link1</a><br />
		
				<a href=http://food.local/test/slug_names/40000/ >link3</a><br />
				
				<a href=http://food.local/test/slug_names/80000/ >link5</a><br />
				
				<a href=http://food.local/test/slug_names/120000/ >link7</a><br />
				
				<a href=http://food.local/test/slug_names/160000/ >link9</a><br />
			
				<a href=http://food.local/test/slug_names/200000/ >link11</a><br />
				
				<a href=http://food.local/test/slug_names/240000/ >link13</a><br />
				
				<a href=http://food.local/test/slug_names/280000/ >link15</a><br />
				<br />
						';
	
	}
	
	
	function slug_view($slug){
		
		echo "test successfully<br />";
		
		echo 'Slug found: ';
		echo $slug;

		
		$custom_url_table = "custom_url";
		
		$slugResults = $this->db->get_where($custom_url_table, array('custom_url' => $slug));
		
		if($slugResults->num_rows() > 0){
			
			//redirect to slug page
			
		}else{		
			//redirect to page not found
			echo 'redirect to page not found';
		}
		
		$this->getTypeOfSlug($slugResults);
	}
	
	
	function getTypeOfSlug($slugResults){
		
		foreach($slugResults->result_array() as $slug){
			
			print_r($slug);
			
			
			if($slug['company_id'] == ''){
				
				return array(
						'slug_id' => $slug['custom_url_id']
					); 
			}else{
				echo 'set';	
			}	
		}
	}
	
	
	//this function  remove more that one spaces from words example los       angeles
	
	function _trimWhiteSpaces($string){
		
		$string = str_replace(" - ", " ", $string);
		
		$words = explode(" ", $string);
		
		$newString = ''; 
		
		if(sizeof($words) == 1 ){
			
			return $words[0];
			
		}else{
			foreach($words as $word){
				if($word != ''){
					$newString .= ' '.$word; 
				}
				
			}
			
			return trim($newString);
		}
		
	}
}