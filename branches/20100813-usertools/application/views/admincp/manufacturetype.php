<?php echo anchor('admincp/manufacturetype/add', 'Add Manufacture Type'); ?><br /><br />

<?php
if (count($MANUFACTURETYPES) > 0 ) {
?>
<table cellpadding="3" cellspacing="0" border="0" id="tbllist">
	<tr>
		<th>Manufacture Type Id</th>
		<th>Manufacture Type</th>
	</tr>
			
	
<?php

	$i = 0;
	foreach($MANUFACTURETYPES as $r) :
		$i++;
		echo '<tr class="d'.($i & 1).'">';
		echo '	<td>'.anchor('admincp/manufacturetype/update/'.$r->manufactureTypeId, $r->manufactureTypeId).'</td>';
		echo '	<td>'.anchor('admincp/manufacturetype/update/'.$r->manufactureTypeId, $r->manufactureType).'</td>';
		echo '</tr>';
 	endforeach;
?>
</table>
<?php
} else {
	echo "No manufacture type available";
}
?>