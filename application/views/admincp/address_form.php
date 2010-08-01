<?php
/*
 * Created on Mar 1, 2010
 *
 * Author: Deepak Kumar
 */
?>
<script>
var documentLocation = '';
<?php
	if ( isset($MANUFACTURE_ID) ) {
?>
		documentLocation = '/admincp/manufacture/add_address/<?php echo $MANUFACTURE_ID; ?>';
<?php
	} else if ( isset($FARM_ID) ) {
?>
		documentLocation = '/admincp/farm/add_address/<?php echo $FARM_ID; ?>';
<?php
	} else if ( isset($RESTAURANT_ID) ) {
?>
		documentLocation = '/admincp/restaurant/add_address/<?php echo $RESTAURANT_ID; ?>';
<?php
	} else if ( isset($DISTRIBUTOR_ID) ) {
?>
		documentLocation = '/admincp/distributor/add_address/<?php echo $DISTRIBUTOR_ID; ?>';
<?php
	} else if ( isset($FARMERS_MARKET_ID) ) {
?>
		documentLocation = '/admincp/distributor/add_address/<?php echo $FARMERS_MARKET_ID; ?>';
<?php
	} 
?>
formValidated = true;

$(document).ready(function() {
	
	// SUCCESS AJAX CALL, replace "success: false," by:     success : function() { callSuccessFunction() }, 
	$("#addressForm").validationEngine({
		success :  function() {formValidated = true;},
		failure : function() {formValidated = false; }
	});
	
	
	$("#addressForm").submit(function() {
		
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
			
			if ($('#addressId').val() != '' ) {
				var formAction = '/admincp/manufacture/address_save_update';
				postArray = {
							  address:$('#address').val(),
							  city: $('#city').val(),
							  stateId:$('#stateId').val(),
							  countryId:$('#countryId').val(),
							  zipcode:$('#zipcode').val(),
							   
							  addressId: $('#addressId').val()
							};
				act = 'update';		
			} else {
				formAction = '/admincp/manufacture/address_save_add';
				postArray = { 
							  address:$('#address').val(),
							  city: $('#city').val(),
							  stateId:$('#stateId').val(),
							  countryId:$('#countryId').val(),
							  zipcode:$('#zipcode').val(),
							  
							  manufactureId: $('#manufactureId').val(),
							  farmId: $('#farmId').val(),
							  restaurantId: $('#restaurantId').val(),
							  distributorId: $('#distributorId').val(),
							  farmersMarketId: $('#farmersMarketId').val()
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
								document.location = documentLocation;
							});	
						} else if (act == 'update') {
							$(this).html('Updated...').addClass('messageboxok').fadeTo(900,1, function(){
								//redirect to secure page
								document.location = documentLocation;
							});
						}
					});
				} else if(data == 'duplicate') {
					//start fading the messagebox 
					$("#msgbox").fadeTo(200,0.1,function() {
						//add message and change the class of the box and start fading
						$(this).html('Duplicate Address...').addClass('messageboxerror').fadeTo(900,1);
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

<div align = "left"><div id="msgbox" style="display:none"></div></div><br /><br />
<?php
	//print_r_pre($MANUFACTURE);
?>
<form id="addressForm" method="post" <?php echo (isset($ADDRESS)) ? 'action="/admincp/address/address_save_update"' : 'action="/admincp/manufacture/address_save_add"' ?>>
<table class="formTable">

	<tr>
		<td colspan = "2"><b>Address</b></td>
	</tr>
	<tr>
		<td width = "25%">Address</td>
		<td width = "75%">
			<input value="<?php echo (isset($ADDRESS) ? $ADDRESS->address : '') ?>" class="validate[required]" type="text" name="address" id="address"/><br />
		</td>
	</tr>
	
	<tr>
		<td width = "25%">City</td>
		<td width = "75%">
			<input value="<?php echo (isset($ADDRESS) ? $ADDRESS->city : '') ?>" class="validate[required]" type="text" name="city" id="city"/><br />
		</td>
	</tr>
	<tr>
		<td width = "25%">State</td>
		<td width = "75%">
			<select name="stateId" id="stateId"  class="validate[required]">
			<option value = ''>--State--</option>
			<?php
				foreach($STATES as $key => $value) {
					echo '<option value="'.$value->stateId.'"' . (  ( isset($ADDRESS) && ( $value->stateId == $ADDRESS->stateId )  ) ? ' SELECTED' : '' ) . '>'.$value->stateName.'</option>';
				}
			?>
			</select>
		</td>
	</tr>
	<tr>
		<td width = "25%">Country</td>
		<td width = "75%">
			<select name="countryId" id="countryId"  class="validate[required]">
			<option value = ''>--Country--</option>
			<?php
				foreach($COUNTRIES as $key => $value) {
					echo '<option value="'.$value->countryId.'"' . (  ( isset($ADDRESS) && ( $value->countryId == $ADDRESS->countryId )  ) ? ' SELECTED' : '' ) . '>'.$value->countryName.'</option>';
				}
			?>
			</select>
		</td>
	</tr>
	<tr>
		<td width = "25%">Zip</td>
		<td width = "75%">
			<input value="<?php echo (isset($ADDRESS) ? $ADDRESS->zipcode : '') ?>" class="validate[required,length[1,6]]" type="text" name="zipcode" id="zipcode" /><br />
		</td>
	</tr>
<?php
	
?>
	<tr>
		<td width = "25%" colspan = "2">
			<input type = "Submit" name = "btnSubmit" id = "btnSubmit" value = "<?php echo (isset($ADDRESS)) ? 'Update Address' : 'Add Address' ?>">
			<input type = "hidden" name = "addressId" id = "addressId" value = "<?php echo (isset($ADDRESS) ? $ADDRESS->addressId : '') ?>">
			
			<input type = "hidden" name = "manufactureId" id = "manufactureId" value = "<?php echo (isset($MANUFACTURE_ID) ? $MANUFACTURE_ID : '') ?>">
			<input type = "hidden" name = "farmId" id = "farmId" value = "<?php echo (isset($FARM_ID) ? $FARM_ID : '') ?>">
			<input type = "hidden" name = "restaurantId" id = "restaurantId" value = "<?php echo (isset($RESTAURANT_ID) ? $RESTAURANT_ID : '') ?>">
			<input type = "hidden" name = "distributorId" id = "distributorId" value = "<?php echo (isset($DISTRIBUTOR_ID) ? $DISTRIBUTOR_ID : '') ?>">			
			<input type = "hidden" name = "farmersMarketId" id = "farmersMarketId" value = "<?php echo (isset($FARMERS_MARKET_ID) ? $FARMERS_MARKET_ID : '') ?>">
		</td>
	</tr>
</table>
</form>

<table cellpadding="3" cellspacing="0" border="0" id="tbllist" width = "50%">
	<tr>
		<th>Id</th>
		<th>Address</th>
	</tr>
<?php
	$controller = $this->uri->segment(2);
	$i = 0;
	foreach($ADDRESSES as $address) :
		$i++;
		echo '<tr class="d'.($i & 1).'">';
		echo '	<td>'.anchor('/admincp/'.$controller.'/update_address/'.$address->addressId, $address->addressId).'</td>';
		echo '	<td>'.anchor('/admincp/'.$controller.'/update_address/'.$address->addressId, $address->displayAddress).'</td>';
		echo '</tr>';

 	endforeach;
?>
</table>
