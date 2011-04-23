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
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'business/register/step2',
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