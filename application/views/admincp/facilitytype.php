<?php echo anchor('admincp/facilitytype/add', 'Add Processing Facility Type'); ?><br /><br />

<?php
if (count($FACILITYTYPES) > 0 ) {
?>
<table cellpadding="3" cellspacing="0" border="0" id="tbllist">
	<tr>
		<th>Facility Type Id</th>
		<th>Facility Type Name</th>
	</tr>
			
	
<?php

	$i = 0;
	foreach($FACILITYTYPES as $r) :
		$i++;
		echo '<tr class="d'.($i & 1).'">';
		echo '	<td>'.anchor('admincp/facilitytype/update/'.$r->facilitytypeId, $r->facilitytypeId).'</td>';
		echo '	<td>'.anchor('admincp/facilitytype/update/'.$r->facilitytypeId, $r->facilitytypeName).'</td>';
		echo '</tr>';
 	endforeach;
?>
</table>
<?php
} else {
	echo "No facility type available";
}
?>