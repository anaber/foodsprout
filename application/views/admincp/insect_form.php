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
	$("#insectForm").validationEngine({
		success :  function() {formValidated = true;},
		failure : function() {formValidated = false; }
	});
	
	
	$("#insectForm").submit(function() {
		
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
			
			if ($('#insect_id').val() != '' ) {
				var formAction = '/admincp/insect/save_update';
				postArray = {
							  insectName:$('#insect_name').val(),
							  description:$('#description').val(),
							  insectId: $('#insect_id').val()
							};
				act = 'update';		
			} else {
				formAction = '/admincp/insect/save_add';
				postArray = { 
							  insectName:$('#insect_name').val(),
							  description:$('#description').val(),
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
								document.location='/admincp/insect';
							});	
						} else if (act == 'update') {
							$(this).html('Updated...').addClass('messageboxok').fadeTo(900,1, function(){
								//redirect to secure page
								document.location='/admincp/insect';
							});
						}

					});
				} else if(data == 'duplicate') {
					//start fading the messagebox 
					$("#msgbox").fadeTo(200,0.1,function() {
						//add message and change the class of the box and start fading
						$(this).html('Duplicate Insect...').addClass('messageboxerror').fadeTo(900,1);
						
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
		
		document.location='/admincp/insect';
	});

});
	
		
</script>


<?php echo anchor('admincp/insect', 'List Insects'); ?><br /><br />

<div align = "left"><div id="msgbox" style="display:none"></div></div><br /><br />
<form id="insectForm" method="post" action="">
<table class="formTable">
	<tr>
		<td width = "25%">Insect Name</td>
		<td width = "75%">
			<input value="<?php echo (isset($INSECT) ? $INSECT->insectName : '') ?>" class="validate[required]" type="text" name="insect_name" id="insect_name" /><br />
		</td>
	</tr>
	<tr>
		<td width = "25%">Description</td>
		<td width = "75%">
			<input value="<?php echo (isset($INSECT) ? $INSECT->description : '') ?>" class="validate[optional]" type="text" name="description" id="description" /><br />
		</td>
	</tr>
	
	<tr>
		<td width = "25%" colspan = "2">
			<input type = "Submit" name = "btnSubmit" id = "btnSubmit" value = "<?php echo (isset($INSECT)) ? 'Update Insect' : 'Add Insect' ?>">
			<input type = "hidden" name = "insect_id" id = "insect_id" value = "<?php echo (isset($INSECT) ? $INSECT->insectId : '') ?>">
		</td>
	</tr>
</table>
</form>

