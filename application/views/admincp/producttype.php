<?php echo anchor('admincp/producttype/add', 'Add Product Type'); ?><br /><br />

<?php
if (count($PRODUCTTYPES) > 0 ) {
?>
<table cellpadding="3" cellspacing="0" border="0" id="tbllist">
	<tr>
		<th>Product Type Id</th>
		<th>Product Type</th>
	</tr>
			
	
<?php

	$i = 0;
	foreach($PRODUCTTYPES as $r) :
		$i++;
		echo '<tr class="d'.($i & 1).'">';
		echo '	<td>'.anchor('admincp/producttype/update/'.$r->producttypeId, $r->producttypeId).'</td>';
		echo '	<td>'.anchor('admincp/producttype/update/'.$r->producttypeId, $r->producttypeName).'</td>';
		echo '</tr>';
 	endforeach;
?>
</table>
<?php
} else {
	echo "No product type available";
}
?>