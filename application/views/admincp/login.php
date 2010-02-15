Login:

<?


	echo '<table cellpadding="2" style="-moz-border-radius: 4px;
	-webkit-border-radius: 4px;
	background: #EEEEEE;
	color: #000000;
	-moz-box-shadow: 0 1px 0 #CCCCCC;
	-webkit-box-shadow: 0 1px 0 #CCCCCC;padding:10px; width:330px;"><tr><td>';
	echo form_open('admincp/login/validate');
	echo 'Username:'. form_input('username', '').'<br><br>';
	echo 'Password:'. form_password('password', '').'<br><br>';
	echo form_submit('submit', 'Login');
	echo '</form></td></tr></table>';


?>