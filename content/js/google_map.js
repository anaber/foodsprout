var mapCenterAddress;
var map;
var gmarkers = [];
var htmls = [];

function loadMapOnStartUp(lat, lng, zoom) {
	
	if (GBrowserIsCompatible()) {
		if (map != null) return;
		map = new GMap2(document.getElementById("map_canvas"));
    	map.addControl(new GSmallMapControl());
    
		map.enableScrollWheelZoom();
		
		map.setCenter(new GLatLng(lat, lng), zoom);

		geocoder = new GClientGeocoder();
	} else {
		alert("Sorry, the Google Maps API is not compatible with this browser");
	}
}


function reinitializeMap(data, zoomLevel) {
	map.clearOverlays();
	
	latitude = '';
	longitude = '';
	var j = 0;
	$.each(data.geocode, function(i, o) {
		if (j == 0) {
			latitude = o.latitude;
			longitude = o.longitude;
		}
		
		var point = new GLatLng(o.latitude, o.longitude);
		html = getMarkerHtml(o);
		htmls[o.id] = html;
		
        var nMarker = createMarker(o, point, html);
        map.addOverlay(nMarker);
        
        gmarkers[o.id] = nMarker;
        
		j++;
	});
		
	map.setCenter(new GLatLng(latitude, longitude), zoomLevel);

}


function createMarker(o, point, html) {
	var marker = new GMarker(point);
	GEvent.addListener(marker, "click", function() {
		marker.openInfoWindowHtml(html);
	});     
	return marker;
}

function getMarkerHtml(o) {
	html = "<font size = '2'><b><i>" + o.restaurantName + "</i></b></font><br /><font size = '1'>" +
		  o.addressLine1 + "<br />" + 
		  o.addressLine2 + "<br />" + 
		  o.addressLine3 + "</font><br />"
		  ;
	return html;
}

function viewMarker(record_id) {
	gmarkers[record_id].openInfoWindowHtml(htmls[record_id]);
}
