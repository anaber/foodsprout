<script src="<?php echo base_url()?>js/my_dashboard.js" type="text/javascript"></script>
<script>
	
	var restaurantId = <?php echo $RESTAURANT->restaurantId; ?>;
	var name = "<?php echo $RESTAURANT->restaurantName; ?>";
	var jsonData;
	var currentContent;
	
	var toggleDuration = 1000;
	var isSupplierFormVisible = false;
	var isMenuFormVisible = false;
	var isCommentFormVisible = false;
	
	$(document).ready(function() {
		$('#bottomPaging').hide();
		
		$.post("/restaurant/ajaxSearchRestaurantSuppliers", { q: restaurantId },
		function(data){
			currentContent = 'supplier';
			jsonData = data;
			redrawContent(data, 'supplier');
			reinitializeTabs();
		},
		"json");
		
		$.post("/restaurant/ajaxSearchRestaurantInfo", { restaurantId:"<?php echo (isset($RESTAURANT) ? $RESTAURANT->restaurantId : '' ) ?>" },
		function(data){
			if (data.geocode != '') {
				//reinitializeMap(data, 13);
			}
		},
		"json");	
	});
		
	
</script>

<div id="alert"></div>
<!-- center tabs -->
	<div id="resultsContainer" style = "border-style:solid;border-width:0px;border-color:#FF0000;">
		<div id="menu-bar"> 
			<div id="suppliers" class = "selected"><a href="#">My Suppliers</a></div>
			<div id="menu" class = "non-selected"><a href="#">My Menu</a></div>
			<div id="comments" class = "non-selected"><a href="#">My Comments</a></div>
			<div id="restaurants" class = "non-selected"><a href="#">My Restaurants</a></div>
			<div id="farms" class = "non-selected"><a href="#">My Farms</a></div>
		</div>
		
		<div style="overflow:auto; padding:5px;">
			<div style="float:left; width:110px; font-size:10px;" id = 'numRecords'>Records 0-0 of 0</div>
			
			<div style="float:left; width:225px; font-size:10px;" id = 'pagingLinks' align = "center">
				<a href="#" id = "imgFirst">First</a> &nbsp;&nbsp;
				<a href="#" id = "imgPrevious">Previous</a>
				&nbsp;&nbsp;&nbsp; Page 1 of 1 &nbsp;&nbsp;&nbsp;
				<a href="#" id = "imgNext">Next</a> &nbsp;&nbsp;
				<a href="#" id = "imgLast">Last</a>
			</div>
			
			<div style="float:right; width:185px; font-size:10px;" id = 'recordsPerPage' align = "right">
				Items per page:&nbsp;
				<a href="#" id = "10PerPage">10</a> | 
				<a href="#" id = "20PerPage">20</a> |  
				<a href="#" id = "40PerPage">40</a> |  
				<a href="#" id = "50PerPage">50</a> 
			</div>
			
			<div class="clear"></div>
		</div>
		
		<div id="resultTableContainer" class="menus"></div>
		<?php
			/*
		?>
		<div style="overflow:auto; padding:5px;" id = "bottomPaging">
			<div style="float:left; width:110px; font-size:10px;" id = 'numRecords2'></div>
			<div style="float:left; width:225px; font-size:10px;" id = 'pagingLinks2' align = "center"></div>
			<div style="float:right; width:185px; font-size:10px;" id = 'recordsPerPage2' align = "right"></div>
			<div class="clear"></div>
		</div>
		<?php
			*/
		?>
	</div>
<!-- end center tabs -->