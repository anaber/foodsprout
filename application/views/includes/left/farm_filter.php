<div id="rbox">
<?php
	
	echo 'Zip Code <input type="text" size="6" maxlength="5"><br><br>';

	echo '<strong>Farm Type</strong><br>';
	$i = 0;
	foreach($FARMTYPES as $r) :
		$i++;
		echo '<input type="checkbox" value="'.$r->farmTypeId.'">';
		echo $r->farmType.'<br>';

	endforeach;

?>
</div>