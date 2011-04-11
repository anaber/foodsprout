<?php echo anchor('admincp/producercategory/add', 'Add Producer Category'); ?><br /><br />

<?php
if (count($PRODUCER_CATEGORIES) > 0 ) {
?>
<table cellpadding="3" cellspacing="0" border="0" id="tbllist" width="100%">
	<tr>
		<th>Producer Category Id</th>
        <th>Producer Category Group</th>
		<th>Producer Category</th>
	</tr>
			
	
<?php

	$i = 0;
	foreach($PRODUCER_CATEGORIES as $r) :
		$i++;
		echo '<tr class="d'.($i & 1).'">';
		echo '	<td>'.anchor('admincp/producercategory/update/'.$r->producerCategoryId, $r->producerCategoryId).'</td>';
		echo '	<td>'.$r->producerCategoryGroup.'</td>';
		echo '	<td>'.anchor('admincp/producercategory/update/'.$r->producerCategoryId, $r->producerCategory).'</td>';
		echo '</tr>';
 	endforeach;
?>
</table>
<?php
} else {
	echo "No Category for Producers";
}
?>