<?php
/*
 * Created on Mar 1, 2010
 *
 * Author: Deepak Kumar
 */
?>
<script>

function resetMenuForm() {
	$('#productName').val('');
	//$('#productTypeId').val('');
	//$('#brand').val('');
	$('#ingredient').val('');
}

formValidated = true;

$(document).ready(function() {
		
		
    // SUCCESS AJAX CALL, replace "success: false," by:     success : function() { callSuccessFunction() },
    $("#productForm").validationEngine({
        scroll:false,
		unbindEngine:false,
		success :  function() {formValidated = true;},
		failure : function() {formValidated = false; }
    });

	$("#productForm").submit(function() {
		
		$("#msgbox").removeClass().addClass('messagebox').text('Validating...').fadeIn(1000);
		
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
			strHasFructose = '0';

            if ($('#productId').val() != '' ) {
                var formAction = '/common/menu_item_save_update';
                postArray = {
                    productName:$('#productName').val(),
                    productTypeId: $('#productTypeId').val(),
                    brand:$('#brand').val(),
                    ingredient:$('#ingredient').val(),
				
                    productId: $('#productId').val(),
						  
                    manufactureId: $('#manufactureId').val(),
                    distributorId: $('#distributorId').val(),
                    restaurantId: $('#restaurantId').val(),
                    restaurantChainId: $('#restaurantChainId').val()
                };
                act = 'update';
            } else {
                formAction = '/common/menu_item_save_add';
                postArray = {
                    productName:$('#productName').val(),
                    productTypeId: $('#productTypeId').val(),
                    brand: '', //$('#brand').val(),
                    upc:'',
                    hasFructose:0,
                    ingredient:$('#ingredient').val(),
						  
                    manufactureId: $('#manufactureId').val(),
                    distributorId: $('#distributorId').val(),
                    restaurantId: $('#restaurantId').val(),
                    restaurantChainId: $('#restaurantChainId').val()
				};
                act = 'add';
			}
			
			$.post(formAction, postArray,function(data) {
				
				if(data=='yes') {
                    
                    if (act == 'add') {
						displayFailedMessage($alert, "Menu item added...");
					} else if (act == 'update') {
						displayFailedMessage($alert, "Menu item updated...");
					}
					hideMessage($alert, '', '');
					$.validationEngine.closePrompt('.formError',true);
					/*
					$("#divAddMenu").hide( toggleDuration, function() {
						$("#addItem").removeClass().addClass('add-item');	
					} );
					*/
					$("#addMenu").removeClass('active');
					$('#divAddMenu').stop(true, false).fadeOut(200);
			
					isMenuFormVisible = false;
					resetMenuForm();
                    
	            } else if(data == 'duplicate') {
	                displayFailedMessage($alert, "Duplicate Menu item...");
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
        	
    	}
		
    	return false; //not to post the  form physically
		
	});

});
		
</script>

<form id="productForm" method="post">
<table class="formTable">
	<tr>
		<td colspan = "2" style="height:5px;"></td>
	</tr>
    <tr>
        <td width = "25%" style="font-size:13px;">Name</td>
        <td width = "75%">
            <input value="<?php echo (isset($PRODUCT) ? $PRODUCT->productName : '') ?>" class="validate[required]" type="text" name="productName" id="productName" style="width: 200px;"/><br />
        </td>
    </tr>
    <?php
    	if ( isset( $MANUFACTURE_ID ) || isset( $DISTRIBUTOR_ID ) ) {
    ?>
    <tr>
        <td width = "25%" nowrap style="font-size:13px;">Product Type</td>
        <td width = "75%">
            <select name="productTypeId" id="productTypeId"  class="validate[required]" style="width: 205px;">
                <option value = ''>--Product Type--</option>
                <?php
                foreach ($PRODUCT_TYPES as $key => $value) {
                    if ($value->productTypeId != 1) {
                    	echo '<option value="' . $value->productTypeId . '"' . ( ( isset($PRODUCT) && ( $value->productTypeId == $PRODUCT->productTypeId ) ) ? ' SELECTED' : '' ) . '>' . $value->productType . '</option>';
                    }
                }
                ?>
            </select>
        </td>
    </tr>
    <?php
    	} else {
    		echo '<input type = "hidden" name = "productTypeId" id = "productTypeId" value = "1">';
    	}
    	/*
    ?>
    <tr>
        <td width = "25%">Brand</td>
        <td width = "75%">
            <input value="<?php echo (isset($PRODUCT) ? $PRODUCT->brand : '') ?>"  type="text" name="brand" id="brand"/><br />
        </td>
    </tr>
    <?php
    	*/
    ?>
    <tr>
        <td width = "25%" style="font-size:13px;">Ingredient</td>
        <td width = "75%">
            <textarea name="ingredient" id="ingredient" class="validate[required]" rows = "3" cols = "30" style="width: 200px;"><?php echo (isset($PRODUCT) ? $PRODUCT->ingredient : '') ?></textarea><br />
        </td>
    </tr>
    <tr>
        <td colspan = "2" align = "right" style = "padding-right:16px;">
            <input type = "Submit" name = "btnSubmit" id = "btnSubmit" value = "<?php echo (isset($PRODUCT)) ? 'Update Menu Item' : 'Add Menu Item' ?>">
            <input type = "hidden" name = "productId" id = "productId" value = "<?php echo (isset($PRODUCT) ? $PRODUCT->productId : '') ?>">

            <input type = "hidden" name = "manufactureId" id = "manufactureId" value = "<?php echo (isset($MANUFACTURE_ID) ? $MANUFACTURE_ID : '') ?>">
            <input type = "hidden" name = "distributorId" id = "distributorId" value = "<?php echo (isset($DISTRIBUTOR_ID) ? $DISTRIBUTOR_ID : '') ?>">
            <input type = "hidden" name = "restaurantId" id = "restaurantId" value = "<?php echo (isset($RESTAURANT_ID) ? $RESTAURANT_ID : '') ?>">
            <input type = "hidden" name = "restaurantChainId" id = "restaurantChainId" value = "<?php echo (isset($RESTAURANT_CHAIN_ID) ? $RESTAURANT_CHAIN_ID : '') ?>">
        </td>
    </tr>
</table>
</form>