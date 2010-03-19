<?php echo anchor('admincp/processing/add', 'Add Processing Center'); ?><br /><br />

<table cellpadding="3" cellspacing="0" border="0" id="tbllist">
	<tr>
		<th>Processing Center Id</th>
		<th>Processing Center Name</th>
		<th>Creation Date</th>
	</tr>
			
	
<?php
	$i = 0;
	foreach($PROCESSINGS as $r) :
		$i++;
		echo '<tr class="d'.($i & 1).'">';
		echo '	<td>'.anchor('admincp/processing/update/'.$r->processingId, $r->processingId).'</td>';
		echo '	<td>'.anchor('admincp/processing/update/'.$r->processingId, $r->processingName).'</td>';
		echo '	<td>'. date('Y-m-d', strtotime($r->creationDate) ) .'</td>';
		echo '</tr>';

 	endforeach;
?>
</table>