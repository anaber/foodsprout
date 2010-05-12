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
		documentLocation = '/admincp/manufacture';
<?php
	} else if ( isset($FARM_ID) ) {
?>
		documentLocation = '/admincp/farm';
<?php
	} else if ( isset($RESTAURANT_ID) ) {
?>
		documentLocation = '/admincp/restaurant';
<?php
	} else if ( isset($DISTRIBUTOR_ID) ) {
?>
		documentLocation = '/admincp/distributor';
<?php
	} 
?>
formValidated = true;

$(document).ready(function() {
	
	
	$("#supplierType").change(function () {
		supplierType = $("#supplierType").val();
		
		if (supplierType == '') {
			$('#companyId')
			    .find('option')
			    .remove();
			$('#companyId').append($("<option></option>").attr("value",'').text('--Existing Companies--'));
			
		} else {
			
			var formAction = '/admincp/company/get_companies_based_on_type';
			postArray = { companyType:supplierType };

			$.post(formAction, postArray, function(data) {
				
				$('#companyId')
				    .find('option')
				    .remove();
				$('#companyId').append($("<option></option>").attr("value",'').text('--Existing Companies--'));
				
				$.each(data.results, function(i, a) {
					$('#companyId').append($("<option></option>").attr("value",a.id).text(a.name));
				});
			},
			"json");
		}
		
	});
	
	
	// SUCCESS AJAX CALL, replace "success: false," by:     success : function() { callSuccessFunction() }, 
	$("#supplierForm").validationEngine({
		success :  function() {formValidated = true;},
		failure : function() {formValidated = false; }
	});
	
	$("#supplierForm").submit(function() {
		
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
			
			if ($('#supplierId').val() != '' ) {
				var formAction = '/admincp/manufacture/supplier_save_update';
				postArray = {
							  supplierType:$('#supplierType').val(),
							  companyId:$('#companyId').val(),
							  companyName:$('#companyName').val(),
							  
							  manufactureId: $('#manufactureId').val(),
							  farmId: $('#farmId').val(),
							  restaurantId: $('#restaurantId').val(),
							  distributorId: $('#distributorId').val(),
							   
							  supplierId: $('#supplierId').val()
							};
				act = 'update';		
			} else {
				formAction = '/admincp/manufacture/supplier_save_add';
				postArray = { 
							  supplierType:$('#supplierType').val(),
							  companyId:$('#companyId').val(),
							  companyName:$('#companyName').val(),
							  
							  manufactureId: $('#manufactureId').val(),
							  farmId: $('#farmId').val(),
							  restaurantId: $('#restaurantId').val(),
							  distributorId: $('#distributorId').val()
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
								document.location = documentLocation;
							});	
						} else if (act == 'update') {
							$(this).html('Updated...').addClass('messageboxok').fadeTo(900,1, function(){
								//redirect to secure page
								document.location = documentLocation;
							});
						}
					});
				} else if(data == 'no_name') {
					//start fading the messagebox 
					$("#msgbox").fadeTo(200,0.1,function() {
						//add message and change the class of the box and start fading
						$(this).html('Either select existing company or enter new supplier name...').addClass('messageboxerror').fadeTo(900,1);
						
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
	var companyId;
<?php
	if (isset($SUPPLIER)) {
?>
		reinitializeCompanyList();
		companyId = <?php echo $SUPPLIER->companyId; ?>;
		
		function reinitializeCompanyList() {
			var formAction = '/admincp/company/get_companies_based_on_type';
			postArray = { companyType:'<?php echo $SUPPLIER->supplierType; ?>' };
	
			$.post(formAction, postArray, function(data) {
				
				$('#companyId')
				    .find('option')
				    .remove();
				$('#companyId').append($("<option></option>").attr("value",'').text('--Existing Companies--'));
				
				$.each(data.results, function(i, a) {
					if (companyId != '' && companyId == a.id ) {
						$('#companyId').append($("<option></option>").attr("value",a.id).text(a.name).attr("selected",true) );
					} else {
						$('#companyId').append($("<option></option>").attr("value",a.id).text(a.name) );
					}
				});
			},
			"json");
		}
<?php	
	}
?>
	
});
		
</script>

<div align = "left"><div id="msgbox" style="display:none"></div></div><br /><br />
<?php
	
?>
<form id="supplierForm" method="post" <?php echo (isset($MANUFACTURE)) ? 'action="/admincp/manufacture/supplier_save_update"' : 'action="/admincp/manufacture/supplier_save_add"' ?>>
<table class="formTable">
	<tr>
		<td width = "25%" nowrap>Supplier Type</td>
		<td width = "75%">
			<select name="supplierType" id="supplierType" class="validate[required]">
			<option value = ''>--Supplier Type--</option>
			<?php
				foreach($SUPPLIER_TYPES as $key => $value) {
					echo '<option value="'.$key.'"' . (  ( isset($SUPPLIER) && ( $key == $SUPPLIER->supplierType )  ) ? ' SELECTED' : '' ) . '>' . $value . '</option>';
				}
			?>
			</select>
		</td>
	<tr>
	
	<tr>
		<td width = "25%" nowrap>Company</td>
		<td width = "75%">
			<select name="companyId" id="companyId" class="validate[optional]">
			<option value = ''>--Existing Companies--</option>
			</select>
		</td>
	<tr>
	<tr>
		<td width = "25%" nowrap>New Supplier</td>
		<td width = "75%">
			<input value="" class="validate[optional]" type="text" name="companyName" id="companyName"/><br />
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
			<input type = "Submit" name = "btnSubmit" id = "btnSubmit" value = "<?php echo (isset($SUPPLIER)) ? 'Update Supplier' : 'Add Supplier' ?>">
			
			<input type = "hidden" name = "supplierId" id = "supplierId" value = "<?php echo (isset($SUPPLIER) ? $SUPPLIER->supplierId : '') ?>">
			
			<input type = "hidden" name = "manufactureId" id = "manufactureId" value = "<?php echo (isset($MANUFACTURE_ID) ? $MANUFACTURE_ID : '') ?>">
			<input type = "hidden" name = "farmId" id = "farmId" value = "<?php echo (isset($FARM_ID) ? $FARM_ID : '') ?>">
			<input type = "hidden" name = "restaurantId" id = "restaurantId" value = "<?php echo (isset($RESTAURANT_ID) ? $RESTAURANT_ID : '') ?>">
			<input type = "hidden" name = "distributorId" id = "distributorId" value = "<?php echo (isset($DISTRIBUTOR_ID) ? $DISTRIBUTOR_ID : '') ?>">			
		</td>
	<tr>
</table>
</form>
