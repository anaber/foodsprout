<?php echo anchor('admincp/animal/add', 'Add Animal'); ?><br /><br />

<?php
if (count($ANIMALS) > 0 ) {
?>
<table cellpadding="3" cellspacing="0" border="0" id="tbllist">
	<tr>
		<th>Animal Id</th>
		<th>Animal Name</th>
	</tr>
			
	
<?php

	$i = 0;
	foreach($ANIMALS as $r) :
		$i++;
		echo '<tr class="d'.($i & 1).'">';
		echo '	<td>'.anchor('admincp/animal/update/'.$r->animalId, $r->animalId).'</td>';
		echo '	<td>'.anchor('admincp/animal/update/'.$r->animalId, $r->animalName).'</td>';
		echo '</tr>';
 	endforeach;
?>

<?php
} else {
	echo "No animal available";
}

?>
</table>