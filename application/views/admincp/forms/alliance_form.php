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
	$("#allianceForm").validationEngine({
		success :  function() {formValidated = true;},
		failure : function() {formValidated = false; }
	});
	
	
	$("#allianceForm").submit(function() {
		
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
			
			if ($('#allianceId').val() != '' ) {
				var formAction = '/admincp/alliance/save_update';
				postArray = {
							  allianceName:$('#allianceName').val(),
							  allianceId: $('#allianceId').val()
							};
				act = 'update';		
			} else {
				formAction = '/admincp/alliance/save_add';
				postArray = { 
							  allianceName:$('#allianceName').val()
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
								document.location='/admincp/alliance';
							});	
						} else if (act == 'update') {
							$(this).html('Updated...').addClass('messageboxok').fadeTo(900,1, function(){
								//redirect to secure page
								document.location='/admincp/alliance';
							});
						}

					});
				} else if(data == 'duplicate') {
					//start fading the messagebox 
					$("#msgbox").fadeTo(200,0.1,function() {
						//add message and change the class of the box and start fading
						$(this).html('Duplicate alliance...').addClass('messageboxerror').fadeTo(900,1);
						
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
		
		document.location='/programs';
	});

});
	
		
</script>


<?php echo anchor('admincp/alliance', 'List Alliances'); ?><br /><br />

<div align = "left"><div id="msgbox" style="display:none"></div></div><br /><br />

<form id="allianceForm" method="post" <?php echo (isset($alliance)) ? 'action="/admincp/alliance/save_update"' : 'action="/admincp/alliance/save_add"' ?>>
<table class="formTable">
	<tr>
		<td width = "25%" nowrap>Alliance Name</td>
		<td width = "75%">
			<input value="<?php echo (isset($alliance) ? $alliance->allianceName : '') ?>" class="validate[required]" type="text" name="allianceName" id="allianceName"/><br />
		</td>
	</tr>
	<tr>
		<td width = "25%" nowrap>Alliance Information</td>
		<td width = "75%">
			<textarea rows="30" cols="50" class="validate[required]" name="allianceInfo" id="allianceInfo">
			<?php echo (isset($alliance) ? $alliance->allianceInfo : '') ?>
				</textarea><br />
		</td>
	</tr>
	
	<tr>
		<td width = "25%" colspan = "2">
			<input type = "Submit" name = "btnSubmit" id = "btnSubmit" value = "<?php echo (isset($alliance)) ? 'Update alliance' : 'Add alliance' ?>">
			<input type = "hidden" name = "allianceId" id = "allianceId" value = "<?php echo (isset($alliance) ? $alliance->allianceId : '') ?>">
		</td>
	</tr>
</table>
</form>

