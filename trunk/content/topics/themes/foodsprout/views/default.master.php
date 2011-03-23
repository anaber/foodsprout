<?php echo '<?xml version="1.0" encoding="utf-8"?>'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-ca">
<head>	
   <?php $this->RenderAsset('Head'); ?>

	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
	<link rel="stylesheet" href="/css/mainstyle.css" type="text/css" />
	
	<script type="text/javascript">
	var _gaq = _gaq || [];_gaq.push(['_setAccount', 'UA-135491-28']);_gaq.push(['_trackPageview']);
	(function() {var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);})();
	</script>
	
</head>
<body id="<?php echo $BodyIdentifier; ?>" class="<?php echo $this->CssClass; ?>">

	<!-- header -->
	<div id="header">
	  <div id="headeritms">
	    <div id="logo"><a href="/"><img src="/img/foodsprout-logo.gif" width="198" height="50" alt="Food Sprout" border="0" /></a></div>
	    <!-- login -->

	    <span id="signup">
		<div id="membername">
			<?php
			$Session = Gdn::Session();
			if ($Session->IsValid()) {
				$Name = $Session->User->Name;
			?>
			<strong><?php echo $Name; ?></strong> | 
			<a href="/user/dashboard" style="font-size:13px;text-decoration:none;">Dashboard</a> | 
			<a href="/user/settings" style="font-size:13px;text-decoration:none;">Settings</a> | 
			<a href="/login/signout" style="font-size:13px;text-decoration:none;">Sign Out</a>
			<?php } else {?>
				<a href="/login" style="font-size:13px;text-decoration:none;">Sign In</a> | <a href="/login" style="font-size:13px;text-decoration:none;">Create Account</a>
			<?php } ?>
			</div>
	</span>	<!-- end login -->
	    <!-- main tabs -->

	<div id="navigation">
		<a href="/restaurant">Restaurants</a>	<a href="/manufacture">Products</a>	<a href="/farm">Farms</a>	<a href="/farmersmarket">Farmers Market</a><a href="/topics" class="tabon">Discuss</a></div>    <!-- end main tabs -->
	  </div>

	</div>
	<!-- end header -->


	<!-- leaf bg -->
	<div id="leafimg">

	<!-- main active tab area -->
	<div id="mainimg">

	
   
      <div id="Body">
         <div id="Content"><?php $this->RenderAsset('Content'); ?></div>
         <div id="Panel">
			<div class="Box BoxCategories">
	            <?php
				      
						if ($this->Menu) {
							$this->Menu->AddLink('Dashboard', T('Dashboard'), '/dashboard/settings', array('Garden.Settings.Manage'));
							// $this->Menu->AddLink('Dashboard', T('Users'), '/user/browse', array('Garden.Users.Add', 'Garden.Users.Edit', 'Garden.Users.Delete'));
							$this->Menu->AddLink('Activity', T('Activity'), '/activity');
				         $Authenticator = Gdn::Authenticator();
							if ($Session->IsValid()) {
								$Name = $Session->User->Name;
								$CountNotifications = $Session->User->CountNotifications;
								if (is_numeric($CountNotifications) && $CountNotifications > 0)
									$Name .= ' <span>'.$CountNotifications.'</span>';

	                     if (urlencode($Session->User->Name) == $Session->User->Name)
	                        $ProfileSlug = $Session->User->Name;
	                     else
	                        $ProfileSlug = $Session->UserID.'/'.urlencode($Session->User->Name);
								$this->Menu->AddLink('User', $Name, '/profile/'.$ProfileSlug, array('Garden.SignIn.Allow'), array('class' => 'UserNotifications'));
								$this->Menu->AddLink('SignOut', T('Sign Out'), Gdn::Authenticator()->SignOutUrl(), FALSE, array('class' => 'NonTab SignOut'));
							} else {
								$Attribs = array();
								if (SignInPopup() && strpos(Gdn::Request()->Url(), 'entry') === FALSE)
									$Attribs['class'] = 'SignInPopup';

								$this->Menu->AddLink('Entry', T('Sign In'), Gdn::Authenticator()->SignInUrl(), FALSE, array('class' => 'NonTab'), $Attribs);
							}
							echo $this->Menu->ToString();
						}
					?>
	            <div class="Search"><?php
						$Form = Gdn::Factory('Form');
						$Form->InputPrefix = '';
						echo 
							$Form->Open(array('action' => Url('/search'), 'method' => 'get')),
							$Form->TextBox('Search'),
							$Form->Button('Search', array('Name' => '')),
							$Form->Close();
					?></div>
	         </div>

			<?php $this->RenderAsset('Panel'); ?>
			
		</div>
      </div>
      <div id="Foot">
			<?php
				$this->RenderAsset('Foot');
				//echo Wrap(Anchor(T('Powered by Vanilla'), C('Garden.VanillaUrl')), 'div');
			?>
		</div>
   
	<?php $this->FireEvent('AfterBody'); ?>
	
	</div>
	<!-- end main active tab area -->

	</div>
	<!-- end leaf bg -->


	<!-- footer -->
	<div id="footerbg">
	  <div id="footertext"><a href="/about">About</a> | <a href="/about/contact">Contact</a> | <a href="http://blog.foodsprout.com">Blog</a> | <a href="/about/business">Businesses</a> | <a href="/about/terms">Terms</a> | <a href="/about/privacy">Privacy</a></div>

	</div>
	<br /><br />
	<!-- end footer -->
	
	
</body>
</html>
