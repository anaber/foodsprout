<div id="rbox">
<?php
	
	echo 'Zip Code <input type="text" size="6" maxlength="5"><br><br>';

	echo '<strong>Restaurant Type</strong><br>';
	$i = 0;
	foreach($RESTAURANTTYPES as $r) :
		$i++;
		echo '<input type="checkbox" value="'.$r->restaurantTypeId.'">';
		echo $r->restaurantTypeName.'<br>';

	endforeach;
	
	echo '<br><strong>Cuisine</strong><br>';
	$i = 0;
	foreach($CUISINES as $r) :
		$i++;
		echo '<input type="checkbox" value="'.$r->cuisineId.'">';
		echo $r->cuisineName.'<br>';

	endforeach;

?>
</div>