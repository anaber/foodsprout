<?php echo anchor('admincp/fruittype/add', 'Add Fruit Type'); ?><br /><br />

<?php
if (count($FRUITTYPES) > 0 ) {
?>
<table cellpadding="3" cellspacing="0" border="0" id="tbllist">
	<tr>
		<th>Fruit Type Id</th>
		<th>Fruit Type</th>
	</tr>
			
	
<?php

	$i = 0;
	foreach($FRUITTYPES as $r) :
		$i++;
		echo '<tr class="d'.($i & 1).'">';
		echo '	<td>'.anchor('admincp/fruittype/update/'.$r->fruittypeId, $r->fruittypeId).'</td>';
		echo '	<td>'.anchor('admincp/fruittype/update/'.$r->fruittypeId, $r->fruittypeName).'</td>';
		echo '</tr>';
 	endforeach;
?>
</table>
<?php
} else {
	echo "No fruit type available";
}
?>
