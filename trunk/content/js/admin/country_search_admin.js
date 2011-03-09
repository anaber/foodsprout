
$(document).ready(function() {
	
	$('#messageContainer').addClass('center').html('<img src="/img/loading_pink_bar.gif" />');
	
	$.post("/admincp/country/ajaxSearchCountry", { },
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
			
			$.post("/admincp/country/ajaxSearchCountry", { q:query },
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
	
	var formAction = '/admincp/country/ajaxSearchCountry';
	
	postArray = { p:page, pp:perPage, sort:s, order:o, q:query};
	
	$.post(formAction, postArray,function(data) {		
		redrawContent(data);
	},
	"json");
}


function reinitializeTableHeadingEvent(data) {
	$("#heading_id").click(function(e) {
		e.preventDefault();
		order = getOrder(data, 'country_id');
		postAndRedrawContent(data.param.firstPage, data.param.perPage, 'country_id', order, data.param.q);
	});
	
	$("#heading_country").click(function(e) {
		e.preventDefault();
		order = getOrder(data, 'country_name');
		postAndRedrawContent(data.param.firstPage, data.param.perPage, 'country_name', order, data.param.q);
	});	
}

function addResult(country, i) {
	var html =
	'<tr>' +
	'	<td valign="top">'+ country.countryId +'</td>' +
	'	<td valign="top"><a href = "/admincp/country/update/' + country.countryId + '">'+ country.country +'</a></td>';
	
	'</tr>';
	
	return html;
}

function getResultTableHeader() {
	var html =
	' <table cellpadding="3" cellspacing="0" border="0" id="tbllist" width = "99%">' +
	'	<thead>' +
	'	<tr>' +
	'		<th id = "heading_id" width="150"><a href = "#" style = "color:#FFFFFF">Id</a></th>' +
	'		<th id = "heading_country"><a href = "#" style = "color:#FFFFFF">Country</a></th>' +
	'	</tr>' +
	'	</thead>' +
	'	<tbody>';

	return html;
}

