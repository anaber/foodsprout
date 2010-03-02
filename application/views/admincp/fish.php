Listing of all the Fish in the database<br><br>

<table cellpadding="3" cellspacing="0" border="0" id="tbllist">
	<tr><th>Fish Name</td></tr>
<?php
	$i = 0;
	foreach($rows as $r) :
		
		$i++;
		echo '<tr class="d'.($i & 1).'"><td>'.anchor('admincp/fish/edit/'.$r->fish_id, $r->fish_name).'</td></tr>';

 	endforeach;
?>
</table>

<br><br>
<hr size="1">
<b>Add Fish</b><br>

<?php
	echo '<table cellpadding="2" style="-moz-border-radius: 4px;
	-webkit-border-radius: 4px;
	background: #EEEEEE;
	color: #000000;
	-moz-box-shadow: 0 1px 0 #CCCCCC;
	-webkit-box-shadow: 0 1px 0 #CCCCCC;padding:10px; width:330px;"><tr><td>';
	echo form_open('admincp/fish/add_fish');
	echo 'Fish Name:'. form_input('fish_name', '').'<br><br>';
	echo form_submit('submit', 'Add Fish');
	echo '</form></td></tr></table>';
?>