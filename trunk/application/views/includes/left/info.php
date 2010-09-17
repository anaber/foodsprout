	<?php
		if (!empty ($INFO['url'])) {
	?>
	<div style="float:left;font-size:13px;width:180px;">&nbsp;Website: <a href = "<?php echo prep_url($INFO['url']); ?>" target = "_blank" style="font-size:13px;text-decoration:none;"><?php echo $INFO['url']; ?></a></div>
	<br /><br />
	<?php
		}
	?>
	<?php
		if (!empty ($INFO['facebook']) || !empty ($INFO['twitter']) ) {
	?>
			<div style="float:left;width:180px;">
	<?php
			if (!empty ($INFO['facebook'])) {
	?>
			<a href = "<?php echo prep_url($INFO['facebook']); ?>" target = "_url"><img src = "<?php echo base_url();?>img/icons/facebook-icon-big.png" border = "0"></a>
	<?php
			}
	?>
	<?php
		if (!empty ($INFO['twitter'])) {
	?>
			<a href = "<?php echo prep_url($INFO['twitter']); ?>" target = "_url"><img src = "<?php echo base_url();?>img/icons/twitter-icon-big.png" border = "0"></a>
	<?php
			}
	?>
			</div>
	<?php
		}
	?>