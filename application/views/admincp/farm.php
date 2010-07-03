<?php echo anchor('admincp/farm/add', 'Add Farm'); ?><br /><br />

<table cellpadding="3" cellspacing="0" border="0" id="tbllist" width = "99%">
	<tr>
		<th>Id</th>
		<th>Farm Name</th>
		<th>Farmer Type</th>
		<th>Suppliers</th>
		<th>Locations</th>
	</tr>
			
	
<?php
	$i = 0;
	foreach($FARMS as $r) :
		$i++;
		echo '<tr class="d'.($i & 1).'">';
		echo '	<td>'.anchor('/admincp/farm/update/'.$r->farmId, $r->farmId).'</td>';
		echo '	<td>'.anchor('/admincp/farm/update/'.$r->farmId, $r->farmName).'</td>';
		echo '	<td>' . ( !empty($r->farmerType) ? $FARMER_TYPES[$r->farmerType] : '' ) . '</td>';
		//echo '	<td>'. date('Y-m-d', strtotime($r->creationDate) ) .'</td>';
		echo '	<td nowrap>';
			
			foreach($r->suppliers as $supplier) :
				echo '<a href = "/admincp/farm/update_supplier/' . $supplier->supplierId . '">' . $supplier->supplierName . ' <b>(' . substr ( ucfirst($supplier->supplierType), 0, 1 ) . ')</b>' . '</a>' . "<br /><br />";
			endforeach;
			echo anchor('/admincp/farm/add_supplier/' . $r->farmId, 'Suppliers');
		echo '</td>';
		echo '	<td>';
		
			foreach($r->addresses as $address) :
				echo '<a href = "/admincp/farm/update_address/' . $address->addressId . '">' . $address->displayAddress . '</a>' . "<br /><br />";
			endforeach;
			echo anchor('/admincp/farm/add_address/' . $r->farmId, 'Addresses');
		echo '</td>';
		echo '</tr>';

 	endforeach;
?>
</table>