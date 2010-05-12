

<div id="rbox">
<form id = "frmFilters">
<?php
	
	echo '<div id = "divZipcode">Zip Code <input type="text" size="6" maxlength="5" id = "q"></div><br>';

	echo '<strong>Restaurant Type</strong><br>';
	$i = 0;
	foreach($RESTAURANT_TYPES as $r) :
		$i++;
		echo '<input type="checkbox" value="r_'.$r->restaurantTypeId.'" id = "restaurantTypeId" name = "restaurantTypeId">';
		echo $r->restaurantType.'<br>';

	endforeach;
	
	echo '<br><strong>Cuisine</strong><br>';
	$i = 0;
	foreach($CUISINES as $r) :
		$i++;
		echo '<input type="checkbox" value="c_'.$r->cuisineId.'" id = "cuisineId" name = "cuisineId">';
		echo $r->cuisineName.'<br>';

	endforeach;

?>
</form>
<br />
<div id = "removeFilters">
	<a id = "imgRemoveFilters" href = "#">Remove Filters</a>
</div>
</div>