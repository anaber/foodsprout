<html>
<head>
	<title>Admin Control Panel</title>
	<link rel="stylesheet" href="<?php echo base_url()?>css/admincp.css" type="text/css" media="all" />
	
	<script src="<?php echo base_url()?>js/jquery.js" type="text/javascript"></script>
	<script src="<?php echo base_url()?>js/jquery.validationEngine_old.js" type="text/javascript"></script>
	<!--<script src="<?php echo base_url()?>js/jquery.validationEngine-en.js" type="text/javascript"></script>-->
	
	<link rel="stylesheet" href="<?php echo base_url()?>css/jquery.autocomplete.frontend.css" type="text/css" />
	
</head>

<body>
<div id="main-container" align="center">
	<div class="header-wide">
		<div id="header">
			<div id="logo">
				<a href="/admincp/dashboard">Food Project</a>
			</div>
		</div>
	</div>
	<br />
	<div align="center">
		<div style="width:980px;">
			<?php $this->load->view('admincp/includes/navigation')?>
		</div>
	</div>