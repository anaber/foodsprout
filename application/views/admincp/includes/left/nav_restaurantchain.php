<div class="leftmenu">
<?php
	echo anchor('admincp/restaurantchain/add_supplier/' . $RESTAURANT_CHAIN_ID, 'Add Supplier');
?><br />
<?php
	if (isset($SUPPLIER_ID) && !empty($SUPPLIER_ID) ) {
		 echo anchor('admincp/restaurantchain/update_supplier/' . $SUPPLIER_ID, 'Update Supplier') . '<br />';
	}
?>
<?php echo anchor('admincp/restaurantchain', 'List Restaurant Chain'); ?><br />
<?php echo anchor('admincp/restaurantchain/add_menu_item/' . $RESTAURANT_CHAIN_ID, 'Add Menu Item'); ?><br />
</div>