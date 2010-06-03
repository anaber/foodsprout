<?php

	$i = 0;
	foreach($RESTAURANT as $r) :
		$i++;
		echo '<h1>'.$r->restaurantName.'</h1>';
		echo 'Cuisine:<br>';
		echo 'Address:<br>';
 	endforeach;

?>
<br><br>