<?php echo anchor('admincp/farm/add', 'Add Farm'); ?><br /><br />
<?php
	//print_r_pre($MANUFACTURES);
?>
<table cellpadding="3" cellspacing="0" border="0" id="tbllist">
	<tr>
		<th>Id</th>
		<th>Farm Name</th>
		<th>Creation Date</th>
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
		echo '	<td>'. date('Y-m-d', strtotime($r->creationDate) ) .'</td>';
		echo '	<td nowrap>';
			
			foreach($r->suppliers as $supplier) :
				echo '<a href = "/admincp/farm/update_supplier/' . $supplier->supplierId . '">' . $supplier->supplierName . ' (' . ucfirst($supplier->supplierType) . ')' . '</a>' . "<br /><br />";
			endforeach;
			echo anchor('/admincp/farm/add_supplier/' . $r->farmId, 'Add Supplier');
		echo '</td>';
		echo '	<td>';
		
			foreach($r->addresses as $address) :
				echo '<a href = "/admincp/farm/update_address/' . $address->addressId . '">' . $address->completeAddress . '</a>' . "<br /><br />";
			endforeach;
			echo anchor('/admincp/farm/add_address/' . $r->farmId, 'Add Location');
		echo '</td>';
		echo '</tr>';

 	endforeach;
?>
</table>