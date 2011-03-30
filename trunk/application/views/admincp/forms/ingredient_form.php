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
	$("#ingredientForm").validationEngine({
		success :  function() {formValidated = true;},
		failure : function() {formValidated = false; }
	});
	
	
	$("#ingredientForm").submit(function() {
		
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
			
			if ($('#ingredientId').val() != '' ) {
				var formAction = '/admincp/ingredient/save_update';
				postArray = {
							  ingredientName:$('#ingredientName').val(),
							  ingredientTypeId:$('#ingredientTypeId').val(),
							  vegetableTypeId:$('#vegetableTypeId').val(),
							  meatTypeId: $('#meatTypeId').val(),
							  fruitTypeId:$('#fruitTypeId').val(),
							  plantId:$('#plantId').val(),
							  ingredientId:$('#ingredientId').val()
							};
				act = 'update';		
			} else {
				formAction = '/admincp/ingredient/save_add';
				postArray = { 
							  ingredientName:$('#ingredientName').val(),
							  ingredientTypeId:$('#ingredientTypeId').val(),
							  vegetableTypeId:$('#vegetableTypeId').val(),
							  meatTypeId: $('#meatTypeId').val(),
							  fruitTypeId:$('#fruitTypeId').val(),
							  plantId:$('#plantId').val()
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
								document.location='/admincp/ingredient';
							});	
						} else if (act == 'update') {
							$(this).html('Updated...').addClass('messageboxok').fadeTo(900,1, function(){
								//redirect to secure page
								document.location='/admincp/ingredient';
							});
						}

					});
				} else if(data == 'duplicate') {
					//start fading the messagebox 
					$("#msgbox").fadeTo(200,0.1,function() {
						//add message and change the class of the box and start fading
						$(this).html('Duplicate Ingredient...').addClass('messageboxerror').fadeTo(900,1);
						
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


<?php echo anchor('admincp/ingredient', 'List Ingredients'); ?><br /><br />

<div align = "left"><div id="msgbox" style="display:none"></div></div><br /><br />

<form id="ingredientForm" method="post" <?php echo (isset($INGREDIENT)) ? 'action="/admincp/ingredient/save_update"' : 'action="/admincp/ingredient/save_add"' ?>>
<table class="formTable">
	
	<tr>
		<td width = "25%" nowrap>Ingredient Name</td>
		<td width = "75%">
			<input value="<?php echo (isset($INGREDIENT) ? $INGREDIENT->ingredientName : '') ?>" class="validate[required]" type="text" name="ingredientName" id="ingredientName"/><br />
		</td>
	</tr>
		
	<tr>
		<td width = "25%">Ingredient Type</td>
		<td width = "75%">
			<select name="ingredientTypeId" id="ingredientTypeId" class="validate[required]">
			<option value = ''>--Ingredient Type--</option>
			<option value = "NULL"<?php echo (  ( isset($INGREDIENT) && empty( $INGREDIENT->ingredientTypeId )  ) ? ' SELECTED' : '' ) ?>>--Not Applicable--</option>
			<?php
				foreach($INGREDIENT_TYPES as $key => $value) {
					echo '<option value="'.$value->ingredienttypeId.'"' . (  ( isset($INGREDIENT) && ( $value->ingredienttypeId == $INGREDIENT->ingredientTypeId )  ) ? ' SELECTED' : '' ) . '>'.$value->ingredienttypeName.'</option>';
				}
			?>
			</select>
		</td>
	</tr>
	
	<tr>
		<td width = "25%">Vegetable Type</td>
		<td width = "75%">
			<select name="vegetableTypeId" id="vegetableTypeId"  class="validate[required]">
			<option value = ''>--Vegetable Type--</option>
			<option value = "NULL"<?php echo (  ( isset($INGREDIENT) && empty( $INGREDIENT->vegetableTypeId )  ) ? ' SELECTED' : '' ) ?>>--Not Applicable--</option>
				<?php
					foreach($VEGETABLE_TYPES as $key => $value) {
						echo '<option value="'.$value->vegetabletypeId.'"' . (  ( isset($INGREDIENT) && ( $value->vegetabletypeId == $INGREDIENT->vegetableTypeId )  ) ? ' SELECTED' : '' ) . '>'.$value->vegetabletypeName.'</option>';
					}
				?>
				</select>
		</td>
	</tr>
	
	<tr>
		<td width = "25%">Meat Type</td>
		<td width = "75%">
			<select name="meatTypeId" id="meatTypeId"  class="validate[required]">
			<option value = ''>--Meat Type--</option>
			<option value = "NULL"<?php echo (  ( isset($INGREDIENT) && empty( $INGREDIENT->meatTypeId )  ) ? ' SELECTED' : '' ) ?>>--Not Applicable--</option>
				<?php
					foreach($MEAT_TYPES as $key => $value) {
						echo '<option value="'.$value->meattypeId.'"' . (  ( isset($INGREDIENT) && ( $value->meattypeId == $INGREDIENT->meatTypeId )  ) ? ' SELECTED' : '' ) . '>'.$value->meattypeName.'</option>';
					}
				?>
				</select>
		</td>
	</tr>
	
	<tr>
		<td width = "25%">Fruit Type</td>
		<td width = "75%">
			<select name="fruitTypeId" id="fruitTypeId"  class="validate[required]">
			<option value = ''>--Fruit Type--</option>
			<option value = "NULL"<?php echo (  ( isset($INGREDIENT) && empty( $INGREDIENT->fruitTypeId )  ) ? ' SELECTED' : '' ) ?>>--Not Applicable--</option>
				<?php
					foreach($FRUIT_TYPES as $key => $value) {
						echo '<option value="'.$value->fruittypeId.'"' . (  ( isset($INGREDIENT) && ( $value->fruittypeId == $INGREDIENT->fruitTypeId )  ) ? ' SELECTED' : '' ) . '>'.$value->fruittypeName.'</option>';
					}
				?>
				</select>
		</td>
	</tr>
	
	<tr>
		<td width = "25%">Plants</td>
		<td width = "75%">
			<select name="plantId" id="plantId"  class="validate[required]">
			<option value = ''>--Plants--</option>
			<option value = "NULL"<?php echo (  ( isset($INGREDIENT) && empty( $INGREDIENT->plantId )  ) ? ' SELECTED' : '' ) ?>>--Not Applicable--</option>
				<?php
					foreach($PLANTS as $key => $value) {
						echo '<option value="'.$value->plantId.'"' . (  ( isset($INGREDIENT) && ( $value->plantId == $INGREDIENT->plantId )  ) ? ' SELECTED' : '' ) . '>'.$value->plantName.'</option>';
					}
				?>
				</select>
		</td>
	</tr>
		
	<tr>
		<td width = "25%" colspan = "2">
			<input type = "Submit" name = "btnSubmit" id = "btnSubmit" value = "<?php echo (isset($INGREDIENT)) ? 'Update Ingredient' : 'Add Ingredient' ?>">
			<input type = "hidden" name = "ingredientId" id = "ingredientId" value = "<?php echo (isset($INGREDIENT) ? $INGREDIENT->ingredientId : '') ?>">
		</td>
	</tr>
		
</table>
</form>

