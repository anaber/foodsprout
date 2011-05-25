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
	$("#usergroupForm").validationEngine({
		success :  function() {formValidated = true;},
		failure : function() {formValidated = false; }
	});
	
	
	$("#usergroupForm").submit(function() {
		
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
			
			if ($('#userId').val() != '' ) {
				var formAction = '/admincp/user/save_update';
				postArray = {
							  username:$('#username').val(),
							  email: $('#email').val(),
							  firstName: $('#firstName').val(),
							  zipcode: $('#zipcode').val(),
							  userId: $('#userId').val()							  
							};
				act = 'update';		
			} else {
				formAction = '/admincp/user/save_add';
				postArray = { 
							  usergroupName:$('#usergroup_name').val()
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
								document.location='/admincp/user';
							});	
						} else if (act == 'update') {
							$(this).html('Updated...').addClass('messageboxok').fadeTo(900,1, function(){
								//redirect to secure page
								document.location='/admincp/user';
							});
						}

					});
				} else if(data == 'duplicate') {
					//start fading the messagebox 
					$("#msgbox").fadeTo(200,0.1,function() {
						//add message and change the class of the box and start fading
						$(this).html('Duplicate Usergroup...').addClass('messageboxerror').fadeTo(900,1);
						
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
		
		document.location='/admincp/user';
	});

});
	
		
</script>
<style type="text/css">
	.usergroup 
	{
		font-size: 12px;
	}
</style>

<?php echo anchor('admincp/user', 'List Users'); ?><br /><br />

<div align = "left"><div id="msgbox" style="display:none"></div></div><br /><br />
<form id="usergroupForm" method="post" action="/admincp/user/save_update">
<table class="formTable" style="width: 450px;">
	<tr>
		<td width ="30%">Username: </td>
		<td>
			<input value="<?php echo (isset($USER) ? $USER->username : '') ?>" class="validate[required]" type="text" name="username" id="username" /><br />
		</td>
	</tr>
	<tr>
		<td>Email: </td>
		<td>
			<input value="<?php echo (isset($USER) ? $USER->email : '') ?>" class="validate[required]" type="text" name="email" id="email" /><br />
		</td>
	</tr>
	<tr>
		<td>First Name: </td>
		<td>
			<input value="<?php echo (isset($USER) ? $USER->firstName : '') ?>" class="validate[required]" type="text" name="firstName" id="firstName" /><br />
		</td>
	</tr>
	<tr>
		<td>Zip Code: </td>
		<td>
			<input value="<?php echo (isset($USER) ? $USER->zipcode : '') ?>" class="validate[required]" type="text" name="zipcode" id="zipcode" /><br />
		</td>
	</tr>
	<tr>
		<td valign="top">User Groups: </td>
		<td>
			<?php 
				if (count($USERGROUPS) > 0)
				{
					foreach($USERGROUPS AS $group)
					{
			?>
			<div class="usergroup"><input type="checkbox" value="<?php echo $group->usergroupId; ?>" <?php echo ($group->usergroupId == $USER->accessId) ? "checked='checked'": ''; ?> name="usergroupId[]" class="usergroupId" /> <?php echo $group->usergroupName;?></div>
			<?php 
					}
				} 
			
			?>
		</td>
	</tr>	
	<tr>
		<td colspan = "2">
			<input type="submit" name="btnSubmit" id="btnSubmit" value="<?php echo (isset($USER)) ? 'Update User' : 'Add User' ?>">
			<input type="hidden" name="userId" id="userId" value="<?php echo (isset($USER) ? $USER->userId : '') ?>">
		</td>
	</tr>
</table>
</form>

