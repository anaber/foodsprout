<?php echo anchor('admincp/vegetabletype/add', 'Add Vegetable Type'); ?><br /><br />

<?php
if (count($VEGETABLETYPES) > 0 ) {
?>
<table cellpadding="3" cellspacing="0" border="0" id="tbllist">
	<tr>
		<th>Vegetable Type Id</th>
		<th>Vegetable Type</th>
	</tr>	
<?php

	$i = 0;
	foreach($VEGETABLETYPES as $r) :
		$i++;
		echo '<tr class="d'.($i & 1).'">';
		echo '	<td>'.anchor('admincp/vegetabletype/update/'.$r->vegetabletypeId, $r->vegetabletypeId).'</td>';
		echo '	<td>'.anchor('admincp/vegetabletype/update/'.$r->vegetabletypeId, $r->vegetabletypeName).'</td>';
		echo '</tr>';
 	endforeach;
?>
</table>
<?php
} else {
	echo "No cuisine available";
}
?>