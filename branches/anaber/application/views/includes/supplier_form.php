<?php
/*
 * Created on Mar 1, 2010
 *
 * Author: Deepak Kumar
 */
?>
<script type="text/javascript">

function resetSupplierForm() {
	$('#companyId').val('');
	$('#companyName').val('');
	$('#companyAjax').val('');
	$('#supplierType').val('');
}
	
$(document).ready(function() {
	resetSupplierForm();
 	function findValueCallback(event, data, formatted) {
		document.getElementById('companyId').value = data[1];
	}
	
	$(":text, textarea").result(findValueCallback).next().click(function() {
		$(this).prev().search();
	});
	
	$("#companyAjax").autocomplete("/company/get_companies_based_on_type", {
		width: 203,
		selectFirst: false,
		cacheLength:0,
		extraParams: {
	       supplierType: function() { return $("#supplierType").val(); }
	   	}
	});
	
	
	$("#companyAjax").result(function(event, data, formatted) {
		if (data)
			$(this).parent().next().find("input").val(data[1]);
	});
	
	
	$("#clear").click(function() {
		$(":input").unautocomplete();
	});
	
	$('#companyAjax').keyup(function() {
		companyName = $("#companyAjax").val();
		if (companyName == '') {
			$('#companyId').val('');
		}
	});
	
	var formValidated = true;
	
	// SUCCESS AJAX CALL, replace "success: false," by:     success : function() { callSuccessFunction() }, 
	
	$("#supplierForm").validationEngine({
		scroll:false,
		unbindEngine:false,
		success :  function() {formValidated = true;},
		failure : function() {formValidated = false; }
	});
	
	$("#supplierForm").submit(function() {
		
		if (formValidated == false) {
			// Don't post the form.
			//displayFailedMessage($alert, "Form validation failed...");
			//hideMessage($alert, '', '');
		} else {
			
			var $alert = $('#alert');
			displayProcessingMessage($alert, "Processing...");
			
			var formAction = '';
			var postArray = '';
			var act = '';
			
			var companyId = $('#companyId').val();
			var companyName;
			
			if (isNaN( companyId ) ) {
				companyName = companyId;
				companyId = '';
			} else {
				companyName = '';
			}
			
			if (companyName != '' || companyId != '') {
				
				if ($('#supplierId').val() != '' ) {
					var formAction = '/common/supplier_save_update';
					postArray = {
								  supplierType:$('#supplierType').val(),
								  companyId:companyId,
								  companyName:companyName,
								  
								  manufactureId: $('#manufactureId').val(),
								  farmId: $('#farmId').val(),
								  restaurantId: $('#restaurantId').val(),
								  distributorId: $('#distributorId').val(),
								  restaurantChainId: $('#restaurantChainId').val(),
								  farmersMarketId: $('#farmersMarketId').val(),
								   
								  supplierId: $('#supplierId').val()
								};
					act = 'update';		
				} else {
					formAction = '/common/supplier_save_add';
					postArray = { 
								  supplierType:$('#supplierType').val(),
								  companyId:companyId,
								  companyName:companyName,
								  
								  manufactureId: $('#manufactureId').val(),
								  farmId: $('#farmId').val(),
								  restaurantId: $('#restaurantId').val(),
								  distributorId: $('#distributorId').val(),
								  restaurantChainId: $('#restaurantChainId').val(),
								  farmersMarketId: $('#farmersMarketId').val()
								};
					act = 'add';
				}
				
				$.post(formAction, postArray,function(data) {
					
					if(data=='yes') {
						if (act == 'add') {
							displayFailedMessage($alert, "Supplier added...");
						} else if (act == 'update') {
							displayFailedMessage($alert, "Supplier updated...");
						}
						hideMessage($alert, '', '');
						$.validationEngine.closePrompt('.formError',true);
						/*
						$("#divAddSupplier").hide( toggleDuration, function() {
							$("#addItem").removeClass().addClass('add-item');	
						} );
						*/
						$("#addSupplier").removeClass('active');
						$('#divAddSupplier').stop(true, false).fadeOut(200);
						
						isSupplierFormVisible = false;
						resetSupplierForm();
						
					} else if(data == 'duplicate_company') {
						displayFailedMessage($alert, "Duplicate Company...");
						hideMessage($alert, '', '');
					} else if(data == 'duplicate') {
						displayFailedMessage($alert, "Duplicate Supplier...");
						hideMessage($alert, '', '');
					} else {
						if (act == 'add') {
							displayFailedMessage($alert, "Not added...");
						} else if (act == 'update') {
							displayFailedMessage($alert, "Not updated...");
						}
						hideMessage($alert, '', '');
					}
				});
			} else {
				displayFailedMessage($alert, "Company not selected...");
				hideMessage($alert, '', '');
			}
			
		}
		
		return false; //not to post the  form physically
		
	});
	
});

</script>

<script src="<?php echo base_url()?>js/jquery.autocomplete.frontend.js" type="text/javascript"></script>

<form id="supplierForm" method="post">
<table class="formTable">
	<tr>
		<td colspan = "2" style="height:5px;"></td>
	</tr>
	
	<tr>
		<td width = "25%" nowrap style="font-size:13px;">Supplier Type</td>
		<td width = "75%">
			<select name="supplierType" id="supplierType" class="validate[required]" style="width: 205px;">
			<option value = ''>--Supplier Type--</option>
			<?php
				foreach ($SUPPLIER_TYPES_2[$TABLE] as $key => $value) {
					echo '<option value="'.$key.'"' . (  ( isset($SUPPLIER) && ( $key == $SUPPLIER->supplierType )  ) ? ' SELECTED' : '' ) . '>' . $value . '</option>';
				}
			?>
			</select>
		</td>
	</tr>
	
	<tr>
		<td width = "25%" nowrap style="font-size:13px;">Company</td>
		<td width = "75%">
			<input type="text" id="companyAjax" value="<?php echo (isset($SUPPLIER) ? $SUPPLIER->companyName : '') ?>" style="width: 200px;"  class="validate[required]" />
		</td>
	</tr>
	<tr>
		<td colspan = "2" align = "right" style = "padding-right:16px;">
			<input type = "Submit" name = "btnSubmit" id = "btnSubmit" value = "<?php echo (isset($SUPPLIER)) ? 'Update Supplier' : 'Add Supplier' ?>">
			
			<input type = "hidden" name = "supplierId" id = "supplierId" value = "<?php echo (isset($SUPPLIER) ? $SUPPLIER->supplierId : '') ?>">
			
			<input type = "hidden" name = "manufactureId" id = "manufactureId" value = "<?php echo (isset($MANUFACTURE_ID) ? $MANUFACTURE_ID : '') ?>">
			<input type = "hidden" name = "farmId" id = "farmId" value = "<?php echo (isset($FARM_ID) ? $FARM_ID : '') ?>">
			<input type = "hidden" name = "restaurantId" id = "restaurantId" value = "<?php echo (isset($RESTAURANT_ID) ? $RESTAURANT_ID : '') ?>">
			<input type = "hidden" name = "distributorId" id = "distributorId" value = "<?php echo (isset($DISTRIBUTOR_ID) ? $DISTRIBUTOR_ID : '') ?>">
			<input type = "hidden" name = "restaurantChainId" id = "restaurantChainId" value = "<?php echo (isset($RESTAURANT_CHAIN_ID) ? $RESTAURANT_CHAIN_ID : '') ?>">
			<input type = "hidden" name = "farmersMarketId" id = "farmersMarketId" value = "<?php echo (isset($FARMERS_MARKET_ID) ? $FARMERS_MARKET_ID : '') ?>">
			<input type = "hidden" name = "companyId" id = "companyId" value = "<?php echo (isset($SUPPLIER) ? $SUPPLIER->companyId : '') ?>">			
		</td>
	</tr>
</table>
</form>