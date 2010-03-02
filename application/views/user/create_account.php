<br>
<div id="main-content">

<strong>Don't have an account?  Sign-up for free.</strong><br>
<fieldset>
	<legend>Account Information</legend>
	<table width="300" cellpadding="2">
	
	<?php

	echo form_open('user/create_user');

	?>
	
	<?php
	echo '<tr><td align="right">First Name:</td><td>'. form_input('firstname', set_value('firstname', '')) .'</td></tr>';
	echo '<tr><td align="right">Email:</td><td>'. form_input('email', set_value('email', '')) .'</td></tr>';
	echo '<tr><td align="right">Zip Code:</td><td>'. form_input('zipcode', set_value('zipcode', '')) .'</td></tr>';
	echo '<tr><td align="right">Password:</td><td>'. form_password('password', set_value('password', '')) .'</td></tr>';
	echo '<tr><td align="right">Confirm Password:</td><td>'. form_password('password2', set_value('password2', '')) .'</td></tr>';

	echo '<tr><td align="center" colspan="2">'.form_submit('submit', 'Create Account').'</td></tr>';
	echo '</form>';

	?>
	</table>
	<?php echo validation_errors('<p>'); ?>

</fieldset>

</div>