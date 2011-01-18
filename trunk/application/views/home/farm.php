<div id="tabs-3" class="ui-tabs-hide">
	Resources to start learning about the source of your food- the farm.<br><br>
	<a href="/farm" style="text-decoration:none;font-size:13px;">Listing of Farms</a><br>
	<a href="/farmersmarket" style="text-decoration:none;font-size:13px;">Find a Farmers Market</a><br><br>
	<h3>Recently Added Farms</h3>
	<div style="float:left;width:230px;">
	<?php
		$x = 1;
		foreach ($NEWFARMS as $key1) {
			$x++;
			echo '<a href="/farm/'.$key1->customURL.'"  style="text-decoration:none;font-size:13px;">'.$key1->farmName.'</span></a><br> ';
			
			if($x=6)
			{
				echo '</div><div style="float:left;width:230px;">';
			}
		}
	?>
	</div>
	<br><br>
</div>