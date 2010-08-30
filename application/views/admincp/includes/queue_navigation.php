<?php
	$method = $this->uri->segment(3);
?>
<?php echo anchor('admincp/queue', ( empty($method) ? '<b>Farm</b>' : 'Farm') ); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php echo anchor('admincp/queue/farmersmarket', ( $method == 'farmersmarket' ? '<b>Farmers Market</b>' : 'Farmers Market') ); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php echo anchor('admincp/queue/manufacture', ( $method == 'manufacture' ? '<b>Manufacture</b>' : 'Manufacture') ); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php echo anchor('admincp/queue/restaurant', ( $method == 'restaurant' ? '<b>Restaurant</b>' : 'Restaurant') ); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php echo anchor('admincp/queue/distributor', ( $method == 'distributor' ? '<b>Distributor</b>' : 'Distributor') ); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php echo anchor('admincp/queue/supplier', ( $method == 'supplier' ? '<b>Suppliers</b>' : 'Suppliers') ); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php echo anchor('admincp/queue/menu', ( $method == 'menu' ? '<b>Menu Items</b>' : 'Menu Items') ); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<br /><br />