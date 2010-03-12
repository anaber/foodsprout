<?php
/*
 * Created on Mar 1, 2010
 *
 * Author: Deepak Kumar
 */
?>
<script>

$(document).ready(function() {
	
	formValidated = true;
	
	// SUCCESS AJAX CALL, replace "success: false," by:     success : function() { callSuccessFunction() }, 
	$("#companyForm").validationEngine({
		success :  function() {formValidated = true;},
		failure : function() {formValidated = false; }
	});
	
	
	$("#companyForm").submit(function() {
		
		$("#msgbox").removeClass().addClass('messagebox').text('Validating...').fadeIn(1000);
		
		alert(formValidated);
		
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
			
			if ($('#company_id').val() != '' ) {
				var formAction = '/admincp/company/save_update';
				postArray = {
							  companyName:$('#company_name').val(),
							  streetAddress:$('#street_address').val(),
							  city: $('#city').val(),
							  stateId:$('#state_id').val(),
							  countryId:$('#country_id').val(),
							  zipcode:$('#zipcode').val(), 
							  companyId: $('#company_id').val()
							};
				act = 'update';		
			} else {
				formAction = '/admincp/company/save_add';
				postArray = { 
							  companyName:$('#company_name').val(),
							  streetAddress:$('#street_address').val(),
							  city: $('#city').val(),
							  stateId:$('#state_id').val(),
							  countryId:$('#country_id').val(),
							  zipcode:$('#zipcode').val()
							};
				act = 'add';
			}
			
			$.post(formAction, postArray,function(data) {
				alert(data);
				return false;
				
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
								document.location='/admincp/company';
							});
						}

					});
				} else if(data == 'duplicate') {
					//start fading the messagebox 
					$("#msgbox").fadeTo(200,0.1,function() {
						//add message and change the class of the box and start fading
						$(this).html('Duplicate Company...').addClass('messageboxerror').fadeTo(900,1);
						
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
	});	
	
	
	$("#btnCancel").click(function(e) {
		//Cancel the link behavior
		e.preventDefault();
		
		document.location='/programs';
	
	});

});
	
		
</script>


<?php echo anchor('admincp/company', 'List Companies'); ?><br /><br />

<div align = "left"><div id="msgbox" style="display:none"></div></div><br /><br />
<table width = "50%" border = "1" cellpadding = "5" cellspacing = "0">
	<form id="companyForm" method="post" action="">
	<tr>
		<td width = "25%">Company Name</td>
		<td width = "75%">
			<input value="<?php echo (isset($COMPANY) ? $COMPANY->companyName : '') ?>" class="validate[required]" type="text" name="company_name" id="company_name" size = "40" /><br />
		</td>
	<tr>
	<tr>
		<td width = "25%">Street Address</td>
		<td width = "75%">
			<input value="<?php echo (isset($COMPANY) ? $COMPANY->streetAddress : '') ?>" class="validate[required]" type="text" name="street_address" id="street_address" size = "40" /><br />
		</td>
	<tr>
	<tr>
		<td width = "25%">City</td>
		<td width = "75%">
			<input value="<?php echo (isset($COMPANY) ? $COMPANY->city : '') ?>" class="validate[required]" type="text" name="city" id="city" size = "40" /><br />
		</td>
	<tr>
	<tr>
		<td width = "25%">State</td>
		<td width = "75%">
			<select name="state_id" id="state_id"  class="validate[required]">
			<option value = ''>--State--</option>
			<?php
				foreach($STATES as $key => $value) {
					echo '<option value="'.$value->stateId.'"' . (  ( isset($COMPANY) && (in_array($value->stateId, $COMPANY->stateId) )  ) ? ' SELECTED' : '' ) . '>'.$value->stateName.'</option>';
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
					echo '<option value="'.$value->countryId.'"' . (  ( isset($COMPANY) && (in_array($value->countryId, $COMPANY->countryId) )  ) ? ' SELECTED' : '' ) . '>'.$value->countryName.'</option>';
				}
			?>
			</select>
		</td>
	<tr>
	<tr>
		<td width = "25%">Zip</td>
		<td width = "75%">
			<input value="<?php echo (isset($COMPANY) ? $COMPANY->zipcode : '') ?>" class="validate[required,length[1,6]]" type="text" name="zipcode" id="zipcode" size = "40" /><br />
		</td>
	<tr>
	<tr>
		<td width = "25%" colspan = "2">
			<input type = "Submit" name = "btnSubmit" id = "btnSubmit">
			<input type = "hidden" name = "company_id" id = "company_id" value = "<?php echo (isset($COMPANY) ? $COMPANY->companyId : '') ?>">
		</td>
	<tr>
	</form>
</table>
