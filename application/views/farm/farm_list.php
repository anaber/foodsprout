<script src="<?php echo base_url()?>js/farm_search.js" type="text/javascript"></script>
<script>
var showMap = true;
var showFilters = true;
//var topCuisines;
var topFarmTypes;

<?php
	
	if ($hide_map == 'yes') {
?>
	showMap = false;
<?php
	}
	
	if ($hide_filters == 'yes') {
?>
	showFilters = false;
<?php
	}
?>
	
	$(document).ready(function() {
		
		//$('#messageContainer').addClass('center').html('<img src="/images/loading_pink_bar.gif" />');
		loadPopupFadeIn();
		
		$.post("/farm/ajaxSearchFarms", { q:"<?php echo (isset($q) ? $q : '' ) ?>", p: "0", f:"<?php echo (isset($f) ? $f : '' ) ?>" },
		function(data){
			
			if (showMap ==  true) {
				loadMapOnStartUp(38.41055825094609, -98, 3);
			}
			//currentZoomLevel = defaultZoomLevel;
			
			//var formAction = '/farm/ajaxGetDistinctUsedFarmType';
			var formAction = '/farm/ajaxGetAllFarmType';
			postArray = { c:10 };
			
			$.post(formAction, postArray,function(farmTypes) {
				topFarmTypes = farmTypes;
				
				redrawContent(data, '');
				
			},
			"json");
			
		},
		"json");
	});
	
</script>

<div id="resultsContainer" style="display:none" class="pd_tp1">
	<div id="resultTableContainer"></div>
</div>

<!--<h2 class="blue_text first" id="messageContainer" align = "center">Your search results are loading, please wait.</h2>-->

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

<div id="popupProcessing"> 
	<img src = "/images/icon_processing.gif">
</div> 