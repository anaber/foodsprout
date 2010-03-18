<?php echo anchor('admincp/plant/add', 'Add Plant'); ?><br /><br />

<?php
if (count($PLANTS) > 0 ) {
?>
<table cellpadding="3" cellspacing="0" border="0" id="tbllist">
	<tr>
		<th>Plant Id</th>
		<th>Plant Name</th>
	</tr>
			
	
<?php

	$i = 0;
	foreach($PLANTS as $r) :
		$i++;
		echo '<tr class="d'.($i & 1).'">';
		echo '	<td>'.anchor('admincp/plant/update/'.$r->plantId, $r->plantId).'</td>';
		echo '	<td>'.anchor('admincp/plant/update/'.$r->plantId, $r->plantName).'</td>';
		echo '</tr>';
 	endforeach;
?>

<?php
} else {
	echo "No plant available";
}

?>
</table>