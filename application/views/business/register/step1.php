<script>
	$(document).ready(function() {
		$("#frmAccount").validationEngine({
			scroll:false,
			unbindEngine:false
		});
	});
</script>

<?php
	$this->load->view('business/register/top_steps');
?>

<div style = "padding:10px 0 10px 0;">
		
	<div id="main-content" class="left" style = "padding-left:20px;">
		<div id="signup-box">
			<div id="register-box-wrapper">
				<div id="login-wrapper">
					<span>Welcome to Food Sprout</span>
				</div>
				<div id="signup-form">
					<h2 id="signup-title"> </h2>
					<form action="/login/create_user<?php echo ( $this->input->get('frm') <> "" ? "?frm=".$this->input->get('frm') : "" ); ?>" method="post" name="frmAccount" id="frmAccount">								
						
						First Name: <input type="text" name="firstname" id="firstname" class="validate[required]" value="<?php echo set_value('username'); ?>" AUTOCOMPLETE="OF"><br/>
						Last Name: <input type="text" name="username" id="username" class="validate[required]" value="<?php echo set_value('username'); ?>" AUTOCOMPLETE="OFF"><br/>
						
						Phone: <input type="text" name="phone" id="phone" class="validate[required]" value="<?php echo set_value('phone'); ?>" AUTOCOMPLETE="OFF"><br/>
						
						Email: <input type="text" name="email" id="email" class="validate[required,custom[email]]" value="<?php echo set_value('email'); ?>" AUTOCOMPLETE="OFF"><br/>
						
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
	
	<div  id="content" class="right" style = "width:480px;padding-right:20px;">
		
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
			<div class = "clear"></div>
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
				<div class="news-item">
					<h2><span class="news-date">July 4, 2010</span></h2>
					<p>FoodSprout  We launched a beta version of Food Sprout.
					Mapping the world's food chain, and what's really in your food, start exploring it with us</p>
				</div>
				<div class="news-item">
					<h2><span class="news-date">July 4, 2010</span></h2>
					<p>FoodSprout  We launched a beta version of Food Sprout.
					Mapping the world's food chain, and what's really in your food, start exploring it with us</p>
				</div>
				<div class="news-item">
					<h2><span class="news-date">July 4, 2010</span></h2>
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
		
	
	<div class = "clear"></div>
</div>
<div class = "clear"></div>
