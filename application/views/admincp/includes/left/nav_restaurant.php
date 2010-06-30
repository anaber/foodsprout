<div class="leftmenu">
<?php
	if (isset($SUPPLIER_ID) && !empty($SUPPLIER_ID) ) {
		 echo anchor('admincp/restaurant/update_supplier/' . $SUPPLIER_ID, 'Update Supplier');
	} else {
		echo anchor('admincp/restaurant/add_supplier/' . $RESTAURANT_ID, 'Add Supplier');
	}		
?><br />
<?php
	echo anchor('admincp/restaurant/add_address/' . $RESTAURANT_ID, 'Add Address');
?><br />
<?php
	if (isset($ADDRESS_ID) && !empty($ADDRESS_ID) ) {
		 echo anchor('admincp/restaurant/update_address/' . $ADDRESS_ID, 'Update Address') . '<br />';
	}		
?>
<?php echo anchor('admincp/restaurant', 'List Restaurant'); ?><br />
<?php echo anchor('admincp/restaurant/add_menu_item', 'Add Menu Item'); ?><br />
</div>