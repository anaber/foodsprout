<?php
/*
 * Created on Mar 1, 2010
 *
 * Author: Deepak Kumar
 */
?>
<script type="text/javascript">


$(document).ready(function() {
	
	var formValidated = true;
	 
 	function findValueCallback(event, data, formatted) {
		document.getElementById('companyId').value = data[1];
	}
	
	$(":text, textarea").result(findValueCallback).next().click(function() {
		$(this).prev().search();
	});
	
	$("#companyAjax").autocomplete("/company/get_companies_based_on_type", {
		width: 260,
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
			
			displayFailedMessage($alert, "Form validation works...");
			hideMessage($alert, '', '');
			
			var formAction = '';
			var postArray = '';
			var act = '';
			
			var companyId = $('#companyId').val();
			var companyName;
			
			if (isNaN( companyId ) ) {
				companyName = companyId;
				companyId = '';
			}
			
			if ($('#supplierId').val() != '' ) {
				var formAction = '/manufacture/supplier_save_update';
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
				formAction = '/manufacture/supplier_save_add';
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
				alert(data);
				return false;
				/*
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
						$(this).html('Duplicate Supplier...').addClass('messageboxerror').fadeTo(900,1);
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
				*/
			});
			
			
		}
		
		return false; //not to post the  form physically
		
	});
	
});

</script>

<script src="<?php echo base_url()?>js/jquery.autocomplete.frontend.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo base_url()?>css/jquery.autocomplete.frontend.css" type="text/css" />

<form id="supplierForm" method="post">
<table class="formTable">
	<tr>
		<td width = "25%" nowrap>Supplier Type</td>
		<td width = "75%">
			<select name="supplierType" id="supplierType" class="validate[required]">
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
		<td width = "25%" nowrap>Company</td>
		<td width = "75%">
			<input type="text" id="companyAjax" value="<?php echo (isset($SUPPLIER) ? $SUPPLIER->companyName : '') ?>" style="width: 200px;"  class="validate[required]" />
		</td>
	</tr>
	<tr>
		<td width = "25%" colspan = "2">
			<input type = "Submit" name = "btnSubmit" id = "btnSubmit" value = "<?php echo (isset($SUPPLIER)) ? 'Update Supplier' : 'Add Supplier' ?>">
			<input type = "button" name = "btnReset" id = "btnReset" value = "Reset" class = "button">
			
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