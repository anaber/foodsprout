<?php echo anchor('admincp/ingredienttype/add', 'Add Ingredient Type'); ?><br /><br />

<?php
if (count($INGREDIENTTYPES) > 0 ) {
?>
<table cellpadding="3" cellspacing="0" border="0" id="tbllist">
	<tr>
		<th>Ingredient Type Id</th>
		<th>Ingredient Type</th>
	</tr>
			
	
<?php

	$i = 0;
	foreach($INGREDIENTTYPES as $r) :
		$i++;
		echo '<tr class="d'.($i & 1).'">';
		echo '	<td>'.anchor('admincp/ingredienttype/update/'.$r->ingredienttypeId, $r->ingredienttypeId).'</td>';
		echo '	<td>'.anchor('admincp/ingredienttype/update/'.$r->ingredienttypeId, $r->ingredienttypeName).'</td>';
		echo '</tr>';
 	endforeach;
?>
</table>
<?php
} else {
	echo "No ingredient type available";
}
?>