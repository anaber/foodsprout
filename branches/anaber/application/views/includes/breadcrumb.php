<div id="breadcrumb">
<?php
$i = 0;
foreach($BREADCRUMB as $text => $link) {
	
	if ($i > 0) {
		if ( !empty( $link) ) {
			echo ' / ' . '<a href = "' . $link . '" class="redtxt">' . $text . '</a>';
		} else {
			echo ' / ' . '<h1>'.$text.'</h1>';
		}
	} else {
		if ( !empty( $link) ) {
			echo '<a href = "' . $link . '" class="redtxt">' . $text . '</a>';
		} else {
			echo '<h1>'.$text.'</h1>';
		}
	}
	
	$i++;
}
?>
</div>
<hr size="1">
