<div class="leftmenu">
<?php echo anchor('admincp/manufacture', 'Manufactures'); ?><br />
<?php echo anchor('admincp/manufacture/add_supplier/' .  ( !empty($TRID) ? $TRID :  $MANUFACTURE_ID ), 'Suppliers'); ?><br />
<?php echo anchor('admincp/manufacture/add_address/' .  ( !empty($TRID) ? $TRID :  $MANUFACTURE_ID ), 'Addresses'); ?><br />
<?php echo anchor('admincp/manufacture/add_menu_item/' .  ( !empty($TRID) ? $TRID :  $MANUFACTURE_ID ), 'Products'); ?><br />
</div>