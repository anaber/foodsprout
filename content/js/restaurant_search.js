var isMapVisible = 1;


function postAndRedrawContent(page, perPage, s, o, query, filter) {
	
	$('#resultsContainer').hide();
	$('#messageContainer').show();
	$('#messageContainer').addClass('center').html('<img src="/images/loading_pink_bar.gif" />');
	
	var formAction = '/restaurant/ajaxSearchRestaurants';
	
	postArray = { p:page, pp:perPage, sort:s, order:o, q:query, f:filter };
	
	$.post(formAction, postArray,function(data) {		
		redrawContent(data);
		
		//reinitializeRemoveFilters(data);
	},
	"json");
}

function redrawContent(data) {
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
	
	//$('#divZipcode').empty();
	//formFilterContent = 'Zip Code <input type="text" size="6" maxlength="5" id = "q">';
	//$('#divZipcode').append(formFilterContent);
	
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
		reinitializeMap(data);
	}
	
	reinitializePagingEvent(data);
	
	reinitializePageCountEvent(data);
	
	if (showFilters ==  true) {
		reinitializeRemoveFilters(data);
	}
	
	//reinitializeTableHeadingEvent(data);
	
	reinitializeFilterEvent(data);
	
	reinitializeQueryFilterEvent(data);
	
	reinitializeShowHideMap(data);
	
	//$("#table_results").colorize( { ignoreHeaders:true });
}



function reinitializeShowHideMap(data) {
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

function reinitializeFilterEvent (data) {
	
	$(':checkbox').click(function () {
		var strRestaurantTypeId = '';
		j = 0;
		$.each($("input[@name='restaurantTypeId']:checked"), function() {
		    if (j == 0 ) {
	        	strRestaurantTypeId += $(this).val();
	        } else {
	        	strRestaurantTypeId += ',' + $(this).val();
	        }
	        j++;
		});
		
		postAndRedrawContent(data.param.firstPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, strRestaurantTypeId);
	});
}

function reinitializeQueryFilterEvent (data) {
	
	$("#frmFilters").submit(function(e) {
		e.preventDefault();
		//alert("Deepak");
		postAndRedrawContent(data.param.firstPage, data.param.perPage, data.param.sort, data.param.order, $("#q").val(), data.param.filter);
	});
}


function reinitializeRemoveFilters(data) {
	
	$("#imgRemoveFilters").click(function(e) {
		e.preventDefault();
		postAndRedrawContent(data.param.firstPage, data.param.perPage, data.param.sort, data.param.order, '', '');
		$('#frmFilters')[0].reset();
	});
}


function reinitializePagingEvent(data) {
	
	$("#imgFirst").click(function(e) {
		e.preventDefault();
		postAndRedrawContent(data.param.firstPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, data.param.filter);
	});
	
	$("#imgPrevious").click(function(e) {
		e.preventDefault();
		previousPage = parseInt(data.param.page)-1;
		if (previousPage <= 0) {
			previousPage = data.param.firstPage;
		}
		postAndRedrawContent(previousPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, data.param.filter);
	});
	
	$("#imgNext").click(function(e) {
		e.preventDefault();
		nextPage = parseInt(data.param.page)+1;
		if (nextPage >= data.param.totalPages) {
			nextPage = data.param.lastPage;
		}
		postAndRedrawContent(nextPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, data.param.filter);
	});
	
	$("#imgLast").click(function(e) {
		e.preventDefault();
		postAndRedrawContent(data.param.lastPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, data.param.filter);
	});
	
}

function reinitializePageCountEvent(data) {
	$("#recordsPerPageList").change(function(e) {
		postAndRedrawContent(data.param.firstPage, $("#recordsPerPageList").val(), data.param.sort, data.param.order, data.param.q, data.param.filter);
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
	'	<div style="float:left; width:300px;"><a href="#" id = "'+ restaurant.restaurantId +'">'+ restaurant.restaurantName +'</a><br>Cuisine:' + restaurant.cuisine + '</div>' +
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