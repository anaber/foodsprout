<div style = "font-size: 13px;">
Start exploring local sustainable restaurants in your area.  We'll pick up the tab.

<br><br>
<?php
if (count($LOTTRIES['results']) > 0) {
?>
	Current restaurants you can enter to win a gift certificate for:<br>
	<br>
		<div style = "width:200px;float:left;border: red 0px solid;"><strong>Photo</strong></div>
		<div style = "width:200px;float:left;border: red 0px solid;"><strong>Restaurants</strong></div>
		<div style = "width:200px;float:left;border: red 0px solid;"><strong>City</strong></div>
		<div style = "width:200px;float:left;border: red 0px solid;"><strong>Enter</strong></div>
		<div style = "clear:both;"></div>
		
		<div style = "width:805px;height:1px;background-color:#cccccc;float:left;border: red 0px solid;">&nbsp;</div>
		<div style = "clear:both;"></div>
<?php
	foreach ($LOTTRIES['results'] as $lottery) {
		echo '<div style = "width:805px;height:5px;float:left;border: red 0px solid;">&nbsp;</div>' .
			 '<div style = "clear:both;"></div>';
		
		echo '<div style = "width:200px;float:left;border: red 0px solid;">&nbsp;';
		echo '	<div class="portfolio_sites flt">';
			foreach ($lottery->photos as $photo) {
				echo '<div class="porffoilo_img" align = "center">' . 
					 '	<a href="' . $photo->photo . '" rel = "lightbox" title="" style = "text-decoration:none;">' . 
					 '		<img src="' . $photo->thumbPhoto . '" width="137" height="92" alt="" border = "0" /> ' .
					 '	</a>' .
					 '</div>';
			}
		echo '	</div>';
		
		echo '</div>';
		echo '<div style = "width:200px;float:left;border: red 0px solid;"><a href="/restaurant/view/'.$lottery->restaurantId.'" style = "font-size: 13px; text-decoration: none;">'.$lottery->restaurantName.'</a></div>';
		echo '<div style = "width:200px;float:left;border: red 0px solid;">' . $lottery->city.', ' . $lottery->stateCode . '</div>';
		echo '<div style = "width:200px;float:left;border: red 0px solid;"><a href="/tab/detail/'.$lottery->lotteryId.'" style = "font-size: 13px; text-decoration: none;">Enter Drawing</a></div>';
		echo '<div style = "clear:both;"></div>';
		
		echo '<div style = "width:805px;height:5px;float:left;border: red 0px solid;">&nbsp;</div>' .
			 '<div style = "clear:both;"></div>';
		
		echo '<div style = "width:805px;height:1px;background-color:#cccccc;float:left;border: red 0px solid;">&nbsp;</div>' .
			 '<div style = "clear:both;"></div>';
	}
}
?>
</div>



