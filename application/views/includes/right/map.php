<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script> 
<script src="<?php echo base_url()?>js/google_map_v3.js" type="text/javascript"></script>
<div id="location-icon"><img src="/img/location-head-icon.jpg" width="89" height="23" alt="location-head-icon" /></div>
<div id = "small_map" style = "float:left;">
	<div id="small_map_canvas" style="width: <?php echo $width;?>px; height: <?php echo $height;?>px"></div>
	<div style="padding:5px;font-size:13px;">
		Address:
		
		<div style="float:left; width:220px;" id = "divAddresses" >
			<?php
				if (isset ($RESTAURANT)) {
					foreach($RESTAURANT->addresses as $key => $address) {
						echo '<a href = "#" id = "map_'.$address->addressId.'" style="font-size:13px;text-decoration:none;">'.$address->displayAddress.'</a><br /><br />';
					}
				} else if (isset ($FARM)) {
					foreach($FARM->addresses as $key => $address) {
						echo '<a href = "#" id = "map_'.$address->addressId.'" style="font-size:13px;text-decoration:none;">'.$address->displayAddress.'</a><br /><br />';
					}
				} else if (isset ($MANUFACTURE)) {
					foreach($MANUFACTURE->addresses as $key => $address) {
						echo '<a href = "#" id = "map_'.$address->addressId.'" style="font-size:13px;text-decoration:none;">'.$address->displayAddress.'</a><br /><br />';
					}
				} else if (isset ($DISTRIBUTOR)) {
					foreach($DISTRIBUTOR->addresses as $key => $address) {
						echo '<a href = "#" id = "map_'.$address->addressId.'" style="font-size:13px;text-decoration:none;">'.$address->displayAddress.'</a><br /><br />';
					}
				} else if (isset ($FARMERS_MARKET)) {
					foreach($FARMERS_MARKET->addresses as $key => $address) {
						echo '<a href = "#" id = "map_'.$address->addressId.'" style="font-size:13px;text-decoration:none;">'.$address->displayAddress.'</a><br /><br />';
					}
				}
			?>
			<div class = "clear"></div>
		</div>
	</div>
</div>