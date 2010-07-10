<script>
	$(document).ready(function() {
		loadMapOnStartUp(38.41055825094609, -98, 3);
		
		$.post("/farm/ajaxSearchFarmInfo", { farmId:"<?php echo (isset($FARM) ? $FARM->farmId : '' ) ?>" },
		function(data){
			reinitializeMap(data, 8);
		},
		"json");
		
		$('#divAddresses a').click(function(e) {
			record_id = $(this).attr('id');
			
			if (record_id != '') {
				if (isNaN(record_id) ) {
					e.preventDefault();
					var arr = record_id.split('_');
					record_id = arr[1];
					
					viewMarker(record_id);
					$('html, body').animate({scrollTop:2000}, 'slow');
				}
			}
		});
		
	});
	
	
	
function getMarkerHtml(o) {
	html = "<font size = '2'><b><i>" + o.farmName + "</i></b></font><br /><font size = '1'>" +
		  o.addressLine1 + ", " + o.addressLine2 + "<br />" + 
		  o.addressLine3 + "</font><br />"
		  ;
	return html;
}
</script>

<?php
echo '<h1>'.$FARM->farmName.'</h1>';
?>
<div style="overflow:auto; padding:5px;">
	<div style="float:left; width:100px;">Website:</div> 
	<div style="float:left; width:400px;"><?php echo ( !empty($FARM->url) ? '<a href="' . $FARM->url . '">'.$FARM->url.'</a>' : '') ?></div>
</div>
<div style="overflow:auto; padding:5px;">
	<div style="float:left; width:100px;">Type:</div> 
	<div style="float:left; width:400px;"><?php echo ( !empty($FARM->farmType) ? $FARM->farmType : '') ?></div>
</div>
<div style="overflow:auto; padding:5px;">
	<div style="float:left; width:100px;">Address:</div> 
	<div style="float:left; width:400px;" id = "divAddresses">
		<?php
			foreach($FARM->addresses as $key => $address) {
				echo '<a href = "#" id = "map_'.$address->addressId.'">'.$address->displayAddress.'</a><br /><br />';
			}
		?>
	</div>
</div>