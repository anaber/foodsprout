<?php
	$isAuthenticated = $this->session->userdata('isAuthenticated');
	$userGroup = $this->session->userdata('userGroup');
	$userId = $this->session->userdata('userId');

	$module = $this->uri->segment(1);
	$producer = $this->uri->segment(2);
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
		
		/**
		 * If users try to load url with HASH segment from address bar
		 */
		if(window.location.hash) {
			
			str = window.location.hash;
			str = str.substr(2);
			arr = str.split('&');
			postArray = {};
			var tab = p = pp = sort = order = q = f = city = '';		
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
				
				if (arr2[0] == 'tab') {
					tab = arr2[1];
				} else if (arr2[0] == 'p') {
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
				} else if (arr2[0] == 'city') {
					city = arr2[1];
				} 
			}
			
			if (tab == 'supplier') {
				$.post("/chain/ajaxSearchRestaurantChainSuppliers", { q: restaurantChainId },
		
				function(data){
					currentContent = 'supplier';
					jsonData = data;
					redrawContent(data, 'supplier');
					reinitializeTabs();
					reinitializeMap(map, data, 8, true);
				},
				"json");
			} else if (tab == 'menu') {
				$.post("/chain/ajaxSearchRestaurantChainMenus", { q: restaurantChainId },
		
				function(data){
					currentContent = 'menu';
					jsonData = data;
					redrawContent(data, 'menu');
					reinitializeTabs();
				},
				"json");
			} else if (tab == 'comment') {
				$.post("/chain/ajaxSearchRestaurantChainComments", { q: restaurantChainId },
		
				function(data){
					currentContent = 'comment';
					jsonData = data;
					redrawContent(data, 'comment');
					reinitializeTabs();
				},
				"json");
			} else if (tab == 'photo') {
				$.post("/chain/ajaxSearchRestaurantChainPhotos", { q: restaurantChainId },
		
				function(data){
					currentContent = 'photo';
					jsonData = data;
					redrawContent(data, 'photo');
					reinitializeTabs();
				},
				"json");
			}
			
		} else {
			$.post("/chain/ajaxSearchRestaurantChainSuppliers", { q: restaurantChainId },
			function(data){
				currentContent = 'supplier';
				jsonData = data;
				redrawContent(data, 'supplier');
				reinitializeTabs();
			},
			"json");
		}
		
	});
	
</script>
<div id="alert"></div>
<div style = "float:left;padding:0px;">
<!-- center tabs -->
	<div id="resultsContainer">
		<div id="menu-bar"> 
			<div id="suppliers" class = "non-selected"><a href = "<?php echo $module . '/' . $producer;?>?tab=supplier" id = "linkSupplier">Suppliers</a></div>
			<div id="menu" class = "non-selected"><a href = "<?php echo $module . '/' . $producer;?>?tab=menu" id = "linkMenu">Menu</a></div>
			<div id="comments" class = "non-selected"><a href = "<?php echo $module . '/' . $producer;?>?tab=comment" id = "linkComment">Comments</a></div>
			<div id="photos" class = "non-selected"><a href = "<?php echo $module . '/' . $producer;?>?tab=photo" id = "linkPhoto">Photos</a></div>
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
		
		<div style="overflow:auto; padding:5px; font-size:10px;" id = "pagingDiv">
			<?php
				if (isset($PAGING_HTML) ) {
					echo $PAGING_HTML;
				} else {
			?>
			<div style="float:left; width:150px;" id = 'numRecords'>Records 0-0 of 0</div>
			
			<div style="float:left; width:250px;" id = 'pagingLinks' align = "center">
				<a href="#" id = "imgFirst">First</a> &nbsp;&nbsp;
				<a href="#" id = "imgPrevious">Previous</a>
				&nbsp;&nbsp;&nbsp; Page 1 of 1 &nbsp;&nbsp;&nbsp;
				<a href="#" id = "imgNext">Next</a> &nbsp;&nbsp;
				<a href="#" id = "imgLast">Last</a>
			</div>
			
			<div style="float:left; width:175px;" id = 'recordsPerPage' align = "right">
				Items per page:&nbsp;
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
		
		<div id="resultTableContainer" class="menus" style = "width:590px; padding:0px;">
		<?php
			if ($LIST_DATA) {
				echo $LIST_DATA;
			}
		?>
		</div>
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