<link href="<?php echo base_url()?>css/floating_messages.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url()?>js/info/restaurant_chain_info.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>js/floating_messages.js" type="text/javascript"></script>

<link href="<?php echo base_url()?>css/supplier.css" rel="stylesheet" type="text/css" />

<script>
	
	var restaurantChainId = <?php echo $RESTAURANT_CHAIN->restaurantChainId; ?>;
	var name = "<?php echo $RESTAURANT_CHAIN->restaurantChain; ?>";
	var jsonData;
	var currentContent;
	
	var toggleDuration = 1000;
	var isSupplierFormVisible = false;
	var isMenuFormVisible = false;
	var isCommentFormVisible = false;
	
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
<div id="alert"></div>
<!-- center tabs -->
	<div id="resultsContainer">
		<div id="menu-bar"> 
			<div id="suppliers" class = "selected"><a href="#">Suppliers</a></div>
			<div id="menu" class = "non-selected"><a href="#">Menu</a></div>
			<div id="comments" class = "non-selected"  style = "display:none;"><a href="#">Comments</a></div>
			<div id="addItem" class = "addItem">&nbsp;+ Supplier</div>
			
			<div id="divAddSupplier" class="supplier">
				<?php
					$data = array(
							'SUPPLIER_TYPES_2' => $SUPPLIER_TYPES_2, 
							'TABLE' => $TABLE,
							'RESTAURANT_CHAIN_ID' => $RESTAURANT_CHAIN->restaurantChainId
							);
					$this->load->view('includes/supplier_form', $data );
				?>
			</div>
			
			<div id="divAddMenu" class="supplier">
				<?php
					$data = array(
							'PRODUCT_TYPES' => $PRODUCT_TYPES, 
							'RESTAURANT_CHAIN_ID' => $RESTAURANT_CHAIN->restaurantChainId
							);
					$this->load->view('includes/menu_form', $data );
				?>
			</div>
			
		</div>
		
		<div id="divAddComment" style = "display:none;">Comment form will come here</div>
		
		<div style="overflow:auto; padding:5px;"></div>
		
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
		
		<div style="overflow:auto; padding:5px;" id = "bottomPaging">
			<div style="float:left; width:110px; font-size:10px;" id = 'numRecords2'></div>
			<div style="float:left; width:225px; font-size:10px;" id = 'pagingLinks2' align = "center"></div>
			<div style="float:right; width:185px; font-size:10px;" id = 'recordsPerPage2' align = "right"></div>
			<div class="clear"></div>
		</div>
		
	</div>
<!-- end center tabs -->
