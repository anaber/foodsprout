<?php echo anchor('admincp/insect/add', 'Add Insect'); ?><br /><br />

<?php
if (count($INSECTS) > 0 ) {
?>
<table cellpadding="3" cellspacing="0" border="0" id="tbllist">
	<tr>
		<th>Insect Id</th>
		<th>Insect Name</th>
	</tr>
			
	
<?php

	$i = 0;
	foreach($INSECTS as $r) :
		$i++;
		echo '<tr class="d'.($i & 1).'">';
		echo '	<td>'.anchor('admincp/insect/update/'.$r->insectId, $r->insectId).'</td>';
		echo '	<td>'.anchor('admincp/insect/update/'.$r->insectId, $r->insectName).'</td>';
		echo '</tr>';
 	endforeach;
?>

<?php
} else {
	echo "No insect available";
}

?>
</table>