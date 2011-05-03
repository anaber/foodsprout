$(document).ready(function() {
	
	$('#messageContainer').addClass('center').html('<img src="/img/loading_pink_bar.gif" />');
	
	$.post("/admincp/newsfeed/ajaxSearchNewsfeed", { },
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
			
			$.post("/admincp/newsfeed/ajaxSearchNewsfeed", { q:query },
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
	
	var formAction = '/admincp/newsfeed/ajaxSearchNewsfeed';
	
	postArray = { p:page, pp:perPage, sort:s, order:o, q:query};
	
	$.post(formAction, postArray,function(data) {		
		redrawContent(data);
	},
	"json");
}


function reinitializeTableHeadingEvent(data) {
	$("#heading_id").click(function(e) {
		e.preventDefault();
		order = getOrder(data, 'news_feed_id');
		postAndRedrawContent(data.param.firstPage, data.param.perPage, 'news_feed_id', order, data.param.q);
	});
	
	$("#heading_title").click(function(e) {
		e.preventDefault();
		order = getOrder(data, 'news_feed_url');
		postAndRedrawContent(data.param.firstPage, data.param.perPage, 'news_feed_url', order, data.param.q);
	});	

	$("#heading_producer").click(function(e) {
		e.preventDefault();
		order = getOrder(data, 'producer.producer');
		postAndRedrawContent(data.param.firstPage, data.param.perPage, 'producer', order, data.param.q);
	});
	
	$("#heading_product").click(function(e) {
		e.preventDefault();
		order = getOrder(data, 'product.product_name');
		postAndRedrawContent(data.param.firstPage, data.param.perPage, 'product_name', order, data.param.q);
	});
	
	$("#heading_author").click(function(e) {
		e.preventDefault();
		order = getOrder(data, 'user.first_name');
		postAndRedrawContent(data.param.firstPage, data.param.perPage, 'first_name', order, data.param.q);
	});
	
	$("#heading_date").click(function(e) {
		e.preventDefault();
		order = getOrder(data, 'date');
		postAndRedrawContent(data.param.firstPage, data.param.perPage, 'date', order, data.param.q);
	});
}

function addResult(newsfeed, i) {
	var html =
	'<tr>' +
	'	<td><a href="/admincp/newsfeed/edit/'+ newsfeed.newsFeedId +'">'+ newsfeed.newsFeedId +'</a></td>' +
	'	<td><a href="/admincp/newsfeed/edit/'+ newsfeed.newsFeedId +'">'+ newsfeed.newsFeedTitle +'</a></td>' +
	'	<td>'+ newsfeed.newsFeedProducer +'</td>' +
	'	<td>'+ newsfeed.newsFeedProduct +'</td>' +
	'	<td>'+ newsfeed.newsFeedDate +'</td>' +
	'	<td>'+ newsfeed.newsFeedAuthor +'</td>' +
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
	'		<th id = "heading_title"><a href = "#" style = "color:#FFFFFF">Title</a></th>' +
	'		<th id = "heading_producer"><a href = "#" style = "color:#FFFFFF">Producer</a></th>' +
	'		<th id = "heading_product"><a href = "#" style = "color:#FFFFFF">Product</a></th>' +
	'		<th id = "heading_author"><a href = "#" style = "color:#FFFFFF">Date</a></th>' +
	'		<th id = "heading_date"><a href = "#" style = "color:#FFFFFF">Author</a></th>' +
	'	</tr>' +
	'	</thead>' +
	'	<tbody>';

	return html;
}

