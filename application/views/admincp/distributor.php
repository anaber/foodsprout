<?php echo anchor('admincp/distributor/add', 'Add Distributor'); ?><br /><br />
<?php
	//print_r_pre($DISTRIBUTORS);
?>
<table cellpadding="3" cellspacing="0" border="0" id="tbllist" width = "99%">
	<tr>
		<th>Id</th>
		<th>Distributor Name</th>
		<th>Creation Date</th>
		<th>Suppliers</th>
		<th>Locations</th>
	</tr>
			
	
<?php

	$i = 0;
	foreach($DISTRIBUTORS as $r) :
		$i++;
		echo '<tr class="d'.($i & 1).'">';
		echo '	<td>'.anchor('/admincp/distributor/update/'.$r->distributorId, $r->distributorId).'</td>';
		echo '	<td>'.anchor('/admincp/distributor/update/'.$r->distributorId, $r->distributorName).'</td>';
		echo '	<td>'. date('Y-m-d', strtotime($r->creationDate) ) .'</td>';
		echo '	<td nowrap>';
			
			foreach($r->suppliers as $supplier) :
				echo '<a href = "/admincp/distributor/update_supplier/' . $supplier->supplierId . '">' . $supplier->supplierName . ' <b>(' . substr ( ucfirst($supplier->supplierType), 0, 1 ) . ')</b>' . '</a>' . "<br /><br />";
			endforeach;
			echo anchor('/admincp/distributor/add_supplier/' . $r->distributorId, 'Add Supplier');
		echo '</td>';
		echo '	<td>';
		
			foreach($r->addresses as $address) :
				echo '<a href = "/admincp/distributor/update_address/' . $address->addressId . '">' . $address->completeAddress . '</a>' . "<br /><br />";
			endforeach;
			echo anchor('/admincp/distributor/add_address/' . $r->distributorId, 'Add Address');
		echo '</td>';
		echo '</tr>';

 	endforeach;
?>
</table>