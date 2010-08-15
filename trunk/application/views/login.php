<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Food Sprout</title>
	
	<link href="<?php echo base_url()?>css/beta.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url()?>css/jquery.validationEngine.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url()?>css/floating_messages.css" rel="stylesheet" type="text/css" />
	
	<script src="<?php echo base_url()?>js/jquery.js" type="text/javascript"></script>
	<script src="<?php echo base_url()?>js/jquery.plugin.js" type="text/javascript"></script>
	<script type="text/javascript" charset="utf-8" src="<?php echo base_url()?>js/beta.js"></script>
	<script src="<?php echo base_url()?>js/floating_messages.js" type="text/javascript"></script>
	<script src="<?php echo base_url()?>js/jquery.validationEngine.js" type="text/javascript"></script>
	<script src="<?php echo base_url()?>js/jquery.validationEngine-en.js" type="text/javascript"></script>

	<script type="text/javascript">

	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-135491-28']);
	  _gaq.push(['_trackPageview']);

	  (function() {
	    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();

	</script>
</head>



<body class="home">
	<script src="<?php echo base_url()?>js/floating_messages.js" type="text/javascript"></script>
	<div id="alert"></div>
<div id="header">
	<div class="wrapper"> 
			<!--<div id="branding" role="banner"> -->
				<div class="site-title" class="beta"> 
					<h1> 
						<a href="#" title="FoodSprout" rel="home"><span>FoodSprout Private Beta</span></a> 
					</h1> 
				</div> 
				 	<div class="skip-link screen-reader-text" role="navigation"><a href="#headerNav" title="Skip to content">Skip to content</a> 
				</div> 
				
	</div><!-- #wrapper --> 
</div><!-- #header --> 
<script>
	$(document).ready(function() {
		$("#frmLogin").validationEngine({
			scroll:false,
			unbindEngine:false
		});
		
		$("#frmAccount").validationEngine({
			scroll:false,
			unbindEngine:false
		});
		
		
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
<div id="main"> 
  <div class="wrapper"> 
	<div id="content" role="main"> 
			<div id="main-banner" class="left">
				<div class="site-title" class="beta"> 
					<h1><a href="#" title="FoodSprout" rel="home"><span>FoodSprout Private Beta</span></a></h1> 
				</div> 
				<h3 class="site-description">Mapping our food's impact</h3>
				<div id="home-banner">
					<img src="/img/home-banner.png" alt="Connecting dots images" />
				</div>
				<div id="site-goal">
					<h3>Enlisting millions to connect the dots....</h3>
					<h2>...for everyone's benefit</h2>
				</div>
			</div>
			<div id="main-content" class="right">
				<div id="signup-box">
					<div id="signup-box-wrapper">
						<div id="login-wrapper">
							<span>Already have an account?</span>
							<a id="show-login-button" href="/login/">Log In</a>
							<div id="login-form">
								<form action="/login/validate" method="post" name="frmLogin" id="frmLogin">
									<h2>Log In</h2>								
									<input type="text" name="login_email" id="login_email" class="validate[required]" value="Email" onfocus="if(this.value == 'Email')this.value='';" onblur="if(this.value=='')this.value='Email';" />
									<input type="password" name="login_password" id="login_password" class="validate[required]" value="Password" onfocus="if(this.value=='Password')this.value='';" onblur="if(this.value=='')this.value='Password';" />
									<!--label for="remember_me" class="checkbox-wrapper">
										<input type="checkbox" name="remember_me" value="remember_me" id="remember_me" />
										<span>Remember me</span>
									</label -->
									<input type="submit" name="submit" value="Login" />
								</form>
							</div>
						</div>
						<div id="signup-form">
							<h2 id="signup-title">Private Beta</h2>
							<h3>We just launched in July, 2010. Join today for the <b>private beta</b>.</h3>
							<form action="/login/create_user" method="post" name="frmAccount" id="frmAccount">								
								<input type="text" name="firstname" id="firstname" class="validate[required]" value="Full Name" onfocus="if(this.value=='Full Name')this.value='';" onblur="if(this.value=='')this.value='Full Name';">
								<input type="text" name="email" id="email" class="validate[required,custom[email]]" value="Email" onfocus="if(this.value=='Email')this.value='';" onblur="if(this.value=='')this.value='Email';">
								<input type="password" name="password" id="password" class="validate[required,length[8,30]]" value="Password" onfocus="if(this.value=='Password')this.value='';" onblur="if(this.value=='')this.value='Password';">
								<input type="text" name="zipcode" id="zipcode" class="validate[required]" value="Zip Code" onfocus="if(this.value=='Zip Code')this.value='';" onblur="if(this.value=='')this.value='Zip Code';">
								<input type="submit" name="submit" value="Create Account">
							</form>
						</div>
					</div><!-- #signup-box -->	
				</div>
				<div class="signup-box-shadow"></div>
				<div id="news">
					<div id="news-title">
						<h2>News</h2>
						<a class="readmore" href="#">Read more ></a>
						<div id="social-icons">
							<a href="http://twitter.com/foodsprout" id="fs-twitter"><span>Twitter</span></a>
							<a href="http://www.facebook.com/foodsprout" id="fs-facebook"><span>Facebook</span></a>
							<a href="http://blog.foodsprout.com" id="fs-blog"><span>Blog</span></a>
						</div>
					</div>
					<div id="newsbody">
						<div class="news-item">
							<h2><span class="from-twitter"></span><span class="news-date">August 3, 2010</span></h2>
							<p>FoodSprout  We launched a beta version of Food Sprout.
							Mapping the world's food chain, and what's really in your food, start exploring it with us</p>
						</div>
						<div class="news-item">
							<h2><span class="news-date">July 14, 2010</span></h2>
							<p>FoodSprout  We launched a beta version of Food Sprout.
							Mapping the world's food chain, and what's really in your food, start exploring it with us</p>
						</div>
						<div class="news-item">
							<h2><span class="news-date">July 4, 2010</span></h2>
							<p>FoodSprout  We launched a beta version of Food Sprout.
							Mapping the world's food chain, and what's really in your food, start exploring it with us</p>
						</div>
					</div>
				</div>
			</div>			 
	</div><!-- #content --> 
  </div><!-- #wrapper --> 
</div><!-- #main -->
<hr size="1">
<div id="footer" role="contentinfo"> 
	<div class="wrapper">
		<div id="site-info"> 
			<div id="footer-navigation" class="menu-header">
				<ul id="menu-footer" class="menu">
					<li class="menu-item">
						<a href="/about">About Us</a>
					</li> 
					<li class="menu-item">
						<a href="/about/contact">Contact</a>
					</li>
					<li class="menu-item">
						<a href="http://blog.foodsprout.com">Blog</a>
					</li>
					<li class="menu-item">
						<a href="/about/business">Business</a>
					</li>
					<li class="menu-item">
						<a href="/about/terms">Terms</a>
					</li>
					<li class="menu-item">
						<a href="/about/privacy">Privacy</a>
					</li>
				</ul>
			</div>			
		</div><!-- #site-info --> 
	</div><!-- #wrapper -->
</div><!-- #footer --> 
</body>
</html>

<?php
	/*
?>
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
<?php
	*/
?>