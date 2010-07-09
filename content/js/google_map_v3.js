var mapCenterAddress;
var map;
var gmarkers = [];
var htmls = [];
var infowindows = [];


function loadMapOnStartUp(lat, lng, zoom) {
	
	
	var myLatlng = new google.maps.LatLng(lat, lng);
    var myOptions = {
      zoom: zoom,
      center: myLatlng,
      disableDefaultUI: true,
      navigationControl: true,
      scrollwheel: false,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
}

function reinitializeMap(data, zoomLevel) {
	clearOverlays();
	
	latitude = '';
	longitude = '';
	
	if (data.param.numResults == 0) {
		latitude = 38.41055825094609;
		longitude = -98;
	} else {
		var j = 0;
		$.each(data.geocode, function(i, o) {
			if (j == 0) {
				latitude = o.latitude;
				longitude = o.longitude;
			}
			
			var point = new google.maps.LatLng(o.latitude, o.longitude);
			
			html = getMarkerHtml(o);
			htmls[o.id] = html;
			
	        var nMarker = createMarker(o, point, html);
	        
	        gmarkers[o.id] = nMarker;
			j++;
		});
	}
	
	var point = new google.maps.LatLng(latitude, longitude);
	map.setCenter(point);
	map.setZoom(zoomLevel);
	
}

function createMarker(o, point, html) {
	var marker = new google.maps.Marker({
        position: point, 
        map: map
    });
	
	var infowindow = new google.maps.InfoWindow({ 
  		content: html
    });
    
	google.maps.event.addListener(marker, 'click', function() {
	    clearInfoWindow();
	    infowindow.open(map, marker);
	    infowindows[0] = infowindow;
	});
	
	return marker;
}

function viewMarker(record_id) {
	clearInfoWindow();
	
	var marker = gmarkers[record_id];
	var infowindow = new google.maps.InfoWindow({ 
  		content: htmls[record_id]
    });
    infowindow.open(map, marker);
    
    infowindows[0] = infowindow;
    $('html, body').animate({scrollTop:0}, 'slow');
}

function clearOverlays() {
	if (gmarkers) {
	    for (i in gmarkers) {
			gmarkers[i].setMap(null);
	    }
	}
	clearInfoWindow();
}

function clearInfoWindow() {
	if (infowindows[0]) {
		infowindow = infowindows[0];
		infowindow.close();
	}
}
