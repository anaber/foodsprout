


<div id="mainarea">
<ul id="menu">
		<li>
			<p><div id="foundStatus"></div></p>
		</li>
		<li>	
			<form method="post" name="findNearMe" action="<?php echo base_url()?>mobile/restaurants/findnearme/">
			Latitude<input name="latitude" id="latitude" value="" />
			<input type="submit" name="jump_to" value="Go" />
			</form>	
			<span></span>
		</li>
	</ul>
</div>

<script type="text/javascript">

 navigator.geolocation.getCurrentPosition(getLocation, unknownLocation);
 
  function getLocation(pos)
  {
    var latitude = pos.coords.latitude;
    var longitude = pos.coords.longitude;
    document.getElementById('latitude').innerHTML  = "Address found";
    alert('Your current coordinates (latitude,longitude) are : ' + latitude + ', ' + longitude);
  }
  function unknownLocation()
  {
	return document.getElementById('latitude').value  = "Address not found";
    alert('Could not find location');
  }

//to do search restaurants by coords
</script>