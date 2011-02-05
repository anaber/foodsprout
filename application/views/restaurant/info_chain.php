<?php
	$isAuthenticated = $this->session->userdata('isAuthenticated');
	$userGroup = $this->session->userdata('userGroup');
	$userId = $this->session->userdata('userId');
?>
<script src="<?php echo base_url()?>js/popup.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>js/info/restaurant_chain_info.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>js/jquery.maxlength.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>js/info/common.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>js/floating_messages.js" type="text/javascript"></script>

<script type="text/javascript" src="<?php echo base_url()?>js/uploadify/swfobject.js"></script> 
<script type="text/javascript" src="<?php echo base_url()?>js/uploadify/jquery.uploadify.v2.1.0.js"></script>

<script src="<?php echo base_url()?>js/jquery.lightbox-0.5.js" type="text/javascript"></script>

<script>
	
	var restaurantChainId = <?php echo $RESTAURANT_CHAIN->restaurantChainId; ?>;
	var name = "<?php echo $RESTAURANT_CHAIN->restaurantChain; ?>";
	var userGroup = "<?php echo $userGroup; ?>";
	var userId = "<?php echo $userId; ?>";
	
	var jsonData;
	var currentContent;
	
	var toggleDuration = 1000;
	
	
	var isAuthenticated = <?php echo ($isAuthenticated ? "true" : "false") ?>;
	var isLoginMessageVisible = false;
	
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
<div style = "float:left;padding:0px;">
<!-- center tabs -->
	<div id="resultsContainer">
		<div id="menu-bar"> 
			<div id="suppliers" class = "selected">Suppliers</div>
			<div id="menu" class = "non-selected">Menu</div>
			<div id="comments" class = "non-selected">Comments</div>
			<div id="photos" class = "non-selected">Photos</div>
			<div id="addItem" class = "addItem">&nbsp;+ Supplier</div>
			<div class="clear"></div>
			
			<div id="divAddSupplier" class="supplier">
				<?php
					$data = array(
							'SUPPLIER_TYPES_2' => $SUPPLIER_TYPES_2, 
							'TABLE' => $TABLE,
							'RESTAURANT_CHAIN_ID' => $RESTAURANT_CHAIN->restaurantChainId
							);
					$this->load->view('includes/supplier_form', $data );
				?>
				<div class="clear"></div>
			</div>
			
			<div id="divAddMenu" class="supplier">
				<?php
					$data = array(
							'PRODUCT_TYPES' => $PRODUCT_TYPES, 
							'RESTAURANT_CHAIN_ID' => $RESTAURANT_CHAIN->restaurantChainId
							);
					$this->load->view('includes/menu_form', $data );
				?>
				<div class="clear"></div>
			</div>
			
			<div id="divLoginMessage" class="supplier">
				<?php
					$this->load->view('includes/login_message');
				?>
			</div>
			<div class="clear"></div>
		</div>
		
		<div class="clear"></div>
		<div style="overflow:auto;height:5px;"></div>
		<div class="clear"></div>
		
		<div style="overflow:auto; padding:5px; font-size:10px;" class = "border-green-0">
			<div style="float:left; width:150px;" id = 'numRecords' class = "border-red-0">Records 0-0 of 0</div>
			
			<div style="float:left; width:250px;" id = 'pagingLinks' align = "center" class = "border-red-0">
				<a href="#" id = "imgFirst">First</a> &nbsp;&nbsp;
				<a href="#" id = "imgPrevious">Previous</a>
				&nbsp;&nbsp;&nbsp; Page 1 of 1 &nbsp;&nbsp;&nbsp;
				<a href="#" id = "imgNext">Next</a> &nbsp;&nbsp;
				<a href="#" id = "imgLast">Last</a>
			</div>
			
			<div style="float:left; width:175px;" id = 'recordsPerPage' align = "right" class = "border-red-0">
				Items per page:&nbsp;
				<a href="#" id = "10PerPage">10</a> | 
				<a href="#" id = "20PerPage">20</a> |  
				<a href="#" id = "40PerPage">40</a> |  
				<a href="#" id = "50PerPage">50</a> 
			</div>
			
			<div class="clear"></div>
		</div>
		<div class = "clear"></div>
		
		<div id="resultTableContainer" class="menus" style = "width:590px; padding:0px;"></div>
		<div class = "clear"></div>
		
		<div style="overflow:auto; padding:5px; font-size:10px;" id = "bottomPaging">
			<div style="float:left; width:150px;" id = 'numRecords2'></div>
			<div style="float:left; width:250px;" id = 'pagingLinks2' align = "center"></div>
			<div style="float:left; width:175px;" id = 'recordsPerPage2' align = "right"></div>
			<div class="clear"></div>
		</div>
		<div class = "clear"></div>
		
	</div>
	<div class = "clear"></div>
<!-- end center tabs -->
</div>
<div style="float:right; width:160px;">
	<?php
			$this->load->view('includes/banners/sky');
	?>
	<div class = "clear"></div>
</div>
<div class = "clear"></div>