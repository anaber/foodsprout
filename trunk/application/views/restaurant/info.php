<?php
	$isAuthenticated = $this->session->userdata('isAuthenticated');
?>
<script src="<?php echo base_url()?>js/popup.js" type="text/javascript"></script>
<link href="<?php echo base_url()?>css/floating_messages.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url()?>js/info/restaurant_info.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>js/floating_messages.js" type="text/javascript"></script>
<link href="<?php echo base_url()?>css/supplier.css" rel="stylesheet" type="text/css" />
<script>
	var isAuthenticated = <?php echo ($isAuthenticated ? "true" : "false") ?>;
	var restaurantId = <?php echo $RESTAURANT->restaurantId; ?>;
	var name = "<?php echo $RESTAURANT->restaurantName; ?>";
	var jsonData;
	var currentContent;
	
	var toggleDuration = 1000;
	var isSupplierFormVisible = false;
	var isMenuFormVisible = false;
	var isCommentFormVisible = false;
	
	var isLoginMessageVisible = false;
	
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
		
		
		loadSmallMapOnStartUp(38.41055825094609, -98, 3);
		
		$.post("/restaurant/ajaxSearchRestaurantInfo", { restaurantId:"<?php echo (isset($RESTAURANT) ? $RESTAURANT->restaurantId : '' ) ?>" },
		function(data){
			if (data.geocode != '') {
				reinitializeMap(data, 13);
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
					
					viewMarker(record_id, 0);
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
	    map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
	}
	
	function getMarkerHtml(o) {
		html = "<font size = '2'><b><i>" + o.restaurantName + "</i></b></font><br /><font size = '1'>" +
			  o.addressLine1 + ", " + o.addressLine2 + "<br />" + 
			  o.addressLine3 + "</font><br />"
			  ;
		return html;
	}
</script>



<div id="alert"></div>
<!-- center tabs -->
	<div id="resultsContainer">
		<div id="menu-bar"> 
			<div id="suppliers" class = "selected"><a href="#">Suppliers</a></div>
			<div id="menu" class = "non-selected"><a href="#">Menu</a></div>
			<div id="comments" class = "non-selected" style = "display:none;"><a href="#">Comments</a></div>
			<div id="addItem" class = "addItem">&nbsp;+ Supplier</div>
			
			<div id="divAddSupplier" class="supplier">
				<?php
					$data = array(
							'SUPPLIER_TYPES_2' => $SUPPLIER_TYPES_2, 
							'TABLE' => $TABLE,
							'RESTAURANT_ID' => $RESTAURANT->restaurantId
							);
					$this->load->view('includes/supplier_form', $data );
				?>
			</div>
			
			<div id="divAddMenu" class="supplier">
				<?php
					$data = array(
							'PRODUCT_TYPES' => $PRODUCT_TYPES, 
							'RESTAURANT_ID' => $RESTAURANT->restaurantId
							);
					$this->load->view('includes/menu_form', $data );
				?>
			</div>
			
			<div id="divAddComment" class="supplier">
				<?php
					$data = array(
							'PRODUCT_TYPES' => $PRODUCT_TYPES, 
							'RESTAURANT_ID' => $RESTAURANT->restaurantId
							);
					$this->load->view('includes/menu_form', $data );
				?>
			</div>
			
			<div id="divAddPhoto" class="supplier">
				<?php
					$data = array(
							'PRODUCT_TYPES' => $PRODUCT_TYPES, 
							'RESTAURANT_ID' => $RESTAURANT->restaurantId
							);
					$this->load->view('includes/menu_form', $data );
				?>
			</div>
			
			<div id="divLoginMessage" class="supplier">
				<?php
					$this->load->view('includes/login_message');
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
<?php

?>