<div class="leftmenu">
<?php
	echo anchor('admincp/manufacture/add_supplier/' . $MANUFACTURE_ID, 'Add Supplier');		
?><br />
<?php
	if (isset($SUPPLIER_ID) && !empty($SUPPLIER_ID) ) {
		 echo anchor('admincp/manufacture/update_supplier/' . $SUPPLIER_ID, 'Update Supplier') . '<br />';
	}
?>
<?php
	echo anchor('admincp/manufacture/add_address/' . $MANUFACTURE_ID, 'Add Address');
?><br />
<?php
	if (isset($ADDRESS_ID) && !empty($ADDRESS_ID) ) {
		 echo anchor('admincp/manufacture/update_address/' . $ADDRESS_ID, 'Update Address') . '<br />';
	}		
?>
<?php echo anchor('admincp/manufacture', 'List Manufactures'); ?><br />
<?php echo anchor('admincp/manufacture/add_menu_item/' . $MANUFACTURE_ID, 'Add Menu Item'); ?><br />
</div>