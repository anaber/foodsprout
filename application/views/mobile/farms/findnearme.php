<form method="post" name="findNearMe" action="<?php echo base_url()?>mobile/farms/nearme/">
	<input name="latitude_input" id="latitude_input" type="hidden" value="" />
	<input name="longitude_input" id="longitude_input" type="hidden"  value="" />
	<input name="distance" id="distance" type="hidden"  value="50" />
	<input type="hidden" name="search_near_me" value="Search" />
</form>	

<div id="mainarea">
	<div>
		Searching... Please wait!
	</div>
</div>	

<script type="text/javascript">
					
 navigator.geolocation.getCurrentPosition(getLocation, unknownLocation);
 
  function getLocation(pos)
  {
    var latitude = pos.coords.latitude;
    var longitude = pos.coords.longitude;
    document.getElementById('latitude_input').value  = + latitude;	
    document.getElementById('longitude_input').value  = + longitude;
    document.forms["findNearMe"].submit();
  }
  function unknownLocation()
  {			
	return alert('Could not find location');
  }

</script>