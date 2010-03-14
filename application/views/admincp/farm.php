<?php echo anchor('admincp/farm/add', 'Add Farm'); ?><br /><br />

<table cellpadding="3" cellspacing="0" border="0" id="tbllist">
	<tr>
		<th>Farm Id</th>
		<th>Farm Name</th>
		<th>Address</th>
		<th>Creation Date</th>
	</tr>
			
	
<?php
	$i = 0;
	foreach($FARMS as $r) :
		$i++;
		echo '<tr class="d'.($i & 1).'">';
		echo '	<td>'.anchor('admincp/farm/update/'.$r->farmId, $r->farmId).'</td>';
		echo '	<td>'.anchor('admincp/farm/update/'.$r->farmId, $r->farmName).'</td>';
		echo '	<td>'.$r->streetAddress . ',<br/>' . $r->stateName . ', ' . $r->countryName . ', - ' . $r->zipcode . '</td>';
		echo '	<td>'. date('Y-m-d', strtotime($r->creationDate) ) .'</td>';
		echo '</tr>';

 	endforeach;
?>
</table>