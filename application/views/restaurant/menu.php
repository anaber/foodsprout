<h2 class="greentxt">Menu</h2>


<?php
if (count($MENU) > 0 ) {
?>
<table cellpadding="3" cellspacing="0" border="0" id="tbllist">
			
	
<?php

	$i = 0;
	foreach($MENU as $r) :
		$i++;
		echo '<tr class="d'.($i & 1).'">';
		echo '	<td><strong>'.$r->productName.'</strong><br><div style="font-size:9px; padding-right:20px;">'.$r->ingredient.'</div><br></td>';
		echo '</tr>';
 	endforeach;
?>

<?php
} else {
	echo "No menu items provided at this time";
}

?>
</table>