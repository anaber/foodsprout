<script src="<?php echo base_url()?>js/jquery.autocomplete.frontend.js" type="text/javascript"></script>
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
	
	<div class="filterh">Search</div>
	<div class="filterb">
		<input type="text" size="18" id="suggestion_box">
	</div>
	<br />
	<div class="filterh">More Options</div>
	<div class="filterb"><a href = "/manufacture" style="font-size:13px;text-decoration:none;">All Manufacturers</a></div>
	
