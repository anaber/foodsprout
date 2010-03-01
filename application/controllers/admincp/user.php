<?php

class User extends Controller {
	
	function __construct()
	{
		parent::Controller();
		if ($this->session->userdata('isAuthenticated') != 1 )
		{
			redirect('admincp/login');
		}
	}
	
	function index()
	{
		$data['main_content'] = 'admincp/user';
		$this->load->view('admincp/template', $data);		
	}
	
	// Search for a user
	function find_user()
	{
		
		
		
	}	
}



?>