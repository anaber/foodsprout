
$(document).ready(function() {
	
	$('#messageContainer').addClass('center').html('<img src="/img/loading_pink_bar.gif" />');
	
	$.post("/admincp/product/ajaxSearchProducts", { f:hasFructose },
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
			
			$.post("/admincp/product/ajaxSearchProducts", { q:query, f:hasFructose },
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
	
	var formAction = '/admincp/product/ajaxSearchProducts';
	
	postArray = { p:page, pp:perPage, sort:s, order:o, q:query, f:hasFructose};
	
	$.post(formAction, postArray,function(data) {		
		redrawContent(data);
	},
	"json");
}


function reinitializeTableHeadingEvent(data) {
	$("#heading_id").click(function(e) {
		e.preventDefault();
		order = getOrder(data, 'product_id');
		postAndRedrawContent(data.param.firstPage, data.param.perPage, 'product_id', order, data.param.q);
	});
	
	$("#heading_product").click(function(e) {
		e.preventDefault();
		order = getOrder(data, 'product_name');
		postAndRedrawContent(data.param.firstPage, data.param.perPage, 'product_name', order, data.param.q);
	});
	
	$("#heading_product_type").click(function(e) {
		e.preventDefault();
		order = getOrder(data, 'product_type');
		postAndRedrawContent(data.param.firstPage, data.param.perPage, 'product_type', order, data.param.q);
	});
	
	$("#heading_brand").click(function(e) {
		e.preventDefault();
		order = getOrder(data, 'brand');
		postAndRedrawContent(data.param.firstPage, data.param.perPage, 'brand', order, data.param.q);
	});
	
/*	$("#heading_upc").click(function(e) {
		e.preventDefault();
		order = getOrder(data, 'upc');
		postAndRedrawContent(data.param.firstPage, data.param.perPage, 'upc', order, data.param.q);
	});*/
}

function addResult(product, i) {
	var html =
	'<tr>' +
	'	<td valign="top">';
	if (product.producerType == 'restaurant') {
		html += '<a href = "/admincp/restaurant/update_menu_item/' + product.productId + '/'+ product.producerId +'">' + product.productId + '</a>';
	} else if (product.producerType == 'restaurant_chain') {
		html += '<a href = "/admincp/restaurantchain/update_menu_item/' + product.productId + '/'+ product.producerId + '">' + product.productId + '</a>';
	} else if (product.producerType == 'manufacture') {
		html += '<a href = "/admincp/manufacture/update_menu_item/' + product.productId + '/'+ product.producerId +'">' + product.productId + '</a>';
	}

	html += 
	'	</td>' +
	'	<td valign="top">';
	if (product.producerType == 'restaurant') {
		html += '<a href = "/admincp/restaurant/update_menu_item/' + product.productId + '/'+ product.producerId +'">' + product.productName + '</a>';
	} else if (product.producerType == 'restaurant_chain') {
		html += '<a href = "/admincp/restaurantchain/update_menu_item/' + product.productId + '/'+ product.producerId + '">' + product.productName + '</a>';
	} else if (product.producerType == 'manufacture') {
		html += '<a href = "/admincp/manufacture/update_menu_item/' + product.productId + '/'+ product.producerId +'">' + product.productName + '</a>';
	}
	
	html += 
	'	</td>' +
	'	<td valign="top">'+ product.productType +'</td>' +
	'	<td valign="top">';
	
	if (product.restaurantName) {
		html += '<a href = "/admincp/restaurant/update/'+product.restaurantId+'">' + product.restaurantName + '</a> <b>(R)</b>';
	} else if (product.restaurantChain) {
		html += '<a href = "/admincp/restaurantchain/update/'+product.restaurantChainId+'">' + product.restaurantChain + '</a> <b>(C)</b>';
	} else if (product.manufactureName) {
		html += '<a href = "/admincp/manufacture/update/'+product.manufactureId+'">' + product.manufactureName + '</a> <b>(M)</b>';
	}
	
	html +=
	'	</td>' +
	'	<td valign="top">'+ product.brand +'</td>';
//	'	<td valign="top">'+ (product.upc ? product.upc : '') +'</td>';
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
	'		<th id = "heading_product"><a href = "#" style = "color:#FFFFFF">Product Name</a></th>' +
	'		<th id = "heading_product_type"><a href = "#" style = "color:#FFFFFF">Product Type</a></th>' +
	'		<th id = ""><a href = "#" style = "color:#FFFFFF">Producer</a></th>' +
	'		<th id = "heading_brand"><a href = "#" style = "color:#FFFFFF">Brand</a></th>' +
//	'		<th id = "heading_upc"><a href = "#" style = "color:#FFFFFF">UPC</a></th>' +
	'	</tr>' +
	'	</thead>' +
	'	<tbody>';

	return html;
}

