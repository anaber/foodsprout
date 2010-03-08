<?php
	if(isset($VIEW_HEADER) ) {
		echo '<h4>' . $VIEW_HEADER . '</h4>';	
	}
?>
<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=false&amp;key=<?php echo $GOOGLE_MAP_KEY; ?>" type="text/javascript"></script> 
<script>
    
     function initializeMap() {
      if (GBrowserIsCompatible()) {
        var map = new GMap2(document.getElementById("map_canvas"));
        map.setCenter(new GLatLng(37.4419, -122.1419), 13);
        map.setUIToDefault();
      }
    }
    
	$(document).ready(function() {
		initializeMap();
	});
</script>

<div id="map_canvas" style="width: <?php echo $width;?>px; height: <?php echo $height;?>px"></div> 