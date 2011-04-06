<?php

class Services extends Controller {
	
	
	function __construct() {
		parent::Controller();
	}
	
	function index() {
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'business/services',
			);
		
		$this->load->view('business/templates/center_template', $data);
	}
	
	// Check to see that the user is valid
	function validate() {
		
		$this->load->model('LoginModel', '', TRUE);
		$authenticated = $this->LoginModel->validateAdmin();
		
		if ($authenticated ==  false) {	
			if($this->session->userdata('accessBlocked') == 'yes') {
				echo 'blocked';
			} else  {
				echo 'no';
			}
		} else {
			echo 'yes';
		}
	}
}

/* End of file login.php */

?>