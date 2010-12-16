<?php echo anchor('admincp/farmtype/add', 'Add Farm Type'); ?><br /><br />

<?php
if (count($FARM_TYPES) > 0 ) {
?>
<table cellpadding="3" cellspacing="0" border="0" id="tbllist">
	<tr>
		<th>Farm Type Id</th>
		<th>Farm Type</th>
	</tr>
			
	
<?php

	$i = 0;
	foreach($FARM_TYPES as $r) :
		$i++;
		echo '<tr class="d'.($i & 1).'">';
		echo '	<td>'.anchor('admincp/farmtype/update/'.$r->farmTypeId, $r->farmTypeId).'</td>';
		echo '	<td>'.anchor('admincp/farmtype/update/'.$r->farmTypeId, $r->farmType).'</td>';
		echo '</tr>';
 	endforeach;
?>
</table>
<?php
} else {
	echo "No farm type available";
}
?>