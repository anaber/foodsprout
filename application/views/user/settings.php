<div>
	
<strong><?php echo $this->session->userdata('email'); ?>'s Settings</strong>
<hr size="1">

<strong>Account</strong> | <?php echo anchor('user/password', 'Password'); ?>
<br>
<br>
<br>

<?php

$attributes = array('name' => 'frmAccount', 'id' => 'frmAccount');
echo form_open('user/update_settings', $attributes);

?>
<table cellpadding="10" cellspacing="0" border="0" width="600" id="settings">
	<tr>
		<td width="150">
			Email
		</td>
		<td width="450">
			<input type="text" value="<?php echo $this->session->userdata('email'); ?>" name="email" maxlength="100">
		</td>
	</tr>
	<tr>
		<td width="150">
			Username
		</td>
		<td width="450">
			<input type="text" value="<?php echo $this->session->userdata('screenName'); ?>" name="screen_name" maxlength="100">
		</td>
	</tr>
	<tr>
		<td width="150">
			First Name
		</td>
		<td width="450">
			<input type="text" value="<?php echo $this->session->userdata('firstName'); ?>" name="first_name" maxlength="100">
		</td>
	</tr>
	<tr>
		<td width="150">
			Zip Code
		</td>
		<td width="450">
			<input type="text" value="<?php echo $this->session->userdata('zipcode'); ?>" name="zipcode" size="5" maxlength="5"><br>
			<span style="font-size:11px">Providing your zip code will allow us to show you results near you by default</span>
		</td>
	</tr>
	<tr>
		<td width="150">
			
		</td>
		<td width="450">
			<?php echo form_submit('submit', 'Save'); ?>
		</td>
	</tr>
</table> 
</form>

<br>
<br>


</div>