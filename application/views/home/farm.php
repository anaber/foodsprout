<div id="tabs-3" class="ui-tabs-hide">
	Resources to start learning about the source of your food- the farm.<br><br>
	<a href="/farm">Listing of Farms</a><br>
	<a href="/farmersmarket">Find a Farmers Market</a><br><br>
	Recently Added Farms<br>
	<?php
		foreach ($NEWFARMS as $key1) {
			echo '<a href="/farm/view/'.$key1->farmId.'" style="text-decoration:none;">'.$key1->farmName.'</span></a>, ';
		}
	?>
	<br><br>
</div>