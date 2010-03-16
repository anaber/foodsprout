<?php echo anchor('admincp/restaurant/add', 'Add Restaurant'); ?><br /><br />

<table cellpadding="3" cellspacing="0" border="0" id="tbllist">
	<tr>
		<th>Restaurant Id</th>
		<th>Restaurant Name</th>
		<th>Creation Date</td>
	</tr>
			
	
<?php
	$i = 0;
	foreach($RESTAURANTS as $r) :
		$i++;
		echo '<tr class="d'.($i & 1).'">';
		echo '	<td>'.anchor('admincp/restaurant/update/'.$r->restaurantId, $r->restaurantId).'</td>';
		echo '	<td>'.anchor('admincp/restaurant/update/'.$r->restaurantId, $r->restaurantName).'</td>';
		echo '	<td>'. date('Y-m-d', strtotime($r->creationDate) ) .'</td>';
		echo '</tr>';

 	endforeach;
?>
</table>