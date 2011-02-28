<?php
if(isset($searchResults) && sizeof($searchResults) > 0){

		if(isset($totalRows)){
			echo '<div id="totalRows" >';
			echo $totalRows." results found";
			echo '</div>';
		}
	
		echo '<ul id="searchResults">';
		foreach($searchResults as $result){
				
				
				
			echo '<li>
					
					<a href="'.base_url().'product/'.$result->custom_url.'">'.$result->product_name.'</a> <br />
					<span class="producer_name">Brand: '.$result->producer_name.'</span>
					<span class="product_type">Type: '.$result->product_type.'</span>
					<span class="product_type">Manufacture: '.$result->producer.'</span>
					<span style="float:right;" class="view_details_button"><a href="'.base_url().'product/'.$result->custom_url.'">View details</a></span>
				
					</li>';
				
		}
		echo '</ul>';
		
		echo $this->pagination->create_links();
	
	}elseif(isset($_POST) && isset($_POST['search_term']) && $_POST['search_term'] !='' ){

		echo "No result for: ". $_POST['search_term'];

}

?>

