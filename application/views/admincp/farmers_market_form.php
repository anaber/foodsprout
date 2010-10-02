<?php
/*
 * Created on Mar 1, 2010
 *
 * Author: Deepak Kumar
 */
?>
<script>

formValidated = true;

$(document).ready(function() {
	
	/* ----------------------------------------------------
	 * City
	 * ----------------------------------------------------*/
	 
	function findValueCallbackCity(event, data, formatted) {
		document.getElementById('cityId').value = data[1];
	}
	
	$("#cityAjax").result(findValueCallbackCity).next().click(function() {
		$(this).prev().search();
	});
	
	$("#cityAjax").autocomplete("/city/get_cities_based_on_state", {
		width: 260,
		selectFirst: false,
		cacheLength:0,
		extraParams: {
	       stateId: function() { return $("#stateId").val(); }
	   	}
	});
	
	$("#cityAjax").result(function(event, data, formatted) {
		if (data)
			$(this).parent().next().find("input").val(data[1]);
	});
	
	$("#clear").click(function() {
		$(":input").unautocomplete();
	});
	
	// SUCCESS AJAX CALL, replace "success: false," by:     success : function() { callSuccessFunction() }, 
	$("#farmForm").validationEngine({
		success :  function() {formValidated = true;},
		failure : function() {formValidated = false; }
	});
	
	
	$("#farmForm").submit(function() {
		
		$("#msgbox").removeClass().addClass('messagebox').text('Validating...').fadeIn(1000);
		
		if (formValidated == false) {
			// Don't post the form.
			$("#msgbox").fadeTo(200,0.1,function() {
				//add message and change the class of the box and start fading
				$(this).html('Form validation failed...').addClass('messageboxerror').fadeTo(900,1);
			});
		} else {
			
			var formAction = '';
			var postArray = '';
			var act = '';
			
			var cityId = $('#cityId').val();
			var cityName;
			
			if (isNaN( cityId ) ) {
				cityName = cityId;
				cityId = '';
			}
			
			if ($('#farmersMarketId').val() != '' ) {
				var formAction = '/admincp/farmersmarket/save_update';
				postArray = {
							  farmersMarketName:$('#farmersMarketName').val(),
							  customUrl:$('#customUrl').val(),
							  url:$('#url').val(),
							  status:$('#status').val(),
							  facebook:$('#facebook').val(),
							  twitter:$('#twitter').val(),

							  farmersMarketId: $('#farmersMarketId').val()
							};
				act = 'update';		
			} else {
				formAction = '/admincp/farmersmarket/save_add';
				postArray = { 
							  farmersMarketName:$('#farmersMarketName').val(),
							  customUrl:$('#customUrl').val(),
							  url:$('#url').val(),
							  status:$('#status').val(),
							  facebook:$('#facebook').val(),
							  twitter:$('#twitter').val(),
							  
							  address:$('#address').val(),
							  
							  cityId:cityId,
							  cityName:cityName,
							  
							  stateId:$('#stateId').val(),
							  countryId:$('#countryId').val(),
							  zipcode:$('#zipcode').val()
							};
				act = 'add';
			}
			
			$.post(formAction, postArray,function(data) {
				if(data=='yes') {
					//start fading the messagebox
					$("#msgbox").fadeTo(200,0.1,function() {
						//add message and change the class of the box and start fading
						if (act == 'add') {
							$(this).html('Added...').addClass('messageboxok').fadeTo(900,1, function(){
								//redirect to secure page
								document.location='/admincp/farmersmarket';
							});	
						} else if (act == 'update') {
							$(this).html('Updated...').addClass('messageboxok').fadeTo(900,1, function(){
								//redirect to secure page
								document.location='/admincp/farmersmarket';
							});
						}
					});
				} else if(data == 'duplicate') {
					//start fading the messagebox 
					$("#msgbox").fadeTo(200,0.1,function() {
						//add message and change the class of the box and start fading
						$(this).html('Duplicate Farmers Market...').addClass('messageboxerror').fadeTo(900,1);
					});
				} else {
					//start fading the messagebox 
					$("#msgbox").fadeTo(200,0.1,function() {
						//add message and change the class of the box and start fading
						if (act == 'add') {
							$(this).html('Not added...').addClass('messageboxerror').fadeTo(900,1);
						} else if (act == 'update') {
							$(this).html('Not updated...').addClass('messageboxerror').fadeTo(900,1);
						}
					});
				}
			});
		}
		return false; //not to post the  form physically
	});
});



</script>

<script src="<?php echo base_url()?>js/jquery.autocomplete.frontend.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo base_url()?>css/jquery.autocomplete.frontend.css" type="text/css" />

<?php
	if (!isset($FARMERS_MARKET)) {
?>
<?php echo anchor('admincp/farmersmarket', 'Farmers Market'); ?><br /><br />
<?php
	}
?>

<div align = "left"><div id="msgbox" style="display:none"></div></div><br /><br />

<form id="farmForm" method="post" <?php echo (isset($FARMERS_MARKET)) ? 'action="/admincp/farmermarket/save_update"' : 'action="/admincp/farmermarket/save_add"' ?>>
<table class="formTable">
	
	<tr>
		<td width = "25%" nowrap>Farmer Market</td>
		<td width = "75%">
			<input value="<?php echo (isset($FARMERS_MARKET) ? $FARMERS_MARKET->farmersMarketName : '') ?>" class="validate[optional]" type="text" name="farmersMarketName" id="farmersMarketName"/><br />
		</td>
	</tr>
	
	<tr>
		<td width = "25%" nowrap>Custom URL</td>
		<td width = "75%">
			<input value="<?php echo (isset($FARMERS_MARKET) ? $FARMERS_MARKET->customUrl : '') ?>" class="validate[optional]" type="text" name="customUrl" id="customUrl"/>
		</td>
	</tr>
	<tr>
		<td width = "25%" nowrap>Website</td>
		<td width = "75%">
			<input value="<?php echo (isset($FARMERS_MARKET) ? $FARMERS_MARKET->url : '') ?>" class="validate[optional]" type="text" name="url" id="url"/>
		</td>
	</tr>
	<tr>
		<td width = "25%" nowrap>Facebook</td>
		<td width = "75%">
			<input value="<?php echo (isset($FARMERS_MARKET) ? $FARMERS_MARKET->facebook : '') ?>" class="validate[optional]" type="text" name="facebook" id="facebook"/>
		</td>
	</tr>
	<tr>
		<td width = "25%" nowrap>Twitter</td>
		<td width = "75%">
			<input value="<?php echo (isset($FARMERS_MARKET) ? $FARMERS_MARKET->twitter : '') ?>" class="validate[optional]" type="text" name="twitter" id="twitter"/>
		</td>
	</tr>
	<tr>
		<td width = "25%" nowrap>Status</td>
		<td width = "75%">
			<select name="status" id="status"  class="validate[required]">
				<option value="">--Choose Status--</option>
			<?php
				foreach($STATUS as $key => $value) {
					echo '<option value="'.$key.'"' . (  ( isset($FARMERS_MARKET) && ( $key == $FARMERS_MARKET->status )  ) ? ' SELECTED' : '' ) . '>'.$value.'</option>';
				}
			?>
			</select>
		</td>
	</tr>
<?php
	if (!isset($FARMERS_MARKET) ){
?>
	<tr>
		<td colspan = "2">&nbsp;</td>
	</tr>
	<tr>
		<td colspan = "2"><b>Address</b></td>
	</tr>
	<tr>
		<td width = "25%">Address</td>
		<td width = "75%">
			<input value="<?php echo (isset($FARMERS_MARKET) ? $FARMERS_MARKET->address : '') ?>" class="validate[required]" type="text" name="address" id="address"/><br />
		</td>
	</tr>
	<tr>
		<td width = "25%">State</td>
		<td width = "75%">
			<select name="stateId" id="stateId"  class="validate[required]">
			<option value = ''>--State--</option>
			<?php
				foreach($STATES as $key => $value) {
					echo '<option value="'.$value->stateId.'"' . (  ( isset($FARMERS_MARKET) && ( $value->stateId == $FARMERS_MARKET->stateId )  ) ? ' SELECTED' : '' ) . '>'.$value->stateName.'</option>';
				}
			?>
			</select>
		</td>
	</tr>
	<tr>
		<td width = "25%">City</td>
		<td width = "75%">
			<input type="text" id="cityAjax" value="<?php echo (isset($FARMERS_MARKET) ? $FARMERS_MARKET->cityName : '') ?>" class="validate[required]" />
		</td>
	</tr>
	
	<tr>
		<td width = "25%">Country</td>
		<td width = "75%">
			<select name="countryId" id="countryId"  class="validate[required]">
			<option value = ''>--Country--</option>
			<?php
				foreach($COUNTRIES as $key => $value) {
					echo '<option value="'.$value->countryId.'"' . (  ( isset($FARMERS_MARKET) && ( $value->countryId == $FARMERS_MARKET->countryId )  ) ? ' SELECTED' : '' ) . '>'.$value->countryName.'</option>';
				}
			?>
			</select>
		</td>
	</tr>
	<tr>
		<td width = "25%">Zip</td>
		<td width = "75%">
			<input value="<?php echo (isset($FARMERS_MARKET) ? $FARMERS_MARKET->zipcode : '') ?>" class="validate[required,length[1,6]]" type="text" name="zipcode" id="zipcode" /><br />
		</td>
	</tr>
<?php
	}
?>
	<tr>
		<td width = "25%" colspan = "2">
			<input type = "Submit" name = "btnSubmit" id = "btnSubmit" value = "<?php echo (isset($FARMERS_MARKET)) ? 'Update Farmers Market' : 'Add Farmers Market' ?>">
			<input type = "hidden" name = "farmersMarketId" id = "farmersMarketId" value = "<?php echo (isset($FARMERS_MARKET) ? $FARMERS_MARKET->farmersMarketId : '') ?>">
			<input type = "hidden" name = "companyId" id = "cityId" value = "">
		</td>
	</tr>
</table>
</form>

