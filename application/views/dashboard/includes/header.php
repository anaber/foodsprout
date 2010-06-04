<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">

<head>
	<title>Mapping the World's Food Chain</title>
	<meta name="description" content="Mapping the World's Food Chain" />
	<meta name="keywords" content="food source, food location" />
	<meta name="robots" content="index,follow" />
	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
	<link type="text/css" rel="stylesheet" media="all" href="/css/main.css" />
		
	<link rel="stylesheet" href="<?php echo base_url()?>css/messages.css" type="text/css" media="all" />
	<link rel="stylesheet" href="<?php echo base_url()?>css/validationEngine.jquery.css" type="text/css" media="screen" title="no title" charset="utf-8" />
	
	<script src="<?php echo base_url()?>js/jquery.js" type="text/javascript"></script>
	<script src="<?php echo base_url()?>js/jquery.validationEngine.js" type="text/javascript"></script>
	
</head>
<body>
<div id="main-container" align="center">
	<div class="header-wide">
		<div id="header">
			<div id="logo">
				<a href="/user/dashboard"><img src="/images/food-logo-dashboard.gif" border="0"></a>
			</div>
			<div id="account">
				<?php
					if ($this->session->userdata('isAuthenticated') == 1 )
					{
						$this->load->view('dashboard/includes/menu_logout');
					}
					else
					{
						$this->load->view('includes/menu_login');
					}
				?>
			</div>
			
		</div>
	</div>
	<?php $this->load->view('dashboard/includes/navigation') ?>
	