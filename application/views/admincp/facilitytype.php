<?php echo anchor('admincp/facilitytype/add', 'Add Facility_type'); ?><br /><br />

<?php
if (count($FACILITYTYPES) > 0 ) {
?>
<table cellpadding="3" cellspacing="0" border="0" id="tbllist">
	<tr>
		<th>Facility_type Id</th>
		<th>Facility_type Name</th>
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

<?php
} else {
	echo "No facilitytype available";
}

?>
</table>