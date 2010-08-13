<script src="<?php echo base_url()?>js/farmers_market_search.js" type="text/javascript"></script>
<script>
var showMap = true;

<?php
	
	if ($hide_map == 'yes') {
?>
	showMap = false;
<?php
	}
	
?>
	
	$(document).ready(function() {
		
		//loadPopupFadeIn();
		
		$.post("/farmersmarket/ajaxSearchFarmersMarket", { q:"<?php echo (isset($q) ? $q : '' ) ?>", p: "0", f:"<?php echo (isset($f) ? $f : '' ) ?>" },
		function(data){
			
			if (showMap ==  true) {
				loadMapOnStartUp(38.41055825094609, -98, 3);
			}
			redrawContent(data);
		},
		"json");
	});
	
</script>

<div style="float:right; width:160px;">
	<?php
		$this->load->view('includes/banners/sky');
	?>
</div>
<div id="resultsContainer" style="display:none" class="pd_tp1">
	<div style="float:left;width:300px;"><h1>Farmers Markets</h1></div><div style="float:right; width:200px; text-align:right; font-size:12px; margin-right:30px;" id="divHideMap"><a href="#" id="linkHideMap">Show/Hide Map</a></div>
	<div id="resultTableContainer"></div>
</div>

<!--<h2 class="blue_text first" id="messageContainer" align = "center">Your search results are loading, please wait.</h2>-->
<br/><br/>

<div style="overflow:auto; padding:5px;">
	
	<div style="float:left; width:170px; font-size:10px;" id = 'numRecords'>Records 0-0 of 0</div>
	
	<div style="float:left; width:400px; font-size:10px;" id = 'pagingLinks' align = "center">
		<a href="#" id = "imgFirst">First</a> &nbsp;&nbsp;
		<a href="#" id = "imgPrevious">Previous</a>
		&nbsp;&nbsp;&nbsp; Page 1 of 1 &nbsp;&nbsp;&nbsp;
		<a href="#" id = "imgNext">Next</a> &nbsp;&nbsp;
		<a href="#" id = "imgLast">Last</a>
	</div>
	
	<div style="float:right; width:210px; font-size:10px;" id = 'recordsPerPage' align = "right">
		Items per page:
		<div id = "50PerPage" style="float:right; width:20px;">50</div>
		<div id = "40PerPage" style="float:right; width:30px;">40 | </div>  
		<div id = "20PerPage" style="float:right; width:30px;">20 | </div>
		<div id = "10PerPage" style="float:right; width:30px;">10 | </div>
	</div>
	
	<div class="clear"></div>
</div> 