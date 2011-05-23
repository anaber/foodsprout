<?php

class Login extends Controller {
	
	
	function __construct() {
		parent::Controller();
		
		if ($this->session->userdata('isAuthenticated') == 1 ) {
			if ($this->session->userdata('access') == 'business' ) {
				redirect('/business/dashboard');
			} else {
				redirect('/');
			}
		}
	}
	
	function index() {
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'business/login',
			);
		
		
		// Custom CSS
		$data['ASSETS']['CSS'] = array(
						'business',
						);
		
		$this->load->view('business/templates/center_template', $data);
	}
	
}

/* End of file login.php */

?>