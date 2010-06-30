<div class="leftmenu">
<?php
	if (isset($SUPPLIER_ID) && !empty($SUPPLIER_ID) ) {
		 echo anchor('admincp/distributor/update_supplier/' . $SUPPLIER_ID, 'Update Supplier');
	} else {
		echo anchor('admincp/distributor/add_supplier/' . $DISTRIBUTOR_ID, 'Add Supplier');
	}		
?><br />
<?php
	echo anchor('admincp/distributor/add_address/' . $DISTRIBUTOR_ID, 'Add Address');
?><br />
<?php
	if (isset($ADDRESS_ID) && !empty($ADDRESS_ID) ) {
		 echo anchor('admincp/distributor/update_address/' . $ADDRESS_ID, 'Update Address') . '<br />';
	}	
?>
<?php echo anchor('admincp/distributor', 'List Distributors'); ?><br />
</div>