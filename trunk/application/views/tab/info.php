<div style = "font-size: 13px;">
Start exploring local sustainable restaurants in your area.  We'll pick up the tab.

<br><br>
<?php
if (count($LOTTRIES['results']) > 0) {
?>
	Current restaurants you can enter to win a gift certificate for:<br>
	<br>
	<?php
	foreach ($LOTTRIES['results'] as $lottery) {
		echo '<a href="/restaurant/view/'.$lottery->restaurantId.'" style = "font-size: 13px; text-decoration: none;">'.$lottery->restaurantName.'</a> - '.$lottery->city.', ' . $lottery->stateCode . '  <a href="/tab/detail/'.$lottery->lotteryId.'" style = "font-size: 13px; text-decoration: none;">Enter Drawing</a><br>';
	}
}
?>
</div>



