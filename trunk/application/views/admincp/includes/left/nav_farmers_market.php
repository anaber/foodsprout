<div class="leftmenu">
<?php echo anchor('admincp/farmersmarket', 'Farmers Market'); ?><br />
<?php echo anchor('admincp/farmersmarket/add_supplier/' . ( !empty($TRID) ? $TRID :  $FARMERS_MARKET_ID ), 'Suppliers'); ?><br />
<?php echo anchor('admincp/farmersmarket/add_address/' . ( !empty($TRID) ? $TRID :  $FARMERS_MARKET_ID ), 'Addresses'); ?><br />
</div>