<html>

<head>
	<title>Admin Control Panel</title>
	<link rel="stylesheet" href="<?php echo base_url()?>css/admincp.css" type="text/css" media="all" />
	<link rel="stylesheet" href="<?php echo base_url()?>css/validationEngine.jquery.css" type="text/css" media="screen" title="no title" charset="utf-8" />
	
	
	<script src="<?php echo base_url()?>js/jquery.js" type="text/javascript"></script>
	<script src="<?php echo base_url()?>js/jquery.validationEngine.js" type="text/javascript"></script>
	
</head>

<body>

<?php
	if ($this->session->userdata('isAuthenticated') == 1 ) {
?>
<div id="main_menu">

	<?php echo anchor('admincp/dashboard', 'Dashboard'); ?> |
	<?php echo anchor('admincp/company', 'Companies'); ?> | 
	<?php echo anchor('admincp/farm', 'Farm'); ?> |
	<?php echo anchor('admincp/distribution', 'Distribution'); ?> |
	<?php echo anchor('admincp/processing', 'Processing'); ?> | 
	<?php echo anchor('admincp/restaurant', 'Restaurant'); ?> |
	<?php echo anchor('admincp/animal', 'Animal'); ?> |
	<?php echo anchor('admincp/fish', 'Fish'); ?> |
	<?php echo anchor('admincp/ingredient', 'Ingredient'); ?> | 
	<?php echo anchor('admincp/item', 'Item'); ?> | 
	<?php echo anchor('admincp/product', 'Products'); ?> ----- 
	<?php echo anchor('admincp/country', 'Country'); ?> | 
	<?php echo anchor('admincp/state', 'State'); ?> -----
	<?php echo anchor('admincp/user', 'Users'); ?> -----

	<?php echo anchor('admincp/logout', 'Logout'); ?>
</div>
<hr size="1">
<?php
	}
?>

