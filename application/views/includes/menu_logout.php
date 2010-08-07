<span id="signup">
	<div id="membername">
		<strong><?php echo $this->session->userdata('firstName'); ?></strong> | <?php echo anchor('user/dashboard', 'Dashboard'); ?> | <?php echo anchor('user/settings', 'Settings'); ?> | <?php echo anchor('login/signout', 'Sign Out'); ?>
	</div>
</span>