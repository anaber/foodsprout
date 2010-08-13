<script src="<?php echo base_url()?>js/restaurant_chain_search.js" type="text/javascript"></script>
<!--<script src="<?php echo base_url()?>js/popup.js" type="text/javascript"></script>-->
<script>
	$(document).ready(function() {
		//loadPopupFadeIn();
		
		$.post("/chain/ajaxSearchRestaurantChains", { },
		function(data){
			redrawContent(data);
		},
		"json");
	});
</script>
<h1>Restaurant Chains</h1>
<div style="float:right; width:160px;">
	<?php
		$this->load->view('includes/banners/sky');
	?>
</div>

<div id="resultsContainer" style="display:none" class="pd_tp1">
	<div id="resultTableContainer"></div>
</div>

<div style="overflow:auto; padding:5px;">
	
	<div style="float:left; width:400px; font-size:10px;" id = 'pagingLinks' align = "center">
		<a href="#" id = "imgFirst">First</a> &nbsp;&nbsp;
		<a href="#" id = "imgPrevious">Previous</a>
		&nbsp;&nbsp;&nbsp; Page 1 of 1 &nbsp;&nbsp;&nbsp;
		<a href="#" id = "imgNext">Next</a> &nbsp;&nbsp;
		<a href="#" id = "imgLast">Last</a>
	</div>

	<div class="clear"></div>
</div>