<?php
class Test extends Controller{
	
	function Test(){
		
		parent::Controller(); 
		
	}
	
	
	function slug_names($start, $stop){
		
		$results = $this->db->query("select * from trif_temp limit ".$start.", ".$stop )->result_array(); 
		
		
		$firstArray= array();
		$i = 0; 
		foreach($results as $key=>$value){
			
			$slug = trim($value['producer_name']).'-'.trim($value['city_name']);
			$slug  = strtolower(str_replace(' ', '-', str_replace("'", '', $slug))); 
			
			$firstArray[$slug][$i]['address_id'] =  $value['address_id'];
			$firstArray[$slug][$i]['producer_id'] =  $value['producer_id'];
			$firstArray[$slug][$i]['value'] =  $slug;	
			
			unset($results[$key]);
			$i++;
		}
		$j = 0;
		
		$finalArray = array();
		foreach($firstArray as $slugPack){
				$k = 1; 
				foreach($slugPack as $slug){

					$finalArray[$slug['address_id']]['address_id'] = $slug['address_id']; 
					$finalArray[$slug['address_id']]['producer_id'] = $slug['producer_id']; 
					
					if($k ==1 ){
						
						$finalArray[$slug['address_id']]['slug'] = $slug['value'];
							
					}else{

						$finalArray[$slug['address_id']]['slug'] = $slug['value'].'-'.$k;
					}			
					$k++;
					unset($slug);
				}
				$j++;
				unset($slugPack);
			}			
//		$insertQuery = "INSERT INTO trif_custom_url (address_id, producer_id, slug) VALUES ";
//		$it = 0; 
//		$sizeOF = sizeof($finalArray);	
//		$sizeOF = $sizeOF - 1 ;	
//		foreach ($finalArray as $row){
//			
//			$insertQuery .= " ( '".$row['address_id']."', '".$row['producer_id']."', '".$row['slug']."' ) ";
//			if($it != $sizeOF ){
//				$insertQuery .= " ,";
//			}
//			$it++;
//		}
//		$this->db->query($insertQuery);	
		
		foreach ($finalArray as $row){	
			$this->db->insert('trif_custom_url', $row);	
		}	
		echo 'Done';
	}
	
	function show_links(){

		echo '<a href = "http://food.local/test/slug_names/0/30000" target="_blank">link1</a> <br />';
		echo '<a href = "http://food.local/test/slug_names/30001/60000" target="_blank">link1</a> <br />';
		echo '<a href = "http://food.local/test/slug_names/60001/90000" target="_blank">link1</a> <br />';
		echo '<a href = "http://food.local/test/slug_names/90001/120000" target="_blank">link1</a> <br />';
		echo '<a href = "http://food.local/test/slug_names/120001/150000" target="_blank">link1</a> <br />';
		echo '<a href = "http://food.local/test/slug_names/150001/180000" target="_blank">link1</a> <br />';
		echo '<a href = "http://food.local/test/slug_names/180001/210000" target="_blank">link1</a> <br />';
		echo '<a href = "http://food.local/test/slug_names/210001/240000" target="_blank">link1</a> <br />';
		echo '<a href = "http://food.local/test/slug_names/240001/270000" target="_blank">link1</a> <br />';
		echo '<a href = "http://food.local/test/slug_names/270001/300000" target="_blank">link1</a> <br />';
	
	}
	
}