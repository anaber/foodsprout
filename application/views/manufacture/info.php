<?php
	$isAuthenticated = $this->session->userdata('isAuthenticated');
	$access = $this->session->userdata('access');
	$userId = $this->session->userdata('userId');

	$module = $this->uri->segment(1);
	$producer = $this->uri->segment(2);
	
	$uri = $this->uri->uri_string();
?>
<script src="<?php echo base_url()?>js/popup.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>js/info/manufacture_info.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>js/jquery.maxlength.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>js/info/common.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>js/floating_messages.js" type="text/javascript"></script>

<script type="text/javascript" src="<?php echo base_url()?>js/uploadify/swfobject.js"></script> 
<script type="text/javascript" src="<?php echo base_url()?>js/uploadify/jquery.uploadify.v2.1.0.js"></script>

<script src="<?php echo base_url()?>js/jquery.lightbox-0.5.js" type="text/javascript"></script>

<script>
	
	var manufactureId = <?php echo $MANUFACTURE->manufactureId; ?>;
	<?php
		if ($ADDRESS_ID) {
			echo 'var addressId = ' . $ADDRESS_ID . ";";
		} else {
			echo 'var addressId = "";';
		}
	?>
	var name = "<?php echo $MANUFACTURE->manufactureName; ?>";
	var access = "<?php echo $access; ?>";
	var userId = "<?php echo $userId; ?>";
	
	var param = <?php echo $PARAMS; ?>;
	
	var currentTab = '<?php echo $CURRENT_TAB; ?>';
	var uri = '<?php echo $uri; ?>';
	
	var jsonData;
	var currentContent;
	
	var toggleDuration = 1000;
	var isSupplierFormVisible = false;
	var isMenuFormVisible = false;
	var isCommentFormVisible = false;
	
	var isAuthenticated = <?php echo ($isAuthenticated ? "true" : "false") ?>;
	var isLoginMessageVisible = false;
	
	$(document).ready(function() {
		
		var data = '';
		
		//$('#bottomPaging').hide();
		
		/**
		 * If users try to load url with HASH segment from address bar
		 */
		if(window.location.hash) {
			
			str = window.location.hash;
			str = str.substr(2);
			arr = str.split('&');
			postArray = {};
			var tab = p = pp = sort = order = q = f = tab = '';		
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
				} else if (arr2[0] == 'tab') {
					tab = arr2[1];
				} 
			}
			
			if (tab == 'supplier') {
				$.post("/manufacture/ajaxSearchManufactureSuppliers", { q: manufactureId, addressId:addressId, producerUrl:uri },
		
				function(data){
					currentContent = 'supplier';
					jsonData = data;
					redrawContent(data, 'supplier');
					reinitializeTabs();
				},
				"json");
			} else if (tab == 'menu') {
				
				$.post("/manufacture/ajaxSearchManufactureMenus", { q: manufactureId, addressId:addressId, producerUrl:uri },
				
				function(data){
					currentContent = 'menu';
					jsonData = data;
					redrawContent(data, 'menu');
					reinitializeTabs();
				},
				"json");
			} else if (tab == 'comment') {
				
				$.post("/manufacture/ajaxSearchManufactureComments", { q: manufactureId, addressId:addressId, producerUrl:uri },
		
				function(data){
					currentContent = 'comment';
					jsonData = data;
					redrawContent(data, 'comment');
					reinitializeTabs();
				},
				"json");
			} else if (tab == 'photo') {
				
				$.post("/manufacture/ajaxSearchManufacturePhotos", { q: manufactureId, addressId:addressId, producerUrl:uri },
		
				function(data){
					currentContent = 'photo';
					jsonData = data;
					redrawContent(data, 'photo');
					reinitializeTabs();
				},
				"json");
			}
			
		} else {
			jsonData = data;
			
			if (currentTab != "") {
				
				currentContent = currentTab;
				redrawContent(data, currentTab);
			} else {
				currentContent = 'supplier';
				redrawContent(data, 'supplier');
			}
			reinitializeTabs();
			
		}
		
		
		loadSmallMapOnStartUp(38.41055825094609, -98, 3);
		
		$.post("/manufacture/ajaxSearchManufactureInfo", { manufactureId:"<?php echo (isset($MANUFACTURE) ? $MANUFACTURE->manufactureId : '' ) ?>", addressId:"<?php echo (isset($ADDRESS_ID) ? $ADDRESS_ID : '' ); ?>"  },
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
	
	function getMarkerHtml2(o) {
		html = "<font size = '2'><b><i>" + o.manufactureName + "</i></b></font><br /><font size = '1'>" +
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
			<div id="suppliers" class = "<?php echo ($CURRENT_TAB == 'supplier' ? 'selected' : 'non-selected') ?>"><a href = "<?php echo $SUPPLIER_TAB_LINK; ?>" id = "linkSupplier">Suppliers</a></div>
			<div id="menu" class = "<?php echo ($CURRENT_TAB == 'menu' ? 'selected' : 'non-selected') ?>"><a href = "<?php echo $MENU_TAB_LINK; ?>" id = "linkMenu">Products</a></div>
			<div id="comments" class = "<?php echo ($CURRENT_TAB == 'comment' ? 'selected' : 'non-selected') ?>"><a href = "<?php echo $COMMENT_TAB_LINK; ?>" id = "linkComment">Comments</a></div>
			<div id="photos" class = "<?php echo ($CURRENT_TAB == 'photo' ? 'selected' : 'non-selected') ?>"><a href = "<?php echo $PHOTO_TAB_LINK; ?>" id = "linkPhoto">Photos</a></div>
			<div id="addItem" class = "addItem">&nbsp;+ Supplier</div>
			<div class = "clear"></div>
			
			<div id="divAddSupplier" class="supplier">
				<?php
					$data = array(
							'SUPPLIER_TYPES_2' => $SUPPLIER_TYPES_2, 
							'TABLE' => $TABLE,
							'MANUFACTURE_ID' => $MANUFACTURE->manufactureId
							);
					$this->load->view('includes/supplier_form', $data );
				?>
				<div class = "clear"></div>
			</div>
			
			<div id="divAddMenu" class="supplier">
				<?php
					$data = array(
							'PRODUCT_TYPES' => $PRODUCT_TYPES, 
							'MANUFACTURE_ID' => $MANUFACTURE->manufactureId
							);
					$this->load->view('includes/menu_form', $data );
				?>
				<div class = "clear"></div>
			</div>
			
			<div id="divLoginMessage" class="supplier">
				<?php
					$this->load->view('includes/login_message');
				?>
				<div class = "clear"></div>
			</div>
			<div class = "clear"></div>
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
			<?php
				if (isset($PAGING_HTML_2) ) {
					echo $PAGING_HTML_2;
				} else {
			?>
			<div style="float:left; width:150px;" id = 'numRecords2'></div>
			<div style="float:left; width:250px;" id = 'pagingLinks2' align = "center"></div>
			<div style="float:left; width:175px;" id = 'recordsPerPage2' align = "right"></div>
			<?php
				}
			?>
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
