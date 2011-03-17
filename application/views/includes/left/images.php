<?php /* ?><div id="rest-main-img"><img src="/img/applebee-img.jpg" width="211" height="143" alt="apple-img" /></div><?php */?>
<?php
	//if (isset($PHOTOS)) {
	if (isset($PHOTOS) && count ($PHOTOS) > 0 ) {
?>
		<div id="rest-main-img"><img src="<?php echo $PHOTOS[0]->thumbPhoto; ?>" width="201" height="133" alt="<?php echo $PHOTOS[0]->title; ?>" /></div>
		<div class = "clear"></div>
		<p class="nav" align = "center"><a href="<?php echo $PHOTO_TAB_LINK; ?>" id = "photos2" style="font-size:13px;text-decoration:none;">View More Photos</a></p>
<?php		
	} else {
?>
		<div id="rest-main-img"><img src="/img/standard/restaurant-na-icon.jpg" width="201" height="133" alt="apple-img" /></div>
<?php
	}
?>