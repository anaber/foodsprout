<script>
	$(document).ready(function() {
		loadSmallMapOnStartUp(38.41055825094609, -98, 3);
		
		$.post("/distributor/ajaxSearchDistributorInfo", { distributorId:"<?php echo (isset($DISTRIBUTOR) ? $DISTRIBUTOR->distributorId : '' ) ?>" },
		function(data){
			reinitializeMap(data, 13);
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
					//$('html, body').animate({scrollTop:2000}, 'slow');
					$('html, body').scrollTop(2000);
				}
			}
		});
		
	});
	
	function loadSmallMapOnStartUp(lat, lng, zoom) {
		var myLatlng = new google.maps.LatLng(lat, lng);
	    var myOptions = {
	      zoom: zoom,
	      center: myLatlng,
	      disableDefaultUI: true,
	      navigationControl: false,
	      scrollwheel: false,
	      mapTypeId: google.maps.MapTypeId.ROADMAP
	    }
	    map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
	}
	
	function getMarkerHtml(o) {
		html = "<font size = '2'><b><i>" + o.distributorName + "</i></b></font><br /><font size = '1'>" +
			  o.addressLine1 + ", " + o.addressLine2 + "<br />" + 
			  o.addressLine3 + "</font><br />"
			  ;
		return html;
	}
</script>

<?php
echo '<h1>'.$DISTRIBUTOR->distributorName.'</h1>';
?>
<div style="overflow:auto; padding:5px;">
	<div style="float:left; width:100px;">Website:</div>
	<div style="float:left; width:400px;"><?php echo ( !empty($DISTRIBUTOR->url) ? '<a target = "_blank" href="' . $this->functionlib->removeProtocolFromUrl($DISTRIBUTOR->url) . '">'.$DISTRIBUTOR->url.'</a>' : '') ?></div>
</div>
<div style="overflow:auto; padding:5px;">
	<div style="float:left; width:100px;">Address:</div> 
	<div style="float:left; width:400px;" id = "divAddresses">
		<?php
			foreach($DISTRIBUTOR->addresses as $key => $address) {
				echo '<a href = "#" id = "map_'.$address->addressId.'">'.$address->displayAddress.'</a><br /><br />';
			}
		?>
	</div>
</div>