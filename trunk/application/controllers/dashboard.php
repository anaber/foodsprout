<?php

class Dashboard extends Controller {
	
	function __construct() {
		// Ensure the user is logged in before allowing access to any of these methods
		parent::Controller();
		checkUserLogin();
		checkUserAgent();
	}
	
	// The default for the user is the dashboard
	function index() {
		global $LANDING_PAGE;
		if ($this->session->userdata('isAuthenticated') != 1 ) {
			redirect($LANDING_PAGE);
		}
		//	echo  $this->session->userdata('userId');
		
		$data['LEFT'] = array(
				'options' => 'dashboard/includes/dashboard_options',
			);
		
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'dashboard/home',
			);
		
		// Custom CSS
		$data['CSS'] = array(
						'dashboard',
						'jquery-ui/jquery.ui.slider',
						'jquery-ui/jquery.ui.theme',
					);
		
		$this->load->view('/dashboard/templates/left_center_template', $data);
	}
	
	// The default for the user is the dashboard
	function restaurants() {
		global $LANDING_PAGE;
		if ($this->session->userdata('isAuthenticated') != 1 ) {
			redirect($LANDING_PAGE);
		}
		//	echo  $this->session->userdata('userId');
		
		$data['LEFT'] = array(
				'options' => 'dashboard/includes/dashboard_options',
			);
		
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'dashboard/restaurants',
			);
		
		// Custom CSS
		$data['CSS'] = array(
						'dashboard',
					);
					
		$this->load->view('/dashboard/templates/left_center_template', $data);
	}
	
	// The default for the user is the dashboard
	function farms() {
		global $LANDING_PAGE;
		if ($this->session->userdata('isAuthenticated') != 1 ) {
			redirect($LANDING_PAGE);
		}
		//	echo  $this->session->userdata('userId');
		
		$data['LEFT'] = array(
				'options' => 'dashboard/includes/dashboard_options',
			);
		
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'dashboard/farms',
			);
		
		// Custom CSS
		$data['CSS'] = array(
						'dashboard',
					);
					
		$this->load->view('/dashboard/templates/left_center_template', $data);
	}
	
	// The default for the user is the dashboard
	function markets() {
		global $LANDING_PAGE;
		if ($this->session->userdata('isAuthenticated') != 1 ) {
			redirect($LANDING_PAGE);
		}
		//	echo  $this->session->userdata('userId');
		
		$data['LEFT'] = array(
				'options' => 'dashboard/includes/dashboard_options',
			);
		
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'dashboard/farms',
			);
		
		// Custom CSS
		$data['CSS'] = array(
						'dashboard',
					);
				
		$this->load->view('/dashboard/templates/left_center_template', $data);
	}
	
}

?>