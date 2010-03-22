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
			
			if ($('#restaurant_id').val() != '' ) {
				var formAction = '/admincp/restaurant/save_update';
				postArray = {
							  restaurantName:$('#restaurantName').val(),
							  streetNumber:$('#streetNumber').val(),
							  street:$('#street').val(),
							  city: $('#city').val(),
							  stateId:$('#stateId').val(),
							  countryId:$('#countryId').val(),
							  zipcode:$('#zipcode').val(),
							  restauranttypeId:$('#restauranttypeId').val(), 
							  restaurantId: $('#restaurant_id').val()
							};
				act = 'update';		
			} else {
				formAction = '/admincp/restaurant/save_add';
				postArray = { 
							  restaurantName:$('#restaurantName').val(),
							  streetNumber:$('#streetNumber').val(),
							  street:$('#street').val(),
							  city: $('#city').val(),
							  stateId:$('#stateId').val(),
							  countryId:$('#countryId').val(),
							  restauranttypeId:$('#restauranttypeId').val(), 
							  zipcode:$('#zipcode').val()
							};
				act = 'add';
			}
			
			$.post(formAction, postArray,function(data) {
				alert(data);
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
	
	
	$("#btnCancel").click(function(e) {
		//Cancel the link behavior
		e.preventDefault();
		
		document.location='/programs';
	});

});
	
		
</script>


<?php echo anchor('admincp/restaurant', 'List Restaurants'); ?><br /><br />

<div align = "left"><div id="msgbox" style="display:none"></div></div><br /><br />

<form id="restaurantForm" method="post" <?php echo (isset($RESTAURANT)) ? 'action="/admincp/restaurant/save_update"' : 'action="/admincp/restaurant/save_add"' ?>>
<table class="formTable">
	<tr>
		<td width = "25%" nowrap>Restaurant Name</td>
		<td width = "75%">
			<input value="<?php echo (isset($RESTAURANT) ? $RESTAURANT->restaurantName : '') ?>" class="validate[required]" type="text" name="restaurantName" id="restaurantName"/><br />
		</td>
	</tr>
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
		<td width = "25%">Type</td>
		<td width = "75%">
			<select name="restauranttypeId" id="restauranttypeId"  class="validate[required]">
			<option value = ''>--Type--</option>
			<?php
				foreach($RESTAURANTTYPES as $key => $value) {
					echo '<option value="'.$value->restauranttypeId.'"' . (  ( isset($RESTAURANT) && ( $value->restauranttypeId == $RESTAURANT->restauranttypeId )  ) ? ' SELECTED' : '' ) . '>'.$value->restauranttypeName.'</option>';
				}
			?>
			</select>
		</td>
	</tr>
	
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
		<td width = "25%">Zip</td>
		<td width = "75%">
			<input value="<?php echo (isset($RESTAURANT) ? $RESTAURANT->zipcode : '') ?>" class="validate[required,length[1,6]]" type="text" name="zipcode" id="zipcode" /><br />
		</td>
	</tr>
	<tr>
		<td width = "25%" colspan = "2">
			<input type = "Submit" name = "btnSubmit" id = "btnSubmit" value = "<?php echo (isset($RESTAURANT)) ? 'Update Restaurant' : 'Add Restaurant' ?>">
			<input type = "hidden" name = "restaurant_id" id = "restaurant_id" value = "<?php echo (isset($RESTAURANT) ? $RESTAURANT->restaurantId : '') ?>">
		</td>
	</tr>
</table>
</form>

