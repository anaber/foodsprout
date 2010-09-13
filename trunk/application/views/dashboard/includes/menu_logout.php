<span id="signup">
	<div id="membername">
		<strong><?php echo $this->session->userdata('firstName'); ?></strong> | <a href="/" style="font-size:13px;text-decoration:none;">Food Sprout Home</a> | <strong>Dashboard</strong> | <?php echo anchor('user/settings', 'Settings', 'style="font-size:13px;text-decoration:none;"'); ?> | <?php echo anchor('login/signout', 'Sign Out', 'style="font-size:13px;text-decoration:none;"'); ?>
	</div>
</span>