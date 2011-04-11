<?php echo anchor('admincp/producercategorygroup/add', 'Add Attribute Group'); ?><br /><br />

<?php
if (count($PRODUCER_CATEGORIES_GROUPS) > 0 ) {
?>
<table cellpadding="3" cellspacing="0" border="0" id="tbllist">
	<tr>
		<th>Attribute Group Id</th>
		<th>Attribute Group</th>
	</tr>	
<?php

	$i = 0;
	foreach($PRODUCER_CATEGORIES_GROUPS as $r) :
		$i++;
		echo '<tr class="d'.($i & 1).'">';
		echo '	<td>'.anchor('admincp/producercategorygroup/update/'.$r->producerCategoryGroupId, $r->producerCategoryGroupId).'</td>';
		echo '	<td>'.anchor('admincp/producercategorygroup/update/'.$r->producerCategoryGroupId, $r->producerCategoryGroup).'</td>';
		echo '</tr>';
 	endforeach;
?>
</table>
<?php
} else {
	echo "No restaurant type available";
}
?>