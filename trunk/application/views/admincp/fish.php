<?php echo anchor('admincp/fish/add', 'Add Fish'); ?><br /><br />

<?php
if (count($FISHES) > 0 ) {
?>
<table cellpadding="3" cellspacing="0" border="0" id="tbllist">
	<tr>
		<th>Fish Id</th>
		<th>Fish Name</th>
	</tr>
			
	
<?php

	$i = 0;
	foreach($FISHES as $r) :
		$i++;
		echo '<tr class="d'.($i & 1).'">';
		echo '	<td>'.anchor('admincp/fish/update/'.$r->fishId, $r->fishId).'</td>';
		echo '	<td>'.anchor('admincp/fish/update/'.$r->fishId, $r->fishName).'</td>';
		echo '</tr>';
 	endforeach;
?>
</table>
<?php
} else {
	echo "No fish available";
}

?>
