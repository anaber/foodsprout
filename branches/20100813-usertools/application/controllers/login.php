<?php

class Login extends Controller {
	
	function __construct()
	{
		parent::Controller();
	}
	
	function index()
	{
		if ($this->session->userdata('isAuthenticated') == 1 )
		{
			redirect('/home');
		} else {
			// List of views to be included
			$data['CENTER'] = array(
					'list' => 'login',
			);
				
			$this->load->view('templates/center_template', $data);
		}
	}
	
	// Check the user's data is valid
	function validate() {
		
		$this->load->model('LoginModel', '', TRUE);
		$authenticated = $this->LoginModel->validateUser();
		
		if ($authenticated ==  false) {
			$data = array();
			if($this->session->userdata('accessBlocked') == 'yes') {
				$data['data']['center']['list']['ERROR'] = 'blocked';
			} else {
				$data['data']['center']['list']['ERROR'] = 'login_failed';
			}
			
			$data['CENTER'] = array(
					'list' => 'login',
			);
			$this->load->view('templates/center_template', $data);
		} else {
			redirect('/');
		}
		
	}
	
	// End a users session	
	function signout()
	{
		$this->session->sess_destroy();
		redirect('/');
	}
	
	// Create and add a new user to the database
	function create_user() {
		$GLOBALS = array();
		
		$this->load->model('UserModel');
		$create_user = $this->UserModel->createUser();
		
		if($create_user == true) {
			redirect('/');
				
			$this->load->library('email');

			$this->email->from('contact@foodsprout.com', 'Food Sprout');
			$this->email->to($this->input->post('email'));

			$this->email->subject('Welcome to Food Sprout, '.$this->input->post('firstname'));
			$this->email->message('Welcome '.$this->input->post('firstname').",\r\n \r\nThank you for joining Food Sprout and taking an interest in learning more about where our food comes from and what is in it.  We hope you will also join us in sharing what information you have so that we may all benefit. \r\n \r\n Food Sprout Team");

			$this->email->send();
			
		} else {
			$data = array();
			$data['CENTER'] = array(
					'list' => 'beta/beta1',
			);
			
			if ( isset ($GLOBALS['error']) && $GLOBALS['error']) {
				$data['data']['center']['list']['ERROR'] = $GLOBALS['error'];
			} else {
				$data['data']['center']['list']['ERROR'] = 'registration_failed';
			}
			
			$data['data']['center']['list']['FIRST_NAME'] = $this->input->post('firstname'); 
			$data['data']['center']['list']['EMAIL'] = $this->input->post('email');
			$data['data']['center']['list']['ZIPCODE'] = $this->input->post('zipcode');
			
			$this->load->view('templates/center_template', $data);
			
		}
		
	}
}



?>