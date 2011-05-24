<?php
	$method = $this->uri->segment(2);
	$dash = $this->uri->segment(1);
?>
<span id="signup">
	<div id="membername">
		<strong><?php echo $this->session->userdata('firstName'); ?></strong> | 
		<?php echo ( !empty($dash) &&  ( $dash == 'dashboard' ) ) ? '<strong>Dashboard</strong>' : anchor('/dashboard', 'Dashboard', 'style="font-size:13px;text-decoration:none;"'); ?> | 
		<?php echo ( !empty($method) &&  ( $method == 'settings' || $method == 'password' ) ) ? '<strong>Settings</strong>' : anchor('user/settings', 'Settings', 'style="font-size:13px;text-decoration:none;"'); ?> | 
		<?php 
		if ($this->session->userdata('isAuthenticated') == 1 && $this->session->userdata('access') == 'admin' ) {
			echo anchor('/admincp/dashboard', 'Admin', 'style="font-size:13px;text-decoration:none;"') . ' | ';
		}
		?>
		<?php echo anchor('login/signout', 'Sign Out', 'style="font-size:13px;text-decoration:none;"'); ?>
	</div>
</span>