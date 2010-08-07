<br>
<h2 class="greentxt">Suppliers</h2>

<?php
if (count($SUPPLIERS) > 0 ) {
?>
			
	
<?php

	$i = 0;
	foreach($SUPPLIERS as $r) :
		$i++;
		echo '<div>'.$r->supplierName.' ('.$r->supplierType.')</div>';
 	endforeach;
?>

<?php
} else {
	echo "<div>Suppliers not provided by Restaurant</div>";
}
?>

<a href = "/restaurant/add_supplier/<?php echo $RESTAURANT_ID; ?>">Add Supplier</a>
