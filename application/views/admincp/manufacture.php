<?php echo anchor('admincp/manufacture/add', 'Add Manufacture'); ?><br /><br />
<?php
	//print_r_pre($MANUFACTURES);
?>
<table cellpadding="3" cellspacing="0" border="0" id="tbllist" width = "99%">
	<tr>
		<th>Id</th>
		<th>Manufacture Name</th>
		<th>Creation Date</th>
		<th>Suppliers</th>
		<th>Locations</th>
	</tr>
			
	
<?php
	
	$i = 0;
	foreach($MANUFACTURES as $r) :
		$i++;
		echo '<tr class="d'.($i & 1).'">';
		echo '	<td>'.anchor('/admincp/manufacture/update/'.$r->manufactureId, $r->manufactureId).'</td>';
		echo '	<td>'.anchor('/admincp/manufacture/update/'.$r->manufactureId, $r->manufactureName).'</td>';
		echo '	<td>'. date('Y-m-d', strtotime($r->creationDate) ) .'</td>';
		echo '	<td nowrap>';
			
			foreach($r->suppliers as $supplier) :
				echo '<a href = "/admincp/manufacture/update_supplier/' . $supplier->supplierId . '">' . $supplier->supplierName . ' <b>(' . substr ( ucfirst($supplier->supplierType), 0, 1 ) . ')</b>' . '</a>' . "<br /><br />";
			endforeach;
			echo anchor('/admincp/manufacture/add_supplier/' . $r->manufactureId, 'Add Supplier');
		echo '</td>';
		echo '	<td>';
		
			foreach($r->addresses as $address) :
				echo '<a href = "/admincp/manufacture/update_address/' . $address->addressId . '">' . $address->displayAddress . '</a>' . "<br /><br />";
			endforeach;
			echo anchor('/admincp/manufacture/add_address/' . $r->manufactureId, 'Add Address');
		echo '</td>';
		echo '</tr>';

 	endforeach;
?>
</table>