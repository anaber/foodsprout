<div>
	
<strong><?php echo $this->session->userdata('email'); ?>'s Settings</strong>
<hr size="1">

<?php echo anchor('user/settings', 'Account'); ?> | <strong>Password</strong>
<br>
<br>
<br>

<?php

$attributes = array('name' => 'frmAccount', 'id' => 'frmAccount');
echo form_open('user/updatePassword', $attributes);

?>
<table cellpadding="10" cellspacing="0" border="0" width="600" id="settings">
	<tr>
		<td width="150">
			Current Password
		</td>
		<td width="450">
			<input type="password" name="current_password" maxlength="100">
		</td>
	</tr>
	<tr>
		<td width="150">
			New Password
		</td>
		<td width="450">
			<input type="password" name="new_pass1" maxlength="100">
		</td>
	</tr>
	<tr>
		<td width="150">
			Verify New Password
		</td>
		<td width="450">
			<input type="password" name="new_pass2" maxlength="100">
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