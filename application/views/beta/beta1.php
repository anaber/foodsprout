<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Food Sprout</title>
	
	<link href="/css/beta.css" rel="stylesheet" type="text/css" />
	
	<script type="text/javascript" charset="utf-8" src="http://code.jquery.com/jquery-latest.min.js"></script>
	<script type="text/javascript" charset="utf-8" src="<?php echo base_url()?>js/beta.js"></script>
	<script src="<?php echo base_url()?>js/floating_messages.js" type="text/javascript"></script>
</head>



<body class="home">
<div id="header">
	<div id="alert"></div>
	<div class="wrapper"> 
			<!--<div id="branding" role="banner"> -->
				<div class="site-title" class="beta"> 
					<h1> 
						<a href="#" title="FoodSprout" rel="home"><span>FoodSprout Private Beta</span></a> 
					</h1> 
				</div> 
				 	<div class="skip-link screen-reader-text" role="navigation"><a href="#headerNav" title="Skip to content">Skip to content</a> 
				</div> 
				<!--<div id="search"> 
							<form role="search" method="get" id="searchform" action="http://terra.looksystems.net/" > 
					<div><label class="screen-reader-text" for="s">Search for:</label> 
					<input type="text" value="" name="s" id="s" /> 
					<input type="submit" id="searchsubmit" value="Search" /> 
					</div> 
					</form>		
				</div> -->
				<!--<div id="site-navigation" role="navigation"> 
					<ul id="menu-main" class="menu">
						<li class="menu-item">
							<a href="#">Restaurants</a>
						</li> 
						<li class="menu-item">
							<a href="#">Manufactures</a>
						</li>
						<li class="menu-item">
							<a href="#">Distributors</a>
						</li>
						<li class="menu-item">
							<a href="#">Farms</a>
						</li>
					</ul> 
				</div><!-- #site-nav --*>-->
				<div id="access" role="navigation">
					<ul id="menu-user" class="menu">
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
							<a href="/about/business">Businesses</a>
						</li>
						<li class="menu-item">
							<a href="/about/terms">Terms</a>
						</li>
						<li class="menu-item">
							<a href="/about/privacy">Privacy</a>
						</li>
					</ul> 	
				</div><!-- #access --> 
	</div><!-- #wrapper --> 
</div><!-- #header -->  
<div id="main"> 
  <div class="wrapper"> 
	<div id="content" role="main"> 
			<div id="main-banner" class="left">
				<div class="site-title" class="beta"> 
					<h1><a href="#" title="FoodSprout" rel="home"><span>FoodSprout Beta</span></a></h1> 
				</div> 
				<h3 class="site-description">Mapping our food's impact.</h3>
				<div id="home-banner">
					<img src="/img/home-banner.png" alt="Food Sprout.  Mapping our food's impact." />
				</div>
				<span style="font-color:#999;font-size:130%;">And, enlisting millions to connect the dots...<br/><br/> ...for everyone's benefit.</span>
			</div>
			<div id="main-content" class="right">
				<div id="signup-box">
					<div id="signup-box-wrapper">
						<div id="login-wrapper">
							<span>Already have an account?</span>
							<a id="show-login-button" href="http://www.foodsprout.com/login/">Log In</a>
							<div id="login-form">
								<form action="http://www.foodsprout.com/login/validate" method="post" name="frmLogin" id="frmLogin">
									<h2>Log In</h2>								
									<input type="text" name="login_email" id="login_email" class="validate[required]" value="Email" onkeypress="if(this.value=='Email')this.value='';" onblur="if(this.value=='')this.value='Email';" />
									<input type="password" name="login_password" id="login_password" class="validate[required]" value="Password" onkeypress="if(this.value=='Password')this.value='';" onblur="if(this.value=='')this.value='Password';" />
									<label for="remember_me" class="checkbox-wrapper">
										<input type="checkbox" name="remember_me" value="remember_me" id="remember_me" />
										<span>Remember me</span>
									</label>
									<input type="submit" name="submit" value="Login" />
								</form>
							</div>
						</div>
						<div id="signup-form">
							<h2>Private Beta</h2>
							<form action="http://www.foodsprout.com/login/create_user" method="post" name="frmAccount" id="frmAccount">								
								<input type="text" name="firstname" id="firstname" class="validate[required]">
								<input type="text" name="email" id="email" class="validate[required,custom[email]]">
								<input type="password" name="password" id="password" class="validate[required,length[8,30]]">
								<input type="text" name="zipcode" id="zipcode" class="validate[required]">
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
							<a href="#" id="fs-twitter"><span>Twitter</span></a>
							<a href="#" id="fs-facebook"><span>Facebook</span></a>
							<a href="#" id="fs-blog"><span>Blog</span></a>
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
<div id="footer" role="contentinfo"> 
	<div class="wrapper">
		<div id="site-info"> 
			<!--<div id="footer-navigation" class="menu-header">
				<ul id="menu-footer" class="menu">
					<li class="menu-item">
						<a href="#">About Us</a>
					</li> 
					<li class="menu-item">
						<a href="#">Contact</a>
					</li>
					<li class="menu-item">
						<a href="#">Blog</a>
					</li>
					<li class="menu-item">
						<a href="#">Help</a>
					</li>
					<li class="menu-item">
						<a href="#">Terms</a>
					</li>
					<li class="menu-item">
						<a href="#">Privacy</a>
					</li>
				</ul>
			</div>-->			
		</div><!-- #site-info --> 
	</div><!-- #wrapper -->
</div><!-- #footer --> 
</body>
</html>