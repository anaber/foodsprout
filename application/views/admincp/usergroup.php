<?php echo anchor('admincp/usergroup/add', 'Add Usergroup'); ?><br /><br />

<?php
if (count($USERGROUPS) > 0 ) {
?>
<table cellpadding="3" cellspacing="0" border="0" id="tbllist">
	<tr>
		<th>Usergroup Id</th>
		<th>Usergroup Name</th>
	</tr>
			
	
<?php

	$i = 0;
	foreach($USERGROUPS as $r) :
		$i++;
		echo '<tr class="d'.($i & 1).'">';
		echo '	<td>'.anchor('admincp/usergroup/update/'.$r->usergroupId, $r->usergroupId).'</td>';
		echo '	<td>'.anchor('admincp/usergroup/update/'.$r->usergroupId, $r->usergroupName).'</td>';
		echo '</tr>';
 	endforeach;
?>

<?php
} else {
	echo "No usergroup available";
}

?>
</table>