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
	$("#manufactureForm").validationEngine({
		success :  function() {formValidated = true;},
		failure : function() {formValidated = false; }
	});
	
	
	$("#manufactureForm").submit(function() {
		
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
			
			if ($('#manufactureId').val() != '' ) {
				var formAction = '/admincp/manufacture/save_update';
				postArray = {
							  companyId:$('#companyId').val(),
							  manufactureName:$('#manufactureName').val(),
							  customUrl:$('#customUrl').val(),
							  manufactureTypeId:$('#manufactureTypeId').val(),
							  isActive:$('#status').val(),
							  /*
							  streetNumber:$('#streetNumber').val(),
							  street:$('#street').val(),
							  city: $('#city').val(),
							  stateId:$('#stateId').val(),
							  countryId:$('#countryId').val(),
							  zipcode:$('#zipcode').val(),
							  */ 
							  manufactureId: $('#manufactureId').val()
							};
				act = 'update';		
			} else {
				formAction = '/admincp/manufacture/save_add';
				postArray = { 
							  companyId:$('#companyId').val(),
							  manufactureName:$('#manufactureName').val(),
							  customUrl:$('#customUrl').val(),
							  manufactureTypeId:$('#manufactureTypeId').val(),
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
				alert(data);
				if(data=='yes') {
					//start fading the messagebox
					$("#msgbox").fadeTo(200,0.1,function() {
						//add message and change the class of the box and start fading
						if (act == 'add') {
							$(this).html('Added...').addClass('messageboxok').fadeTo(900,1, function(){
								//redirect to secure page
								document.location='/admincp/manufacture';
							});	
						} else if (act == 'update') {
							$(this).html('Updated...').addClass('messageboxok').fadeTo(900,1, function(){
								//redirect to secure page
								document.location='/admincp/manufacture';
							});
						}

					});
				} else if(data == 'no_name') {
					//start fading the messagebox 
					$("#msgbox").fadeTo(200,0.1,function() {
						//add message and change the class of the box and start fading
						$(this).html('Either select company or enter manufacture name...').addClass('messageboxerror').fadeTo(900,1);
						
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
						$(this).html('Duplicate Manufacture...').addClass('messageboxerror').fadeTo(900,1);
						
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
		
		document.location='/admincp/manufacture';
	});

});
		
</script>

<div align = "left"><div id="msgbox" style="display:none"></div></div><br /><br />
<?php
	
?>
<form id="supplierForm" method="post" <?php echo (isset($MANUFACTURE)) ? 'action="/admincp/manufacture/save_update"' : 'action="/admincp/manufacture/save_add"' ?>>
<table class="formTable">
	<tr>
		<td width = "25%" nowrap>Supplier Type</td>
		<td width = "75%">
			<select name="supplierType" id="supplierType"  class="validate[required]">
			<option value = ''>--Supplier Type--</option>
			<?php
				foreach($SUPPLIER_TYPE as $key => $value) {
					echo '<option value="'.$key.'"' . (  ( isset($SUPPLIER) && ( $key == $SUPPLIER->supplierType )  ) ? ' SELECTED' : '' ) . '>' . $value . '</option>';
				}
			?>
			</select>
		</td>
	<tr>
	
	<tr>
		<td width = "25%" nowrap>Company</td>
		<td width = "75%">
			<select name="companyId" id="companyId"  class="validate[optional]">
			<option value = ''>--Existing Companies--</option>
			<?php
				foreach($COMPANIES as $key => $value) {
					echo '<option value="'.$value->companyId.'"' . (  ( isset($MANUFACTURE) && ( $value->companyId == $MANUFACTURE->companyId )  ) ? ' SELECTED' : '' ) . '>'.$value->companyName.'</option>';
				}
			?>
			</select>
		</td>
	<tr>
	<tr>
		<td width = "25%" nowrap>New Supplier</td>
		<td width = "75%">
			<input value="" class="validate[optional]" type="text" name="supplierName" id="supplierName"/><br />
		</td>
	<tr>
	<tr>
		<td colspan = "2" style = "font-size:10px;">
			<ul>
				<li>Select either existing supplier or enter new supplier</li>
				<li>If you do not want to use any of previous records, add new supplier from here.</li>
				<li>Based on the type of supplier selected from first dropdown, new manufacture, distributor, farm, restaurant (and company) will be added.</li>
				<li>Records will be added only if it is unique.</li>
			</ul>
		</td>
	<tr>
	<tr>
		<td width = "25%" colspan = "2">
			<input type = "Submit" name = "btnSubmit" id = "btnSubmit" value = "<?php echo (isset($MANUFACTURE)) ? 'Update Manufacture' : 'Add Manufacture' ?>">
			<input type = "hidden" name = "manufactureId" id = "manufactureId" value = "<?php echo (isset($MANUFACTURE) ? $MANUFACTURE->manufactureId : '') ?>">
		</td>
	<tr>
</table>
</form>

