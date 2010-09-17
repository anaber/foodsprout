
$(document).ready(function() {
	
	$('#messageContainer').addClass('center').html('<img src="/img/loading_pink_bar.gif" />');
	
	$.post("/admincp/manufacture/ajaxSearchManufactures", { },
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
		
		$.post("/admincp/manufacture/ajaxSearchManufactures", { q:query },
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
	
	var formAction = '/admincp/manufacture/ajaxSearchManufactures';
	
	postArray = { p:page, pp:perPage, sort:s, order:o, q:query};
	
	$.post(formAction, postArray,function(data) {		
		redrawContent(data);
	},
	"json");
}


function reinitializeTableHeadingEvent(data) {
	$("#heading_id").click(function(e) {
		e.preventDefault();
		order = getOrder(data, 'manufacture_id');
		postAndRedrawContent(data.param.firstPage, data.param.perPage, 'manufacture_id', order, data.param.q);
	});
	
	$("#heading_manufacture").click(function(e) {
		e.preventDefault();
		order = getOrder(data, 'manufacture_name');
		postAndRedrawContent(data.param.firstPage, data.param.perPage, 'manufacture_name', order, data.param.q);
	});
	
	$("#heading_manufacture_type").click(function(e) {
		e.preventDefault();
		order = getOrder(data, 'manufacture_type');
		postAndRedrawContent(data.param.firstPage, data.param.perPage, 'manufacture_type', order, data.param.q);
	});
}

function addResult(manufacture, i) {
	var html =
	'<tr>' +
	'	<td valign="top"><a href="/admincp/manufacture/update/'+ manufacture.manufactureId +'">'+ manufacture.manufactureId +'</a></td>' +
	'	<td valign="top"><a href="/admincp/manufacture/update/'+ manufacture.manufactureId +'">'+ manufacture.manufactureName +'</a></td>' +
	'	<td valign="top">'+ manufacture.manufactureType +'</td>' +
	'	<td valign="top">';
	
	$.each(manufacture.suppliers, function(j, supplier) {
		supplierType = supplier.supplierType
		supplierType = supplierType.substring(0, 1);
		html += '<a href = "/admincp/manufacture/update_supplier/'+supplier.supplierId+'">' + supplier.supplierName + " <b>("+ supplierType.toUpperCase() +")</b>" +"</a><br /><br />";
	});
	
	html += '<a href = "/admincp/manufacture/add_supplier/'+manufacture.manufactureId+'">Supplier</a>' +
			'</td>';
	html +=
	'	<td valign="top">';
	
	$.each(manufacture.addresses, function(j, address) {
		html += '<a href = "/admincp/manufacture/update_address/'+address.addressId+'">' + address.displayAddress + '</a><br /><br />';
	});
	
	html += '<a href = "/admincp/manufacture/add_address/'+manufacture.manufactureId+'">+Addresses</a>' +
			'</td>';
	html +='<td valign="top">' + 
			'<a href = "/admincp/manufacture/add_menu_item/'+manufacture.manufactureId+'">+Product</a>' +
			'</td>';
	
	html +=
	'</tr>'
	;
	
	return html;
}

function getResultTableHeader() {
	var html =
	' <table cellpadding="3" cellspacing="0" border="0" id="tbllist" width = "99%">' +
	'	<thead>' +
	'	<tr>' +
	'		<th id = "heading_id"><a href = "#" style = "color:#FFFFFF">Id</a></th>' +
	'		<th id = "heading_manufacture"><a href = "#" style = "color:#FFFFFF">Manufacture Name</a></th>' +
	'		<th id = "heading_manufacture_type"><a href = "#" style = "color:#FFFFFF">Type</a></th>' +
	'		<th id = ""><a href = "#" style = "color:#FFFFFF">Suppliers</a></th>' +
	'		<th id = ""><a href = "#" style = "color:#FFFFFF">Location</a></th>' +
	'		<th id = ""><a href = "#" style = "color:#FFFFFF">Products</a></th>' +
	'	</tr>' +
	'	</thead>' +
	'	<tbody>';

	return html;
}

