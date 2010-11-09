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
	$("#plantGroupForm").validationEngine({
		success :  function() {formValidated = true;},
		failure : function() {formValidated = false; }
	});
	
	
	$("#plantGroupForm").submit(function() {
		
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
			
			if ($('#plant_group_id').val() != '' ) {
				var formAction = '/admincp/plantgroup/save_update';
				postArray = {
							  plantGroupName:$('#plant_group_name').val(),
							  plantGroupSciName:$('#plant_group_sci_name').val(),
							  plantGroupId:$('#plant_group_id').val()
							};
				act = 'update';		
			} else {
				formAction = '/admincp/plantgroup/save_add';
				postArray = { 
							  plantGroupName:$('#plant_group_name').val(),
							  plantGroupSciName:$('#plant_group_sci_name').val()
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
								document.location='/admincp/plantgroup';
							});	
						} else if (act == 'update') {
							$(this).html('Updated...').addClass('messageboxok').fadeTo(900,1, function(){
								//redirect to secure page
								document.location='/admincp/plantgroup';
							});
						}

					});
				} else if(data == 'duplicate') {
					//start fading the messagebox 
					$("#msgbox").fadeTo(200,0.1,function() {
						//add message and change the class of the box and start fading
						$(this).html('Duplicate Fruit Type...').addClass('messageboxerror').fadeTo(900,1);
						
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
		
		document.location='/plantgroup';
	});

});
	
		
</script>


<?php echo anchor('admincp/plantgroup', 'List Plant Groups'); ?><br /><br />

<div align = "left"><div id="msgbox" style="display:none"></div></div><br /><br />

<form id="plantGroupForm" method="post" <?php echo (isset($PLANT_GROUP)) ? 'action="/admincp/plantgroup/save_update"' : 'action="/admincp/plantgroup/save_add"' ?>>
<table class="formTable">
	<tr>
		<td width = "25%" nowrap>Plant Group</td>
		<td width = "75%">
			<input value="<?php echo (isset($PLANT_GROUP) ? $PLANT_GROUP->plantGroupName : '') ?>" class="validate[required]" type="text" name="plant_group_name" id="plant_group_name"/><br />
		</td>
	</tr>
	<tr>
		<td width = "25%" nowrap>Sci Name</td>
		<td width = "75%">
			<input value="<?php echo (isset($PLANT_GROUP) ? $PLANT_GROUP->plantGroupSciName : '') ?>" class="validate[required]" type="text" name="plant_group_sci_name" id="plant_group_sci_name"/><br />
		</td>
	</tr>
	<tr>
		<td width = "25%" colspan = "2">
			<input type = "Submit" name = "btnSubmit" id = "btnSubmit" value = "<?php echo (isset($PLANT_GROUP)) ? 'Update Plant Group' : 'Add Plant Group' ?>">
			<input type = "hidden" name = "plant_group_id" id = "plant_group_id" value = "<?php echo (isset($PLANT_GROUP) ? $PLANT_GROUP->plantGroupId : '') ?>">
		</td>
	</tr>
</table>
</form>

