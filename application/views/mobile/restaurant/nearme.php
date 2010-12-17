<script type="text/javascript">

 navigator.geolocation.getCurrentPosition(getLocation, unknownLocation);
 
  function getLocation(pos)
  {
    var latitde = pos.coords.latitude;
    var longitude = pos.coords.longitude;
    alert('Your current coordinates (latitide,longitude) are : ' + latitde + ', ' + longitude);
  }
  function unknownLocation()
  {
    alert('Could not find location');
  }

//to do search restaurants by coords
</script>


<div id="mainarea">

</div>