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
<?php
	if ($this->session->userdata('isAuthenticated') == 1 ) {
?>
	<?php echo anchor('admincp/logout', 'Logout'); ?>
<?php
	}
?>
</div>