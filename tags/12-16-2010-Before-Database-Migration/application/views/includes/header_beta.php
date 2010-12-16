<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo (isset($SEO->titleTag)? $SEO->titleTag: 'Food Sprout'); ?></title>
<meta name="description" content="<?php echo (isset($SEO->metaDescription)? $SEO->metaDescription: 'Mapping the World\'s Food Chain'); ?>" />
<meta name="keywords" content="<?php echo (isset($SEO->metaKeywords)? $SEO->metaKeywords: 'food source, food location'); ?>" />
<meta name="robots" content="index,follow" />
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />

<link href="/css/mainstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url()?>css/jquery.validationEngine.css" type="text/css" media="screen" title="no title" charset="utf-8" />

<script src="<?php echo base_url()?>js/jquery.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>js/jquery.plugin.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>js/jquery.validationEngine_old.js" type="text/javascript"></script>

<script type="text/javascript">
var _gaq = _gaq || [];_gaq.push(['_setAccount', 'UA-135491-28']);_gaq.push(['_trackPageview']);
(function() {var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);})();
</script>

<style type="text/css">
body {
	background: #E5E5E5;
}
</style>

</head>

<body>
<!-- header -->
<div id="header">
  <div id="headeritms">
    <div id="logo"><a href="/"><img src="/img/foodsprout-logo.gif" width="144" height="44" alt="Food Sprout" border="0" /></a></div>
  
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
		if ($this->session->userdata('isAuthenticated') == 1 )
		{
			$this->load->view('includes/navigation');
		}
		else
		{
			$this->load->view('includes/navigation_beta');
		}
	?>
    <!-- end main tabs -->
  </div>
</div>
<!-- end header -->

<!-- leaf bg -->
<div id="leafimg">
	
<!-- main active tab area -->
<div id="mainimg">