<?php

class User extends Controller {
	
	function __construct()
	{
		global $ADMIN_LANDING_PAGE;
		parent::Controller();
		if ($this->session->userdata('isAuthenticated') != 1 || $this->session->userdata('userGroup') != 'admin' )
		{
			redirect($ADMIN_LANDING_PAGE);
		}
	}
	
	function index()
	{	
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/user',
			);
		
		$data['LEFT'] = array(
				'navigation' => 'admincp/includes/left/nav_user',
			);
			
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "User Dashboard";
		
		$data['data']['left']['navigation']['VIEW_HEADER'] = "User Options";
		
		$this->load->view('admincp/templates/left_center_template', $data);		
	}
	
	// Search for a user
	function find_user()
	{
		
		
		
	}	
}



?>