<script src="<?php echo base_url()?>js/floating_messages.js" type="text/javascript"></script>
<div id="alert"></div>

<div>
<strong class="redtxt">Mapping the world's food chain, and what's really in your food, start exploring it with us</strong><br><br>
	
	<div style="padding:10px;overflow:auto;">
		<img src="/images/Connecting-Dots.gif" border="0" align="left" style="margin-right: 10px; margin-left:0px;">
		<br><br><span class="redtxt"><b>Private Beta</b></span>
		<br>

		<span style="font-size:12px;">We just launched in July, 2010.  Join today for the private beta.</span>
		<br>

		<div style="font-size:18px; float:right; width:340px; margin-right:20px; ">
		<br/><a href="/about">Learn More</a> | <?php echo anchor('/about/privatebeta', 'Join Us'); ?> <br/><br/>
		</div>
		<script>
			loginFormValidated = true;
			
			$(document).ready(function() {
				$("#frmLogin").validationEngine();
		<?php
			if (isset($ERROR) ) {
		
				if ($ERROR == 'blocked') {
					$message = 'Your access is blocked';
				} else if ($ERROR == 'login_failed') {
					$message = 'Wrong Email and password combination.';
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
			<strong>Sign In</strong><br />
				<?php

				$attributes = array('name' => 'frmLogin', 'id' => 'frmLogin');
				echo form_open('login/validate', $attributes);
				?>
				<table width="300" cellpadding="2">
					<tr>
						<td colspan = "2"></td>
					</tr>
				<?php
				echo '<tr><td align="right">Email:</td><td>'. '<input type = "text" name = "email" id = "email" class = "validate[required]">' .'</td></tr>' . "\n";
				echo '<tr><td align="right">Password:</td><td>'. '<input type = "password" name = "password" id = "password" class = "validate[required]">' .'</td></tr>' . "\n";
				
				echo '<tr><td align="center" colspan="2">'.form_submit('submit', 'Login').'</td></tr>' . "\n";
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