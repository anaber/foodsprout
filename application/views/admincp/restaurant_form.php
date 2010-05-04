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
	
	// SUCCESS AJAX CALL, replace "success: false," by:     success : function() { callSuccessFunction() }, 
	$("#restaurantForm").validationEngine({
		success :  function() {formValidated = true;},
		failure : function() {formValidated = false; }
	});
	
	
	$("#restaurantForm").submit(function() {
		
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
			
			if ($('#restaurantId').val() != '' ) {
				var formAction = '/admincp/restaurant/save_update';
				postArray = {
							  companyId:$('#companyId').val(),
							  restaurantName:$('#restaurantName').val(),
							  customUrl:$('#customUrl').val(),
							  restaurantTypeId:$('#restaurantTypeId').val(),
							  cuisineId:$('#cuisineId').val(),
							  isActive:$('#status').val(),
							  							 
							  restaurantId: $('#restaurantId').val()
							};
				act = 'update';		
			} else {
				formAction = '/admincp/restaurant/save_add';
				postArray = { 
							  
							  companyId:$('#companyId').val(),
							  restaurantName:$('#restaurantName').val(),
							  customUrl:$('#customUrl').val(),
							  restaurantTypeId:$('#restaurantTypeId').val(),
							  cuisineId:$('#cuisineId').val(),
							  isActive:$('#status').val(),
							  streetNumber:$('#streetNumber').val(),
							  street:$('#street').val(),
							  city: $('#city').val(),
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
								document.location='/admincp/restaurant';
							});	
						} else if (act == 'update') {
							$(this).html('Updated...').addClass('messageboxok').fadeTo(900,1, function(){
								//redirect to secure page
								document.location='/admincp/restaurant';
							});
						}

					});
				} else if(data == 'no_name') {
					//start fading the messagebox 
					$("#msgbox").fadeTo(200,0.1,function() {
						//add message and change the class of the box and start fading
						$(this).html('Either select company or enter resstaurant name...').addClass('messageboxerror').fadeTo(900,1);
						
					});
				} else if(data == 'duplicate_company') {
					//start fading the messagebox 
					$("#msgbox").fadeTo(200,0.1,function() {
						//add message and change the class of the box and start fading
						$(this).html('Duplicate Company...').addClass('messageboxerror').fadeTo(900,1);
						
					});
				} else if(data == 'duplicate') {
					//start fading the messagebox 
					$("#msgbox").fadeTo(200,0.1,function() {
						//add message and change the class of the box and start fading
						$(this).html('Duplicate Restaurant...').addClass('messageboxerror').fadeTo(900,1);
						
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
<?php
	
?>

<?php echo anchor('admincp/restaurant', 'List Restaurants'); ?><br /><br />

<div align = "left"><div id="msgbox" style="display:none"></div></div><br /><br />

<form id="restaurantForm" method="post" <?php echo (isset($RESTAURANT)) ? 'action="/admincp/restaurant/save_update"' : 'action="/admincp/restaurant/save_add"' ?>>
<table class="formTable">
	<tr>
		<td width = "25%" nowrap>Company</td>
		<td width = "75%">
			<select name="companyId" id="companyId"  class="validate[optional]">
			<option value = ''>--Existing Companies--</option>
			<?php
				foreach($COMPANIES as $key => $value) {
					echo '<option value="'.$value->companyId.'"' . (  ( isset($RESTAURANT) && ( $value->companyId == $RESTAURANT->companyId )  ) ? ' SELECTED' : '' ) . '>'.$value->companyName.'</option>';
				}
			?>
			</select>
		</td>
	<tr>
	<tr>
		<td width = "25%" nowrap>Restaurant Name</td>
		<td width = "75%">
			<input value="<?php echo (isset($RESTAURANT) ? $RESTAURANT->restaurantName : '') ?>" class="validate[optional]" type="text" name="restaurantName" id="restaurantName"/><br />
		</td>
	</tr>
	<tr>
		<td colspan = "2" style = "font-size:10px;">
			<ul>
				<li>Existing companies selected and name entered, restaurant will be treated as the subsidery of selected company but with overridden name.</li>
				<li>Existing companies selected and NO name entered, restaurant name will be considered as of company name.</li>
				<li>No company selected from the list above and name entered, new comapny and restaurant will be added.</li>
			</ul>
		</td>
	<tr>
	<tr>
		<td width = "25%">Restaurant Type</td>
		<td width = "75%">
			<select name="restaurantTypeId" id="restaurantTypeId"  class="validate[required]">
			<option value = ''>--Restaurant Type--</option>
			<?php
				foreach($RESTAURANT_TYPES as $key => $value) {
					echo '<option value="'.$value->restaurantTypeId.'"' . (  ( isset($RESTAURANT) && ( $value->restaurantTypeId == $RESTAURANT->restaurantTypeId )  ) ? ' SELECTED' : '' ) . '>'.$value->restaurantTypeName.'</option>';
				}
			?>
			</select>
		</td>
	<tr>
	<tr>
		<td width = "25%">Cuisine</td>
		<td width = "75%">
			<select name="cuisineId" id="cuisineId"  class="validate[required]">
			<option value = ''>--Cuisine--</option>
			<option value = "NULL">--Unknown--</option>
			<?php
				foreach($CUISINES as $key => $value) {
					echo '<option value="'.$value->cuisineId.'"' . (  ( isset($RESTAURANT) && ( $value->restauranttypeId == $RESTAURANT->cuisineId )  ) ? ' SELECTED' : '' ) . '>'.$value->cuisineName.'</option>';
				}
			?>
			</select>
		</td>
	</tr>	
	
	<tr>
		<td width = "25%" nowrap>Custom URL</td>
		<td width = "75%">
			<input value="<?php echo (isset($RESTAURANT) ? $RESTAURANT->customUrl : '') ?>" class="validate[optional]" type="text" name="customUrl" id="customUrl"/>
		</td>
	<tr>
	<tr>
		<td width = "25%" nowrap>Status</td>
		<td width = "75%">
			<select name="status" id="status"  class="validate[required]">
				<option value="">--Choose Status--</option>
				<option value="active"<?php echo ((isset($RESTAURANT) && ($RESTAURANT->isActive == 1)) ? ' SELECTED' : '')?>>Active</option>
				<option value="inactive"<?php echo ((isset($RESTAURANT) && ($RESTAURANT->isActive == 0)) ? ' SELECTED' : '')?>>In-active</option>
			</select>
		</td>
	<tr>
<?php
	if (!isset($RESTAURANT) ){
?>
	<tr>
		<td colspan = "2">&nbsp;</td>
	<tr>
	<tr>
		<td colspan = "2"><b>Address</b></td>
	<tr>
	<tr>
		<td width = "25%">Street Number</td>
		<td width = "75%">
			<input value="<?php echo (isset($RESTAURANT) ? $RESTAURANT->streetNumber : '') ?>" class="validate[required]" type="text" name="streetNumber" id="streetNumber"/><br />
		</td>
	</tr>
	<tr>
		<td width = "25%">Street Name</td>
		<td width = "75%">
			<input value="<?php echo (isset($RESTAURANT) ? $RESTAURANT->street : '') ?>" class="validate[required]" type="text" name="street" id="street"/><br />
		</td>
	</tr>
	<tr>
		<td width = "25%">City</td>
		<td width = "75%">
			<input value="<?php echo (isset($RESTAURANT) ? $RESTAURANT->city : '') ?>" class="validate[required]" type="text" name="city" id="city"/><br />
		</td>
	</tr>
	<tr>
		<td width = "25%">State</td>
		<td width = "75%">
			<select name="stateId" id="stateId"  class="validate[required]">
			<option value = ''>--State--</option>
			<?php
				foreach($STATES as $key => $value) {
					echo '<option value="'.$value->stateId.'"' . (  ( isset($RESTAURANT) && ( $value->stateId == $RESTAURANT->stateId )  ) ? ' SELECTED' : '' ) . '>'.$value->stateName.'</option>';
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
					echo '<option value="'.$value->countryId.'"' . (  ( isset($RESTAURANT) && ( $value->countryId == $RESTAURANT->countryId )  ) ? ' SELECTED' : '' ) . '>'.$value->countryName.'</option>';
				}
			?>
			</select>
		</td>
	</tr>
	<tr>
		<td width = "25%">Zip</td>
		<td width = "75%">
			<input value="<?php echo (isset($RESTAURANT) ? $RESTAURANT->zipcode : '') ?>" class="validate[required,length[1,6]]" type="text" name="zipcode" id="zipcode" /><br />
		</td>
	</tr>
<?php
	}
?>
	<tr>
		<td width = "25%" colspan = "2">
			<input type = "Submit" name = "btnSubmit" id = "btnSubmit" value = "<?php echo (isset($RESTAURANT)) ? 'Update Restaurant' : 'Add Restaurant' ?>">
			<input type = "hidden" name = "restaurantId" id = "restaurantId" value = "<?php echo (isset($RESTAURANT) ? $RESTAURANT->restaurantId : '') ?>">
		</td>
	</tr>
</table>
</form>

