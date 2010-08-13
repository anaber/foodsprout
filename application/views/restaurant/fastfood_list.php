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


<div id="resultsContainer" style="display:none;" class="pd_tp1">
	<div id="resultTableContainer"></div>
</div>

<div style="overflow:auto; padding:5px;" align="left">
	
	<div style="width:690px; padding:10px; font-size:10px; border-color:#FF0000; border-width:1px; border-style:solid;" id = 'pagingLinks' align = "center">
		<b>Page</b> &nbsp;&nbsp;
		<a href="#" id = "1">1</a>
	</div>
	
	<div class="clear"></div>
</div>
<!--
<div id="popupProcessing"> 
	<img src = "/img/icon_processing.gif">
</div> 

<div id="backgroundPopup"></div>
-->  