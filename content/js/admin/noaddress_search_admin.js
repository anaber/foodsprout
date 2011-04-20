
$(document).ready(function() {
	
	$('#messageContainer').addClass('center').html('<img src="/img/loading_pink_bar.gif" />');
	
	$.post("/admincp/noaddress/ajaxSearchProducers", { },
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
			
			$.post("/admincp/lottery/ajaxSearchProducers", { q:query },
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
	
	var formAction = '/admincp/noaddress/ajaxSearchProducers';
	
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
	
	$("#heading_producer").click(function(e) {
		e.preventDefault();
		order = getOrder(data, 'producer');
		postAndRedrawContent(data.param.firstPage, data.param.perPage, 'producer', order, data.param.q);
	});
	
}

function addResult(producers, i) {
	var html =
	'<tr>' +
	'	<td valign="top"><a href="/admincp/'+producers.restaurantURL+'/update/'+producers.producerId+'">'+ producers.producerId  +'</a></td>' +
	'	<td valign="top"><a href="/admincp/'+producers.restaurantURL+'/update/'+producers.producerId+'">'+ producers.producer  +'</a></td>' +
	'</tr>';
	
	return html;
}

function getResultTableHeader() {
	var html =
		' <table cellpadding="3" cellspacing="0" border="0" id="tbllist" width = "99%">' +
		'	<thead>' +
		'	<tr>' +
		'		<th id = "heading_id"><a href = "#" style = "color:#FFFFFF">Id</a></th>' +
		'		<th id = "heading_producer"><a href = "#" style = "color:#FFFFFF">Producer Name</a></th>' +
	//	'		<th id = ""><a href = "#" style = "color:#FFFFFF">Chain</a></th>' +
	//	'		<th id = ""><a href = "#" style = "color:#FFFFFF">Company</a></th>' +
	//	'		<th id = ""><a href = "#" style = "color:#FFFFFF">Locations</a></th>' +
	//	'		<th id = ""><a href = "#" style = "color:#FFFFFF">Menu</a></th>' +
		'	</tr>' +
		'	</thead>' +
		'	<tbody>';

	return html;
}

