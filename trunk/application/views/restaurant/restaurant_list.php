<script src="<?php echo base_url()?>js/search/restaurant_search.js" type="text/javascript"></script>
<script>
var showMap = true;
var showFilters = true;
var topCuisines;
var topRestaurantTypes;

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
		/*
		//$('#messageContainer').addClass('center').html('<img src="/img/loading_pink_bar.gif" />');
		loadPopupFadeIn();
		
		$.post("/restaurant/ajaxSearchRestaurants", { city:"<?php echo (isset($CITY) ? $CITY->cityId : '' ) ?>", q:"<?php echo (isset($q) ? $q : '' ) ?>", p: "0", f:"<?php echo (isset($f) ? $f : '' ) ?>" },
		function(data){
		
			
			if (showMap ==  true) {
				loadMapOnStartUp(38.41055825094609, -98, 3);
			}
			//currentZoomLevel = defaultZoomLevel;
			
			var formAction = '/restaurant/ajaxGetDistinctUsedRestaurantType';
			postArray = { c:10 };
			
			$.post(formAction, postArray,function(restaurantTypes) {
				topRestaurantTypes = restaurantTypes;
				
				var formAction = '/restaurant/ajaxGetDistinctUsedCuisine';
				postArray = { c:10 };
				
				$.post(formAction, postArray,function(cuisines) {		
					topCuisines = cuisines;
					redrawContent(data, '');
				},
				"json");
				
			},
			"json");
			
		
		},
		"json");
		*/
	});
	
</script>

<div style = "float:left;padding:0px;">
	
	<div>
		<div style="float:left;width:530px;"><h1><?php echo ( isset($CITY) ? 'Sustainable Restaurants in ' . $CITY->city : 'List of Restaurants' ) ?></h1></div>
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


<div id="popupProcessing"> 
	<img src = "/img/icon_processing.gif">
</div> 