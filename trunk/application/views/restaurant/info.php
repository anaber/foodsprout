<?php
	$isAuthenticated = $this->session->userdata('isAuthenticated');
	$userGroup = $this->session->userdata('userGroup');
	$userId = $this->session->userdata('userId');
?>
<script src="<?php echo base_url()?>js/popup.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>js/info/restaurant_info.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>js/jquery.maxlength.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>js/info/common.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>js/floating_messages.js" type="text/javascript"></script>

<script type="text/javascript" src="<?php echo base_url()?>js/uploadify/swfobject.js"></script> 
<script type="text/javascript" src="<?php echo base_url()?>js/uploadify/jquery.uploadify.v2.1.0.js"></script>

<script src="<?php echo base_url()?>js/jquery.lightbox-0.5.js" type="text/javascript"></script>

<script>
	var restaurantId = <?php echo $RESTAURANT->restaurantId; ?>;
	var addressId = <?php echo $ADDRESS_ID; ?>;
	var name = "<?php echo $RESTAURANT->restaurantName; ?>";
	var userGroup = "<?php echo $userGroup; ?>";
	var userId = "<?php echo $userId; ?>";
	
	var jsonData;
	var currentContent;
	
	var toggleDuration = 1000;
	
	var isAuthenticated = <?php echo ($isAuthenticated ? "true" : "false") ?>;
	var isLoginMessageVisible = false;
	
	$(document).ready(function() {
		
		loadMapOnStartUp(38.41055825094609, -98, 3);
		
		$('#bottomPaging').hide();
		
		$.post("/restaurant/ajaxSearchRestaurantSuppliers", { q: restaurantId, addressId:addressId },
		
		function(data){
			currentContent = 'supplier';
			jsonData = data;
			redrawContent(data, 'supplier');
			reinitializeTabs();
			reinitializeMap(map, data, 8, true);
		},
		"json");
		
		
		loadSmallMapOnStartUp(38.41055825094609, -98, 3);
		
		$.post("/restaurant/ajaxSearchRestaurantInfo", { restaurantId:"<?php echo (isset($RESTAURANT) ? $RESTAURANT->restaurantId : ''); ?>", addressId:"<?php echo (isset($ADDRESS_ID) ? $ADDRESS_ID : '' ); ?>" },
		function(data){
			if (data.geocode != '') {
				reinitializeMap(map2, data, 13);
			}
		},
		"json");
		
		
		$('#divAddresses a').click(function(e) {
			record_id = $(this).attr('id');
			
			if (record_id != '') {
				if (isNaN(record_id) ) {
					e.preventDefault();
					var arr = record_id.split('_');
					record_id = arr[1];
					
					viewMarker(map2, record_id, 0);
					//$('html, body').animate({scrollTop:2000}, 'slow');
					$('html, body').scrollTop(2000);
				}
			}
		});
		
		
		/*
		$(document).click( function(event) {
			var clicked = $(this); // jQuery wrapper for clicked element
			elementId = $(clicked).attr('id');
			//alert(elementId);
			if (elementId == 'addItem' || elementId == 'divAddSupplier') {
				
			} else {
				$("#addSupplier").removeClass('active');
				$('#divAddSupplier').stop(true, false).fadeOut(200);
				isSupplierFormVisible = false;
			}
			
			if (elementId == 'addItem' || elementId == 'divAddMenu') {
				
			} else {
				$("#addMenu").removeClass('active');
				$('#divAddMenu').stop(true, false).fadeOut(200);
				isMenuFormVisible = false;
			}
			
		});
		*/
		
		/*
		$(document).click(function(event) { 
			var target = $(event.target);
			if( target.parents("#login-form").length == 0 ){
				
				$("#addSupplier").removeClass('active');
				$('#divAddComment').stop(true, false).fadeOut(200);
				
				$("#addMenu").removeClass('active');
				$('#divAddMenu').stop(true, false).fadeOut(200);
			}
		});
		*/
		
	});
		
	function loadSmallMapOnStartUp(lat, lng, zoom) {
		var myLatlng = new google.maps.LatLng(lat, lng);
	    var myOptions = {
	      zoom: zoom,
	      center: myLatlng,
	      disableDefaultUI: true,
	      navigationControl: false,
	      scrollwheel: false,
	      draggable: false,
	      mapTypeId: google.maps.MapTypeId.ROADMAP
	    }
	    map2 = new google.maps.Map(document.getElementById("small_map_canvas"), myOptions);
	}
	
	function getMarkerHtml(o) {
		html = "<font size = '2'><b><i>" + o.supplierName + "</i></b></font><br /><font size = '1'>" +
			  o.addressLine1 + ", " + o.addressLine2 + "<br />" + 
			  o.addressLine3 + "</font><br />"
			  ;
		return html;
	}
	
	function getMarkerHtml2(o) {
		html = "<font size = '2'><b><i>" + o.restaurantName + "</i></b></font><br /><font size = '1'>" +
			  o.addressLine1 + ", " + o.addressLine2 + "<br />" + 
			  o.addressLine3 + "</font><br />"
			  ;
		return html;
	}
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
			<div class = "clear"></div>
			
			<div id="divAddSupplier" class="supplier">
				<?php
					$data = array(
							'SUPPLIER_TYPES_2' => $SUPPLIER_TYPES_2, 
							'TABLE' => $TABLE,
							'RESTAURANT_ID' => $RESTAURANT->restaurantId
							);
					$this->load->view('includes/supplier_form', $data );
				?>
				<div class = "clear"></div>
			</div>
			
			<div id="divAddMenu" class="supplier">
				<?php
					$data = array(
							'PRODUCT_TYPES' => $PRODUCT_TYPES, 
							'RESTAURANT_ID' => $RESTAURANT->restaurantId
							);
					$this->load->view('includes/menu_form', $data );
				?>
				<div class = "clear"></div>
			</div>
			
			<div id="divAddComment" class="supplier">
				<?php
					$data = array(
							'SUPPLIER_TYPES_2' => $SUPPLIER_TYPES_2, 
							'TABLE' => $TABLE,
							'RESTAURANT_ID' => $RESTAURANT->restaurantId
							);
					$this->load->view('includes/comment_form', $data );
				?>
				<div class = "clear"></div>
			</div>
			
			<div id="divAddPhoto" class="supplier">
				<?php
					$this->load->view('includes/login_message');
					echo "<br />ADD PHOTO here";
				?>
				<div class = "clear"></div>
			</div>
			
			<div id="divLoginMessage" class="supplier">
				<?php
					$this->load->view('includes/login_message');
				?>
				<div class = "clear"></div>
			</div>
			
		</div>
		
		<div id = "supplyChartMap">
			<?php
				$param = array(
								'width' => 590, 
								'height' => 250,
								'type' => 'supplier',
							);
				$this->load->view('includes/map', $param);
			?>
			<div class = "clear"></div>
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



