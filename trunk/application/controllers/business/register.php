<?php

class Register extends Controller {
	
	
	function __construct() {
		parent::Controller();
		
	}
	
	function index() {
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'business/register/register',
			);
			
		// Data to send to the views
		$data['BREADCRUMB'] = array(
							'Business' => '/business',
							'Upgrade Your Account to Business' => '',
						);
		
		// Custom CSS
		$data['ASSETS']['CSS'] = array(
						'business',
						//'beta'
						);
		
		$this->load->view('business/templates/center_template', $data);
	}
	
	function step1() {
		$data = array();
		
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'business/register/step1',
			);
		
		// Data to send to the views
		$data['BREADCRUMB'] = array(
			'Business' => '/business',
			'Plans' => '/business/register',
			'Step1: Create Account' =>'',
			);
			
		// Custom CSS
		$data['ASSETS']['CSS'] = array(
						'business',
						//'beta',
						'jquery.validationEngine',
						);
		
		// Custom CSS
		$data['ASSETS']['JS'] = array(
						'jquery.validationEngine',
						'jquery.validationEngine-en',
						);
		
		$this->load->view('business/templates/center_template', $data);
	}
	
	function step2() {
		checkUserLogin();
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'business/register/step2',
			);
			
		// Data to send to the views
		$data['BREADCRUMB'] = array(
			'Business' => '/business',
			'Plans' => '/business/register',
			'Step1: Create Account' =>'/business/register/step1',
			'Step2: Payment' =>'',
			);
		
		// Custom CSS
		$data['ASSETS']['CSS'] = array(
						'business',
						//'beta',
						'jquery.validationEngine',
						);
		
		// Custom CSS
		$data['ASSETS']['JS'] = array(
						'jquery.validationEngine',
						'jquery.validationEngine-en',
						);
		
		$this->load->view('business/templates/center_template', $data);
	}
	
	function step3() {
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'business/register/step3',
			);
			
		// Data to send to the views
		$data['BREADCRUMB'] = array(
			'Business' => '/business',
			'Confirmation' => '',
			);
		
		// Custom CSS
		$data['ASSETS']['CSS'] = array(
						'business',
						//'beta',
						'jquery.validationEngine',
						);
		
		// Custom CSS
		$data['ASSETS']['JS'] = array(
						'jquery.validationEngine',
						'jquery.validationEngine-en',
						);
		
		$this->load->view('business/templates/center_template', $data);
	}
}

/* End of file login.php */

?>