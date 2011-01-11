<?php
set_time_limit(0);
error_reporting(E_ALL);
class Deepak extends Controller{
	
	
	function Test(){
		parent::Controller(); 
	}
	
	function index(){
		
		echo '<strong>All Producers</strong><br />';
		echo '<a href="/deepak/update_blank_city" target="_blank">Step1: Correct City Records in Address table</a> <br />';
		echo '<a href="/deepak/create_temp_table" target="_blank">Step2: Create temp tables</a> <br />';
		echo '<a href="/deepak/dump_data_to_temp_custom_url" target="_blank">Step3: Dump all address data to producer table</a> <br />';
		echo '<a href="/deepak/verify_num_records" target="_blank">Step4: Verify Number of records from address and temp_custom_url table</a> <br />';
		echo '<a href="/deepak/generate_custom_url" target="_blank">Ste5: Generate Custom URL</a> <br />';
		
		
		echo '<br /><br /><br /><a href="/deepak/drop_temp_table" target="_blank">Drop temp tables</a> <br />';
			
	}
	
	function update_blank_city() {
		$query = "SELECT address.*, city.city FROM address, city
					WHERE address.city_id = city.city_id
					AND address.city = ''";
		$result = $this->db->query($query);
		foreach ($result->result_array() as $row) {
			echo $row['address_id'];
			
			$query = 'UPDATE address SET city = "'.$row['city'].'" WHERE address_id = ' . $row['address_id'];
			$this->db->query($query); 
		}
	}
	
	//custom url script 
	function create_temp_table(){
		$query = "CREATE TABLE IF NOT EXISTS `temp_custom_url` (
				  `custom_url_id` int(11) NOT NULL AUTO_INCREMENT,
				  `producer_id` int(11) NOT NULL,
				  `producer` varchar(255) NOT NULL,
				  `producer_slug` varchar(255) DEFAULT NULL,
				  `address_id` int(11) DEFAULT NULL,
				  `city` varchar(95) DEFAULT NULL,
				  `city_counter` int(11) NULL,
				  `custom_url` varchar(255) DEFAULT NULL,
				  PRIMARY KEY (`custom_url_id`),
				  KEY `fk_address_custom_url1` (`custom_url`),
				  KEY `fk_producer_id` (`producer_id`),
				  KEY `fk_producer_slug` (`producer_slug`)
				) ENGINE=InnoDB  DEFAULT CHARSET=latin1;"; 
		$this->db->query($query); 
		echo 'Table temp_custom_url created'; 
		
	}
	
	
	function drop_temp_table(){
		$query = "DROP TABLE `temp_custom_url`";
		$this->db->query($query); 
		echo 'Table temp_custom_url droped<br />'; 
	}
	
	function dump_data_to_temp_custom_url(){
		$query = "
				insert into temp_custom_url (producer_id, producer, producer_slug, address_id, city, city_counter, custom_url)
				SELECT
				address.producer_id,
				producer.producer,
				NULL,
				address.address_id,
				address.city,
				NULL,
				NULL
				FROM
				address ,
				producer
				WHERE
				address.producer_id =  producer.producer_id		
		"; 
		$this->db->query($query); 
		echo 'address data dumped from producer and address to temp_custom_url'; 
		
	}
	
	function verify_num_records() {
		$query = "select count(address_id) as num_records from address";
		$results = $this->db->query($query);
		$num_rows = $results->row_array();
		$num_rows1 = $num_rows['num_records'];
		
		echo "No. of records in Address table : " . $num_rows1;
		echo "<br />------------------<br />";
		$query = "select count(custom_url_id) as num_records from temp_custom_url";
		$results = $this->db->query($query);
		$num_rows = $results->row_array();
		$num_rows2 = $num_rows['num_records'];
		
		echo "No. of records in Temp Custom URL table : " . $num_rows2;
		
		if ($num_rows1 == $num_rows2) {
			echo "<br /><strong>G O O D ! ! !</strong> All data imported correctly from address to temp_custom_url table";
		} else {
			echo "<br /><strong>B A D ! ! !</strong> Something is wrong";
		}
	}
	
	function generate_custom_url() {
		
		$query = "SELECT * FROM temp_custom_url WHERE custom_url IS NULL limit 0, 5000";
		$result = $this->db->query($query);
		foreach ($result->result_array() as $row) {
			echo $row['custom_url_id'];
			if (!$row['custom_url']) {
				$producer_without_spaces = $this->_trimWhiteSpaces(trim($row['producer']));
				
				$producer_with_city = $producer_without_spaces;
				
				if($row['city'] != ''){
					$producer_with_city .= '-'.$this->_trimWhiteSpaces(trim($row['city']));
				}
				
				$slug = $producer_with_city;
				$slug = strtolower(str_replace(' ', '-', str_replace("'", '',$slug))); 
				
				echo '##' . $row['producer'] . '##' . $row['city'] . '##' . $slug . '## Correct Slug : ';
				
				$query = 'SELECT * ' .
					' FROM temp_custom_url' .
					' WHERE ' .
					' producer_id = ' . $row['producer_id'] .
					' AND city = \''.$row['city'].'\'' .
					' AND custom_url = \''.$slug.'\'';
				//echo $query . "<br />";
				$result1 = $this->db->query($query);
				if ($result1->num_rows() == 0) {
					//echo "Update Custom URL <br />";
					$query = 'UPDATE temp_custom_url' .
						' SET ' .
						' custom_url = \''.$slug.'\', ' .
						' city_counter = 1' .
						' WHERE custom_url_id = ' . $row['custom_url_id'];
					//echo $query . "<br />";
					$this->db->query($query);
					echo $slug;
				} else {
					$query = 'SELECT * ' .
						' FROM temp_custom_url' .
						' WHERE ' .
						' producer_id = ' . $row['producer_id'] .
						' AND city = \''.$row['city'].'\'' .
						' AND custom_url != \'\'' .
						' ORDER BY city_counter DESC ';
					//echo $query;
					
					$result1 = $this->db->query($query);
					$row1 = $result1->result_array();
					$city_counter = $row1[0]['city_counter'];
					$city_counter_next = $city_counter +1;
					$slug = $slug . '-' . $city_counter_next;
					//echo $slug;
					
					$query = 'SELECT * ' .
						' FROM temp_custom_url' .
						' WHERE ' .
						' producer_id = ' . $row['producer_id'] .
						' AND city = \''.$row['city'].'\'' .
						' AND custom_url = \''.$slug.'\'';
					//echo $query . "<br />";
					$result1 = $this->db->query($query);
					if ($result1->num_rows() == 0) {
						//echo "Update Custom URL <br />";
						$query = 'UPDATE temp_custom_url' .
							' SET ' .
							' custom_url = \''.$slug.'\', ' .
							' city_counter = ' . $city_counter_next .
							' WHERE custom_url_id = ' . $row['custom_url_id'];
						//echo $query . "<br />";
						echo $slug;
						$this->db->query($query);
					} else {
						die("<br />Fails at level 2<br />");
					}
				}
			} else {
				echo '## Already generated custom_url'; 
			}
			
			echo "<br />";
			
		}
	}
	
	
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