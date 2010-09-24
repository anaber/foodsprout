<link href="<?php echo base_url()?>css/floating_messages.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url()?>js/info/restaurant_info.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>js/floating_messages.js" type="text/javascript"></script>

<link href="<?php echo base_url()?>css/supplier.css" rel="stylesheet" type="text/css" />

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
		
		
		$('#show-login-button').click(function(event){
			event.preventDefault();
			$.validationEngine.closePrompt('.formError',true);
			if($(this).hasClass('active')){
				$(this).removeClass('active');
				$('#login-form').stop(true, false).fadeOut(200);
			} else {
				$(this).addClass('active');
				$('#login-form').stop(true, false).fadeIn(200);
			}
		});
		
		
		
		
		
		
		
		
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
			
			<div class = "non-selected" id="show-login-button"><a href="#">Log In</a></div>
			<div id="addItem" class="add-item"><a href="#">+ Supplier</a></div>
			
			<div id="login-form">
				<form action="/login/validate" method="post" name="frmLogin" id="frmLogin">
					<h2>Log In</h2>								
					<input type="text" name="login_email" id="login_email" class="validate[required,custom[email]]" value="Email" onfocus="if(this.value == 'Email')this.value='';" onblur="if(this.value=='')this.value='Email';" />
					<input type="password" name="login_password" id="login_password" class="validate[required]" value="Password" onfocus="if(this.value=='Password')this.value='';" onblur="if(this.value=='')this.value='Password';" />
					<!--label for="remember_me" class="checkbox-wrapper">
						<input type="checkbox" name="remember_me" value="remember_me" id="remember_me" />
						<span>Remember me</span>
					</label -->
					<input type="submit" name="submit" value="Login" />
				</form>
			</div>
			
		</div>
		
		<div id="divAddSupplier" style = "display:none;" class="addform">
			<?php
				$data = array(
						'SUPPLIER_TYPES_2' => $SUPPLIER_TYPES_2, 
						'TABLE' => $TABLE,
						'RESTAURANT_ID' => $RESTAURANT->restaurantId
						);
				$this->load->view('includes/supplier_form', $data );
			?>
		</div>
		
		<div id="divAddMenu" style = "display:none;" class="addform">
			<?php
				$data = array(
						'PRODUCT_TYPES' => $PRODUCT_TYPES, 
						'RESTAURANT_ID' => $RESTAURANT->restaurantId
						);
				$this->load->view('includes/menu_form', $data );
			?>
		</div>
		
		<div id="divAddComment" style = "display:none;">Comment form will come here</div>
		
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