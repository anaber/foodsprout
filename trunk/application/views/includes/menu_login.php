<span id="signup">
	<div id="membername">
		<?php echo anchor('login?redirect='.$_SERVER['REQUEST_URI'], 'Sign In', 'style="font-size:13px;text-decoration:none;"'); ?> | <?php echo anchor('/login?redirect='.$_SERVER['REQUEST_URI'], 'Create Account', 'style="font-size:13px;text-decoration:none;"'); ?>
	</div>
</span>