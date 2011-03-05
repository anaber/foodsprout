<div id="recentlyEeaten">
	<?php 
		
		echo '<div id="recentlyLabel">Recently eaten items</div>';
		
		if(isset($recentlyEatenProducts) && sizeof($recentlyEatenProducts) > 0){

			echo '<ul id="recentlyAddedList">';
			foreach($recentlyEatenProducts as $product){
				
				echo '<li>';
					echo '<a href="'.base_url().'product/'.$product->custom_url.'">'.$product->product_name.'</a>';
					echo '<br /><span >Recently added by: <a href="#">'.$product->user.'</a>;</span>';
				echo '</li>';
				
			}
			echo '</ul>';
			
		}
	?>
</div>
<div id="recentlyAdded">
	<?php 
	
		echo '<div id="recentlyLabel">Recently added items</div>';
	
		if(isset($recentlyAddedProducts) && sizeof($recentlyAddedProducts) > 0){

			echo '<ul id="recentlyAddedList">';
			foreach($recentlyAddedProducts as $product){
				
				echo '<li>';
					echo '<a href="'.base_url().'product/'.$product->custom_url.'">'.$product->product_name.'</a>';
					echo '<br /><span >Recently added by: <a href="#">'.$product->user.'</a>;</span>';
				echo '</li>';
				
					
			}
			echo '</ul>';
			
		}
	
	?>
</div>
<div id="worstFood"></div>