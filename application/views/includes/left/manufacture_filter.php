<div id="rbox">
<?php
	
	echo 'Zip Code <input type="text" size="6" maxlength="5"><br><br>';

	echo '<strong>Manufacture Type</strong><br>';
	$i = 0;
	foreach($MANUFACTURETYPES as $r) :
		$i++;
		echo '<input type="checkbox" value="'.$r->manufactureTypeId.'">';
		echo $r->manufactureType.'<br>';

	endforeach;

?>
</div>