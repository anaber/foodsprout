Start exploring local sustainable restaurants in your area.  We'll pick up the tab.

<br><br>
Current restaurants you can enter to win a gift certificate for:<br>
<br>
<?php
foreach ($LOTTRIES['results'] as $lottery) {
	echo '<a href="/restaurant/view/'.$lottery->restaurantId.'">'.$lottery->restaurantName.'</a> - '.$lottery->city.', ' . $lottery->stateCode . '  <a href="/tab/detail/'.$lottery->lotteryId.'">Enter Drawing</a><br>';
}
?>



