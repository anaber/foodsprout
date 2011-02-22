<?php
	$uri = $this->uri->uri_string();
?>
<script src="<?php echo base_url()?>js/search/restaurant_search.js" type="text/javascript"></script>
<script>
var showMap = true;
var showFilters = true;
var topCuisines;
var topRestaurantTypes;

var param = <?php echo $PARAMS; ?>;
var geocode = <?php echo $GEOCODE; ?>;
var uri = '<?php echo $uri; ?>';

//var param = {"page":0,"totalPages":2,"perPage":20,"start":1,"end":20,"firstPage":0,"lastPage":1,"numResults":"36","sort":"claims_sustainable DESC, producer","order":"ASC","q":"98004","filter":"r_13,r_22","city":false,"zoomLevel":13};

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
		loadPopupFadeIn();
		
		//$.post("/restaurant/ajaxSearchRestaurants", { city:"<?php echo (isset($CITY) ? $CITY->cityId : '' ) ?>", q:"<?php echo (isset($q) ? $q : '' ) ?>", p: "0", f:"<?php echo (isset($f) ? $f : '' ) ?>" },
		//function(data){
		
			var data = '';
			
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
					
					
					/**
					 * If users try to load url with HASH segment from address bar
					 */
					if(window.location.hash) {
						loadPopupFadeIn();
						str = window.location.hash;
						str = str.substr(2);
						arr = str.split('&');
						postArray = {};
						var p = pp = sort = order = q = f = city = '';		
						for(i = 0; i < arr.length; i++) {
							queryString = arr[i];
							arr2 = queryString.split('=');
							var key = ''; 
							var value = '';
							if (arr2[0]) {
								key = arr2[0];
							}				
							if (arr2[1]) {
								value = arr2[0];
							}
							
							//alert(key + " : " + value);
							//alert(arr2[0] + " : " + arr2[1]);
							
							if (arr2[0] == 'p') {
								p = arr2[1];
							} else if (arr2[0] == 'pp') {
								pp = arr2[1];
							}  else if (arr2[0] == 'sort') {
								sort = arr2[1];
							}  else if (arr2[0] == 'order') {
								order = arr2[1];
							}  else if (arr2[0] == 'f') {
								f = arr2[1];
							}  else if (arr2[0] == 'q') {
								q = arr2[1];
							}  else if (arr2[0] == 'city') {
								city = arr2[1];
							} 
						}
						//disableFadein = true;
						postAndRedrawContent(p, pp, sort, order, q, f, city);
					}
					
					
				},
				"json");
				
			},
			"json");
			
		
		//},
		//"json");
		
	
		
		
		
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
			if ($LIST_DATA) {
				echo $LIST_DATA;
			}
		?>
		</div>
		<div class = "clear"></div>
	</div>
	<div class = "clear"></div>
	
	<div style="overflow:auto; padding:5px; font-size:10px;" id = "pagingDiv">
		
		<?php
			if (isset($PAGING_HTML) ) {
				echo $PAGING_HTML;
			} else {
		?>
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
		<?php
			}
		?>
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