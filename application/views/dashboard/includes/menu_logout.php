<span id="signup">
	<div id="membername">
		<strong><?php echo $this->session->userdata('firstName'); ?></strong> | <a href="/">Food Sprout Home</a> | <strong>Dashboard</strong> | <?php echo anchor('user/settings', 'Settings'); ?> | <?php echo anchor('login/signout', 'Sign Out'); ?>
	</div>
</span>