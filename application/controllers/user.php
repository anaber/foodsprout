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
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'user/settings',
		);
			
		$this->load->view('templates/center_template', $data);
	}
	
	// Add a product
	function addProduct()
	{
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'product/product_add',
		);
			
		$this->load->view('templates/center_template', $data);
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