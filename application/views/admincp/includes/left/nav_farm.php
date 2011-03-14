<div class="leftmenu">
<?php echo anchor('admincp/farm', 'Farms'); ?><br />
<?php echo anchor('admincp/farm/add_supplier/' . ( !empty($TRID) ? $TRID : $FARM_ID ), 'Suppliers'); ?><br />
<?php echo anchor('admincp/farm/add_address/' . ( !empty($TRID) ? $TRID : $FARM_ID ), 'Addresses'); ?><br />
</div>