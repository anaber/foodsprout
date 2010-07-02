
$(document).ready(function() {
	
	$('#messageContainer').addClass('center').html('<img src="/images/loading_pink_bar.gif" />');
	
	$.post("/admincp/restaurant/ajaxSearchRestaurants", { },
		function(data){
			$('#suggestion_box').val('');
			
			redrawContent(data);
		},
		"json");
		
	$("#suggestion_box").keyup(function() {
		
		$('#resultsContainer').hide();
		$('#messageContainer').show();
		$('#messageContainer').addClass('center').html('<img src="/images/loading_pink_bar.gif" />');
		var query = $("#suggestion_box").val();
		
		$.post("/admincp/restaurant/ajaxSearchRestaurants", { q:query },
		function(data){
			redrawContent(data);
      	},
      	"json");
      	
	});

});

function postAndRedrawContent(page, perPage, s, o, query) {
	
	$('#resultsContainer').hide();
	$('#messageContainer').show();
	$('#messageContainer').addClass('center').html('<img src="/images/loading_pink_bar.gif" />');
	
	var formAction = '/admincp/restaurant/ajaxSearchRestaurants';
	
	postArray = { p:page, pp:perPage, sort:s, order:o, q:query};
	
	$.post(formAction, postArray,function(data) {		
		redrawContent(data);
	},
	"json");
}

function redrawContent(data) {
	$('#resultTableContainer').empty();
	var resultTableHtml = getResultTableHeader();
	//var resultTableHtml = '';
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
	
	//$('#searchBox').empty();
	//searchBoxContent = drawSearchBox(data.param);
	//$('#searchBox').append(searchBoxContent);
	
	
	reinitializePagingEvent(data);
	
	reinitializePageCountEvent(data);
	
	reinitializeTableHeadingEvent(data);
	
	$("#tbllist").colorize( { ignoreHeaders:true });
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
	$("#heading_id").click(function(e) {
		e.preventDefault();
		order = getOrder(data, 'restaurant_id');
		postAndRedrawContent(data.param.firstPage, data.param.perPage, 'restaurant_id', order, data.param.q);
	});
	
	$("#heading_restaurant").click(function(e) {
		e.preventDefault();
		order = getOrder(data, 'restaurant_name');
		postAndRedrawContent(data.param.firstPage, data.param.perPage, 'restaurant_name', order, data.param.q);
	});
	
	$("#heading_creation_date").click(function(e) {
		e.preventDefault();
		order = getOrder(data, 'creation_date');
		postAndRedrawContent(data.param.firstPage, data.param.perPage, 'creation_date', order, data.param.q);
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

function drawSearchBox(params) {
	str = '';
	str += '<input type = "text" name = "q" id = "q" size = "30">';
	return str;
}

function drawNumRecords(params) {
	
	str = 'Viewing records ' + params.start + '-' + params.end + ' of ' + params.numResults;
	
	return str;
}

function addResult(restaurant, i) {
	var html =
	'<tr>' +
	'	<td valign="top"><a href="/admincp/restaurant/update/'+ restaurant.restaurantId +'">'+ restaurant.restaurantId +'</a></td>' +
	'	<td valign="top"><a href="/admincp/restaurant/update/'+ restaurant.restaurantId +'">'+ restaurant.restaurantName +'</a></td>' +
	'	<td valign="top">'+ restaurant.creationDate +'</td>' + 
	'	<td valign="top">';
	
		
	$.each(restaurant.suppliers, function(j, supplier) {
		supplierType = supplier.supplierType
		supplierType = supplierType.substring(0, 1);
		
		if (restaurant.suppliersFrom == 'restaurant') {
			html += '<a href = "/admincp/restaurant/update_supplier/'+supplier.supplierId+'">' + supplier.supplierName + " <b>("+ supplierType.toUpperCase() +")</b>" +"</a><br /><br />";
		} else {
			html += supplier.supplierName + " <b>("+ supplierType.toUpperCase() +")</b>" +"<br /><br />";
		}
	});
	if (restaurant.suppliersFrom == 'restaurant') {
		html += '<a href = "/admincp/restaurant/add_supplier/'+restaurant.restaurantId+'">Add Supplier</a>';
	}
	
	html += '</td>';
	
	html +=
	'	<td valign="top">';
	/*
	$.each(restaurant.addresses, function(j, address) {
		html += '<a href = "/admincp/restaurant/update_address/'+address.addressId+'">' + address.completeAddress + '</a><br /><br />';
	});
	*/
	html += '<a href = "/admincp/restaurant/add_address/'+restaurant.restaurantId+'">Add Address</a>' +
			'</td>';
	html +=
	'	<td valign="top">';
	html += '<a href = "/admincp/restaurant/add_menu_item/'+restaurant.restaurantId+'">Menu Item</a>' +
			'</td>';
	
	html +=
	'</tr>'
	;
	
	return html;
}

function getResultTableHeader() {
	var html =
	//'<table width="790" border="1" cellpadding="5" cellspacing="0" id = "table_results">' +
	' <table cellpadding="3" cellspacing="0" border="0" id="tbllist" width = "99%">' +
	'	<thead>' +
	'	<tr>' +
	'		<th id = "heading_id"><a href = "#" style = "color:#FFFFFF">Restaurant Id</a></th>' +
	'		<th id = "heading_restaurant"><a href = "#" style = "color:#FFFFFF">Restaurant Name</a></th>' +
	'		<th id = "heading_creation_date"><a href = "#" style = "color:#FFFFFF">Creation Date</a></th>' +
	'		<th id = ""><a href = "#" style = "color:#FFFFFF">Suppliers</a></th>' +
	'		<th id = ""><a href = "#" style = "color:#FFFFFF">Locations</a></th>' +
	'		<th id = ""><a href = "#" style = "color:#FFFFFF">Menu</a></th>' +
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
