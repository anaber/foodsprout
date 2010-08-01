
$(document).ready(function() {
	
	$('#messageContainer').addClass('center').html('<img src="/images/loading_pink_bar.gif" />');
	
	$.post("/admincp/farmersmarket/ajaxSearchFarmersMarket", { },
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
		
		$.post("/admincp/farmersmarket/ajaxSearchFarmersMarket", { q:query },
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
	
	var formAction = '/admincp/farmersMarket/ajaxSearchFarmersMarket';
	
	postArray = { p:page, pp:perPage, sort:s, order:o, q:query};
	
	$.post(formAction, postArray,function(data) {		
		redrawContent(data);
	},
	"json");
}


function reinitializeTableHeadingEvent(data) {
	$("#heading_id").click(function(e) {
		e.preventDefault();
		order = getOrder(data, 'farmers_market_id');
		postAndRedrawContent(data.param.firstPage, data.param.perPage, 'farmers_market_id', order, data.param.q);
	});
	
	$("#heading_farm").click(function(e) {
		e.preventDefault();
		order = getOrder(data, 'farmers_market_name');
		postAndRedrawContent(data.param.firstPage, data.param.perPage, 'farmers_market_name', order, data.param.q);
	});
}

function addResult(farmersMarket, i) {
	var html =
	'<tr>' +
	'	<td valign="top"><a href="/admincp/farmersmarket/update/'+ farmersMarket.farmersMarketId +'">'+ farmersMarket.farmersMarketId +'</a></td>' +
	'	<td valign="top"><a href="/admincp/farmersmarket/update/'+ farmersMarket.farmersMarketId +'">'+ farmersMarket.farmersMarketName +'</a></td>' +
	'	<td valign="top">';
	
	$.each(farmersMarket.suppliers, function(j, supplier) {
		supplierType = supplier.supplierType
		supplierType = supplierType.substring(0, 1);
		html += '<a href = "/admincp/farmersmarket/update_supplier/'+supplier.supplierId+'">' + supplier.supplierName + " <b>("+ supplierType.toUpperCase() +")</b>" +"</a><br /><br />";
	});
	
	html += '<a href = "/admincp/farmersmarket/add_supplier/'+farmersMarket.farmersMarketId+'">Supplier</a>' +
			'</td>';
	html +=
	'	<td valign="top">';
	
	$.each(farmersMarket.addresses, function(j, address) {
		html += '<a href = "/admincp/farmersmarket/update_address/'+address.addressId+'">' + address.displayAddress + '</a><br /><br />';
	});
	
	html += '<a href = "/admincp/farmersmarket/add_address/'+farmersMarket.farmersMarketId+'">Addresses</a>' +
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
	'		<th id = "heading_farm"><a href = "#" style = "color:#FFFFFF">Farmers Market</a></th>' +
	'		<th id = ""><a href = "#" style = "color:#FFFFFF">Suppliers</a></th>' +
	'		<th id = ""><a href = "#" style = "color:#FFFFFF">Location</a></th>' +
	'	</tr>' +
	'	</thead>' +
	'	<tbody>';

	return html;
}

