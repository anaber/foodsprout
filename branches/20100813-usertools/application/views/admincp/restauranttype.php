<?php echo anchor('admincp/restauranttype/add', 'Add Restaurant Type'); ?><br /><br />

<?php
if (count($RESTAURANTTYPES) > 0 ) {
?>
<table cellpadding="3" cellspacing="0" border="0" id="tbllist">
	<tr>
		<th>Restaurant Type Id</th>
		<th>Restaurant Type</th>
	</tr>	
<?php

	$i = 0;
	foreach($RESTAURANTTYPES as $r) :
		$i++;
		echo '<tr class="d'.($i & 1).'">';
		echo '	<td>'.anchor('admincp/restauranttype/update/'.$r->restaurantTypeId, $r->restaurantTypeId).'</td>';
		echo '	<td>'.anchor('admincp/restauranttype/update/'.$r->restaurantTypeId, $r->restaurantTypeName).'</td>';
		echo '</tr>';
 	endforeach;
?>
</table>
<?php
} else {
	echo "No restaurant type available";
}
?>