<?php echo anchor('admincp/company/add', 'Add Company'); ?><br /><br />

<table cellpadding="3" cellspacing="0" border="0" id="tbllist">
	<tr>
		<th>Company Id</th>
		<th>Company Name</th>
		<th>Creation Date</td>
	</tr>
			
	
<?php
	$i = 0;
	foreach($COMPANIES as $r) :
		$i++;
		echo '<tr class="d'.($i & 1).'">';
		echo '	<td>'.anchor('admincp/company/update/'.$r->companyId, $r->companyId).'</td>';
		echo '	<td>'.anchor('admincp/company/update/'.$r->companyId, $r->companyName).'</td>';
		echo '	<td>'. date('Y-m-d', strtotime($r->creationDate) ) .'</td>';
		echo '</tr>';

 	endforeach;
?>
</table>