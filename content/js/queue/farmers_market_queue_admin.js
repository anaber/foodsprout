
$(document).ready(function() {
	
	$('#messageContainer').addClass('center').html('<img src="/img/loading_pink_bar.gif" />');
	
	$.post("/admincp/queue/ajaxQueueFarmersMarket", { },
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
		
		$.post("/admincp/queue/ajaxQueueFarmersMarket", { q:query },
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
	
	var formAction = '/admincp/queue/ajaxQueueFarmersMarket';
	
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
	
	$("#heading_farmers_market").click(function(e) {
		e.preventDefault();
		order = getOrder(data, 'farmers_market_name');
		postAndRedrawContent(data.param.firstPage, data.param.perPage, 'farmers_market_name', order, data.param.q);
	});
	
	$("#heading_user").click(function(e) {
		e.preventDefault();
		order = getOrder(data, 'email');
		postAndRedrawContent(data.param.firstPage, data.param.perPage, 'email', order, data.param.q);
	});
	
	$("#heading_track_ip").click(function(e) {
		e.preventDefault();
		order = getOrder(data, 'track_ip');
		postAndRedrawContent(data.param.firstPage, data.param.perPage, 'track_ip', order, data.param.q);
	});
}

function addResult(farmersMarket, i) {
	var html =
	'<tr>' +
	'	<td valign="top"><a href="/admincp/farmersmarket/update/'+ farmersMarket.farmersMarketId +'">'+ farmersMarket.farmersMarketId +'</a></td>' +
	'	<td valign="top"><a href="/admincp/farmersmarket/update/'+ farmersMarket.farmersMarketId +'">'+ farmersMarket.farmersMarketName +'</a></td>' +
	'	<td valign="top">'+ farmersMarket.email +'</td>' +  
	'	<td valign="top">'+ farmersMarket.ip +'</td>' +  
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
	'		<th id = "heading_farmers_market"><a href = "#" style = "color:#FFFFFF">Farmers Market</a></th>' +
	'		<th id = "heading_user"><a href = "#" style = "color:#FFFFFF">User</a></th>' +
	'		<th id = "heading_track_ip"><a href = "#" style = "color:#FFFFFF">IP</a></th>' +
	'	</tr>' +
	'	</thead>' +
	'	<tbody>';

	return html;
}

