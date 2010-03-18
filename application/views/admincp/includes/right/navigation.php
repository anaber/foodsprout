<?php
	if ($this->session->userdata('isAuthenticated') == 1 ) {
?>
	<div id="sec_menu">

	<?php
	/*
	<?php echo anchor('admincp/dashboard', 'Dashboard'); ?><br />
	<?php echo anchor('admincp/company', 'Companies'); ?> <br />
	<?php echo anchor('admincp/farm', 'Farm'); ?><br />
	<?php echo anchor('admincp/distribution', 'Distribution'); ?><br />
	<?php echo anchor('admincp/processing', 'Processing'); ?><br />
	<?php echo anchor('admincp/restaurant', 'Restaurant'); ?><br />
	<?php echo anchor('admincp/animal', 'Animal'); ?><br />
	<?php echo anchor('admincp/fish', 'Fish'); ?><br />
	<?php echo anchor('admincp/ingredient', 'Ingredient'); ?><br />
	<?php echo anchor('admincp/item', 'Item'); ?><br />
	<?php echo anchor('admincp/product', 'Products'); ?><br />
	<?php echo anchor('admincp/country', 'Country'); ?><br />
	<?php echo anchor('admincp/state', 'State'); ?><br />
	<?php echo anchor('admincp/user', 'Users'); ?><br /><br />
	*/
	?>
	
	<?php echo anchor('admincp/insect', 'Insects'); ?><br />
	<?php echo anchor('admincp/cuisine', 'Cuisines'); ?><br />
	<?php echo anchor('admincp/plant', 'Plants'); ?><br />
	<?php echo anchor('admincp/plantgroup', 'Plant Groups'); ?><br />
	<br />
	<strong>Types</strong><br>
	<?php echo anchor('admincp/ingredienttype', 'Ingredient Type'); ?><br />
	<?php echo anchor('admincp/fruittype', 'Fruit Type'); ?><br />
	<?php echo anchor('admincp/meattype', 'Meat Type'); ?><br />
	<?php echo anchor('admincp/facilitytype', 'Processing Facility Type'); ?><br />
	<?php echo anchor('admincp/producttype', 'Product Type'); ?><br />
	<?php echo anchor('admincp/restauranttype', 'Restaurant Type'); ?><br />
	<?php echo anchor('admincp/vegetabletype', 'Vegetable Type'); ?><br /><br />
	
	<?php echo anchor('admincp/logout', 'Logout'); ?>

</div>

<?php
	}
?>
