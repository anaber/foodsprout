<script>
    
	accountFormValidated = true;
		
	$(document).ready(function() {
		
		$("#frmAccount").validationEngine({
			success : function() {accountFormValidated = true;},
			failure : function() {accountFormValidated = false;}
		})
		
		$("#frmAccount").submit(function() {
			//remove all the class add the messagebox classes and start fading
			$("#msgbox").removeClass().addClass('messagebox').text('Validating....').fadeIn(1000);
			//check the username exists or not from ajax
			
			if (loginFormValidated == false) {
				//start fading the messagebox 
				$("#msgbox").fadeTo(200,0.1,function() {
					//add message and change the class of the box and start fading
					$(this).html('Form validation failed...').addClass('messageboxerror').fadeTo(900,1);
				});
			} else {
				
				$.post("/login/create_user",{ email:$('#email').val(),password:$('#password').val(),firstname:$('#firstname').val(),password:$('#zipcode').val() } ,function(data) {
					//if correct login detail
					
					if(data=='yes') {
						//start fading the messagebox
						$("#msgbox").fadeTo(200,0.1,function() {
							//add message and change the class of the box and start fading
							$(this).html('Logging in.....').addClass('messageboxok').fadeTo(900,1, function(){
								//redirect to secure page
								document.location='user/dashboard';
							});
			  
						});
					} else if(data == 'blocked') {
						//start fading the messagebox 
						$("#msgbox").fadeTo(200,0.1,function() {
							//add message and change the class of the box and start fading
							$(this).html('Your access is blocked...').addClass('messageboxerror').fadeTo(900,1);
						});
					} else {
						//start fading the messagebox 
						$("#msgbox").fadeTo(200,0.1,function() {
							//add message and change the class of the box and start fading
							$(this).html('Your login is not correct...').addClass('messageboxerror').fadeTo(900,1);
						});
					}

				});
			
			}
			
			return false; //not to post the form physically
			
		});
		
		
	});
</script>

<br>

<div style="-moz-border-radius: 4px;
-webkit-border-radius: 4px;
background: #EEEEEE;
color: #000000;
-moz-box-shadow: 0 1px 0 #CCCCCC;
-webkit-box-shadow: 0 1px 0 #CCCCCC;padding:10px; width:330px;">

<strong>Don't have an account?  Sign-up for free.</strong><br>

	<table width="300" cellpadding="2">
	
	<?php

	//$attributes = array('name' => 'frmAccount', 'id' => 'frmAccount');
	//echo form_open('login/create_user', $attributes);
	echo form_open('login/create_user');

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

</div>

