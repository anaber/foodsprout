<?php
	echo "Not sure of its a good odea to create a generic list view which can server our purpose for all cases.";

		$i = 0;
		foreach($LIST as $r) :
			$i++;
			echo '<div style="overflow:auto; padding:5px;">';
			echo '	<div style="float:left; width:300px;">'.anchor('restaurant/view/'.$r->restaurantId, $r->restaurantName).'<br>Cuisine:</div>';
			echo '  <div style="float:right; width:400px;">Address:</div>';
			echo '</div>';

	 	endforeach;
?>