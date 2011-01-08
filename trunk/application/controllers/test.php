<?php
set_time_limit(0);
error_reporting(E_ALL);
class Test extends Controller{
	
	
	private $queryLimit = 7000; 

	
	function Test(){
		parent::Controller(); 
		
	}
	
	function index(){
		
		
		echo 'Trigger below mentioned SQL query<br />-------------------------------------------<br />';
		echo 'ALTER TABLE `custom_url` CHANGE `company_id` `producer_id` INT( 11 ) NULL DEFAULT NULL;<br />';
		echo 'ALTER TABLE `custom_url` ADD `address_id` INT NOT NULL AFTER `producer_id`;<br />';
		echo 'ALTER TABLE `custom_url` ADD `farmers_market_id` INT NULL AFTER `restaurant_id`;<br />';
		echo '<br />-------------------------------------------<br />';
		
		echo '<strong>Farms</strong><br />';
		echo '<a href="'.base_url().'test/create_temp_tables" target="_blank">Step1: Create temp tables</a> <br />';
		echo '<a href="'.base_url().'test/dump_data_to_trif_temp/farm" target="_blank">Step2: Dump farm data to temp table </a> <br />';
		echo '<a href="'.base_url().'test/links" target="_blank">Step3: Create slugs </a> <br />';
		echo '<a href="'.base_url().'test/move_data_to_custom_url/farm" target="_blank">Step4: move farm data to custom_url </a> <br />';
		echo '<a href="'.base_url().'test/drop_temp_tables" target="_blank">Drop temp tables</a> <br />';
		echo 'Trigger below mentioned SQL query<br />-------------------------------------------<br />';
		echo 'UPDATE custom_url SET producer_id = farm_id WHERE farm_id IS NOT NULL;';
		echo '<br />-------------------------------------------<br />';
		
		echo '<br /><strong>Restaurants</strong><br />';
		
		echo '<a href="'.base_url().'test/create_temp_tables" target="_blank">Step1: Create temp tables</a> <br />';
		echo '<a href="'.base_url().'test/dump_data_to_trif_temp/restaurant" target="_blank">Step2: Dump restaurant data to temp table </a> <br />';
		echo '<a href="'.base_url().'test/links" target="_blank">Step3: Create slugs </a> <br />';
		echo '<a href="'.base_url().'test/move_data_to_custom_url/restaurant" target="_blank">Step4: move restaurant data to custom_url </a> <br />';
		echo '<a href="'.base_url().'test/drop_temp_tables" target="_blank">Drop temp tables</a> <br />';
		echo 'Trigger below mentioned SQL query<br />-------------------------------------------<br />';
		echo 'UPDATE custom_url SET producer_id = restaurant_id WHERE restaurant_id IS NOT NULL;';
		echo '<br />-------------------------------------------<br />';
		
		echo '<br /><strong>Manufacture</strong><br />';
		echo '<a href="'.base_url().'test/create_temp_tables" target="_blank">Step1: Create temp tables</a> <br />';
		echo '<a href="'.base_url().'test/dump_data_to_trif_temp/manufacture" target="_blank">Step2-c: Dump manufacture data to temp table </a> <br />';
		echo '<a href="'.base_url().'test/links" target="_blank">Step3: Create slugs </a> <br />';
		echo '<a href="'.base_url().'test/move_data_to_custom_url/manufacture" target="_blank">Step4: manufacture move data to custom_url </a> <br />';
		echo '<a href="'.base_url().'test/drop_temp_tables" target="_blank">Drop temp tables</a> <br />';
		echo 'Trigger below mentioned SQL query<br />-------------------------------------------<br />';
		echo 'UPDATE custom_url SET producer_id = manufacture_id WHERE manufacture_id IS NOT NULL;';
		echo '<br />-------------------------------------------<br />';

		echo '<br /><strong>Distributor</strong><br />';
		echo '<a href="'.base_url().'test/create_temp_tables" target="_blank">Step1: Create temp tables</a> <br />';
		echo '<a href="'.base_url().'test/dump_data_to_trif_temp/distributor" target="_blank">Step2-c: Dump manufacture data to temp table </a> <br />';
		echo '<a href="'.base_url().'test/links" target="_blank">Step3: Create slugs </a> <br />';
		echo '<a href="'.base_url().'test/move_data_to_custom_url/distributor" target="_blank">Step4: distributor move data to custom_url </a> <br />';
		echo '<a href="'.base_url().'test/drop_temp_tables" target="_blank">Drop temp tables</a> <br />';
		echo 'Trigger below mentioned SQL query<br />-------------------------------------------<br />';
		echo 'UPDATE custom_url SET producer_id = distributor_id WHERE distributor_id IS NOT NULL;';
		echo '<br />-------------------------------------------<br />';
		
		echo '<br /><strong>Farmers Market</strong><br />';
		echo '<a href="'.base_url().'test/create_temp_tables" target="_blank">Step1: Create temp tables</a> <br />';
		echo '<a href="'.base_url().'test/dump_data_to_trif_temp/farmers_market" target="_blank">Step2-c: Dump manufacture data to temp table </a> <br />';
		echo '<a href="'.base_url().'test/links" target="_blank">Step3: Create slugs </a> <br />';
		echo '<a href="'.base_url().'test/move_data_to_custom_url/farmers_market" target="_blank">Step4: farmers market move data to custom_url </a> <br />';
		echo '<a href="'.base_url().'test/drop_temp_tables" target="_blank">Drop temp tables</a> <br />';
		echo 'Trigger below mentioned SQL query<br />-------------------------------------------<br />';
		echo 'UPDATE custom_url SET producer_id = farmers_market_id WHERE farmers_market_id IS NOT NULL;';
		echo '<br />-------------------------------------------<br />';
		
			
	}
	
	
	//custom url script 
	function create_temp_tables(){
		
		$query = "CREATE TABLE `trif_custom_url` (
				  `address_id` varchar(255) COLLATE utf8_bin DEFAULT NULL,
				  `producer_id` varchar(255) COLLATE utf8_bin DEFAULT NULL,
				  `slug` varchar(255) COLLATE utf8_bin DEFAULT NULL UNIQUE
				) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin"; 
		$this->db->query($query); 
		echo 'Table trif_custom_url created<br />'; 
		
		$query = "CREATE TABLE `trif_temp` (
					  `producer_id` varchar(255) COLLATE utf8_bin DEFAULT NULL,
					  `address_id` varchar(255) COLLATE utf8_bin DEFAULT NULL,
					  `producer_name` varchar(255) COLLATE utf8_bin DEFAULT NULL,
					  `city_name` varchar(255) COLLATE utf8_bin DEFAULT NULL
					) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin"; 
		$this->db->query($query); 
		echo 'Table trif_temp created'; 
		
	}
	
	
	function drop_temp_tables(){
		
		$query = "DROP TABLE `trif_custom_url`";
		$this->db->query($query); 
		echo 'Table trif_custom_url droped<br />'; 
		$query = "DROP TABLE `trif_temp`";
		$this->db->query($query); 
		echo 'Table trif_temp droped<br />'; 
		
		
	}
	
	function dump_data_to_trif_temp($producerType){
		
		$query = "
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
				producer.is_".$producerType." =  '1'		
		"; 
		$this->db->query($query); 
		echo $producerType.' data dumped from producer and address to trif_temp'; 
		
	}
	
	
	function links(){
		
		$query = "select count(producer_id) as counter from trif_temp";
		
		$results = $this->db->query($query);
		
		$num_rows = $results->row_array();
		$num_rows = $num_rows['counter'];
		
		
		if($num_rows > $this->queryLimit){
			
			$links = $num_rows/$this->queryLimit;	
			
		}else{
			$links = 1; 
		}
		
		$i = 0; 
		
		for($i = 0; $i < $links; $i++){
			
			$start = (int) $this->queryLimit * $i ;
			
			echo '<a href="'.base_url().'test/slug_names/'.$start.'" >link '.$i.'</a><br />'; 
		}
		
	}
	
	
	
	
	function slug_names($start){
		
	
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
		
		//limiting result to avoid memory limit error 
		$results = $this->db->query("select * from trif_temp limit ".$start.", ".$this->queryLimit )->result_array(); 
		
		$total = sizeof($results);
		
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
		echo 'Done ';
		
		echo $total;
		
		echo ' slugs was added to trif_custom_url ';
		
		//if everything looks fine we can do a insert into ... select  to custom_url table. 
		
		/*
		 * 
		 -------------------------------------------------------------

		---------------------------------------------------------------
		 * 
		 */
	}
	
	function move_data_to_custom_url($producerType){
					
			
			
				$query = "
				
				insert into custom_url (address_id, ".$producerType."_id, custom_url )
				SELECT * FROM `trif_custom_url`;
						
			"; 
		$this->db->query($query); 
		echo 'Data dumped from trif_custom_url to custom url'; 
		
	}
	
	
	function getTypeOfSlug($slugResults){
		
		foreach($slugResults->result_array() as $slug){

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
		$string = str_replace(".", "", $string);
		$string = str_replace(",", "", $string);
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