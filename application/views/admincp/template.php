<?php $this->load->view('admincp/header'); ?>

<?php 
	
	if (isset($data) ) {
		$this->load->view($main_content, $data);
	} else {
		$this->load->view($main_content);
	}
?>

<?php $this->load->view('admincp/footer'); ?>