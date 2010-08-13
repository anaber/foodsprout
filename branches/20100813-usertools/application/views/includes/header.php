<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">

<head>
	<title><?php echo (isset($SEO->titleTag)? $SEO->titleTag: 'Food Sprout'); ?></title>
	<meta name="description" content="<?php echo (isset($SEO->metaDescription)? $SEO->metaDescription: 'Mapping the World\'s Food Chain'); ?>" />
	<meta name="keywords" content="<?php echo (isset($SEO->metaKeywords)? $SEO->metaKeywords: 'food source, food location'); ?>" />
	<meta name="robots" content="index,follow" />
	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
	<link type="text/css" rel="stylesheet" media="all" href="/css/main.css" />
		
	<link rel="stylesheet" href="<?php echo base_url()?>css/messages.css" type="text/css" media="all" />
	<link rel="stylesheet" href="<?php echo base_url()?>css/validationEngine.jquery.css" type="text/css" media="screen" title="no title" charset="utf-8" />
	<link rel="stylesheet" href="<?php echo base_url()?>css/popup.css" type="text/css" media="all"/>
	
	<script src="<?php echo base_url()?>js/jquery.js" type="text/javascript"></script>
	<script src="<?php echo base_url()?>js/jquery.plugin.js" type="text/javascript"></script>
	<script src="<?php echo base_url()?>js/jquery.validationEngine.js" type="text/javascript"></script>
	
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
<body>
<div id="main-container" align="center">
	<div class="header-wide">
		<div id="header">
			<div id="logo">
				<a href="/"><img src="/img/food-logo.gif" border="0"></a>
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
			<!-- div id="search">
				<span class="greentxt">Search For</span> <span style="font-size: 11px; color: #666;">(i.e. BigMac, salmon, potato chips)<br>
				<?php
				
					echo form_open('search/results');
					$data = array(
					              'name'        => 'search_query',
					              'id'          => 'search_query',
					              'value'       => 'Search',
					              'maxlength'   => '100',
					              'size'        => '30',
					              'style'       => 'width:300',
								  'class'       => 'search',
					            );

					echo form_input($data);
					echo ' '.form_submit('submit', 'Search', 'class="search"');
					echo '</form>';
				
				?>
			</div -->
		</div>
	</div>

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