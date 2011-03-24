<div class="leftmenu">
<?php echo anchor('admincp/restaurantchain', 'Restaurant Chain'); ?><br />
<?php echo anchor('admincp/restaurantchain/add_supplier/' .  ( !empty($TRID) ? $TRID :  $RESTAURANT_CHAIN_ID ), 'Suppliers'); ?><br />
<?php echo anchor('admincp/restaurantchain/add_menu_item/' .  ( !empty($TRID) ? $TRID :  $RESTAURANT_CHAIN_ID ), 'Menu Items'); ?><br />
</div>