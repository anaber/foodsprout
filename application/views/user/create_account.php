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
			
			if (accountFormValidated == false) {
				//start fading the messagebox 
				$("#msgbox").fadeTo(200,0.1,function() {
					//add message and change the class of the box and start fading
					$(this).html('Form validation failed...').addClass('messageboxerror').fadeTo(900,1);
				});
			} else {
				
				$.post("/login/create_user",{ email:$('#email').val(),password:$('#password').val(),firstname:$('#firstname').val(),zipcode:$('#zipcode').val() } ,function(data) {
					//if correct login detail
					
					if(data=='yes') {
						//start fading the messagebox
						$("#msgbox").fadeTo(200,0.1,function() {
							//add message and change the class of the box and start fading
							$(this).html('Logging in.....').addClass('messageboxok').fadeTo(900,1, function(){
								//redirect to secure page
								document.location='/';
							});
			  
						});
					} else if(data == 'passwordNotSame') {
						//start fading the messagebox 
						$("#msgbox").fadeTo(200,0.1,function() {
							//add message and change the class of the box and start fading
							$(this).html('Passowrd do not match...').addClass('messageboxerror').fadeTo(900,1);
						});
					} else {
						//start fading the messagebox 
						$("#msgbox").fadeTo(200,0.1,function() {
							//add message and change the class of the box and start fading
							$(this).html('Cannot create your account...').addClass('messageboxerror').fadeTo(900,1);
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
<div align = "left"><div id="msgbox" style="display:none;"></div></div>
<br /><br />
	<?php

	$attributes = array('name' => 'frmAccount', 'id' => 'frmAccount');
	echo form_open('login/create_user', $attributes);
	//echo form_open('login/create_user');
	
	//$attributes = array('name' => 'frmLogin', 'id' => 'frmLogin');
	//echo form_open('login/validate', $attributes);
	

	?>
	<table width="300" cellpadding="2">
	
	<?php
	echo '<tr><td align="right">First Name:</td><td>'. '<input type = "text" name = "firstname" id = "firstname" class = "validate[required]">' .'</td></tr>' . "\n";
	echo '<tr><td align="right">Email:</td><td>'. '<input type = "text" name = "email" id = "email" class = "validate[required,custom[email]]">' .'</td></tr>' . "\n";
	echo '<tr><td align="right">Zip Code:</td><td>'. '<input type = "text" name = "zipcode" id = "zipcode" class = "validate[required]">' .'</td></tr>' . "\n";
	echo '<tr><td align="right">Password:</td><td>'. '<input type = "password" name = "password" id = "password" class = "validate[required,length[8,30]]">' .'</td></tr>' . "\n";
	echo '<tr><td align="right">Confirm Password:</td><td>'. '<input type = "password" name = "password2" id = "password2" class = "validate[required,length[8,30]]">' .'</td></tr>' . "\n";
	
	echo '<tr><td align="center" colspan="2">'.form_submit('submit', 'Create Account').'</td></tr>' . "\n";
	?>
	</table>
	<?php
		echo '</form>';
	?>
	<?php echo validation_errors('<p>'); ?>

</div>

