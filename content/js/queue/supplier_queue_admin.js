
$(document).ready(function() {
	
	$('#messageContainer').addClass('center').html('<img src="/img/loading_pink_bar.gif" />');
	
	$.post("/admincp/queue/ajaxQueueSuppliers", { },
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
			
			$.post("/admincp/queue/ajaxQueueSuppliers", { q:query },
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
	
	var formAction = '/admincp/queue/ajaxQueueSuppliers';
	
	postArray = { p:page, pp:perPage, sort:s, order:o, q:query};
	
	$.post(formAction, postArray,function(data) {		
		redrawContent(data);
	},
	"json");
}


function reinitializeTableHeadingEvent(data) {

	$("#heading_supplier").click(function(e) {
		e.preventDefault();
		order = getOrder(data, 'producer');
		postAndRedrawContent(data.param.firstPage, data.param.perPage, 'producer', order, data.param.q);
	});

	$("#heading_suppliee").click(function(e) {
		e.preventDefault();
		order = getOrder(data, 'suppliee');
		postAndRedrawContent(data.param.firstPage, data.param.perPage, 'suppliee', order, data.param.q);
	});


	$("#heading_user").click(function(e) {
		e.preventDefault();
		order = getOrder(data, 'user.email');
		postAndRedrawContent(data.param.firstPage, data.param.perPage, 'user.email', order, data.param.q);
	});
	
	$("#heading_track_ip").click(function(e) {
		e.preventDefault();
		order = getOrder(data, 'supplier.track_ip');
		postAndRedrawContent(data.param.firstPage, data.param.perPage, 'supplier.track_ip', order, data.param.q);
	});
		
}

function addResult(supplier, i) {
/*
	parentType = supplier.parentType
	if (parentType == 'restaurantchain') {
		parentType = 'C';
	} else if (parentType == 'farmersmarket') {
		parentType = 'FM';
	} else {
		parentType = parentType.substring(0, 1);
	}
	var html =
	'<tr>' +
	'	<td valign="top"><a href="/admincp/' + supplier.parentType + '/update/'+ supplier.parentId +'">'+ supplier.parentName + " <b>("+ parentType.toUpperCase() +")</b>" + '</a></td>';
	supplierType = supplier.supplierType
	supplierType = supplierType.substring(0, 1);
	html +=
	'	<td valign="top"><a href="/admincp/' + supplier.parentType + '/update_supplier/'+ supplier.supplierId +'">'+ supplier.supplierName + " <b>("+ supplierType.toUpperCase() +")</b>" +'</a></td>' +

	'	<td valign="top">'+ supplier.supplierId +'</td>' +  
	'	<td valign="top">'+ supplier.supplierName +'</td>' +  
	'	<td valign="top">'+ supplier.email +'</td>' +  
	'	<td valign="top">'+ supplier.ip +'</td>' +  
	'</tr>'
	;
*/

	var html =
	'<tr>' +
	'	<td valign="top">'+ supplier.supplierName +'</td>' +  
	'	<td valign="top">'+ supplier.supplieeName +'</td>' +  
	'	<td valign="top">'+ supplier.email +'</td>' +  
	'	<td valign="top">'+ supplier.ip +'</td>' +  
	'</tr>'
	;
	
	return html;
}

function getResultTableHeader() {
	var html =
	' <table cellpadding="3" cellspacing="0" border="0" id="tbllist" width = "99%">' +
	'	<thead>' +
	'	<tr>' +
	'		<th id="heading_supplier"><a href = "#" style = "color:#FFFFFF">Supplier Name</a></th>' +
	'		<th id="heading_suppliee"><a href = "#" style = "color:#FFFFFF">Suppliee Name</a></th>' +
	'		<th id = "heading_user"><a href = "#" style = "color:#FFFFFF">User</a></th>' +
	'		<th id = "heading_track_ip"><a href = "#" style = "color:#FFFFFF">IP</a></th>' +
	'	</tr>' +
	'	</thead>' +
	'	<tbody>';

	return html;
}

