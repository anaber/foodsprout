


function reinitializeTableHeadingEvent(data) {
	$("#heading_id").click(function(e) {
		e.preventDefault();
		order = getOrder(data, 'product_id');
		postAndRedrawContent(data.param.firstPage, data.param.perPage, 'product_id', order, data.param.q);
	});
	
	$("#heading_menu_item").click(function(e) {
		e.preventDefault();
		order = getOrder(data, 'product_name');
		postAndRedrawContent(data.param.firstPage, data.param.perPage, 'product_name', order, data.param.q);
	});

}


function getResultTableHeader() {
	var html =	
	' <table cellpadding="3" cellspacing="0" border="0" id="tbllist" width = "90%">' +
	'	<thead>' +
	'	<tr>' +
	'		<th id = "heading_id"><a href = "#" style = "color:#FFFFFF">Id</a></th>' +
	'		<th id = "heading_menu_item"><a href = "#" style = "color:#FFFFFF">Menu Item</a></th>' +
	'		<th id = "heading_ingredients"><a href = "#" style = "color:#FFFFFF">Ingredients</a></th>' +	
	'	</tr>' +
	'	</thead>' +
	'	<tbody>';

	return html;
}
