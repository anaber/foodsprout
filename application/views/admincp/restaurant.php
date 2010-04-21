<?php echo anchor('admincp/restaurant/add', 'Add Restaurant'); ?><br /><br />

<table cellpadding="3" cellspacing="0" border="0" id="tbllist">
	<tr>
		<th>Restaurant Id</th>
		<th>Restaurant Name</th>
		<th>Creation Date</th>
		<th>Suppliers</th>
		<th>Locations</th>
	</tr>
			
	
<?php
	$i = 0;
	foreach($RESTAURANTS as $r) :
		$i++;
		echo '<tr class="d'.($i & 1).'">';
		echo '	<td>'.anchor('admincp/restaurant/update/'.$r->restaurantId, $r->restaurantId).'</td>';
		echo '	<td>'.anchor('admincp/restaurant/update/'.$r->restaurantId, $r->restaurantName).'</td>';
		echo '	<td>'. date('Y-m-d', strtotime($r->creationDate) ) .'</td>';
		echo '	<td nowrap>';
			
			foreach($r->suppliers as $supplier) :
				echo '<a href = "/admincp/restaurant/update_supplier/' . $supplier->supplierId . '">' . $supplier->supplierName . ' (' . ucfirst($supplier->supplierType) . ')' . '</a>' . "<br /><br />";
			endforeach;
			echo anchor('/admincp/restaurant/add_supplier/' . $r->restaurantId, 'Add Supplier');
		echo '</td>';
		echo '	<td>';
		
			foreach($r->addresses as $address) :
				echo '<a href = "/admincp/restaurant/update_address/' . $address->addressId . '">' . $address->completeAddress . '</a>' . "<br /><br />";
			endforeach;
			echo anchor('/admincp/restaurant/add_address/' . $r->restaurantId, 'Add Address');
		echo '</td>';
		echo '</tr>';

 	endforeach;
?>
</table>