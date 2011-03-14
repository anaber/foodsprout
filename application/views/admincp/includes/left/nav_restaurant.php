<div class="leftmenu">
<?php echo anchor('admincp/restaurant', 'Restaurants'); ?><br />
<?php echo anchor('admincp/restaurant/add_supplier/' . ( !empty($TRID) ? $TRID : $RESTAURANT_ID ), 'Suppliers'); ?><br />
<?php echo anchor('admincp/restaurant/add_address/' . ( !empty($TRID) ? $TRID : $RESTAURANT_ID ), 'Addresses'); ?><br />
<?php echo anchor('admincp/restaurant/add_menu_item/' . ( !empty($TRID) ? $TRID : $RESTAURANT_ID ), 'Menu Items'); ?><br />
</div>