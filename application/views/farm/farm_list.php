<script src="<?php echo base_url()?>js/search/farm_search.js" type="text/javascript"></script>
<script>
var showMap = true;
var showFilters = true;
//var topCuisines;
var topFarmTypes;
var farmsData;

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
		
		//$('#messageContainer').addClass('center').html('<img src="/img/loading_pink_bar.gif" />');
		//loadPopupFadeIn();
		
		$.post("/farm/ajaxSearchFarms", { q:"<?php echo (isset($q) ? $q : '' ) ?>", p: "0", f:"<?php echo (isset($f) ? $f : '' ) ?>" },
		function(data){
			
			if (showMap ==  true) {
				loadMapOnStartUp(38.41055825094609, -98, 3);
			}
			//currentZoomLevel = defaultZoomLevel;
			
			var formAction = '/farm/ajaxGetAllFarmType';
			postArray = { c:10 };
			
			$.post(formAction, postArray,function(farmTypes) {
				topFarmTypes = farmTypes;
				farmsData = data;
				redrawContent(data, '');
				
				reinitializeRadiusSearch();

			},
			"json");
			
		},
		"json");
		
	});
	
</script>

<div style = "float:left;padding:0px;">
	
	<div>
		<div style="float:left;width:530px;"><h1>List of Farms</h1></div>
		<div style="float:left; text-align:right; margin-right:5px;" id="divHideMap"><a href = "#" id = "linkHideMap" style="font-size:13px;text-decoration:none;">Show/Hide Map</a></div>
		<div class="clear"></div>
	</div>
	<div class = "clear"></div>
	
	<div id="resultsContainer" class="pd_tp1">
		<div id="resultTableContainer" style = "width:630px; padding:0px;">
		<?php
			//echo $LIST_DATA;
		?>
		</div>
		<div class = "clear"></div>
	</div>
	<div class = "clear"></div>
	
	<div style="overflow:auto; padding:5px; font-size:10px;">
	
		<div style="float:left; width:172px;" id = 'numRecords'>Records 0-0 of 0</div>
		
		<div style="float:left; width:250px;" id = 'pagingLinks' align = "center">
			<a href="#" id = "imgFirst">First</a> &nbsp;&nbsp;
			<a href="#" id = "imgPrevious">Previous</a>
			&nbsp;&nbsp;&nbsp; Page 1 of 1 &nbsp;&nbsp;&nbsp;
			<a href="#" id = "imgNext">Next</a> &nbsp;&nbsp;
			<a href="#" id = "imgLast">Last</a>
		</div>
		
		<div style="float:left; width:195px;" id = 'recordsPerPage' align = "right">
			Items per page:
			<a href="#" id = "10PerPage">10</a> | 
			<a href="#" id = "20PerPage">20</a> | 
			<a href="#" id = "40PerPage">40</a> | 
			<a href="#" id = "50PerPage">50</a>
		</div>
		
		<div class="clear"></div>
	</div>
	<div class = "clear"></div>
</div>
<div style="float:right; width:160px;">
	<?php
			$this->load->view('includes/banners/sky');
	?>
	<div class = "clear"></div>
</div>
<div class = "clear"></div>




<!--<h2 class="blue_text first" id="messageContainer" align = "center">Your search results are loading, please wait.</h2>-->

