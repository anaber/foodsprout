<br>
<h2 class="greentxt"><?php echo $MANUFACTURE->manufactureName; ?>'s Suppliers</h2>

<?php
if (count($SUPPLIER) > 0 ) {
?>
			
	
<?php

	$i = 0;
	foreach($SUPPLIER as $r) :
		$i++;
		echo '<div>'.$r->supplierName.' ('.$r->supplierType.')</div>';
 	endforeach;
?>

<?php
} else {
	echo "<div>Suppliers not provided by manufacture</div>";
}

?>