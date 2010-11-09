<h2 class="greentxt">Products</h2>

<?php
if (count($PRODUCT) > 0 ) {
?>			
	
<?php

	$i = 0;
	foreach($PRODUCT as $r) :
		$i++;	
		echo '<div><strong>'.$r->productName.'</strong></div><div style="font-size:9px; padding-right:20px;">Ingredients: '.$r->ingredient.'</div><br>';
 	endforeach;
?>

<?php
} else {
	echo "<div>No products provided at this time by the manufacture.</div>";
}

?>