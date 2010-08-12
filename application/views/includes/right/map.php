<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script> 
<script src="<?php echo base_url()?>js/google_map_v3.js" type="text/javascript"></script>
<div id="location-icon"><img src="/img/location-head-icon.jpg" width="89" height="23" alt="location-head-icon" /></div>
<div id = "map">
	<div id="map_canvas" style="width: <?php echo $width;?>px; height: <?php echo $height;?>px"></div>
	<div style="padding:5px;">
		<div style="float:left; width:100px;">Address:</div> 
		<div style="float:left; width:400px;" id = "divAddresses">
			<?php
				foreach($RESTAURANT->addresses as $key => $address) {
					echo '<a href = "#" id = "map_'.$address->addressId.'">'.$address->displayAddress.'</a><br /><br />';
				}
			?>
		</div>
	</div>	
</div>

