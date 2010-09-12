<script src="<?php echo base_url()?>js/jquery.autocomplete.frontend.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo base_url()?>css/jquery.autocomplete.frontend.css" type="text/css" />
<script>
$(document).ready(function() {
	
	function findValueCallback(event, data, formatted) {
		postAndRedrawContent(dataProducts.param.firstPage, dataProducts.param.perPage, dataProducts.param.sort, dataProducts.param.order, data[1], '');
	}
	
	$(":text, textarea").result(findValueCallback).next().click(function() {
		$(this).prev().search();
	});
	
	$("#suggestion_box").autocomplete("/product/get_products_for_auto_suggest", {
		width: 180,
		selectFirst: false,
		cacheLength:0,
		extraParams: {
	       hasFructose: hasFructose
	   	}
	});
	
	$("#suggestion_box").result(function(event, data, formatted) {
		if (data)
			$(this).parent().next().find("input").val(data[1]);
	});
	
	$("#clear").click(function() {
		$(":input").unautocomplete();
	});
	
});
</script>
	
	<div style="-moz-border-radius-topleft:7px;-webkit-border-radius-topleft:7px;border-top-left-radius:7px;background: #F05A25; color:#fff; padding:5px;padding-left:10px;">Search</div>
	<div style="background:#e5e5e5; font-size:90%;padding-left:5px;padding-bottom:5px;padding-top:5px;">
		<input type="text" size="29" id = "suggestion_box">
	</div>
	<br />
	<div style="-moz-border-radius-topleft:7px;-webkit-border-radius-topleft:7px;border-top-left-radius:7px;background: #F05A25; color:#fff; padding:5px;">More Options</div>
	<div style="background:#e5e5e5; font-size:90%; padding:5px;"><a href = "/manufacture">All Manufacturers</a></div>
	
