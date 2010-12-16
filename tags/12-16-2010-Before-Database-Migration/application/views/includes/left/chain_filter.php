<div style="-moz-border-radius-topleft:7px;-webkit-border-radius-topleft:7px;border-top-left-radius:7px;background: #F05A25; color:#fff; padding:5px;">More Options</div>
<div id="divCuisines" style="background:#e5e5e5; font-size:90%; padding:5px;"><a href = "/restaurant" style="font-size:13px;text-decoration:none;">Restaurants</a></div>

<?php
	$city = $this->uri->segment(2);
?>
<br />
<div style="-moz-border-radius-topleft:7px;-webkit-border-radius-topleft:7px;border-top-left-radius:7px;background: #F05A25; color:#fff; padding:5px;padding-left:10px;">View Sustainable Only</div>
<div id="" style="background:#e5e5e5; font-size:90%; padding:5px;">
	<?php
		foreach ($RECOMMENDED_CITIES as $rec_city) {
			$browser_compatible_rec_city = implode('-', explode (' ', strtolower($rec_city)) );
			echo '<a href="/sustainable/' . $browser_compatible_rec_city . '" style="font-size:13px;text-decoration:none;">'. ( ($browser_compatible_rec_city == $city) ? '<b>'.$rec_city.'</b>' : $rec_city ) . '</a><br/>';
		}
	?>
</div>