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
</head>
<body>
<div id="main-container" align="center">
	<div class="header-wide">
		<div id="header">
			<div id="logo">
				<a href="/"><img src="/images/food-logo.gif" border="0"></a>
			</div>
			<div id="account">
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
			</div>
			<div id="search">
				<span class="greentxt">Search For</span> <span style="font-size: 11px; color: #666;">(i.e. BigMac, salmon, potato chips)<br>
				<?php
				
					echo form_open('search/results');
					$data = array(
					              'name'        => 'search_query',
					              'id'          => 'search_query',
					              'value'       => 'Search',
					              'maxlength'   => '100',
					              'size'        => '50',
					              'style'       => 'width:86%',
					            );

					echo form_input($data);
					echo ' '.form_submit('submit', 'Search');
					echo '</form>';
				
				?>
			</div>
		</div>
	</div>
	<div class="nav-wide"><br>
		<div id="main-nav">
			<ul id="navlist"><li id="active"><?php echo anchor('product', 'Products', array('id' => 'current')); ?></li>
			<li><?php echo anchor('company', 'Companies & Brands'); ?></li>
			<li><?php echo anchor('farm', 'Farms'); ?></li>
			<li><?php echo anchor('processing', 'Processing Facilities'); ?></li>
			<li><?php echo anchor('distribution', 'Distribution Centers'); ?></li>
			</ul>
		</div>
	</div>