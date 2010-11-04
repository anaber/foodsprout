
$(document).ready(function() {
	
	$('#messageContainer').addClass('center').html('<img src="/img/loading_pink_bar.gif" />');
	
	$.post("/admincp/seo/ajaxSearchSeo", { },
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
			
			$.post("/admincp/seo/ajaxSearchSeo", { q:query },
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
	
	var formAction = '/admincp/seo/ajaxSearchSeo';
	
	postArray = { p:page, pp:perPage, sort:s, order:o, q:query};
	
	$.post(formAction, postArray,function(data) {		
		redrawContent(data);
	},
	"json");
}


function reinitializeTableHeadingEvent(data) {
	$("#heading_id").click(function(e) {
		e.preventDefault();
		order = getOrder(data, 'seo_id');
		postAndRedrawContent(data.param.firstPage, data.param.perPage, 'seo_id', order, data.param.q);
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

function addResult(seo, i) {
	var html =
	'<tr>' +
	'	<td valign="top"><a href="/admincp/seo/update/'+ seo.seoPageId +'">'+ seo.seoPageId +'</a></td>' +
	'	<td valign="top"><a href="/admincp/seo/update/'+ seo.seoPageId +'">'+ seo.page +'</a></td>' +
	'	<td valign="top">'+ seo.titleTag +'</td>' +
	'	<td valign="top">'+ seo.metaDescription +'</td>' + 
	'	<td valign="top">'+ seo.metaKeywords +'</td>' +
	'	<td valign="top">'+ seo.h1 +'</td>' +
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
	'		<th id = "heading_farm"><a href = "#" style = "color:#FFFFFF">Page</a></th>' +
	'		<th id = "heading_farm_type"><a href = "#" style = "color:#FFFFFF">Title</a></th>' +
	'		<th id = "heading_farmer_type"><a href = "#" style = "color:#FFFFFF">Meta Description</a></th>' +
	'		<th id = "heading_farmer_type"><a href = "#" style = "color:#FFFFFF">Meta Keywords</a></th>' +
	'		<th id = "heading_farmer_type"><a href = "#" style = "color:#FFFFFF">H1</a></th>' +
	'	</tr>' +
	'	</thead>' +
	'	<tbody>';

	return html;
}

