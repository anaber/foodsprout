
$(document).ready(function() {
	
	$('#messageContainer').addClass('center').html('<img src="/img/loading_pink_bar.gif" />');
	
	$.post("/admincp/queue/ajaxQueueRestaurants", { },
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
			
			$.post("/admincp/queue/ajaxQueueRestaurants", { q:query },
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
		order = getOrder(data, 'producer_id');
		postAndRedrawContent(data.param.firstPage, data.param.perPage, 'producer_id', order, data.param.q);
	});
	
	$("#heading_restaurant").click(function(e) {
		e.preventDefault();
		order = getOrder(data, 'producer');
		postAndRedrawContent(data.param.firstPage, data.param.perPage, 'producer', order, data.param.q);
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
	'	<td valign="top">'+ restaurant.email +'</td>' +  
	'	<td valign="top">'+ restaurant.ip +'</td>' +  
	'	<td valign="top">'+ restaurant.dateAdded +'</td>' +
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
	'		<th id = "heading_restaurant"><a href = "#" style = "color:#FFFFFF">Restaurant Name</a></th>' +
	'		<th id = ""><a href = "#" style = "color:#FFFFFF">Chain</a></th>' +
	'		<th id = ""><a href = "#" style = "color:#FFFFFF">Company</a></th>' +
	'		<th id = "heading_user"><a href = "#" style = "color:#FFFFFF">User</a></th>' +
	'		<th id = "heading_track_ip"><a href = "#" style = "color:#FFFFFF">IP</a></th>' +
	'		<th id = "heading_creation_date"><a href = "#" style = "color:#FFFFFF">Date Added</a></th>' +
	'	</tr>' +
	'	</thead>' +
	'	<tbody>';

	return html;
}
