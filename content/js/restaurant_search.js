$(document).ready(function() {
	
	$('#messageContainer').addClass('center').html('<img src="/images/loading_pink_bar.gif" />');
	
	
	$.post("/restaurant/ajaxSearchRestaurants", { a:"", p: "0" },
		function(data){
			loadMapOnStartUp(38.41055825094609, -98, 3);
			redrawContent(data);
		},
		"json");
});

function postAndRedrawContent(page, perPage, s, o, query) {
	
	$('#resultsContainer').hide();
	$('#messageContainer').show();
	$('#messageContainer').addClass('center').html('<img src="/images/loading_pink_bar.gif" />');
	
	var formAction = '/restaurant/ajaxSearchRestaurants';
	
	postArray = { p:page, pp:perPage, sort:s, order:o, q:query };
	
	$.post(formAction, postArray,function(data) {		
		redrawContent(data);
	},
	"json");
}

function redrawContent(data) {
	$('#resultTableContainer').empty();
	var resultTableHtml = getResultTableHeader();
	
	$.each(data.results, function(i, a) {
		resultTableHtml += addResult(a, i);
	});	

	resultTableHtml += getResultTableFooter();
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
	
	$('#table_results tbody tr td a').click(function(e) {
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

	reinitializeMap(data);
	
	reinitializePagingEvent(data);
	
	reinitializePageCountEvent(data);
	
	reinitializeRemoveFilters(data);
	
	reinitializeTableHeadingEvent(data);
	
	$("#table_results").colorize( { ignoreHeaders:true });
}


function reinitializeRemoveFilters(data) {
	
	$("#imgRemoveFilters").click(function(e) {
		e.preventDefault();
		postAndRedrawContent(data.param.firstPage, data.param.perPage, data.param.sort, data.param.order, '');
	});
}


function reinitializePagingEvent(data) {
	
	$("#imgFirst").click(function(e) {
		e.preventDefault();
		postAndRedrawContent(data.param.firstPage, data.param.perPage, data.param.sort, data.param.order, data.param.q);
	});
	
	$("#imgPrevious").click(function(e) {
		e.preventDefault();
		previousPage = parseInt(data.param.page)-1;
		if (previousPage <= 0) {
			previousPage = data.param.firstPage;
		}
		postAndRedrawContent(previousPage, data.param.perPage, data.param.sort, data.param.order, data.param.q);
	});
	
	$("#imgNext").click(function(e) {
		e.preventDefault();
		nextPage = parseInt(data.param.page)+1;
		if (nextPage >= data.param.totalPages) {
			nextPage = data.param.lastPage;
		}
		postAndRedrawContent(nextPage, data.param.perPage, data.param.sort, data.param.order, data.param.q);
	});
	
	$("#imgLast").click(function(e) {
		e.preventDefault();
		postAndRedrawContent(data.param.lastPage, data.param.perPage, data.param.sort, data.param.order, data.param.q);
	});
	
}

function reinitializePageCountEvent(data) {
	$("#recordsPerPageList").change(function(e) {
		postAndRedrawContent(data.param.firstPage, $("#recordsPerPageList").val(), data.param.sort, data.param.order, data.param.q);
	});
}

function reinitializeTableHeadingEvent(data) {
	$("#heading_restaurant").click(function(e) {
		e.preventDefault();
		order = getOrder(data, 'restaurant_name');
		postAndRedrawContent(data.param.firstPage, data.param.perPage, 'restaurant_name', order, data.param.q);
	});
}



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
