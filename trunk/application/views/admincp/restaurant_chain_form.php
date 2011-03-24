<?php
/*
 * Created on June 21, 2010
 *
 * Author: Deepak Kumar
 */
?>
<script>

formValidated = true;

$(document).ready(function() {
	
	
	<?php echo (isset($RESTAURANT) ? '' : "$('#companyId').val('');") ?>
	
	// SUCCESS AJAX CALL, replace "success: false," by:     success : function() { callSuccessFunction() }, 
	$("#restaurantForm").validationEngine({
		success :  function() {formValidated = true;},
		failure : function() {formValidated = false; }
	});
	
	
	$("#restaurantForm").submit(function(e) {
		e.preventDefault();
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
			
			//alert($('#companyId').val());
			
			var selectedCuisines = '';
			var j = 0;
		    $('#cuisineId' + ' :selected').each(function(i, selected){
			    if (j == 0) {
			    	selectedCuisines += $(selected).val();
			    } else {
			    	selectedCuisines += ',' + $(selected).val();
			    }
			    j++;
			});
			
			if ($('#restaurantChainId').val() != '' ) {
				var formAction = '/admincp/restaurantchain/save_update';
				postArray = {
							  restaurantChainId:$('#restaurantChainId').val(),
							  restaurantChain:$('#restaurantChain').val(),
//							  matchString:$('#matchString').val(),
							  restaurantTypeId:$('#restaurantTypeId').val(),
							  status:$('#status').val()
							};
				act = 'update';		
			} else {
				formAction = '/admincp/restaurantchain/save_add';
				postArray = { 
							  restaurantChain:$('#restaurantChain').val(),
//							  matchString:$('#matchString').val(),
							  restaurantTypeId:$('#restaurantTypeId').val(),
							  status:$('#status').val()				  
							};
				act = 'add';
			}
			
			$.post(formAction, postArray,function(data) {
				//alert(data);
				//return false;
				if(data=='yes') {
					//start fading the messagebox
					$("#msgbox").fadeTo(200,0.1,function() {
						//add message and change the class of the box and start fading
						if (act == 'add') {
							$(this).html('Added...').addClass('messageboxok').fadeTo(900,1, function(){
								//redirect to secure page
								document.location='/admincp/restaurantchain';
							});	
						} else if (act == 'update') {
							$(this).html('Updated...').addClass('messageboxok').fadeTo(900,1, function(){
								//redirect to secure page
								document.location='/admincp/restaurantchain';
							});
						}

					});
				} else if(data == 'duplicate') {
					//start fading the messagebox 
					$("#msgbox").fadeTo(200,0.1,function() {
						//add message and change the class of the box and start fading
						$(this).html('Duplicate Restaurant Chain...').addClass('messageboxerror').fadeTo(900,1);
						
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
<?php
	if (!isset($RESTAURANT)) {
?>
<?php echo anchor('admincp/restaurantchain', 'Restaurant Chain'); ?><br /><br />
<?php
	}
?>

<div align = "left"><div id="msgbox" style="display:none"></div></div><br /><br />

<form id="restaurantForm" method="post" <?php echo (isset($RESTAURANT)) ? 'action="/admincp/restaurant/save_update"' : 'action="/admincp/restaurant/save_add"' ?>>
<table class="formTable">
	<tr>
		<td width = "25%" nowrap>Name</td>
		<td width = "75%">
			<input value="<?php echo (isset($RESTAURANT) ? $RESTAURANT->restaurantChain : '') ?>" class="validate[required]" type="text" name="restaurantChain" id="restaurantChain"/><br />
		</td>
	</tr>
<!--	<tr>
		<td width = "25%" nowrap>Match String</td>
		<td width = "75%">
			<input value="<?php echo (isset($RESTAURANT) ? $RESTAURANT->matchString : '') ?>" class="validate[required]" type="text" name="matchString" id="matchString"/><br />
		</td>
	</tr>
-->
	<tr>
		<td width = "25%">Restaurant Type</td>
		<td width = "75%">
			<select name="restaurantTypeId" id="restaurantTypeId"  class="validate[required]">
			<option value = ''>--Restaurant Type--</option>
			<?php
				foreach($RESTAURANT_TYPES as $key => $value) {
					echo '<option value="'.$value->restaurantProductCategoryId.'"' . (  ( isset($RESTAURANT) && ( $value->restaurantProductCategoryId == $RESTAURANT->restaurantTypeId )  ) ? ' SELECTED' : '' ) . '>'.$value->restaurantTypeName.'</option>';
				}
			?>
			</select>
		</td>
	</tr>
	<tr>
		<td width = "25%" nowrap>Status</td>
		<td width = "75%">
			<select name="status" id="status"  class="validate[required]">
				<option value="">--Choose Status--</option>
			<?php
				foreach($STATUS as $key => $value) {
					echo '<option value="'.$key.'"' . (  ( isset($RESTAURANT) && ( $key == $RESTAURANT->status )  ) ? ' SELECTED' : '' ) . '>'.$value.'</option>';
				}
			?>
			</select>
		</td>
	</tr>
	
	<tr>
		<td width = "25%" colspan = "2">
			<input type = "Submit" name = "btnSubmit" id = "btnSubmit" value = "<?php echo (isset($RESTAURANT)) ? 'Update Restaurant' : 'Add Restaurant' ?>">
			<input type = "hidden" name = "restaurantChainId" id = "restaurantChainId" value = "<?php echo (isset($RESTAURANT) ? $RESTAURANT->restaurantChainId : '') ?>">
		</td>
	</tr>
</table>
</form>

