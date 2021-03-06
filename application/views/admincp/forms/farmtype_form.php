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
	$("#farmTypeForm").validationEngine({
		success :  function() {formValidated = true;},
		failure : function() {formValidated = false; }
	});
	
	
	$("#farmTypeForm").submit(function() {
		
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
			
			if ($('#farmTypeId').val() != '' ) {
				var formAction = '/admincp/farmtype/save_update';
				postArray = {
							  farmType:$('#farmType').val(),
							  farmTypeId:$('#farmTypeId').val()
							};
				act = 'update';		
			} else {
				formAction = '/admincp/farmtype/save_add';
				postArray = { 
							  farmType:$('#farmType').val()
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
								document.location='/admincp/farmtype';
							});	
						} else if (act == 'update') {
							$(this).html('Updated...').addClass('messageboxok').fadeTo(900,1, function(){
								//redirect to secure page
								document.location='/admincp/farmtype';
							});
						}

					});
				} else if(data == 'duplicate') {
					//start fading the messagebox 
					$("#msgbox").fadeTo(200,0.1,function() {
						//add message and change the class of the box and start fading
						$(this).html('Duplicate Farm Type...').addClass('messageboxerror').fadeTo(900,1);
						
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


<?php echo anchor('admincp/farmtype', 'List Farm Types'); ?><br /><br />

<div align = "left"><div id="msgbox" style="display:none"></div></div><br /><br />

<form id="farmTypeForm" method="post" <?php echo (isset($FARM_TYPE)) ? 'action="/admincp/farmtype/save_update"' : 'action="/admincp/farmtype/save_add"' ?>>
<table class="formTable">
	<tr>
		<td width = "25%" nowrap>Farm Type</td>
		<td width = "75%">
			<input value="<?php echo (isset($FARM_TYPE) ? $FARM_TYPE->farmType : '') ?>" class="validate[required]" type="text" name="farmType" id="farmType"/><br />
		</td>
	</tr>
	<tr>
		<td width = "25%" colspan = "2">
			<input type = "Submit" name = "btnSubmit" id = "btnSubmit" value = "<?php echo (isset($FARM_TYPE)) ? 'Update Farm Type' : 'Add Farm Type' ?>">
			<input type = "hidden" name = "farmTypeId" id = "farmTypeId" value = "<?php echo (isset($FARM_TYPE) ? $FARM_TYPE->farmTypeId : '') ?>">
		</td>
	</tr>
</table>
</form>

