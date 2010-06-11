<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script src="<?php echo base_url()?>js/google_map_v3.js" type="text/javascript"></script> 
<script>
    /*
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
	*/
</script>
<div id = "map">
<div id="map_canvas" style="width: <?php echo $width;?>px; height: <?php echo $height;?>px"></div>
</div>
<div align = "right"><div style="float:right; width:400px;" id = "divHideMap"><a href = "#" id = "linkHideMap">Show/Hide Map</a></div></div>