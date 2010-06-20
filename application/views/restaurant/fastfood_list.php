<?php
if (count($FASTFOOD) > 0 ) {
?>
<table cellpadding="3" cellspacing="0" border="0" id="tbllist">
	<tr>
		<th>Restaurant Chain</th>
	</tr>
			
	
<?php

	$i = 0;
	foreach($FASTFOOD as $r) :
		$i++;
		echo '<tr class="d'.($i & 1).'">';
		echo '	<td>'.anchor('restaurant/viewchain/'.$r->restaurantChainId, $r->restaurantChain).'</td>';
		echo '</tr>';
 	endforeach;
?>

<?php
} else {
	echo "No restaurant chains available";
}

?>
</table>