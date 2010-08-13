<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>css/floating_messages.css" />
<script src="<?php echo base_url()?>js/floating_messages.js" type="text/javascript"></script>
<div id="alert"></div>

<div>
	<strong class="redtxt">Mapping the world's food chain, and what's really in your food, start exploring it with us</strong><br><br>

	<div style="padding:10px;overflow:auto;">
		<img src="/img/Connecting-Dots.gif" border="0" align="left" style="margin-right: 10px; margin-left:0px;">
		<br><br><span class="redtxt"><b>Private Beta</b></span>
		<br>

		<span style="font-size:12px;">We just launched in July, 2010.  Join today for the private beta.</span>
		<br>

		<div style="font-size:18px; float:right; width:340px; margin-right:20px; ">
		<br/><a href="/about">Learn More</a> | <?php echo anchor('login', 'Sign In'); ?> <br/><br/>
		</div>
		<script>
			accountFormValidated = true;

			$(document).ready(function() {
				$("#frmAccount").validationEngine();
		<?php
			if (isset($ERROR) ) {
		
				if ($ERROR == 'duplicate') {
					$message = 'Your email is already registered with us.';
				} else if ($ERROR == 'registration_failed') {
					$message = 'Your account cannot be created.';
				}
		?>
				var $alert = $('#alert');
				message = '<?php echo $message; ?>';
				displayProcessingMessage($alert, message);
				displayFailedMessage($alert, message);
				hideMessage($alert, '', '');
		<?php
			}
		?>
			});
		</script>

		<br>

		<div style="-moz-border-radius: 4px;
			-webkit-border-radius: 4px;
			background: #EEEEEE;
			color: #000000;
			-moz-box-shadow: 0 1px 0 #CCCCCC;
			-webkit-box-shadow: 0 1px 0 #CCCCCC;padding:10px; width:320px; float:right; margin-right:20px;">

			
			<div align = "left"><div id="msgbox" style="display:none;"></div></div>
			<strong>Join the Private Beta</strong><br />
			<?php

			$attributes = array('name' => 'frmAccount', 'id' => 'frmAccount');
			echo form_open('login/create_user', $attributes);
			?>
			<table width="300" cellpadding="2">
				<tr>
					<td colspan = "2"></td>
				</tr>
			<?php                               
			echo '<tr><td align="right">First Name:</td><td>'. '<input type = "text" name = "firstname" id = "firstname" class = "validate[required]" value="'.(isset($FIRST_NAME) ? $FIRST_NAME : '' ).'">' .'</td></tr>' . "\n";
			echo '<tr><td align="right">Email:</td><td>'. '<input type = "text" name = "email" id = "email" class = "validate[required,custom[email]]" value="'.(isset($EMAIL) ? $EMAIL : '' ).'">' .'</td></tr>' . "\n";
			echo '<tr><td align="right">Zip Code:</td><td>'. '<input type = "text" name = "zipcode" id = "zipcode" class = "validate[required]" value="'.(isset($ZIPCODE) ? $ZIPCODE : '' ).'">' .'</td></tr>' . "\n";

			echo '<tr><td align="right">Password:</td><td>'. '<input type = "password" name = "password" id = "password" class = "validate[required,length[8,30]]" >' .'</td></tr>' . "\n";
			echo '<tr><td align="right">Confirm Password:</td><td>'. '<input type = "password" name = "password2" id = "password2" class = "validate[required,length[8,30],confirm[password]]" >' .'</td></tr>' . "\n";

			echo '<tr><td align="center" colspan="2">'.form_submit('submit', 'Create Account').'</td></tr>' . "\n";
			?>
			</table>
			<?php
				echo '</form>';
			?>
			<?php echo validation_errors('<p>'); ?>
		</div>
	</div>
</div>
<br>