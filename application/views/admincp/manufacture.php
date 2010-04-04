<?php echo anchor('admincp/manufacture/add', 'Add Manufacture'); ?><br /><br />

<table cellpadding="3" cellspacing="0" border="0" id="tbllist">
	<tr>
		<th>Manufacture Id</th>
		<th>Manufacture Name</th>
		<th>Creation Date</th>
	</tr>
			
	
<?php
	$i = 0;
	foreach($MANUFACTURES as $r) :
		$i++;
		echo '<tr class="d'.($i & 1).'">';
		echo '	<td>'.anchor('admincp/manufacture/update/'.$r->manufactureId, $r->manufactureId).'</td>';
		echo '	<td>'.anchor('admincp/manufacture/update/'.$r->manufactureId, $r->manufactureName).'</td>';
		echo '	<td>'. date('Y-m-d', strtotime($r->creationDate) ) .'</td>';
		echo '</tr>';

 	endforeach;
?>
</table>