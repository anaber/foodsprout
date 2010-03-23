<?php echo anchor('admincp/product/add', 'Add Product'); ?><br /><br />

<?php
if (count($PRODUCTS) > 0 ) {
?>
<table cellpadding="3" cellspacing="0" border="0" id="tbllist">
	<tr>
		<th>Product Id</th>
		<th>Product Name</th>
	</tr>
			
	
<?php

	$i = 0;
	foreach($PRODUCTS as $r) :
		$i++;
		echo '<tr class="d'.($i & 1).'">';
		echo '	<td>'.anchor('admincp/product/update/'.$r->productId, $r->productId).'</td>';
		echo '	<td>'.anchor('admincp/product/update/'.$r->productId, $r->productName).'</td>';
		echo '</tr>';
 	endforeach;
?>

<?php
} else {
	echo "No product available";
}

?>
</table>