<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo (isset($SEO->titleTag)? $SEO->titleTag: 'Food Sprout'); ?></title>
<meta name="description" content="<?php echo (isset($SEO->metaDescription)? $SEO->metaDescription: 'Mapping the World\'s Food Chain'); ?>" />
<meta name="keywords" content="<?php echo (isset($SEO->metaKeywords)? $SEO->metaKeywords: 'food source, food location'); ?>" />
<meta name="robots" content="index,follow" />
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
<link rel="stylesheet" href="<?php echo base_url();?>css/mainstyle.css" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url()?>css/jquery.autocomplete.frontend.css" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url()?>css/uploadify.css" type="text/css" /> 
<link rel="stylesheet" href="<?php echo base_url()?>css/jquery.lightbox-0.5.css" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url()?>css/floating_messages.css" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url()?>css/thickbox.css" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url()?>css/jquery.datepick.css" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url()?>js/fancybox/jquery.fancybox-1.3.4.css" type="text/css" />
<?php 
if (isset ($CSS) ) {
	foreach ($CSS as $key => $css_file) {
		echo '<link href="' . base_url() . 'css/'.$css_file.'.css" rel="stylesheet" type="text/css" />';
	}
}
?>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>js/jquery.plugin.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>js/floating_messages.js" type="text/javascript"></script>
<?php
$module = $this->uri->segment(1);
$page = $this->uri->segment(2);

$arr = array(
		'addrestaurant',
		'addfarm',
		'addmarket'
		);
if (in_array($page, $arr)) {
?>
<script src="<?php echo base_url()?>js/jquery.validationEngine-v2.js" type="text/javascript"></script>
<?php
} else {
?>
<script src="<?php echo base_url()?>js/jquery.validationEngine.js" type="text/javascript"></script>
<?php
}
?>
<script src="<?php echo base_url()?>js/jquery.validationEngine-en.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>js/thickbox.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>js/jquery.datepick.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>js/jquery.autocomplete.frontend.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>js/fancybox/jquery.fancybox-1.3.4.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>js/script.js" type="text/javascript"></script>


<script type="text/javascript">
var _gaq = _gaq || [];_gaq.push(['_setAccount', 'UA-135491-28']);_gaq.push(['_trackPageview']);
(function() {var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);})();
</script>

<script type='text/javascript' src='http://partner.googleadservices.com/gampad/google_service.js'></script>
<script type='text/javascript'>GS_googleAddAdSenseService("ca-pub-5358554883766443");GS_googleEnableAllServices();</script>
<script type='text/javascript'>GA_googleAddSlot("ca-pub-5358554883766443", "FoodSprout-ROS-MediumRec");GA_googleAddSlot("ca-pub-5358554883766443", "FoodSprout-ROS-Sky");</script>
<script type='text/javascript'>GA_googleFetchAds();</script>

</head>
<body>
<div id="alert"></div>
<script>		
<?php
	if (isset($_SESSION['ERROR']) ) {
		
		if ($_SESSION['ERROR'] == 'registration_success') {
			$message = 'Account successfuly created';
			
		}
?>
		var $alert = $('#alert');
		message = '<?php echo $message; ?>';
		displayProcessingMessage($alert, message);
		displayFailedMessage($alert, message);
		hideMessage($alert, '', '');
<?php
		unset($_SESSION['ERROR']);
	}
	
?>
</script> 
<div id="container">
<!-- header -->
<div id="header">
  <div id="headeritms">
    <div id="logo"><a href="/"><img src="/img/foodsprout-logo.gif" width="198" height="50" alt="Food Sprout" border="0" /></a></div>
    <!-- login -->
    <?php
    	if ($this->session->userdata('isAuthenticated') == 1 )
		{
			$this->load->view('includes/menu_logout');
		}
		else
		{
			$this->load->view('includes/menu_login');
		}
	?>
	<!-- end login -->
    <!-- main tabs -->
    <?php
			$this->load->view('includes/navigation');
	?>
    <!-- end main tabs -->
  </div>
</div>
<!-- end header -->

	
<!-- leaf bg -->
<?php /* ?><div id="leafimg"><?php */ ?>
<div id="leafimg">

<!-- main active tab area -->
<?php /* ?><div id="mainimg"><?php */ ?>
<div id="mainimg">
<?php
	/*
	$module = $this->uri->segment(1);
	if ($module == 'tab') {
?>
		<div class="tell_friend">Tell a Friend</div>
<?php	
	}
	*/
?>