<html>

<head>
	<title>Admin Control Panel</title>
	<link rel="stylesheet" href="<?php echo base_url()?>css/admincp.css" type="text/css" media="all" />
	<link rel="stylesheet" href="<?php echo base_url()?>css/messages.css" type="text/css" media="all" />
	<link rel="stylesheet" href="<?php echo base_url()?>css/validationEngine.jquery.css" type="text/css" media="screen" title="no title" charset="utf-8" />
	
	
	<script src="<?php echo base_url()?>js/jquery.js" type="text/javascript"></script>
	<script src="<?php echo base_url()?>js/jquery.validationEngine.js" type="text/javascript"></script>
	
</head>

<body>

<script>
    
	loginFormValidated = true;
		
	$(document).ready(function() {
		
		$("#frmLogin").validationEngine({
			success : function() {loginFormValidated = true;},
			failure : function() {loginFormValidated = false;}
		})
		
		$("#frmLogin").submit(function() {
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
				
				$.post("/admincp/login/validate",{ email:$('#email').val(),password:$('#password').val() } ,function(data) {
					//if correct login detail
					
					if(data=='yes') {
						//start fading the messagebox
						$("#msgbox").fadeTo(200,0.1,function() {
							//add message and change the class of the box and start fading
							$(this).html('Logging in.....').addClass('messageboxok').fadeTo(900,1, function(){
								//redirect to secure page
								document.location='dashboard';
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
			
			return false; //not to post the  form physically
			
		});
		
		
	});
</script>


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
	echo form_open('/admincp/login/validate', $attributes);
				
	echo 'Email: <input type = "text" name = "email" id = "email" class = "validate[required]"><br><br>';
	echo 'Password: <input type = "password" name = "password" id = "password" class = "validate[required]"><br><br>';
	echo form_submit('submit', 'Login');
	echo '</form></td></tr></table>';
?>


</body>
</html>
