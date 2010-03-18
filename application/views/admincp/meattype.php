<?php echo anchor('admincp/cuisine/add', 'Add Cuisine'); ?><br /><br />

<?php
if (count($MEATTYPES) > 0 ) {
?>
<table cellpadding="3" cellspacing="0" border="0" id="tbllist">
	<tr>
		<th>Meat Type Id</th>
		<th>Meat Type</th>
	</tr>
			
	
<?php

	$i = 0;
	foreach($MEATTYPES as $r) :
		$i++;
		echo '<tr class="d'.($i & 1).'">';
		echo '	<td>'.anchor('admincp/meattype/update/'.$r->meattypeId, $r->meattypeId).'</td>';
		echo '	<td>'.anchor('admincp/meattype/update/'.$r->meattypeId, $r->meattypeName).'</td>';
		echo '</tr>';
 	endforeach;
?>
</table>
<?php
} else {
	echo "No cuisine available";
}
?>