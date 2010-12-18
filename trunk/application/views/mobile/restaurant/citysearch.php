<div id="mainarea">
	<ul id="menu">
		<li>
			<form method="post" name="city_search" action="<?php echo base_url()?>mobile/restaurants/browsebycity">
			<label for="city">City: </label>
				<input type="text" value="" name="city" id="city" />
				<input type="submit" name="city_btn" value="Go" />
			</form>	
			<span></span>
		</li>
	</ul>
</div>

<?php if( isset($cities) && sizeof($cities) > 0){	 ?>
		
<div id="mainarea">
	<ul id="menu">
		<li>
			<p>More that one city has been found for your search. Please select the city from where you want to see results</p>
			
			<?php
				foreach($cities as $city){
					
					echo '<span><a href="'.base_url().'mobile/restaurants/cityrestaurantlist/'.$city['city_id'].'" >'.$city['city'].'</a></span><br />';
				
				}
			?>
		</li>
	</ul>
</div>
		
		
		
		
<?php } ?>
