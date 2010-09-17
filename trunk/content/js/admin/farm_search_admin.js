
$(document).ready(function() {
	
	$('#messageContainer').addClass('center').html('<img src="/img/loading_pink_bar.gif" />');
	
	$.post("/admincp/farm/ajaxSearchFarms", { },
		function(data){
			$('#suggestion_box').val('');
			
			redrawContent(data);
		},
		"json");
		
	$("#suggestion_box").keyup(function() {
		
		var query = $("#suggestion_box").val();
		
		if ( query.length >= 3 || query.length == 0 ) {
			$('#resultsContainer').hide();
			$('#messageContainer').show();
			$('#messageContainer').addClass('center').html('<img src="/img/loading_pink_bar.gif" />');
			
			$.post("/admincp/farm/ajaxSearchFarms", { q:query },
			function(data){
				redrawContent(data);
	      	},
	      	"json");
	    }
      	
	});

});

function postAndRedrawContent(page, perPage, s, o, query) {
	
	$('#resultsContainer').hide();
	$('#messageContainer').show();
	$('#messageContainer').addClass('center').html('<img src="/img/loading_pink_bar.gif" />');
	
	var formAction = '/admincp/farm/ajaxSearchFarms';
	
	postArray = { p:page, pp:perPage, sort:s, order:o, q:query};
	
	$.post(formAction, postArray,function(data) {		
		redrawContent(data);
	},
	"json");
}


function reinitializeTableHeadingEvent(data) {
	$("#heading_id").click(function(e) {
		e.preventDefault();
		order = getOrder(data, 'farm_id');
		postAndRedrawContent(data.param.firstPage, data.param.perPage, 'farm_id', order, data.param.q);
	});
	
	$("#heading_farm").click(function(e) {
		e.preventDefault();
		order = getOrder(data, 'farm_name');
		postAndRedrawContent(data.param.firstPage, data.param.perPage, 'farm_name', order, data.param.q);
	});
	
	$("#heading_farm_type").click(function(e) {
		e.preventDefault();
		order = getOrder(data, 'farm_type');
		postAndRedrawContent(data.param.firstPage, data.param.perPage, 'farm_type', order, data.param.q);
	});
	
	$("#heading_farmer_type").click(function(e) {
		e.preventDefault();
		order = getOrder(data, 'farmer_name');
		postAndRedrawContent(data.param.firstPage, data.param.perPage, 'farmer_name', order, data.param.q);
	});
}

function addResult(farm, i) {
	var html =
	'<tr>' +
	'	<td valign="top"><a href="/admincp/farm/update/'+ farm.farmId +'">'+ farm.farmId +'</a></td>' +
	'	<td valign="top"><a href="/admincp/farm/update/'+ farm.farmId +'">'+ farm.farmName +'</a></td>' +
	'	<td valign="top">'+ farm.farmType +'</td>' +
	'	<td valign="top">'+ farm.farmerType +'</td>' +  
	'	<td valign="top">';
	
	$.each(farm.suppliers, function(j, supplier) {
		supplierType = supplier.supplierType
		supplierType = supplierType.substring(0, 1);
		html += '<a href = "/admincp/farm/update_supplier/'+supplier.supplierId+'">' + supplier.supplierName + " <b>("+ supplierType.toUpperCase() +")</b>" +"</a><br /><br />";
	});
	
	html += '<a href = "/admincp/farm/add_supplier/'+farm.farmId+'">+Supplier</a>' +
			'</td>';
	html +=
	'	<td valign="top">';
	
	$.each(farm.addresses, function(j, address) {
		html += '<a href = "/admincp/farm/update_address/'+address.addressId+'">' + address.displayAddress + '</a><br /><br />';
	});
	
	html += '<a href = "/admincp/farm/add_address/'+farm.farmId+'">+Address</a>' +
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
	'		<th id = "heading_farm"><a href = "#" style = "color:#FFFFFF">Farm Name</a></th>' +
	'		<th id = "heading_farm_type"><a href = "#" style = "color:#FFFFFF">Farm Type</a></th>' +
	'		<th id = "heading_farmer_type"><a href = "#" style = "color:#FFFFFF">Farmer Type</a></th>' +
	'		<th id = ""><a href = "#" style = "color:#FFFFFF">Suppliers</a></th>' +
	'		<th id = ""><a href = "#" style = "color:#FFFFFF">Location</a></th>' +
	'	</tr>' +
	'	</thead>' +
	'	<tbody>';

	return html;
}

