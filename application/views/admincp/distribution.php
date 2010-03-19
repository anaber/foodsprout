<?php echo anchor('admincp/distribution/add', 'Add Distribution Center'); ?><br /><br />

<table cellpadding="3" cellspacing="0" border="0" id="tbllist">
	<tr>
		<th>Distribution Center Id</th>
		<th>Distribution Center Name</th>
		<th>Creation Date</th>
	</tr>
			
	
<?php
	$i = 0;
	foreach($DISTRIBUTIONS as $r) :
		$i++;
		echo '<tr class="d'.($i & 1).'">';
		echo '	<td>'.anchor('admincp/distribution/update/'.$r->distributionId, $r->distributionId).'</td>';
		echo '	<td>'.anchor('admincp/distribution/update/'.$r->distributionId, $r->distributionName).'</td>';
		echo '	<td>'. date('Y-m-d', strtotime($r->creationDate) ) .'</td>';
		echo '</tr>';

 	endforeach;
?>
</table>