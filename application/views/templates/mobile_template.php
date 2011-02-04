<?php 
	if (isset($SEO) ) {
		$this->load->view('mobile/includes/header', array('SEO' => $SEO));
	} else {
		$this->load->view('mobile/includes/header');
	}
?>

<?php
	if (isset($BREADCRUMB)) {
		
		$this->load->view('includes/breadcrumb', array('BREADCRUMB' => $BREADCRUMB ) );
	}
	else {
		echo '<br>';
	}
?>

<?php
	if (isset($CENTER)) {
		
		$this->load->view($CENTER['mainarea']);
	}
	else {
		echo '<br>';
	}
?>

<?php $this->load->view('mobile/includes/footer'); ?>