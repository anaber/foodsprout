	<?php
		if (!empty ($INFO['url'])) {
	?>
	<div style="float:left;">&nbsp;Website: <a href = "<?php echo $INFO['url']; ?>" target = "_url" style="font-size:13px;text-decoration:none;"><?php echo $INFO['url']; ?></a></div>
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