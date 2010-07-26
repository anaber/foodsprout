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
	$("#plantForm").validationEngine({
		success :  function() {formValidated = true;},
		failure : function() {formValidated = false; }
	});
	
	
	$("#plantForm").submit(function() {
		
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
			
			if ($('#plant_id').val() != '' ) {
				var formAction = '/admincp/plant/save_update';
				postArray = {
							  plantName:$('#plant_name').val(),
							  plantGroupId:$('#plant_group').val(),
							  plantId: $('#plant_id').val()
							};
				act = 'update';		
			} else {
				formAction = '/admincp/plant/save_add';
				postArray = { 
							  plantName:$('#plant_name').val(),
							  plantGroupId:$('#plant_group').val()
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
								document.location='/admincp/plant';
							});	
						} else if (act == 'update') {
							$(this).html('Updated...').addClass('messageboxok').fadeTo(900,1, function(){
								//redirect to secure page
								document.location='/admincp/plant';
							});
						}

					});
				} else if(data == 'duplicate') {
					//start fading the messagebox 
					$("#msgbox").fadeTo(200,0.1,function() {
						//add message and change the class of the box and start fading
						$(this).html('Duplicate Plant...').addClass('messageboxerror').fadeTo(900,1);
						
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
		
		document.location='/admincp/plant';
	});

});
	
		
</script>


<?php echo anchor('admincp/plant', 'List Plants'); ?><br /><br />

<div align = "left"><div id="msgbox" style="display:none"></div></div><br /><br />
<form id="plantForm" method="post" action="">
<table class="formTable">
	<tr>
		<td nowrap>Plant Name</td>
		<td>
			<input value="<?php echo (isset($PLANT) ? $PLANT->plantName : '') ?>" class="validate[required]" type="text" name="plant_name" id="plant_name" /><br />
		</td>
	</tr>
	<tr>
		<td>State</td>
		<td>
			<select name="plant_group" id="plant_group"  class="validate[required]">
			<option value = ''>--Plant Group--</option>
			<?php
				foreach($PLANT_GROUPS as $key => $value) {
					echo '<option value="'.$value->plantGroupId.'"' . (  ( isset($PLANT) && ( $value->plantGroupId == $PLANT->plantGroupId )  ) ? ' SELECTED' : '' ) . '>'.$value->plantGroupName.'</option>';
				}
			?>
			</select>
		</td>
	</tr>
	<tr>
		<td width = "25%" colspan = "2">
			<input type = "Submit" name = "btnSubmit" id = "btnSubmit" value = "<?php echo (isset($PLANT)) ? 'Update Plant' : 'Add Plant' ?>">
			<input type = "hidden" name = "plant_id" id = "plant_id" value = "<?php echo (isset($PLANT) ? $PLANT->plantId : '') ?>">
		</td>
	</tr>
</table>
</form>

