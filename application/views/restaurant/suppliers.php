<br>
<h2 class="greentxt">Suppliers</h2>

<?php
if (count($SUPPLIER) > 0 ) {
?>
<table cellpadding="3" cellspacing="0" border="0" id="tbllist">
			
	
<?php

	$i = 0;
	foreach($SUPPLIER as $r) :
		$i++;
		echo '<tr class="d'.($i & 1).'">';
		echo '	<td>'.$r.'</td>';
		echo '</tr>';
 	endforeach;
?>

<?php
} else {
	echo "No menu items provided at this time";
}

?>
</table>