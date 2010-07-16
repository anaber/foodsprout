<?php

class User extends Controller {
	
	function __construct()
	{
		// Ensure the user is logged in before allowing access to any of these methods
		
		parent::Controller();
		/*
		if ($this->session->userdata('isAuthenticated') != 1 )
		{
			redirect('login');
		}
		*/
	}
	
	// The default for the user is the dashboard
	function index()
	{
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'user/dashboard',
		);
		
		$this->load->view('/templates/center_template', $data);
	}
	
	// The default page after login, the users dashboard
	function dashboard()
	{
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'user/dashboard',
		);
		
		$data['data']['center']['list']['VIEW_HEADER'] = "My Dashboard";
			
		$this->load->view('/dashboard/templates/center_template', $data);
	}
	
	// The settings for the user
	function settings()
	{
		$this->load->model('UserModel');
		$user = $this->UserModel->getUserFromId($this->session->userdata('userId'));
		
		// List of views to be included
		$data['CENTER'] = array(
				'form' => 'user/settings',
		);
		$data['data']['center']['form']['USER'] = $user;
		
		$this->load->view('templates/center_template', $data);
	}
	
	function updateSettings() {
		
		$this->load->model('UserModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->UserModel->updateUserSettings() ) {
			echo "yes";
		} else {
			if (isset($GLOBALS['error']) && !empty($GLOBALS['error']) ) {
				echo $GLOBALS['error'];
			} else {
				echo 'no';
			}
		}
	}
	
	// Display the page for the user to change their password
	function password()
	{
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'user/password',
		);
			
		$this->load->view('templates/center_template', $data);
	}
	
	function updatePassword() {
		
		$this->load->model('UserModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->UserModel->updatePassword() ) {
			echo "yes";
		} else {
			if (isset($GLOBALS['error']) && !empty($GLOBALS['error']) ) {
				echo $GLOBALS['error'];
			} else {
				echo 'no';
			}
		}
		
	}
	
	function create()
	{
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'user/create_account',
		);
		
		$this->load->view('/templates/center_template', $data);
	}
	
	
}



?>