<?php

		$i = 0;
		foreach($LIST as $r) :
			$i++;
			echo '<div style="overflow:auto; padding:5px;">';
			echo '	<div style="float:left; width:300px;">'.anchor('farm/view/'.$r->farmId, $r->farmName).'<br>Type:</div>';
			echo '  <div style="float:right; width:400px;">Address:</div>';
			echo '</div>';

	 	endforeach;
?>