<script>
	$(document).ready(function() {
		$("#frmAccount").validationEngine({
			scroll:false,
			unbindEngine:false
		});
	});
</script>

<div style = "padding:10px 0 10px 0;">
		
	<div class="left" style = "padding-left:20px;">
		<div id="signup-box">
			<div id="register-box-wrapper" style="height:250px;">
				<div id="login-wrapper">
					<span>Login Existin Account</span>
				</div>
				<div id="signup-form">
					<h2 id="signup-title"> </h2>
					<form action="/login/create_user<?php echo ( $this->input->get('frm') <> "" ? "?frm=".$this->input->get('frm') : "" ); ?>" method="post" name="frmAccount" id="frmAccount">								
						
						Email: <input type="text" name="firstname" id="firstname" class="validate[required]" value="<?php echo set_value('username'); ?>" AUTOCOMPLETE="OF"><br/>
						Password: <input type="text" name="username" id="username" class="validate[required]" value="<?php echo set_value('username'); ?>" AUTOCOMPLETE="OFF"><br/>
						
						<input type="submit" name="submit" value="Sign In">
						
					</form>
				</div>
			</div><!-- #signup-box -->	
		</div>
		<div class="signup-box-shadow"></div>
	</div>
	
	<div class="right" style = "width:426px;padding-right:20px;">
		
		<div id="signup-box">
			<div id="register-box-wrapper">
				<div id="login-wrapper">
					<span>Create a New Account</span>
				</div>
				<div id="signup-form">
					<h2 id="signup-title"> </h2>
					<form action="/login/create_user<?php echo ( $this->input->get('frm') <> "" ? "?frm=".$this->input->get('frm') : "" ); ?>" method="post" name="frmAccount" id="frmAccount">								
						
						Username: <input type="text" name="firstname" id="firstname" class="validate[required]" value="<?php echo set_value('username'); ?>" AUTOCOMPLETE="OF"><br/>
						Email: <input type="text" name="username" id="username" class="validate[required]" value="<?php echo set_value('username'); ?>" AUTOCOMPLETE="OFF"><br/>
						
						First Name: <input type="text" name="phone" id="phone" class="validate[required]" value="<?php echo set_value('phone'); ?>" AUTOCOMPLETE="OFF"><br/>
						
						Last Name: <input type="text" name="email" id="email" class="validate[required,custom[email]]" value="<?php echo set_value('email'); ?>" AUTOCOMPLETE="OFF"><br/>
						
						Password: <input type="password" name="password" id="password" class="validate[required,length[8,30]]" value="<?php echo set_value('password'); ?>" AUTOCOMPLETE="OFF"><br/>
						Re-enter Password: <input type="password" name="password" id="password" class="validate[required,length[8,30]]" value="<?php echo set_value('password'); ?>" AUTOCOMPLETE="OFF"><br/>
						Zip Code: <input type="text" name="zipcode" id="zipcode" class="validate[required]" value="<?php echo set_value('zipcode'); ?>" AUTOCOMPLETE="OFF"><br/>
						
						<input type="submit" name="submit" value="Create Account">
						
					</form>
				</div>
			</div><!-- #signup-box -->	
		</div>
		<div class="signup-box-shadow"></div>
		
		
	</div>
		
	
	<div class = "clear"></div>
</div>
<div class = "clear"></div>
