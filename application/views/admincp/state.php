Listing of all the States in the database<br><br>

<table cellpadding="3" cellspacing="0" border="0" id="tbllist">
	<tr><th>State Name</td></tr>
<?php
	$i = 0;
	foreach($rows as $r) :
		
		$i++;
		echo '<tr class="d'.($i & 1).'"><td>'.anchor('admincp/state/edit/'.$r->state_id, $r->state_name).'</td></tr>';

 	endforeach;
?>
</table>

<br><br>
<hr size="1">
<b>Add State</b><br>

<?
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