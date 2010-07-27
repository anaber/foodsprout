<?php
if (count($STATES) > 0 ) {
?>
<table cellpadding="3" cellspacing="0" border="0" id="tbllist">
	<tr>
		<th>State Id</th>
		<th>State Name</th>
	</tr>
			
	
<?php

	$i = 0;
	foreach($STATES as $r) :
		$i++;
		echo '<tr class="d'.($i & 1).'">';
		echo '	<td>'.$r->stateId.'</td>';
		echo '	<td>'.$r->stateName.'</td>';
		echo '</tr>';
 	endforeach;
?>

<?php
} else {
	echo "No state available";
}

?>
</table>



<hr size="1">
<b>Add State</b><br>

<?php
	echo '<table cellpadding="2" style="-moz-border-radius: 4px;
	-webkit-border-radius: 4px;
	background: #EEEEEE;
	color: #000000;
	-moz-box-shadow: 0 1px 0 #CCCCCC;
	-webkit-box-shadow: 0 1px 0 #CCCCCC;padding:10px; width:330px;"><tr><td>';
	echo form_open('admincp/state/add_state');
	echo 'State Name:'. form_input('state_name', '').'<br><br>';
	echo form_submit('submit', 'Add State');
	echo '</form></td></tr></table>';
?>