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
			
			if ($('#farmId').val() != '' ) {
				var formAction = '/admincp/farm/save_update';
				postArray = {
							  companyId:$('#companyId').val(),
							  farmName:$('#farmName').val(),
							  customUrl:$('#customUrl').val(),
							  farmTypeId:$('#farmTypeId').val(),
							  isActive:$('#status').val(),
							  							 
							  farmId: $('#farmId').val()
							};
				act = 'update';		
			} else {
				formAction = '/admincp/farm/save_add';
				postArray = { 
							  companyId:$('#companyId').val(),
							  farmName:$('#farmName').val(),
							  customUrl:$('#customUrl').val(),
							  farmTypeId:$('#farmTypeId').val(),
							  isActive:$('#status').val(),
							  address:$('#address').val(),
							  city: $('#city').val(),
							  stateId:$('#stateId').val(),
							  countryId:$('#countryId').val(),
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
								document.location='/admincp/farm';
							});	
						} else if (act == 'update') {
							$(this).html('Updated...').addClass('messageboxok').fadeTo(900,1, function(){
								//redirect to secure page
								document.location='/admincp/farm';
							});
						}

					});
				} else if(data == 'no_name') {
					//start fading the messagebox 
					$("#msgbox").fadeTo(200,0.1,function() {
						//add message and change the class of the box and start fading
						$(this).html('Either select company or enter farm name...').addClass('messageboxerror').fadeTo(900,1);
						
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

});
		
</script>

<?php echo anchor('admincp/farm', 'List Farms'); ?><br /><br />

<div align = "left"><div id="msgbox" style="display:none"></div></div><br /><br />

<form id="farmForm" method="post" <?php echo (isset($FARM)) ? 'action="/admincp/farm/save_update"' : 'action="/admincp/farm/save_add"' ?>>
<table class="formTable">
	<tr>
		<td width = "25%" nowrap>Company</td>
		<td width = "75%">
			<select name="companyId" id="companyId"  class="validate[optional]">
			<option value = ''>--Existing Companies--</option>
			<?php
				foreach($COMPANIES as $key => $value) {
					echo '<option value="'.$value->companyId.'"' . (  ( isset($FARM) && ( $value->companyId == $FARM->companyId )  ) ? ' SELECTED' : '' ) . '>'.$value->companyName.'</option>';
				}
			?>
			</select>
		</td>
	<tr>
	<tr>
		<td width = "25%" nowrap>Farm Name</td>
		<td width = "75%">
			<input value="<?php echo (isset($FARM) ? $FARM->farmName : '') ?>" class="validate[optional]" type="text" name="farmName" id="farmName"/><br />
		</td>
	<tr>
	<tr>
		<td colspan = "2" style = "font-size:10px;">
			<ul>
				<li>Existing companies selected and name entered, farm will be treated as the subsidery of selected company but with overridden name.</li>
				<li>Existing companies selected and NO name entered, farm name will be considered as of company name.</li>
				<li>No company selected from the list above and name entered, new comapny and farm will be added.</li>
			</ul>
		</td>
	<tr>
	<tr>
		<td width = "25%">Farm Type</td>
		<td width = "75%">
			<select name="farmTypeId" id="farmTypeId"  class="validate[required]">
			<option value = ''>--Farm Type--</option>
			<?php
				foreach($FARM_TYPES as $key => $value) {
					echo '<option value="'.$value->farmTypeId.'"' . (  ( isset($FARM) && ( $value->farmTypeId == $FARM->farmTypeId )  ) ? ' SELECTED' : '' ) . '>'.$value->farmType.'</option>';
				}
			?>
			</select>
		</td>
	<tr>
	<tr>
		<td width = "25%" nowrap>Custom URL</td>
		<td width = "75%">
			<input value="<?php echo (isset($FARM) ? $FARM->customUrl : '') ?>" class="validate[optional]" type="text" name="customUrl" id="customUrl"/>
		</td>
	<tr>
	<tr>
		<td width = "25%" nowrap>Status</td>
		<td width = "75%">
			<select name="status" id="status"  class="validate[required]">
				<option value="">--Choose Status--</option>
				<option value="active"<?php echo ((isset($FARM) && ($FARM->isActive == 1)) ? ' SELECTED' : '')?>>Active</option>
				<option value="inactive"<?php echo ((isset($FARM) && ($FARM->isActive == 0)) ? ' SELECTED' : '')?>>In-active</option>
			</select>
		</td>
	<tr>
<?php
	if (!isset($FARM) ){
?>
	<tr>
		<td colspan = "2">&nbsp;</td>
	<tr>
	<tr>
		<td colspan = "2"><b>Address</b></td>
	<tr>
	<tr>
		<td width = "25%">Address</td>
		<td width = "75%">
			<input value="<?php echo (isset($FARM) ? $FARM->address : '') ?>" class="validate[required]" type="text" name="address" id="address"/><br />
		</td>
	<tr>
	<tr>
		<td width = "25%">City</td>
		<td width = "75%">
			<input value="<?php echo (isset($FARM) ? $FARM->city : '') ?>" class="validate[required]" type="text" name="city" id="city"/><br />
		</td>
	<tr>
	<tr>
		<td width = "25%">State</td>
		<td width = "75%">
			<select name="stateId" id="stateId"  class="validate[required]">
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
			<select name="countryId" id="countryId"  class="validate[required]">
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
<?php
	}
?>
	<tr>
		<td width = "25%" colspan = "2">
			<input type = "Submit" name = "btnSubmit" id = "btnSubmit" value = "<?php echo (isset($FARM)) ? 'Update Farm' : 'Add Farm' ?>">
			<input type = "hidden" name = "farmId" id = "farmId" value = "<?php echo (isset($FARM) ? $FARM->farmId : '') ?>">
		</td>
	<tr>
</table>
</form>

