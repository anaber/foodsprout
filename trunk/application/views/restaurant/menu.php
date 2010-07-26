<h2 class="greentxt">Menu</h2>

<?php
if (count($MENU) > 0 ) {
?>			
	
<?php

	$i = 0;
	foreach($MENU as $r) :
		$i++;	
		echo '<div><strong>'.$r->productName.'</strong></div><div style="font-size:9px; padding-right:20px;">Ingredients: '.$r->ingredient.'</div><br>';
 	endforeach;
?>

<?php
} else {
	echo "<div>No menu items provided at this time.</div>";
}

?>