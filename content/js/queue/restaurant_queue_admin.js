
$(document).ready(function() {
	
	$('#messageContainer').addClass('center').html('<img src="/img/loading_pink_bar.gif" />');
	
	$.post("/admincp/queue/ajaxQueueRestaurants", { },
		function(data){
			$('#suggestion_box').val('');
			
			redrawContent(data);
		},
		"json");
		
	$("#suggestion_box").keyup(function() {
		
		$('#resultsContainer').hide();
		$('#messageContainer').show();
		$('#messageContainer').addClass('center').html('<img src="/img/loading_pink_bar.gif" />');
		var query = $("#suggestion_box").val();
		
		$.post("/admincp/queue/ajaxQueueRestaurants", { q:query },
		function(data){
			redrawContent(data);
      	},
      	"json");
      	
	});

});

function postAndRedrawContent(page, perPage, s, o, query) {
	
	$('#resultsContainer').hide();
	$('#messageContainer').show();
	$('#messageContainer').addClass('center').html('<img src="/img/loading_pink_bar.gif" />');
	
	var formAction = '/admincp/queue/ajaxQueueRestaurants';
	
	postArray = { p:page, pp:perPage, sort:s, order:o, q:query};
	
	$.post(formAction, postArray,function(data) {		
		redrawContent(data);
	},
	"json");
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


function addResult(restaurant, i) {
	var html =
	'<tr>' +
	'	<td valign="top"><a href="/admincp/restaurant/update/'+ restaurant.restaurantId +'">'+ restaurant.restaurantId +'</a></td>' +
	'	<td valign="top"><a href="/admincp/restaurant/update/'+ restaurant.restaurantId +'">'+ restaurant.restaurantName +'</a></td>' +
	'	<td valign="top">'+ (restaurant.restaurantChain ? restaurant.restaurantChain : '' ) +'</td>' + 
	'	<td valign="top">'+ (restaurant.companyName ? restaurant.companyName : '' ) +'</td>' +
	//'	<td valign="top">'+ restaurant.creationDate +'</td>' + 
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
		html += '<a href = "/admincp/restaurant/add_supplier/'+restaurant.restaurantId+'">Supplier</a>';
	}
	
	html += '</td>';
	
	html +=
	'	<td valign="top">';
	/*
	$.each(restaurant.addresses, function(j, address) {
		html += '<a href = "/admincp/restaurant/update_address/'+address.addressId+'">' + address.completeAddress + '</a><br /><br />';
	});
	*/
	html += '<a href = "/admincp/restaurant/add_address/'+restaurant.restaurantId+'">Address</a>' +
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
	'		<th id = "heading_id"><a href = "#" style = "color:#FFFFFF">Id</a></th>' +
	'		<th id = "heading_restaurant"><a href = "#" style = "color:#FFFFFF">Restaurant Name</a></th>' +
	'		<th id = ""><a href = "#" style = "color:#FFFFFF">Chain</a></th>' +
	'		<th id = ""><a href = "#" style = "color:#FFFFFF">Company</a></th>' +
	//'		<th id = "heading_creation_date"><a href = "#" style = "color:#FFFFFF">Creation Date</a></th>' +
	'		<th id = ""><a href = "#" style = "color:#FFFFFF">Suppliers</a></th>' +
	'		<th id = ""><a href = "#" style = "color:#FFFFFF">Locations</a></th>' +
	'		<th id = ""><a href = "#" style = "color:#FFFFFF">Menu</a></th>' +
	'	</tr>' +
	'	</thead>' +
	'	<tbody>';

	return html;
}
