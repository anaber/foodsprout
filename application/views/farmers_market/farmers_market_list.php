<?php
	$uri = $this->uri->uri_string();
?>
<script src="<?php echo base_url()?>js/search/farmers_market_search.js" type="text/javascript"></script>
<script>
var showMap = true;

var farmersMarketData;

var param = <?php echo $PARAMS; ?>;
var geocode = <?php echo $GEOCODE; ?>;
var uri = '<?php echo $uri; ?>';

<?php
	
	if ($hide_map == 'yes') {
?>
	showMap = false;
<?php
	}
	
?>
	
	$(document).ready(function() {
		
		if (showMap ==  true) {
			loadMapOnStartUp(38.41055825094609, -98, 3);
		}
			
		var data = '';
		farmersMarketData = data;
		redrawContent(data, '');
		reinitializeRadiusSearch();
		
		/**
		 * If users try to load url with HASH segment from address bar
		 */
		if(window.location.hash) {
			str = window.location.hash;
			str = str.substr(2);
			arr = str.split('&');
			postArray = {};
			
			var p = pp = sort = order = q = f = r = '';		
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
				
				if (arr2[0] == 'p') {
					p = arr2[1];
				} else if (arr2[0] == 'pp') {
					pp = arr2[1];
				} else if (arr2[0] == 'sort') {
					sort = arr2[1];
				} else if (arr2[0] == 'order') {
					order = arr2[1];
				} else if (arr2[0] == 'f') {
					f = arr2[1];
				} else if (arr2[0] == 'q') {
					q = arr2[1];
				} else if (arr2[0] == 'r') {
					r = arr2[1];
				} else if (arr2[0] == 'city') {
					city = arr2[1];
				}  
			}
			postAndRedrawContent(p, pp, sort, order, q, f, r, city);
		}
	});
	
</script>

<div style = "float:left;padding:0px;">
	
	<div>
		<div style="float:left;width:530px;"><h1><?php echo ( isset($CITY) ? $CITY->city .' Farmers Markets' : 'Farmers Markets' ) ?></h1></div>
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
