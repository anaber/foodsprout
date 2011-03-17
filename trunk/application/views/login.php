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


<?php
	$return = $this->input->get('return');
	
	if (!$return) {
		$return = $this->input->post('return');
	}
?>
<body class="home">
	<script src="<?php echo base_url()?>js/floating_messages.js" type="text/javascript"></script>
	<div id="alert"></div>
<div id="header">
	<div class="wrapper"> 
			<!--<div id="branding" role="banner"> -->
				<div class="site-title" class="beta"> 
					<h1> 
						<a href="/" title="FoodSprout" rel="home"><span>Food Sprout</span></a> 
					</h1> 
				</div> 
				 	<div class="skip-link screen-reader-text" role="navigation"><a href="#headerNav" title="Skip to content">Skip to content</a> 
				</div> 
				<div id="login-form">
					<form action="/login/validate<?php echo ( !empty($VANILLA) && $VANILLA == 1 ? "?vanilla=1" : "" ); ?>" method="post" name="frmLogin" id="frmLogin">
							<input type="checkbox" id="remember" name = "remember"/>
							<span>Remember me</span>
							<span> | </span>
							<span><a href="<?php echo base_url();?>login/forgotpassword" title="Forgot" >Forgot Password?</a></span>
						<br/>						
						<input type="text" name="login_email" id="login_email" class="validate[required]" value="<?php if($this->input->post('login_email') != '' ){echo $this->input->post('login_email');}else{echo 'Email';} ?>" onFocus="if(this.value == 'Email')this.value='';" onBlur="if(this.value=='')this.value='Email';" /> <input type="password" name="login_password" id="login_password" class="validate[required]" value="Password" onFocus="if(this.value=='Password')this.value='';" onBlur="if(this.value=='')this.value='Password';" />
						<input type = "hidden" name = "return" value = "<?php echo $return; ?>">
						<input type="submit" name="submit" value="Login" />
					</form>
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
		}else if($ERROR == 'registration_failed'){
			
			$message = "Registration error! Please contact Administrator!";
			
		}else if($ERROR == 'duplicate'){
			
			$message = "This email is already registered!";
			
		}else if($ERROR == 'empty_email'){
			
			$message = "Please enter email address!";
			
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
	
		<div class="validation_error">
			<?php
			
				if(isset($flashdata) && sizeof($flashdata) > 0){
					
					foreach ($flashdata as $mes){					
						echo $mes. " <br />";					
					}	
				}
			
			
				echo validation_errors(); 	
			
			?>
		</div>
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
							<span>Welcome to Food Sprout</span>
						</div>
						<div id="signup-form">
							<h2 id="signup-title"> </h2>
							<h3>Join today for <b>free</b> and get started exploring your food.</h3>
							<form action="/login/create_user" method="post" name="frmAccount" id="frmAccount">								
								Full Name: <input type="text" name="firstname" id="firstname" class="validate[required]" value="<?php echo set_value('firstname', 'Full Name'); ?>" onFocus="if(this.value=='Full Name')this.value='';" onBlur="if(this.value=='')this.value='Full Name';"><br/>
								Email: <input type="text" name="email" id="email" class="validate[required,custom[email]]" value="<?php echo set_value('email', 'Email'); ?>" onFocus="if(this.value=='Email')this.value='';" onBlur="if(this.value=='')this.value='Email';"><br/>
								Password: <input type="password" name="password" id="password" class="validate[required,length[8,30]]" value="<?php echo set_value('password', 'Password'); ?>" onFocus="if(this.value=='Password')this.value='';" onBlur="if(this.value=='')this.value='Password';"><br/>
								Zip Code: <input type="text" name="zipcode" id="zipcode" class="validate[required]" value="<?php echo set_value('zipcode', 'Zip Code'); ?>" onFocus="if(this.value=='Zip Code')this.value='';" onBlur="if(this.value=='')this.value='Zip Code';"><br/>
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
<div align="center"><hr size="1"></div>
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