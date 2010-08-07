<script src="<?php echo base_url()?>js/restaurant_chain_info.js" type="text/javascript"></script>
<script>
	
	var restaurantChainId = <?php echo $RESTAURANT_CHAIN->restaurantChainId; ?>;
	var jsonData;
	var currentContent;
	
	$(document).ready(function() {
		$('#bottomPaging').hide();
		
		$.post("/chain/ajaxSearchRestaurantChainSuppliers", { q: restaurantChainId },
		function(data){
			currentContent = 'supplier';
			jsonData = data;
			redrawContent(data, 'supplier');
			reinitializeTabs();
		},
		"json");
		
	});
	
</script>

<!-- center tabs -->
	<div id="resultsContainer">
		<div id="menu-bar"> 
			<div id="suppliers" class = "selected"><a href="#">Suppliers</a></div>
			<div id="menu" class = "non-selected"><a href="#">Menu</a></div>
			<?php /*?><div id="comments" class = "non-selected"><a href="#">Comments</a></div><?php */ ?>
			<div id="addItem" class = "add-item"><a href="/chain/add_supplier/<?php echo $RESTAURANT_CHAIN->restaurantChainId; ?>">+ Add Supplier</a></div>
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
				Items per page:
				<div id = "50PerPage" style="float:right; width:20px;">50</div>
				<div id = "40PerPage" style="float:right; width:30px;">40 | </div>  
				<div id = "20PerPage" style="float:right; width:30px;">20 | </div>
				<div id = "10PerPage" style="float:right; width:30px;">10 | </div>
			</div>
			
			<div class="clear"></div>
		</div>
		
		<div id="resultTableContainer" class="menus"></div>
		
		<div style="overflow:auto; padding:5px;" id = "bottomPaging">
			<div style="float:left; width:110px; font-size:10px;" id = 'numRecords2'></div>
			<div style="float:left; width:225px; font-size:10px;" id = 'pagingLinks2' align = "center"></div>
			<div style="float:right; width:185px; font-size:10px;" id = 'recordsPerPage2' align = "right"></div>
			<div class="clear"></div>
		</div>
		
	</div>
<!-- end center tabs -->
