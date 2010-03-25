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
	$("#processingForm").validationEngine({
		success :  function() {formValidated = true;},
		failure : function() {formValidated = false; }
	});
	
	
	$("#processingForm").submit(function() {
		
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
			
			if ($('#processingId').val() != '' ) {
				var formAction = '/admincp/processing/save_update';
				postArray = {
							  processingName:$('#processingName').val(),
							  streetNumber:$('#streetNumber').val(),
							  street:$('#street').val(),
							  city: $('#city').val(),
							  stateId:$('#stateId').val(),
							  countryId:$('#countryId').val(),
							  zipcode:$('#zipcode').val(), 
							  processingId: $('#processingId').val()
							};
				act = 'update';		
			} else {
				formAction = '/admincp/processing/save_add';
				postArray = { 
							  processingName:$('#processingName').val(),
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
								document.location='/admincp/processing';
							});	
						} else if (act == 'update') {
							$(this).html('Updated...').addClass('messageboxok').fadeTo(900,1, function(){
								//redirect to secure page
								document.location='/admincp/processing';
							});
						}

					});
				} else if(data == 'duplicate') {
					//start fading the messagebox 
					$("#msgbox").fadeTo(200,0.1,function() {
						//add message and change the class of the box and start fading
						$(this).html('Duplicate Processing...').addClass('messageboxerror').fadeTo(900,1);
						
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
		
		document.location='/admincp/processing';
	});

});
		
</script>

<?php echo anchor('admincp/processing', 'List Processings'); ?><br /><br />

<div align = "left"><div id="msgbox" style="display:none"></div></div><br /><br />

<form id="processingForm" method="post" <?php echo (isset($PROCESSING)) ? 'action="/admincp/processing/save_update"' : 'action="/admincp/processing/save_add"' ?>>
<table class="formTable">
	<tr>
		<td width = "25%" nowrap>Processing Name</td>
		<td width = "75%">
			<input value="<?php echo (isset($PROCESSING) ? $PROCESSING->processingName : '') ?>" class="validate[required]" type="text" name="processingName" id="processingName"/><br />
		</td>
	<tr>
	<tr>
		<td width = "25%">Street Number</td>
		<td width = "75%">
			<input value="<?php echo (isset($PROCESSING) ? $PROCESSING->streetNumber : '') ?>" class="validate[required]" type="text" name="streetNumber" id="streetNumber"/><br />
		</td>
	<tr>
	<tr>
		<td width = "25%">Street Name</td>
		<td width = "75%">
			<input value="<?php echo (isset($PROCESSING) ? $PROCESSING->street : '') ?>" class="validate[required]" type="text" name="street" id="street"/><br />
		</td>
	<tr>
	<tr>
		<td width = "25%">City</td>
		<td width = "75%">
			<input value="<?php echo (isset($PROCESSING) ? $PROCESSING->city : '') ?>" class="validate[required]" type="text" name="city" id="city"/><br />
		</td>
	<tr>
	<tr>
		<td width = "25%">State</td>
		<td width = "75%">
			<select name="stateId" id="stateId"  class="validate[required]">
			<option value = ''>--State--</option>
			<?php
				foreach($STATES as $key => $value) {
					echo '<option value="'.$value->stateId.'"' . (  ( isset($PROCESSING) && ( $value->stateId == $PROCESSING->stateId )  ) ? ' SELECTED' : '' ) . '>'.$value->stateName.'</option>';
				}
			?>
			</select>
		</td>
	<tr>
	<tr>
		<td width = "25%">Country</td>
		<td width = "75%">
			<select name="countryId" id="countryId"  class="validate[required]">
			<option value = ''>--Country--</option>
			<?php
				foreach($COUNTRIES as $key => $value) {
					echo '<option value="'.$value->countryId.'"' . (  ( isset($PROCESSING) && ( $value->countryId == $PROCESSING->countryId )  ) ? ' SELECTED' : '' ) . '>'.$value->countryName.'</option>';
				}
			?>
			</select>
		</td>
	<tr>
	<tr>
		<td width = "25%">Zip</td>
		<td width = "75%">
			<input value="<?php echo (isset($PROCESSING) ? $PROCESSING->zipcode : '') ?>" class="validate[required,length[1,6]]" type="text" name="zipcode" id="zipcode" /><br />
		</td>
	<tr>
	<tr>
		<td width = "25%" colspan = "2">
			<input type = "Submit" name = "btnSubmit" id = "btnSubmit" value = "<?php echo (isset($PROCESSING)) ? 'Update Processing' : 'Add Processing' ?>">
			<input type = "hidden" name = "processingId" id = "processingId" value = "<?php echo (isset($PROCESSING) ? $PROCESSING->processingId : '') ?>">
		</td>
	<tr>
</table>
</form>

