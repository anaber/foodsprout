<div >
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
									
									$("#frmLogin").validationEngine({
										success : function() {loginFormValidated = true;},
										failure : function() {loginFormValidated = false;}
									})
									
									$("#frmLogin").submit(function() {
										//remove all the class add the messagebox classes and start fading
										$("#msgbox").removeClass().addClass('messageboxleft105').text('Validating....').fadeIn(1000);
										//check the username exists or not from ajax
										
										if (loginFormValidated == false) {
											//start fading the messagebox 
											$("#msgbox").fadeTo(200,0.1,function() {
												//add message and change the class of the box and start fading
												$(this).html('Form validation failed...').addClass('messageboxerrorleft105').fadeTo(900,1);
											});
										} else {
											
											$.post("/login/validate",{ email:$('#email').val(),password:$('#password').val() } ,function(data) {
												//if correct login detail
												
												if(data=='yes') {
													//start fading the messagebox
													$("#msgbox").fadeTo(200,0.1,function() {
														//add message and change the class of the box and start fading
														$(this).html('Logging in.....').addClass('messageboxokleft105').fadeTo(900,1, function(){
															//redirect to secure page
															document.location='/';
														});
										  
													});
												} else if(data == 'blocked') {
													//start fading the messagebox 
													$("#msgbox").fadeTo(200,0.1,function() {
														//add message and change the class of the box and start fading
														$(this).html('Your access is blocked...').addClass('messageboxerrorleft105').fadeTo(900,1);
													});
												} else {
													//start fading the messagebox 
													$("#msgbox").fadeTo(200,0.1,function() {
														//add message and change the class of the box and start fading
														$(this).html('Your login is not correct...').addClass('messageboxerrorleft105').fadeTo(900,1);
													});
												}
							
											});
										
										}
										
										return false; //not to post the  form physically
										
									});
									
									
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




















<?php
/*
?>
Login:
	
	<div align = "left"><div id="msgbox" style="display:none;"></div></div>
	<br /><br />
<?php

	echo '<table cellpadding="2" style="-moz-border-radius: 4px;
	-webkit-border-radius: 4px;
	background: #EEEEEE;
	color: #000000;
	-moz-box-shadow: 0 1px 0 #CCCCCC;
	-webkit-box-shadow: 0 1px 0 #CCCCCC;padding:10px; width:330px;"><tr><td>';
	
	$attributes = array('name' => 'frmLogin', 'id' => 'frmLogin');
	echo form_open('login/validate', $attributes);
				
	echo 'Email: <input type = "text" name = "email" id = "email" class = "validate[required]"><br><br>';
	echo 'Password: <input type = "password" name = "password" id = "password" class = "validate[required]"><br><br>';
	echo form_submit('submit', 'Login');
	echo '</form></td></tr></table>';
*/
?>