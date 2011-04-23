<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>

<!-- SEO -->
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo (isset($SEO->titleTag)? $SEO->titleTag: 'Food Sprout'); ?></title>
<meta name="description" content="<?php echo (isset($SEO->metaDescription)? $SEO->metaDescription: 'Mapping the World\'s Food Chain'); ?>" />
<meta name="keywords" content="<?php echo (isset($SEO->metaKeywords)? $SEO->metaKeywords: 'food source, food location'); ?>" />
<meta name="robots" content="index,follow" />

<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />

<!-- Mandatory CSS -->
<link rel="stylesheet" href="<?php echo base_url();?>css/mainstyle.css" type="text/css" />
<!-- Custom CSS -->
<?php 
if (isset ($ASSETS['CSS']) ) {
	foreach ($ASSETS['CSS'] as $key => $css_file) {
		echo '<link href="' . base_url() . 'css/'.$css_file.'.css" rel="stylesheet" type="text/css" />';
	}
}
?>

<!-- Mandatory JS -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js" type="text/javascript"></script>
<!-- Custom JS -->
<?php 
if (isset ($ASSETS['JS']) ) {
	foreach ($ASSETS['JS'] as $key => $js_file) {
		echo '<script src="' . base_url() .'js/' . $js_file . '.js" type="text/javascript"></script>';
	}
}
?>
<?php
	$this->load->view('includes/ga');
?>

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

<!-- header -->
<div id="header">
  <div id="headeritms">
    <div id="logo"><a href="/"><img src="/img/foodsprout-logo.gif" width="198" height="50" alt="Food Sprout" border="0" /></a></div>
    <!-- login -->
    <?php
    	if ($this->session->userdata('isAuthenticated') == 1 ) {
			$this->load->view('includes/menu_logout');
		} else {
			$this->load->view('business/includes/menu_login');
		}
	?>
	<!-- end login -->
    <!-- main tabs -->
    <?php
		$this->load->view('business/includes/navigation');
	?>
	<!-- end main tabs -->
	<div style = "float:right;border:0px solid #FF0000;color:#FFFFFF;font-size:20px;">
		Business Services
	</div>
  </div>
  <div class = "clear"></div><div class = "clear"></div>
</div>
<!-- end header -->

	
<!-- leaf bg -->
<?php /* ?><div id="leafimg"><?php */ ?>
<div id="leafimg">
<!-- main active tab area -->
<?php /* ?><div id="mainimg"><?php */ ?>
<div id="mainimg">
