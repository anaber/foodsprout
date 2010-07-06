<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script> 
<script src="<?php echo base_url()?>js/google_map_v3.js" type="text/javascript"></script>
<script>
	$(document).ready(function() {
		loadMapOnStartUp(-34.397, 150.644, 8);
	});
</script>
<div id = "map">
<div id="map_canvas" style="width: <?php echo $width;?>px; height: <?php echo $height;?>px"></div>
</div>