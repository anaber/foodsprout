<div style="float:left; width:225px;">
	<?php
		if (!empty ($INFO['url'])) {
	?>
	<div style="float:left;"><a href = "<?php echo $INFO['url']; ?>" target = "_url">Website</a></div>
	<br /><br />
	<?php
		}
	?>
	<?php
		if (!empty ($INFO['facebook'])) {
	?>
	<div style="float:left;"><a href = "<?php echo $INFO['facebook']; ?>" target = "_url"><img src = "<?php echo base_url();?>img/icons/facebook-icon-big.png" border = "0"></a></div>
	<?php
		}
	?>
	<?php
		if (!empty ($INFO['twitter'])) {
	?>
	<div style="float:left;"><a href = "<?php echo $INFO['twitter']; ?>" target = "_url"><img src = "<?php echo base_url();?>img/icons/twitter-icon-big.png" border = "0"></a></div>
	<?php
		}
	?>
	<div class="clear"></div>
</div>