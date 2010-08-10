<script>
	$(document).ready(function() {
		loadSmallMapOnStartUp(38.41055825094609, -98, 3);
		
		$.post("/farm/ajaxSearchFarmInfo", { farmId:"<?php echo (isset($FARM) ? $FARM->farmId : '' ) ?>" },
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
		html = "<font size = '2'><b><i>" + o.farmName + "</i></b></font><br /><font size = '1'>" +
			  o.addressLine1 + ", " + o.addressLine2 + "<br />" + 
			  o.addressLine3 + "</font><br />"
			  ;
		return html;
	}
</script>

<div id="restaurantname">
    <div id="logorestaurant"><?php echo '<h1>'.$FARM->farmName.'</h1>';?></div> 
  </div>
  
  <!-- left column-->
  <div id="rest-main-details">	
    <div id="rest-main-img"><img src="/img/applebee-img.jpg" width="201" height="133" alt="apple-img" /></div>
    
    <div id="rest-dec">
      <div id="dec-head"><img src="/img/decription-icon.jpg" width="106" height="22" alt="dec-head" /></div>
      <div id="description-details">welcome</div>
    </div>
    
    <div id="location-icon"><img src="/img/location-head-icon.jpg" width="89" height="23" alt="location-head-icon" /></div>
    
    <div id="map">
	<br>
	<div style="color:#333;">
	http://www.applebees.com<br>
	128 King Street<br>
	San Francisco, CA<br>
	650-210-3100<br>
	</div>
    </div>
  </div>
  <!-- end left column -->
  
  <!-- center tabs -->
  <div id="resultsContainer">
  
    <div id="menu-bar"> 
      <div id="suppliers" class="selected"><a href="#">Supply To</a></div>
      <div id="menu" class="non-selected"><a href="#">Farmers Markets</a></div>
      <div id="comments" class="non-selected"><a href="#">Comments</a></div>
      <div id="add-menu" class="add-item"><a href="#">+ Add</a></div>
    </div>
    
  	<div id="menus"> 
		
	
	
	</div>
	
  </div>
  <!-- end center tabs -->
  
  <!-- right ads -->
  <div id="add-designs">
    	<?php
			$this->load->view('includes/banners/sky');
		?>
  </div>
  <!-- end right ads -->