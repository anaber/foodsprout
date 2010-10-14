
$(document).ready(function() {
	
	$('#messageContainer').addClass('center').html('<img src="/img/loading_pink_bar.gif" />');
	
	$.post("/admincp/city/ajaxSearchCity", { },
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
			
			$.post("/admincp/city/ajaxSearchCity", { q:query },
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
	
	var formAction = '/admincp/city/ajaxSearchCity';
	
	postArray = { p:page, pp:perPage, sort:s, order:o, q:query};
	
	$.post(formAction, postArray,function(data) {		
		redrawContent(data);
	},
	"json");
}


function reinitializeTableHeadingEvent(data) {
	$("#heading_id").click(function(e) {
		e.preventDefault();
		order = getOrder(data, 'city_id');
		postAndRedrawContent(data.param.firstPage, data.param.perPage, 'city_id', order, data.param.q);
	});
	
	$("#heading_city").click(function(e) {
		e.preventDefault();
		order = getOrder(data, 'city');
		postAndRedrawContent(data.param.firstPage, data.param.perPage, 'city', order, data.param.q);
	});
	
	$("#heading_state").click(function(e) {
		e.preventDefault();
		order = getOrder(data, 'state');
		postAndRedrawContent(data.param.firstPage, data.param.perPage, 'state', order, data.param.q);
	});
	
}

function addResult(city, i) {
	var html =
	'<tr>' +
	'	<td valign="top">'+ city.cityId +'</td>' +
	'	<td valign="top">'+ city.city +'</td>' +
	'	<td valign="top">';
	
	$.each(city.states, function(j, state) {
		html += state.stateName;
	});
	
	html += '</td>';
	
	'</tr>';
	
	return html;
}

function getResultTableHeader() {
	var html =
	' <table cellpadding="3" cellspacing="0" border="0" id="tbllist" width = "99%">' +
	'	<thead>' +
	'	<tr>' +
	'		<th id = "heading_id"><a href = "#" style = "color:#FFFFFF">Id</a></th>' +
	'		<th id = "heading_city"><a href = "#" style = "color:#FFFFFF">City</a></th>' +
	'		<th id = "heading_city"><a href = "#" style = "color:#FFFFFF">State</a></th>' +
	'	</tr>' +
	'	</thead>' +
	'	<tbody>';

	return html;
}

