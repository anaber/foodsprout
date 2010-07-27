<?php echo anchor('admincp/plantgroup/add', 'Add Plant Group'); ?><br /><br />

<?php
if (count($PLANT_GROUPS) > 0 ) {
?>
<table cellpadding="3" cellspacing="0" border="0" id="tbllist">
	<tr>
		<th>Plant Group Id</th>
		<th>Plant Group Name</th>
		<th>Plant Group Sci Name</th>
	</tr>
			
	
<?php

	$i = 0;
	foreach($PLANT_GROUPS as $r) :
		$i++;
		echo '<tr class="d'.($i & 1).'">';
		echo '	<td>'.anchor('admincp/plantgroup/update/'.$r->plantGroupId, $r->plantGroupId).'</td>';
		echo '	<td>'.anchor('admincp/plantgroup/update/'.$r->plantGroupId, $r->plantGroupName).'</td>';
		echo '	<td>'.anchor('admincp/plantgroup/update/'.$r->plantGroupId, $r->plantGroupSciName).'</td>';
		echo '</tr>';
 	endforeach;
?>
</table>
<?php
} else {
	echo "No plant group available";
}
?>
