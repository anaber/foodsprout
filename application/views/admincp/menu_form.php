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
	if ( isset($RESTAURANT_ID) ) {
?>
		documentLocation = '/admincp/restaurant/add_menu_item/<?php echo $RESTAURANT_ID; ?>';
<?php
	} else if ( isset($RESTAURANT_CHAIN_ID) ) {
?>
		documentLocation = '/admincp/restaurantchain';
<?php
	} else if ( isset($MANUFACTURE_ID) ) {
?>
		documentLocation = '/admincp/manufacture';
<?php
	}
	
?>
formValidated = true;

$(document).ready(function() {
	
	// SUCCESS AJAX CALL, replace "success: false," by:     success : function() { callSuccessFunction() }, 
	$("#productForm").validationEngine({
		success :  function() {formValidated = true;},
		failure : function() {formValidated = false; }
	});
	
	
	$("#productForm").submit(function() {
		
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
			
			if ($('#productId').val() != '' ) {
				var formAction = '/admincp/restaurantchain/menu_item_save_update';
				postArray = {
							  productName:$('#productName').val(),
							  productTypeId: $('#productTypeId').val(),
							  brand:$('#brand').val(),
							  status:$('#status').val(),
							  ingredient:$('#ingredient').val(),
							  
							  productId: $('#productId').val(),
							  
							  manufactureId: $('#manufactureId').val(),
							  restaurantId: $('#restaurantId').val(),
							  restaurantChainId: $('#restaurantChainId').val()
							};
				act = 'update';		
			} else {
				formAction = '/admincp/restaurantchain/menu_item_save_add';
				postArray = { 
							  productName:$('#productName').val(),
							  productTypeId: $('#productTypeId').val(),
							  brand:$('#brand').val(),
							  status:$('#status').val(),
							  ingredient:$('#ingredient').val(),
							  
							  manufactureId: $('#manufactureId').val(),
							  restaurantId: $('#restaurantId').val(),
							  restaurantChainId: $('#restaurantChainId').val()
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
								document.location = documentLocation;
							});	
						} else if (act == 'update') {
							$(this).html('Updated...').addClass('messageboxok').fadeTo(900,1, function(){
								//redirect to secure page
								document.location = documentLocation;
							});
						}
					});
				} else if(data == 'duplicate') {
					//start fading the messagebox 
					$("#msgbox").fadeTo(200,0.1,function() {
						//add message and change the class of the box and start fading
						$(this).html('Duplicate Menu item...').addClass('messageboxerror').fadeTo(900,1);
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

<div align = "left"><div id="msgbox" style="display:none"></div></div><br /><br />
<?php
	//print_r_pre($this->session->userdata);
?>
<form id="productForm" method="post" <?php echo (isset($PRODUCT)) ? 'action="/admincp/address/address_save_update"' : 'action="/admincp/manufacture/address_save_add"' ?>>
<table class="formTable">

	<tr>
		<td colspan = "2"><b>Menu Item</b></td>
	<tr>
	<tr>
		<td width = "25%">Name</td>
		<td width = "75%">
			<input value="<?php echo (isset($PRODUCT) ? $PRODUCT->productName : '') ?>" class="validate[required]" type="text" name="productName" id="productName"/><br />
		</td>
	<tr>
	<tr>
		<td width = "25%">Product Type</td>
		<td width = "75%">
			<select name="productTypeId" id="productTypeId"  class="validate[required]">
			<option value = ''>--Product Type--</option>
			<?php
				foreach($PRODUCT_TYPES as $key => $value) {
					echo '<option value="'.$value->productTypeId.'"' . (  ( isset($PRODUCT) && ( $value->productTypeId == $PRODUCT->productTypeId )  ) ? ' SELECTED' : '' ) . '>'.$value->productType.'</option>';
				}
			?>
			</select>
		</td>
	<tr>
	<tr>
		<td width = "25%">Brand</td>
		<td width = "75%">
			<input value="<?php echo (isset($PRODUCT) ? $PRODUCT->brand : '') ?>" class="validate[required]" type="text" name="brand" id="brand"/><br />
		</td>
	<tr>
	<tr>
		<td width = "25%" nowrap>Status</td>
		<td width = "75%">
			<select name="status" id="status"  class="validate[required]">
				<option value="">--Status--</option>
				<option value="live"<?php echo ((isset($PRODUCT) && ($PRODUCT->status == 'live')) ? ' SELECTED' : '')?>>Live</option>
				<option value="queue"<?php echo ((isset($PRODUCT) && ($PRODUCT->status == 'queue')) ? ' SELECTED' : '')?>>Queue</option>
			</select>
		</td>
	<tr>
	<tr>
		<td width = "25%">Ingredient</td>
		<td width = "75%">
			<textarea name="ingredient" id="ingredient" class="validate[required]" rows = "5" cols = "30"><?php echo (isset($PRODUCT) ? $PRODUCT->ingredient : '') ?></textarea><br />
		</td>
	<tr>
	
	
<?php
	
?>
	<tr>
		<td width = "25%" colspan = "2">
			<input type = "Submit" name = "btnSubmit" id = "btnSubmit" value = "<?php echo (isset($PRODUCT)) ? 'Update Menu Item' : 'Add Menu Item' ?>">
			<input type = "hidden" name = "productId" id = "productId" value = "<?php echo (isset($PRODUCT) ? $PRODUCT->productId : '') ?>">
			
			<input type = "hidden" name = "manufactureId" id = "manufactureId" value = "<?php echo (isset($MANUFACTURE_ID) ? $MANUFACTURE_ID : '') ?>">
			<input type = "hidden" name = "restaurantId" id = "restaurantId" value = "<?php echo (isset($RESTAURANT_ID) ? $RESTAURANT_ID : '') ?>">
			<input type = "hidden" name = "restaurantChainId" id = "restaurantChainId" value = "<?php echo (isset($RESTAURANT_CHAIN_ID) ? $RESTAURANT_CHAIN_ID : '') ?>">
		</td>
	<tr>
</table>
</form>

<table cellpadding="3" cellspacing="0" border="0" id="tbllist" width = "90%">
	<tr>
		<th>Id</th>
		<th>Menu Item</th>
		<th>Ingredients</th>
	</tr>
<?php
	$controller = $this->uri->segment(2);
	$i = 0;
	foreach($PRODUCTS as $product) :
		$i++;
		echo '<tr class="d'.($i & 1).'">';
		echo '	<td>'.anchor('/admincp/'.$controller.'/update_menu_item/'.$product->productId, $product->productId).'</td>';
		echo '	<td>'.anchor('/admincp/'.$controller.'/update_menu_item/'.$product->productId, $product->productName).'</td>';
		echo '	<td>'.$product->ingredient.'</td>';
		echo '</tr>';

 	endforeach;
?>
</table>
