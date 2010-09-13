<?php
/*
 * Created on Jul 16, 2010
 *
 * Author: Deepak Kumar
 */
?>
<script>

formValidated = true;

$(document).ready(function() {
	
	// SUCCESS AJAX CALL, replace "success: false," by:     success : function() { callSuccessFunction() }, 
	$("#frmAccount").validationEngine({
		success :  function() {formValidated = true;},
		failure : function() {formValidated = false; }
	});
	
	$("#frmAccount").submit(function() {
		
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
			
			var formAction = '/user/updatePassword';
			postArray = {
						  currentPassword:$('#current_password').val(),
						  newPassword:$('#new_password').val()
						};
		
			$.post(formAction, postArray,function(data) {
				
				if(data=='yes') {
					//start fading the messagebox
					$("#msgbox").fadeTo(200,0.1,function() {
						//add message and change the class of the box and start fading
						$(this).html('Password updated...').addClass('messageboxok').fadeTo(900,1, function(){
							//redirect to secure page
							document.location='/user/password';
						});
					});
				} else if(data == 'wrong_password') {
					//start fading the messagebox 
					$("#msgbox").fadeTo(200,0.1,function() {
						//add message and change the class of the box and start fading
						$(this).html('Wrong Password...').addClass('messageboxerror').fadeTo(900,1);
					});
				} else {
					//start fading the messagebox 
					$("#msgbox").fadeTo(200,0.1,function() {
						//add message and change the class of the box and start fading
						$(this).html('Password not updated...').addClass('messageboxerror').fadeTo(900,1);
					});
				}	
			});
		}
		
		return false; //not to post the  form physically
		
	});

});
	
		
</script>
<div>
	
<strong><?php echo $this->session->userdata('email'); ?>'s Settings</strong>
<hr size="1">

<div style="font-size:13px;text-decoration:none;float:left;"><?php echo anchor('user/settings', 'Account', 'style="font-size:13px;text-decoration:none;"'); ?> | <strong>Password</strong></div>
<br><br>
<div align = "left"><div id="msgbox" style="display:none"></div></div><br />

<?php

$attributes = array('name' => 'frmAccount', 'id' => 'frmAccount');
echo form_open('/user/updatePassword', $attributes);

?>
<table cellpadding="10" cellspacing="0" border="0" width="600" id="settings">
	<tr>
		<td width="150" style="font-size:13px;text-decoration:none;">
			Current Password
		</td>
		<td width="450">
			<input type="password" id="current_password" maxlength="100" class = "validate[required]">
		</td>
	</tr>
	<tr>
		<td width="150" style="font-size:13px;text-decoration:none;">
			New Password
		</td>
		<td width="450">
			<input type="password" id="new_password" maxlength="100" class = "validate[required,length[8,30]]">
		</td>
	</tr>
	<tr>
		<td width="150" style="font-size:13px;text-decoration:none;">
			Verify New Password
		</td>
		<td width="450">
			<input type="password" id="new_password2" maxlength="100" class = "validate[required,length[8,30],confirm[new_password]]">
		</td>
	</tr>
	<tr>
		<td width="150">
			
		</td>
		<td width="450">
			<?php echo form_submit('submit', 'Update Password'); ?>
		</td>
	</tr>
</table> 
</form>

<br>
<br>


</div>