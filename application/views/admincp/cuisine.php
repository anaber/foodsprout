<?php echo anchor('admincp/cuisine/add', 'Add Cuisine'); ?><br /><br />

<?php
if (count($CUISINES) > 0 ) {
?>
<table cellpadding="3" cellspacing="0" border="0" id="tbllist">
	<tr>
		<th>Cuisine Id</th>
		<th>Cuisine Name</th>
	</tr>
			
	
<?php

	$i = 0;
	foreach($CUISINES as $r) :
		$i++;
		echo '<tr class="d'.($i & 1).'">';
		echo '	<td>'.anchor('admincp/cuisine/update/'.$r->cuisineId, $r->cuisineId).'</td>';
		echo '	<td>'.anchor('admincp/cuisine/update/'.$r->cuisineId, $r->cuisineName).'</td>';
		echo '</tr>';
 	endforeach;
?>
</table>
<?php
} else {
	echo "No cuisine available";
}
?>