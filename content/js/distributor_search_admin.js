
$(document).ready(function() {
	
	$('#messageContainer').addClass('center').html('<img src="/img/loading_pink_bar.gif" />');
	
	$.post("/admincp/distributor/ajaxSearchDistributors", { },
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
		
		$.post("/admincp/distributor/ajaxSearchDistributors", { q:query },
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
	
	var formAction = '/admincp/distributor/ajaxSearchDistributors';
	
	postArray = { p:page, pp:perPage, sort:s, order:o, q:query};
	
	$.post(formAction, postArray,function(data) {		
		redrawContent(data);
	},
	"json");
}


function reinitializeTableHeadingEvent(data) {
	$("#heading_id").click(function(e) {
		e.preventDefault();
		order = getOrder(data, 'distributor_id');
		postAndRedrawContent(data.param.firstPage, data.param.perPage, 'distributor_id', order, data.param.q);
	});
	
	$("#heading_distributor").click(function(e) {
		e.preventDefault();
		order = getOrder(data, 'distributor_name');
		postAndRedrawContent(data.param.firstPage, data.param.perPage, 'distributor_name', order, data.param.q);
	});
}

function addResult(distributor, i) {
	var html =
	'<tr>' +
	'	<td valign="top"><a href="/admincp/distributor/update/'+ distributor.distributorId +'">'+ distributor.distributorId +'</a></td>' +
	'	<td valign="top"><a href="/admincp/distributor/update/'+ distributor.distributorId +'">'+ distributor.distributorName +'</a></td>' +
	'	<td valign="top">';
	
	$.each(distributor.suppliers, function(j, supplier) {
		supplierType = supplier.supplierType
		supplierType = supplierType.substring(0, 1);
		html += '<a href = "/admincp/distributor/update_supplier/'+supplier.supplierId+'">' + supplier.supplierName + " <b>("+ supplierType.toUpperCase() +")</b>" +"</a><br /><br />";
	});
	
	html += '<a href = "/admincp/distributor/add_supplier/'+distributor.distributorId+'">Supplier</a>' +
			'</td>';
	html +=
	'	<td valign="top">';
	
	$.each(distributor.addresses, function(j, address) {
		html += '<a href = "/admincp/distributor/update_address/'+address.addressId+'">' + address.displayAddress + '</a><br /><br />';
	});
	
	html += '<a href = "/admincp/distributor/add_address/'+distributor.distributorId+'">Addresses</a>' +
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
	'		<th id = "heading_distributor"><a href = "#" style = "color:#FFFFFF">Distributor Name</a></th>' +
	'		<th id = ""><a href = "#" style = "color:#FFFFFF">Suppliers</a></th>' +
	'		<th id = ""><a href = "#" style = "color:#FFFFFF">Location</a></th>' +
	'	</tr>' +
	'	</thead>' +
	'	<tbody>';

	return html;
}

