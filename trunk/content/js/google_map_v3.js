var mapCenterAddress;
var map;
var gmarkers = [];
var gmarkers2 = [];

var htmls = [];
var htmls2 = [];

var infowindows = [];
var infowindows2 = [];

var lines = [];

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

function reinitializeMap(mapObject, data, zoomLevel, showLines) {
	a = mapObject.getDiv();
	divId = a.id;
	
	clearOverlays(mapObject);
	
	latitude = '';
	longitude = '';
	
	if (data) {
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
				
				//html = getMarkerHtml(o);
				if (divId == 'small_map_canvas') {
					html = getMarkerHtml2(o);
					htmls2[o.id] = html;
				} else {
					html = getMarkerHtml(o);
					htmls[o.id] = html;
				}
				
		        
		        if (divId == 'small_map_canvas') {
		        	var nMarker = createMarker(mapObject, o, point, html);
		        	gmarkers2[o.id] = nMarker;
		        } else {
		        	if (showLines == true && j == 0) {
		        		var nMarker = createMarker(mapObject, o, point, html, 'king');
		        	} else {
		        		var nMarker = createMarker(mapObject, o, point, html);
		        	}
		        	gmarkers[o.id] = nMarker;
		        }
		        
		        if (showLines == true) {
			        var linesCoordinates = [
					    new google.maps.LatLng(latitude, longitude),
					    new google.maps.LatLng(o.latitude, o.longitude)
					  ];
				  	var linePath = new google.maps.Polyline({
					    path: linesCoordinates,
					    strokeColor: "#F05A25",
					    strokeOpacity: 1.0,
					    strokeWeight: 1
				  	});
		  			linePath.setMap(mapObject);
		  			lines[o.id] = linePath;
	  			}
	  			
				j++;
			});
		}
	} else {
		if (param.numResults == 0) {
			latitude = 38.41055825094609;
			longitude = -98;
		} else {
			var j = 0;
			$.each(geocode, function(i, o) {
				if (j == 0) {
					latitude = o.latitude;
					longitude = o.longitude;
				}
				
				var point = new google.maps.LatLng(o.latitude, o.longitude);
				
				//html = getMarkerHtml(o);
				if (divId == 'small_map_canvas') {
					html = getMarkerHtml2(o);
					htmls2[o.id] = html;
				} else {
					html = getMarkerHtml(o);
					htmls[o.id] = html;
				}
				
		        
		        if (divId == 'small_map_canvas') {
		        	var nMarker = createMarker(mapObject, o, point, html);
		        	gmarkers2[o.id] = nMarker;
		        } else {
		        	if (showLines == true && j == 0) {
		        		var nMarker = createMarker(mapObject, o, point, html, 'king');
		        	} else {
		        		var nMarker = createMarker(mapObject, o, point, html);
		        	}
		        	gmarkers[o.id] = nMarker;
		        }
		        
		        if (showLines == true) {
			        var linesCoordinates = [
					    new google.maps.LatLng(latitude, longitude),
					    new google.maps.LatLng(o.latitude, o.longitude)
					  ];
				  	var linePath = new google.maps.Polyline({
					    path: linesCoordinates,
					    strokeColor: "#F05A25",
					    strokeOpacity: 1.0,
					    strokeWeight: 1
				  	});
		  			linePath.setMap(mapObject);
		  			lines[o.id] = linePath;
	  			}
	  			
				j++;
			});
		}
	}
	var point = new google.maps.LatLng(latitude, longitude);
	mapObject.setCenter(point);
	mapObject.setZoom(zoomLevel);
}

function createMarker(mapObject, o, point, html, king) {
	a = mapObject.getDiv();
	divId = a.id;
	
	if (king == 'king') {
		var image = '/images/icons/restaurant.png';
	
		var marker = new google.maps.Marker({
	        position: point, 
	        map: mapObject,
	        icon: image
	    });
	} else {
		var marker = new google.maps.Marker({
	        position: point, 
	        map: mapObject
	    });
	}
	
	var infowindow = new google.maps.InfoWindow({ 
  		content: html
  		//maxWidth: 50
  	});
    
    if (divId == 'small_map_canvas') {
    	/*
    	google.maps.event.addListener(marker, 'click', function() {
		    clearInfoWindow(mapObject);
		    infowindow.open(mapObject, marker);
		    infowindows2[0] = infowindow;
		});
		*/
    } else {
    	google.maps.event.addListener(marker, 'click', function() {
		    clearInfoWindow(mapObject);
		    infowindow.open(mapObject, marker);
		    infowindows[0] = infowindow;
		});
    }
    	
	return marker;
}

function viewMarker(mapObject, record_id, viewBubble) {
	clearInfoWindow(mapObject);
	
	a = mapObject.getDiv();
	divId = a.id;
	
	if (divId == 'small_map_canvas') {
		/*
		var marker = gmarkers2[record_id];
	
		var infowindow = new google.maps.InfoWindow({ 
	  		content: htmls2[record_id]
	  		//maxWidth: 50
	    });
	    
	    infowindow.open(mapObject, marker);
	    
	    infowindows2[0] = infowindow;
	    */
	} else {
		var marker = gmarkers[record_id];
	
		var infowindow = new google.maps.InfoWindow({ 
	  		content: htmls[record_id]
	  		//maxWidth: 50
	    });
	    
	    infowindow.open(mapObject, marker);
	    
	    infowindows[0] = infowindow;
	}
	
}

function clearOverlays(mapObject) {
	a = mapObject.getDiv();
	divId = a.id;
	//alert(divId);
	if (divId == 'small_map_canvas') {
		if (gmarkers2) {
		    for (i in gmarkers2) {
				gmarkers2[i].setMap(null);
		    }
		}
	} else {
		if (gmarkers) {
		    for (i in gmarkers) {
				gmarkers[i].setMap(null);
		    }
		}
		
		if (lines) {
		    for (i in lines) {
				lines[i].setMap(null);
		    }
		}
	}
	
	
	
	clearInfoWindow(mapObject);
}

function clearInfoWindow(mapObject) {
	a = mapObject.getDiv();
	divId = a.id;
	if (divId == 'small_map_canvas') {
		if (infowindows2[0]) {
			infowindow = infowindows2[0];
			infowindow.close();
		}
	} else {
		if (infowindows[0]) {
			infowindow = infowindows[0];
			infowindow.close();
		}
	}
}
