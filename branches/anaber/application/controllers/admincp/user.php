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
			
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Users";
		
		$this->load->view('admincp/templates/center_template', $data);		
	}
	
	// Search for a user
	function ajaxSearchUsers() {
		$this->load->model('UserModel', '', TRUE);
		$users = $this->UserModel->getUsersJsonAdmin();
		echo json_encode($users);
	}	
}



?>