<?php echo anchor('admincp/ingredient/add', 'Add Ingredient'); ?><br /><br />

<table cellpadding="3" cellspacing="0" border="0" id="tbllist">
	<tr>
		<th>Ingredient Id</th>
		<th>Ingredient Name</th>
	</tr>
			
	
<?php
	$i = 0;
	foreach($INGREDIENTS as $r) :
		$i++;
		echo '<tr class="d'.($i & 1).'">';
		echo '	<td>'.anchor('admincp/ingredient/update/'.$r->ingredientId, $r->ingredientId).'</td>';
		echo '	<td>'.anchor('admincp/ingredient/update/'.$r->ingredientId, $r->ingredientName).'</td>';
		echo '</tr>';

 	endforeach;
?>
</table>