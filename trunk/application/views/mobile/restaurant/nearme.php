


<div id="mainarea">
<ul id="menu">
		<li>
			<div id="foundStatus"></div>
			<br />
		</li>
		<li>	
			<form method="post" name="findNearMe" action="<?php echo base_url()?>mobile/restaurants/nearme/">
			
			<label>Latitude</label>	 
			
			<input name="latitude_input" id="latitude_input" value="" />
			<br />
			<label>Longitude</label>
			 <input name="longitude_input" id="longitude_input" value="" />
			<br />
			<label for="distance">Distance: </label>
			<select name="distance" id="distance">
				<option>2</option>
				<option>7</option>
				<option>10</option>
				<option>20</option>
				<option>50</option>
			</select>(miles)
			<br />
			<input type="submit" name="jump_to" value="Search Restaurants" />
			</form>	
			<span></span>
		</li>
	</ul>
</div> 			
			
		
<div id="mainarea">
	<div id="search_by_zip_code_results" >
		<?php 
		
			if(isset($search_results) && sizeof($search_results) > 0){
				
				echo '<ul  id="menu">';
					foreach ($search_results as $result ){
						
						echo '<li>';
							echo 	'<a href="'.base_url().'mobile/restaurants/view-'.$result['custom_url'].'">
									'.$result['producer'].'<span>City: <strong>'.$result['city'].'</strong>, address: <strong>
									'.$result['address'].', </strong>
									cuisine: '.$result['cuisine'].'</span></a>';	
						echo '</li>'; 	              
					}
				echo '</ul>';
			}else{
				
				echo '
					<ul  id="menu">
						<li>no results found</li>
					</ul>';
 
			}
			?>
	</div>
</div>	
			
			

<script type="text/javascript">

 navigator.geolocation.getCurrentPosition(getLocation, unknownLocation);
 
  function getLocation(pos)
  {
    var latitude = pos.coords.latitude;
    var longitude = pos.coords.longitude;
    document.getElementById('foundStatus').innerHTML  = "Address found";	
    document.getElementById('latitude_input').value  = + latitude;	
    document.getElementById('longitude_input').value  = + longitude;
  }
  function unknownLocation()
  {
	return alert('Could not find location');
  }

//to do search restaurants by coords
</script>