<script src="<?php echo base_url()?>js/my_dashboard.js" type="text/javascript"></script>

<script type="text/javascript" src="<?php echo base_url()?>js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />

<script src="<?php echo base_url()?>js/jquery.autocomplete.frontend.js" type="text/javascript"></script>

<script src="<?php echo base_url()?>js/jquery.validationEngine.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>js/jquery.validationEngine-en.js" type="text/javascript"></script>

<?php
/*
	$addRestaurantFormHtml = '';
	$addRestaurantFormHtml .= 
'<form id="restaurantForm" method="post" action = "">'. "'+\n" .
'\'<table class="formTable" border = "0" width = "300">'. "'+\n" .
'\'	<tr>'. "'+\n" .
'\'		<td>'. "'+\n" .
'\'			<table class="formTable" border = "0" width = "300">'. "'+\n" .
'\'				<tr>'. "'+\n" .
'\'					<td width = "25%" nowrap style = "font-size:13px;">Restaurant Name</td>'. "'+\n" .
'\'					<td width = "25%">'. "'+\n" .
'\'						<input value="" class="validate[required]" type="text" name="restaurantName" id="restaurantName"/><br />'. "'+\n" .
'\'					</td>'. "'+\n" .
'\'				</tr>'. "'+\n" .
				
'\'				<tr>'. "'+\n" .
'\'					<td width = "25%" style = "font-size:13px;">Restaurant Type</td>'. "'+\n" .
'\'					<td width = "75%">'. "'+\n" .
'\'						<select name="restaurantTypeId" id="restaurantTypeId"  class="validate[required]">'. "'+\n" .
'\'						<option value = "">--Restaurant Type--</option>' . "'+\n" ;
							foreach($RESTAURANT_TYPES as $key => $value) {
$addRestaurantFormHtml .= 		'\'<option value="'.$value->restaurantTypeId.'"' . (  ( isset($RESTAURANT) && ( $value->restaurantTypeId == $RESTAURANT->restaurantTypeId )  ) ? ' SELECTED' : '' ) . '>'.$value->restaurantTypeName.'</option>'. "'+\n" ;
							}
$addRestaurantFormHtml .= 
'\'						</select>'. "'+\n" .
'\'					</td>'. "'+\n" .
'\'				</tr>'. "'+\n" .
				
'\'				<tr>'. "'+\n" .
'\'					<td width = "25%" style = "font-size:13px;">Cuisine</td>'. "'+\n" .
'\'					<td width = "75%">'. "'+\n" .
'\'						<select name="cuisineId" id="cuisineId"  class="validate[required]" multiple size = "4">'. "'+\n" .
'\'						<option value = "">--Cuisine--</option>'. "'+\n";
							foreach($CUISINES as $key => $value) {
$addRestaurantFormHtml .= 		'\'<option value="'.$value->cuisineId.'"' . (  ( isset($RESTAURANT) && in_array($value->cuisineId, $RESTAURANT->cuisines) ) ? ' SELECTED' : '' ) . '>'.$value->cuisineName.'</option>'. "'+\n" ;
							}
$addRestaurantFormHtml .= 
'\'						</select>'. "'+\n" .
'\'					</td>'. "'+\n" .
'\'				</tr>'. "'+\n" .
'\'				<tr>'. "'+\n" .
'\'					<td width = "25%" nowrap style = "font-size:13px;">Phone</td>'. "'+\n" .
'\'					<td width = "75%">'. "'+\n" .
'\'						<input value="" class="validate[optional]" type="text" name="phone" id="phone"/>'. "'+\n" .
'\'					</td>'. "'+\n" .
'\'				</tr>'. "'+\n" .
'\'				<tr>'. "'+\n" .
'\'					<td width = "25%" nowrap style = "font-size:13px;">Fax</td>'. "'+\n" .
'\'					<td width = "75%">'. "'+\n" .
'\'						<input value="" class="validate[optional]" type="text" name="fax" id="fax"/>'. "'+\n" .
'\'					</td>'. "'+\n" .
'\'				</tr>'. "'+\n" .
'\'				<tr>'. "'+\n" .
'\'					<td width = "25%" nowrap style = "font-size:13px;">E-Mail</td>'. "'+\n" .
'\'					<td width = "75%">'. "'+\n" .
'\'						<input value="" class="validate[optional,custom[email]]" type="text" name="email" id="email"/>'. "'+\n" .
'\'					</td>'. "'+\n" .
'\'				</tr>'. "'+\n" .
				
'\'			</table>'. "'+\n" .
'\'		</td>'. "'+\n" .
'\'		<td valign = "top">'. "'+\n" .
'\'			<table class="formTable" border = "0" width = "300">'. "'+\n" .
'\'				<tr>'. "'+\n" .
'\'					<td width = "25%" style = "font-size:13px;">Address</td>'. "'+\n" .
'\'					<td width = "25%">'. "'+\n" .
'\'						<input value="" class="validate[required]" type="text" name="address" id="address"/><br />'. "'+\n" .
'\'					</td>'. "'+\n" .
'\'				</tr>'. "'+\n" .
				
'\'				<tr>'. "'+\n" .
'\'					<td width = "25%" style = "font-size:13px;">State</td>'. "'+\n" .
'\'					<td width = "25%">'. "'+\n" .
'\'						<select name="stateId" id="stateId"  class="validate[required]">'. "'+\n" .
'\'						<option value = "">--State--</option>' . "'+\n";
							foreach($STATES as $key => $value) {
$addRestaurantFormHtml .= 		'\'<option value="'.$value->stateId.'"' . (  ( isset($RESTAURANT) && ( $value->stateId == $RESTAURANT->stateId )  ) ? ' SELECTED' : '' ) . '>'.$value->stateName.'</option>'. "'+\n" ;
							}
$addRestaurantFormHtml .= 
'\'						</select>'. "'+\n" .
'\'					</td>'. "'+\n" .
'\'				</tr>'. "'+\n" .
				
'\'				<tr>'. "'+\n" .
'\'					<td width = "25%" style = "font-size:13px;">City</td>'. "'+\n" .
'\'					<td width = "25%">'. "'+\n" .
'\'						<input type="text" id="cityAjax" value="" class="validate[required]" />'. "'+\n" .
'\'					</td>'. "'+\n" .
'\'				</tr>'. "'+\n" .
				
'\'				<tr>'. "'+\n" .
'\'					<td width = "25%" style = "font-size:13px;">Country</td>'. "'+\n" .
'\'					<td width = "25%">'. "'+\n" .
'\'						<select name="countryId" id="countryId"  class="validate[required]">'. "'+\n" .
'\'						<option value = "">--Country--</option>' . "'+\n";
							foreach($COUNTRIES as $key => $value) {
//$addRestaurantFormHtml .= 		'\'<option value="' . $value->countryId . '"' . (  ( isset($RESTAURANT) && ( $value->countryId == $RESTAURANT->countryId )  ) ? ' SELECTED' : '' ) . '>'.$value->countryName.'</option>'. "'+\n" ;
$addRestaurantFormHtml .= 		'\'<option value="' . $value->countryId . '"' . (  $value->countryId == 1 ? ' SELECTED' : '' ) . '>'.$value->countryName.'</option>'. "'+\n" ;
							}
$addRestaurantFormHtml .= 
'\'						</select>'. "'+\n" .
'\'					</td>'. "'+\n" .
'\'				</tr>'. "'+\n" .
'\'				<tr>'. "'+\n" .
'\'					<td width = "25%" style = "font-size:13px;">Zip</td>'. "'+\n" .
'\'					<td width = "25%">'. "'+\n" .
'\'						<input value="" class="validate[required,length[1,6]]" type="text" name="zipcode" id="zipcode" /><br />'. "'+\n" .
'\'					</td>'. "'+\n" .
'\'				</tr>'. "'+\n" .
'\'				<tr>'. "'+\n" .
'\'					<td width = "25%" nowrap style = "font-size:13px;">Website</td>'. "'+\n" .
'\'					<td width = "25%">'. "'+\n" .
'\'						<input value="" class="validate[optional]" type="text" name="website" id="website"/>'. "'+\n" .
'\'					</td>'. "'+\n" .
'\'				</tr>'. "'+\n" .
'\'				<tr>'. "'+\n" .
'\'					<td width = "25%" nowrap style = "font-size:13px;">Facebook</td>'. "'+\n" .
'\'					<td width = "25%">'. "'+\n" .
'\'						<input value="" class="validate[optional]" type="text" name="facebook" id="facebook"/>'. "'+\n" .
'\'					</td>'. "'+\n" .
'\'				</tr>'. "'+\n" .
'\'				<tr>'. "'+\n" .
'\'					<td width = "25%" nowrap style = "font-size:13px;">Twitter</td>'. "'+\n" .
'\'					<td width = "25%">'. "'+\n" .
'\'						<input value="" class="validate[optional]" type="text" name="twitter" id="twitter"/>'. "'+\n" .
'\'					</td>'. "'+\n" .
'\'				</tr>'. "'+\n" .
				
'\'			</table>'. "'+\n" .
'\'		</td>'. "'+\n" .
'\'	</tr>'. "'+\n" .
'\'	<tr>'. "'+\n" .
'\'		<td colspan = "2" align = "right">'. "'+\n" .
'\'			<input type = "Submit" name = "btnSubmit" id = "btnSubmit" value = "Add Restaurant">'. "'+\n" .
'\'		</td>'. "'+\n" .
'\'	</tr>'. "'+\n" .
'\'</table>'. "'+\n" .
'\'<input type = "hidden" name = "cityId" id = "cityId" value = "">'. "'+\n" .
'\'</form>';
*/
$addRestaurantFormHtml = 'Deepak here';
?>

<script>
	
	var userId = <?php echo $this->session->userdata('userId'); ?>;
	var addRestaurantFormHtml = '<?php echo $addRestaurantFormHtml; ?>';
	
	var jsonData;
	var currentContent;
	
	var toggleDuration = 1000;
	var isSupplierFormVisible = false;
	var isMenuFormVisible = false;
	var isCommentFormVisible = false;
	
	$(document).ready(function() {
		$('#bottomPaging').hide();
		
		//$.post("/user/ajaxSuppliersByUser", { q: userId },
		$.post("/user/ajaxRestaurantsByUser", { q: userId },
		function(data){
			currentContent = 'restaurants';
			jsonData = data;
			redrawContent(data, 'restaurants');
			reinitializeTabs();
		},
		"json");
	});
	
</script>

<div id="alert"></div>
<!-- center tabs -->
	<div id="resultsContainer" style = "border-style:solid;border-width:0px;border-color:#FF0000;">
		<div id="menu-bar"> 
			<div id="restaurants" class = "selected"><a href="#">My Restaurants</a></div>
			<div id="suppliers" class = "non-selected"><a href="#">My Suppliers</a></div>
			<div id="menu" class = "non-selected"><a href="#">My Menu</a></div>
			<div id="comments" class = "non-selected" style = "display:none;"><a href="#">My Comments</a></div>
			<div id="farms" class = "non-selected" style = "display:none;"><a href="#">My Farms</a></div>
		</div>
		
		<div style="overflow:auto; padding:5px;">
			<div style="float:left; width:110px; font-size:10px;border-style:solid;border-width:0px;border-color:#FF0000;" id = 'numRecords'>Records 0-0 of 0</div>
			
			<div style="float:left; width:500px; font-size:10px;border-style:solid;border-width:0px;border-color:#FF0000;" id = 'pagingLinks' align = "center">
				<a href="#" id = "imgFirst">First</a> &nbsp;&nbsp;
				<a href="#" id = "imgPrevious">Previous</a>
				&nbsp;&nbsp;&nbsp; Page 1 of 1 &nbsp;&nbsp;&nbsp;
				<a href="#" id = "imgNext">Next</a> &nbsp;&nbsp;
				<a href="#" id = "imgLast">Last</a>
			</div>
			
			<div style="float:right; width:165px; font-size:10px;border-style:solid;border-width:0px;border-color:#FF0000;" id = 'recordsPerPage' align = "right">
				Items per page:&nbsp;
				<a href="#" id = "10PerPage">10</a> | 
				<a href="#" id = "20PerPage">20</a> |  
				<a href="#" id = "40PerPage">40</a> |  
				<a href="#" id = "50PerPage">50</a> 
			</div>
			
			<div class="clear"></div>
		</div>
		
		<div id="resultTableContainer" class="menus" style = "width:790px; padding:0px;"></div>
		<div class = "clear"></div>
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