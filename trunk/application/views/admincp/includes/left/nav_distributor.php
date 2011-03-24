<div class="leftmenu">
<?php echo anchor('admincp/distributor', 'Distributors'); ?><br />
<?php echo anchor('admincp/distributor/add_supplier/' . ( !empty($TRID) ? $TRID : $DISTRIBUTOR_ID ), 'Suppliers'); ?><br />
<?php echo anchor('admincp/distributor/add_address/' . ( !empty($TRID) ? $TRID : $DISTRIBUTOR_ID ), 'Addresses'); ?><br />
</div>