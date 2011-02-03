<div id="mainarea">
	<ul id="menu">
		<li>
			<div id="foundStatus"></div>
			<br />
		</li>
		<li>	
			<form method="post" name="findNearMe" action="<?php echo base_url()?>mobile/farmersmarket/nearme/">
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
				<input type="submit" name="search_near_me" value="Search" />
			</form>	
			<span></span>
		</li>
	</ul>
</div> 			
			
<?php $this->load->view('mobile/farmersmarket/list');?>
			
			

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