<div class="leftmenu">
<?php
	if (isset($SUPPLIER_ID) && !empty($SUPPLIER_ID) ) {
		 echo anchor('admincp/farm/update_supplier/' . $SUPPLIER_ID, 'Update Supplier');
	} else {
		echo anchor('admincp/farm/add_supplier/' . $FARM_ID, 'Add Supplier');
	}		
?><br />
<?php
	if (isset($ADDRESS_ID) && !empty($ADDRESS_ID) ) {
		 echo anchor('admincp/farm/update_address/' . $ADDRESS_ID, 'Update Address');
	} else {
		echo anchor('admincp/farm/add_address/' . $FARM_ID, 'Add Address');
	}		
?><br />
<?php echo anchor('admincp/farm', 'List Farms'); ?><br />
</div>