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
			
			if ($('#farm_id').val() != '' ) {
				var formAction = '/admincp/farm/save_update';
				postArray = {
							  farmName:$('#farm_name').val(),
							  streetAddress:$('#street_address').val(),
							  customUrl: $('#custom_url').val(),
							  stateId:$('#state_id').val(),
							  countryId:$('#country_id').val(),
							  zipcode:$('#zipcode').val(), 
							  farmId: $('#farm_id').val()
							};
				act = 'update';		
			} else {
				formAction = '/admincp/farm/save_add';
				postArray = { 
							  farmName:$('#farm_name').val(),
							  streetAddress:$('#street_address').val(),
							  customUrl: $('#custom_url').val(),
							  stateId:$('#state_id').val(),
							  countryId:$('#country_id').val(),
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
								document.location='/admincp/company';
							});	
						} else if (act == 'update') {
							$(this).html('Updated...').addClass('messageboxok').fadeTo(900,1, function(){
								//redirect to secure page
								document.location='/admincp/farm';
							});
						}

					});
				} else if(data == 'duplicate') {
					//start fading the messagebox 
					$("#msgbox").fadeTo(200,0.1,function() {
						//add message and change the class of the box and start fading
						$(this).html('Duplicate Farm...').addClass('messageboxerror').fadeTo(900,1);
						
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
		
		document.location='/admincp/farm';
	});

});
		
</script>


<?php echo anchor('admincp/farm', 'List Farms'); ?><br /><br />

<div align = "left"><div id="msgbox" style="display:none"></div></div><br /><br />
<form id="farmForm" method="post" action="">
<table class="formTable">
	<tr>
		<td width = "25%">Farm Name</td>
		<td width = "75%">
			<input value="<?php echo (isset($FARM) ? $FARM->farmName : '') ?>" class="validate[required]" type="text" name="farm_name" id="farm_name" /><br />
		</td>
	<tr>
	<tr>
		<td width = "25%" nowrap>Street Address</td>
		<td width = "75%">
			<input value="<?php echo (isset($FARM) ? $FARM->streetAddress : '') ?>" class="validate[required]" type="text" name="street_address" id="street_address" /><br />
		</td>
	<tr>
	<tr>
		<td width = "25%">State</td>
		<td width = "75%">
			<select name="state_id" id="state_id"  class="validate[required]">
			<option value = ''>--State--</option>
			<?php
				foreach($STATES as $key => $value) {
					echo '<option value="'.$value->stateId.'"' . (  ( isset($FARM) && ( $value->stateId == $FARM->stateId )  ) ? ' SELECTED' : '' ) . '>'.$value->stateName.'</option>';
				}
			?>
			</select>
		</td>
	<tr>
	<tr>
		<td width = "25%">Country</td>
		<td width = "75%">
			<select name="country_id" id="country_id"  class="validate[required]">
			<option value = ''>--Country--</option>
			<?php
				foreach($COUNTRIES as $key => $value) {
					echo '<option value="'.$value->countryId.'"' . (  ( isset($FARM) && ( $value->countryId == $FARM->countryId )  ) ? ' SELECTED' : '' ) . '>'.$value->countryName.'</option>';
				}
			?>
			</select>
		</td>
	<tr>
	<tr>
		<td width = "25%">Zip</td>
		<td width = "75%">
			<input value="<?php echo (isset($FARM) ? $FARM->zipcode : '') ?>" class="validate[required,length[1,6]]" type="text" name="zipcode" id="zipcode" /><br />
		</td>
	<tr>
	<tr>
		<td width = "25%">Custom URL</td>
		<td width = "75%">
			<input value="<?php echo (isset($FARM) ? $FARM->customUrl : '') ?>" class="validate[required]" type="text" name="custom_url" id="custom_url" /><br />
		</td>
	<tr>
	<tr>
		<td width = "25%" colspan = "2">
			<input type = "Submit" name = "btnSubmit" id = "btnSubmit" value = "<?php echo (isset($FARM)) ? 'Update Farm' : 'Add Farm' ?>">
			<input type = "hidden" name = "farm_id" id = "farm_id" value = "<?php echo (isset($FARM) ? $FARM->farmId : '') ?>">
		</td>
	<tr>
</table>
</form>