<?php
	$step = $this->uri->segment(3);
?>
<div id="restaurantname">
	<div style = "float:left;">
		<img src = "/images/Number-1-icon.png">
	</div>
	<div style = "float:left;padding:10px 0 0 10px;width:200px;">
		<h1 style="font-size: <?php echo ($step == 'step1' ? '18px;' : '16px;'); ?>">Setup Account</h1>
	</div>
	
	<div style = "float:left;">
		<img src = "/images/Number-2-icon.png">
	</div>
	<div style = "float:left;padding:10px 0 0 10px;width:270px;">
		<h1 style="font-size: <?php echo ($step == 'step2' ? '18px;' : '16px;'); ?>">Confirm Connection to Business</h1>
	</div>
	
	<div style = "float:left;">
		<img src = "/images/Number-3-icon.png">
	</div>
	<div style = "float:left;padding:10px 0 0 10px;width:250px;">
		<h1 style="font-size: <?php echo ($step == 'step3' ? '18px;' : '16px;'); ?>">Access For Business Owners</h1>
	</div>
	
	<div class = "clear"></div>
</div>
<div class = "clear"></div>