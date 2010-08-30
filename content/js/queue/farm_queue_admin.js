
$(document).ready(function() {
	
	$('#messageContainer').addClass('center').html('<img src="/img/loading_pink_bar.gif" />');
	
	$.post("/admincp/queue/ajaxQueueFarms", { },
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
		
		$.post("/admincp/queue/ajaxQueueFarms", { q:query },
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
	
	var formAction = '/admincp/queue/ajaxQueueFarms';
	
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
	'	<td valign="top">'+ farm.email +'</td>' +  
	'	<td valign="top">'+ farm.ip +'</td>' +  
	'	<td valign="top">'+ farm.dateAdded +'</td>' +
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
	'		<th id = ""><a href = "#" style = "color:#FFFFFF">User</a></th>' +
	'		<th id = ""><a href = "#" style = "color:#FFFFFF">IP</a></th>' +
	'		<th id = ""><a href = "#" style = "color:#FFFFFF">Date Added</a></th>' +
	'	</tr>' +
	'	</thead>' +
	'	<tbody>';

	return html;
}

