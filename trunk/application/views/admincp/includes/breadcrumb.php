<div id="restaurantname">
<?php
$i = 0;
foreach($BREADCRUMB as $text => $link) {
	
	if ($i > 0) {
		if ( !empty( $link) ) {
			echo ' >> ' . '<a href = "' . $link . '" class="redtxt">' . $text . '</a>';
		} else {
			echo ' >> ' . $text;
		}
	} else {
		if ( !empty( $link) ) {
			echo '<a href = "' . $link . '" class="redtxt">' . $text . '</a>';
		} else {
			echo $text;
		}
	}
	
	$i++;
}
?>
</div>
