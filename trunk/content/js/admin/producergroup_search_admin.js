$(document).ready(function() {
	
	$('#messageContainer').addClass('center').html('<img src="/img/loading_pink_bar.gif" />');
	
	$.post("/admincp/producergroup/ajaxSearchProducerGroups", { },
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
			
			$.post("/admincp/producergroup/ajaxSearchProducerGroups", { q:query },
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
	
	var formAction = '/admincp/producergroup/ajaxSearchProducerGroups';
	
	postArray = { p:page, pp:perPage, sort:s, order:o, q:query};
	
	$.post(formAction, postArray,function(data) {		
		redrawContent(data);
	},
	"json");
}

function reinitializeTableHeadingEvent(data) {
	$("#heading_id").click(function(e) {
		e.preventDefault();
		order = getOrder(data, 'company_id');
		postAndRedrawContent(data.param.firstPage, data.param.perPage, 'company_id', order, data.param.q);
	});
	
	$("#heading_company").click(function(e) {
		e.preventDefault();
		order = getOrder(data, 'company_name');
		postAndRedrawContent(data.param.firstPage, data.param.perPage, 'company_name', order, data.param.q);
	});
}

function addResult(company, i) {
	var html =
	'<tr>' +
	'	<td valign="top"><a href="/admincp/company/update/'+ company.companyId +'">'+ company.companyId +'</a></td>' +
	'	<td valign="top"><a href="/admincp/company/update/'+ company.companyId +'">'+ company.companyName +'</a></td>';
	'	<td valign="top"><a href="/admincp/company/update/'+ company.companyId +'">'+ company.companyName +'</a></td>';
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
	'		<th id = "heading_company"><a href = "#" style = "color:#FFFFFF">Company Name</a></th>' +
	'		<th id = "heading_producers">Producers</th>' +
	'	</tr>' +
	'	</thead>' +
	'	<tbody>';

	return html;
}

