var isMapVisible = 1;


function postAndRedrawContent(page, perPage, s, o, query, filter, zoomLevel, restaurantTypes, cuisines) {
	
	//$('#resultsContainer').hide();
	$('#messageContainer').show();
	$('#messageContainer').addClass('center').html('<img src="/images/loading_pink_bar.gif" />');
	
	
	
	
	var formAction = '/restaurant/ajaxSearchRestaurants';
	
	postArray = { p:page, pp:perPage, sort:s, order:o, q:query, f:filter };
	
	$.post(formAction, postArray,function(data) {		
		
		redrawContent(data, zoomLevel, restaurantTypes, cuisines, filter);
		
		//reinitializeRemoveFilters(data);
	},
	"json");
	
}

function redrawAllCuisines(data, cuisines) {
	$('#divAllCuisines').empty();
	
	var resultHtml = '';
	resultHtml = '<strong>Cuisines</strong><br>';
	
	resultHtml += '<table cellpadding = "2" cellspacing = "0" border = "0" width = "500">';
	
	j = 0;
	$.each(cuisines, function(i, a) {
		if (j == 0) {
			resultHtml += '<tr>';
		}
		
		resultHtml += '<td width = "133"><input type="checkbox" value="c_'+ a.cuisineId + '" id = "cuisineId" name = "cuisineId">';
		resultHtml += a.cuisineName;
		resultHtml += '</td>';
		if (j == 2) {
			resultHtml += '</tr>';
		}
		
		j++;
		if (j == 3) {
			j = 0;
		}
	});
	
	if (j < 3 && j > 0) {
		cellRequired = eval(3-j);
		
		for(i = 1; i<= cellRequired; i++) {
			resultHtml += '<td>&nbsp;</td>';
		}
		resultHtml += '</tr>';
	}
	resultHtml += '<tr><td colspan = "3" align = "right"><input type = "button" id = "btnApplyCuisines" value = "Apply Filters"></td></tr>';
	resultHtml += '</table>';
	
		
	$('#divAllCuisines').html(resultHtml);
	
	//reinitializeMoreCuisine();
	reinitializePopupCuisineEvent(data);
}

function redrawCuisines(data, cuisines, filter) {
	$('#divCuisines').empty();
	
	arrRestaurantTypes = new Array();
	j = 0;
	if (filter != '') {
		arrFilter = filter.split(',');
		
		for(i = 0; i < arrFilter.length; i++ ) {
			arr = arrFilter[i].split('_');
			if (arr[0] == 'c') {
				arrRestaurantTypes[j] = arr[1];
				j++;
			}
		}
	}
	
	var resultHtml = '';
	$.each(cuisines, function(i, a) {
		resultHtml += '<input type="checkbox" value="c_'+ a.cuisineId + '" id = "cuisineId" name = "cuisineId"';
		
		for(i = 0; i < arrRestaurantTypes.length; i++ ) {
			if ( arrRestaurantTypes[i] ==  a.cuisineId) {
				resultHtml += ' CHECKED';
				break;
			}
		}
		resultHtml += '>';
		
		resultHtml += a.cuisineName + '<br>';
	});	
	
	resultHtml += '<br><a href = "#" id = "chooseMoreCuisine" name = "">Choose More..</a><br>';
		
	$('#divCuisines').html(resultHtml);
	
	reinitializeMoreCuisine(data);
}

function reinitializeMoreCuisine(data) {
	$("#chooseMoreCuisine").click(function(e){
		e.preventDefault();
		
		var formAction = '/restaurant/ajaxGetAllDistinctUsedCuisine';
		postArray = { };
		
		$.post(formAction, postArray,function(cuisines) {		
			centerPopup();
			loadPopup();
			
			redrawAllCuisines(data, cuisines);
			
		},
		"json");
		
	});
	
	//CLOSING POPUP
	//Click the x event!
	$("#popupClose").click(function(){
		disablePopup();
	});
	//Click out event!
	$("#backgroundPopup").click(function(){
		disablePopup();
	});
	//Press Escape event!
	$(document).keypress(function(e){
		if(e.keyCode==27 && popupStatus==1){
			disablePopup();
		}
	});
	
}



	
function redrawRestaurantTypes(restaurantTypes, filter) {
	$('#divRestaurantTypes').empty();
	
	arrRestaurantTypes = new Array();
	j = 0;
	if (filter != '') {
		arrFilter = filter.split(',');
		
		for(i = 0; i < arrFilter.length; i++ ) {
			arr = arrFilter[i].split('_');
			if (arr[0] == 'r') {
				arrRestaurantTypes[j] = arr[1];
				j++;
			}
		}
	}
	
	var resultHtml = '';
	$.each(restaurantTypes, function(i, a) {
		resultHtml += '<input type="checkbox" value="r_'+ a.restaurantTypeId + '" id = "restaurantTypeId" name = "restaurantTypeId"';
		
		for(i = 0; i < arrRestaurantTypes.length; i++ ) {
			if ( arrRestaurantTypes[i] ==  a.restaurantTypeId) {
				resultHtml += ' CHECKED';
				break;
			}
		}
		resultHtml += '>';
		resultHtml += a.restaurantType + '<br>';
	});	
	
	resultHtml += '<br><a href = "#" id = "chooseMoreRestaurantType" name = "">Choose More..</a><br>';
	
	$('#divRestaurantTypes').html(resultHtml);
}
		
function redrawZipcodeBox() {
	$('#divZipcode').empty();
	formFilterContent = '<form id = "frmFilters">Zip Code <input type="text" size="6" maxlength="5" id = "q"></form>';
	$('#divZipcode').html(formFilterContent);
}
		
	

function redrawContent(data, zoomLevel, restaurantTypes, cuisines, filter) {
	
	redrawRestaurantTypes(restaurantTypes, filter);
	redrawCuisines(data, cuisines, filter);
	
	$('#resultTableContainer').empty();
	//var resultTableHtml = getResultTableHeader();
	var resultTableHtml = '';
	
	$.each(data.results, function(i, a) {
		resultTableHtml += addResult(a, i);
	});	
	
	//resultTableHtml += getResultTableFooter();
	$('#resultTableContainer').append(resultTableHtml);
	
	$('#messageContainer').hide();
	$('#resultsContainer').show();
	
	
	$('#numRecords').empty();
	numRecordsContent = drawNumRecords(data.param);			
	$('#numRecords').append(numRecordsContent);
	
	$('#recordsPerPage').empty();
	recordsPerPageContent = drawRecordsPerPage(data.param);
	$('#recordsPerPage').append(recordsPerPageContent);
	
	$('#pagingLinks').empty();
	pagingLinksContent = drawPagingLinks(data.param);
	$('#pagingLinks').append(pagingLinksContent);
	
	if (showFilters ==  true) {
		$('#removeFilters').empty();
		removeFilterContent = '<a id = "imgRemoveFilters" href = "#">Remove Filters</a>';
		$('#removeFilters').append(removeFilterContent);
	}
	
	if (showMap ==  true) { 
		$('#divHideMap').empty();
		showHideMapContent = '<a href = "#" id = "linkHideMap">Show/Hide Map</a>';
		$('#divHideMap').append(showHideMapContent);
	}
	
	redrawZipcodeBox();
	
	$("#q").val(data.param.q);
	
	//$('#table_results tbody tr td a').click(function(e) {
	$('#resultTableContainer div div a').click(function(e) {
		record_id = $(this).attr('id');
		
		if (record_id != '') {
			if (isNaN(record_id) ) {
				e.preventDefault();
				var arr = record_id.split('_');
				record_id = arr[1];
				
				viewMarker(record_id);
			} else {
				document.location='/restaurant/view/'+record_id;
			}
		}
		
	});
	
	if (showMap ==  true) { 
		reinitializeMap(data, zoomLevel);
	}
	
	reinitializePagingEvent(data, restaurantTypes, cuisines);
	
	reinitializePageCountEvent(data, restaurantTypes, cuisines);
	
	if (showFilters ==  true) {
		reinitializeRemoveFilters(data, restaurantTypes, cuisines);
	}
	
	//reinitializeTableHeadingEvent(data);
	
	reinitializeFilterEvent(data, restaurantTypes, cuisines);
	
	reinitializeQueryFilterEvent(data, restaurantTypes, cuisines);
	
	reinitializeShowHideMap(data, restaurantTypes, cuisines);
	
	
	
	//$("#table_results").colorize( { ignoreHeaders:true });
	
}



function reinitializeShowHideMap(data, restaurantTypes, cuisines) {
	$("#linkHideMap").click(function(e) {
		
		e.preventDefault();
		
		var $map = $('#map');
		if (isMapVisible == 1) {
			$map.hide(800);
			isMapVisible = 0;
		} else {
			$map.show(800);
			isMapVisible = 1;
		}
	});
}

function reinitializeFilterEvent (data, restaurantTypes, cuisines) {
	
	$(':checkbox').click(function () {
		
		var strRestaurantTypeId = '';
		var strRestaurantTypeId2 = '';
		j = 0;
		
		$('#divRestaurantTypes :checked').each(function() {
		   if (j == 0 ) {
	        	strRestaurantTypeId += $(this).val();
	        } else {
	        	strRestaurantTypeId += ',' + $(this).val();
	        }
	        j++;
		  }
		);
		$('#divCuisines :checked').each(function() {
		   if (j == 0 ) {
	        	strRestaurantTypeId += $(this).val();
	        } else {
	        	strRestaurantTypeId += ',' + $(this).val();
	        }
	        j++;
		  }
		);
		
		/*
		$('#divAllCuisines :checked').each(function() {
		   if (j == 0 ) {
	        	strRestaurantTypeId2 += $(this).val();
	        } else {
	        	strRestaurantTypeId2 += ',' + $(this).val();
	        }
	        j++;
		  }
		);
		*/
		alert("From line 294: " + strRestaurantTypeId);
		currentZoomLevel = defaultZoomLevel;
		
		postAndRedrawContent(data.param.firstPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, strRestaurantTypeId, defaultZoomLevel, restaurantTypes, cuisines);
	});
}

function reinitializePopupCuisineEvent (data) {
	
	var strRestaurantTypeId = '';
	
	//$(':checkbox').click(function () {
	$('#btnApplyCuisines').click(function () {
		
		j = 0;
		
		$('#divAllCuisines :checked').each(function() {
		   if (j == 0 ) {
	        	strRestaurantTypeId += $(this).val();
	        } else {
	        	strRestaurantTypeId += ',' + $(this).val();
	        }
	        j++;
		  }
		);
		alert("From line 368: " + strRestaurantTypeId);
		
		currentZoomLevel = defaultZoomLevel;
		disablePopup();
		//postAndRedrawContent(data.param.firstPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, strRestaurantTypeId, defaultZoomLevel, restaurantTypes, cuisines);
		postAndRedrawContent(data.param.firstPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, strRestaurantTypeId, defaultZoomLevel, '', '');
		
	});
	
	
}



function reinitializeQueryFilterEvent (data, restaurantTypes, cuisines) {
	
	$("#frmFilters").submit(function(e) {
		e.preventDefault();
		currentZoomLevel = zipSearchZoomLevel;
		postAndRedrawContent(data.param.firstPage, data.param.perPage, data.param.sort, data.param.order, $("#q").val(), data.param.filter, zipSearchZoomLevel, restaurantTypes, cuisines);
	});
}


function reinitializeRemoveFilters(data, restaurantTypes, cuisines) {
	
	$("#imgRemoveFilters").click(function(e) {
		e.preventDefault();
		currentZoomLevel = defaultZoomLevel;
		postAndRedrawContent(data.param.firstPage, data.param.perPage, data.param.sort, data.param.order, '', '', defaultZoomLevel, restaurantTypes, cuisines);
		$('#frmFilters')[0].reset();
	});
}


function reinitializePagingEvent(data, restaurantTypes, cuisines) {
	
	$("#imgFirst").click(function(e) {
		e.preventDefault();
		postAndRedrawContent(data.param.firstPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, data.param.filter, currentZoomLevel, restaurantTypes, cuisines);
	});
	
	$("#imgPrevious").click(function(e) {
		e.preventDefault();
		previousPage = parseInt(data.param.page)-1;
		if (previousPage <= 0) {
			previousPage = data.param.firstPage;
		}
		postAndRedrawContent(previousPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, data.param.filter, currentZoomLevel, restaurantTypes, cuisines);
	});
	
	$("#imgNext").click(function(e) {
		e.preventDefault();
		nextPage = parseInt(data.param.page)+1;
		if (nextPage >= data.param.totalPages) {
			nextPage = data.param.lastPage;
		}
		postAndRedrawContent(nextPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, data.param.filter, currentZoomLevel, restaurantTypes, cuisines);
	});
	
	$("#imgLast").click(function(e) {
		e.preventDefault();
		postAndRedrawContent(data.param.lastPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, data.param.filter, currentZoomLevel, restaurantTypes, cuisines);
	});
	
}

function reinitializePageCountEvent(data, restaurantTypes, cuisines) {
	$("#recordsPerPageList").change(function(e) {
		postAndRedrawContent(data.param.firstPage, $("#recordsPerPageList").val(), data.param.sort, data.param.order, data.param.q, data.param.filter, currentZoomLevel, restaurantTypes, cuisines);
	});
}

/*
function reinitializeTableHeadingEvent(data) {
	$("#heading_restaurant").click(function(e) {
		e.preventDefault();
		order = getOrder(data, 'restaurant_name');
		postAndRedrawContent(data.param.firstPage, data.param.perPage, 'restaurant_name', order, data.param.q, data.param.filter);
	});
}
*/


function getOrder(data, field_name ) {
	var order = 'ASC';
	
	if (data.param.sort == field_name) {
		if (data.param.order == 'ASC') {
			order = 'DESC';
		} else {
			order = 'ASC';
		}
	}
	return order;
}

function drawRecordsPerPage(params) {
	str = '';
	str += '<select id = "recordsPerPageList">';
	str += '<option value = "">--Per Page--</option>';
	for(i = 10; i <= 100; i+=10) {
		str += '<option value = "' + i + '"';
		if (i == params.perPage) {
			str += ' SELECTED'
		}
		str += '>'+i+'</option>';
	}
	str += '</select>';

	return str;
}

function drawPagingLinks(params) {
	str = '';
	str += '<a href="#" id = "imgFirst">First</a> &nbsp;&nbsp;';
	str += '<a href="#" id = "imgPrevious">Previous</a> ';
	str += '&nbsp;&nbsp;&nbsp; Page ' + (parseInt(params.page)+1) + ' of ' + params.totalPages + '&nbsp;&nbsp;&nbsp;';
	str += '<a href="#" id = "imgNext">Next</a> &nbsp;&nbsp;';
	str += '<a href="#" id = "imgLast">Last</a>';
	
	return str;
}

function drawNumRecords(params) {
	
	str = 'Viewing records ' + params.start + '-' + params.end + ' of ' + params.numResults;
	
	return str;
}


function addResult(restaurant, i) {
	var html =
	'<div style="overflow:auto; padding:5px;">' +
	'	<div style="float:left; width:300px;"><a href="/restaurant/view/' + restaurant.restaurantId + '" id = "'+ restaurant.restaurantId +'">'+ restaurant.restaurantName +'</a><br>Cuisine:';
	
	$.each(restaurant.cuisines, function(j, cuisine) {
		if (j == 0) {
			html += cuisine.cuisine;
		} else {
			html += ",&nbsp;" + cuisine.cuisine;
		}
	});
	
	html += '</div>' + 
	'	<div style="float:right; width:400px;">Address:<br />';
	$.each(restaurant.addresses, function(j, address) {
		if (j == 0) {
			html += '<a href="#" id = "map_'+ address.addressId +'"><em>' + address.completeAddress + '</em></a>';
		} else {
			html += "<br /><br />" + '<a href="#" id = "map_'+ address.addressId +'"><em>' + address.completeAddress + '</em></a>';
		}
	});
	html += '</div>';
	html +=
	'</div>'
	;
	
	return html;
}

/*
function addResult(restaurant, i) {
	var html =
	'<tr>' +
	'	<td valign="top"><a href="#" id = "'+ restaurant.restaurantId +'">'+ restaurant.restaurantName +'</a></td>' +
	'	<td valign="top">';
	$.each(restaurant.addresses, function(j, address) {
		if (j == 0) {
			html += '<a href="#" id = "map_'+ address.addressId +'"><em>' + address.completeAddress + '</em></a>';
		} else {
			html += "<br /><br />" + '<a href="#" id = "map_'+ address.addressId +'"><em>' + address.completeAddress + '</em></a>';
		}
	});
	html += '</td>';
	
	html +=
	'	<td valign="top">';
	$.each(restaurant.suppliers, function(j, supplier) {
		if (j == 0) {
			html += supplier.supplierName;
		} else {
			html += "<br /><br />" + supplier.supplierName;
		}
	});
	html += '</td>';
	
	html +=
	'</tr>'
	;
	
	return html;
}

function getResultTableHeader() {
	var html =
	'<table width="790" border="1" cellpadding="5" cellspacing="0" id = "table_results">' +
	'	<thead>' +
	'	<tr>' +
	'		<th width="250" id = "heading_restaurant"><a href = "#" style = "color:#505050">Restaurant</a></th>' +
	'		<th width="300" id = ""><a href = "#" style = "color:#505050">Address</a></th>' +
	'		<th width="240" id = ""><a href = "#" style = "color:#505050">Suppliers</a></th>' +
	'	</tr>' +
	'	</thead>' +
	'	<tbody>';

	return html;
}

function getResultTableFooter() {
	var html = 
	'</tbody>' +
	'</table>';
	return html;
}
*/