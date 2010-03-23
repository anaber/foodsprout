<?php

class Usergroup extends Controller {
	
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
		$this->list_usergroup();
	}
	
	// List all the usergroup in the database
	function list_usergroup()
	{
		$data = array();
		$usergroups = array();
		
		$this->load->model('UsergroupModel');
		$usergroups = $this->UsergroupModel->list_usergroup();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/usergroup',
			);
			
		$data['LEFT'] = array(
				'list' => 'admincp/includes/left/nav_user',
			);
			
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Usergroups";
		$data['data']['center']['list']['USERGROUPS'] = $usergroups;
	
		$data['data']['left']['navigation']['VIEW_HEADER'] = "User Options";
		
		$this->load->view('admincp/templates/left_center_template', $data);
	}
	
	function add()
	{
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/usergroup_form',
			);
		
		$data['RIGHT'] = array(
				'navigation' => 'admincp/includes/right/navigation',
			);
			
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Add Usergroup";
		
		$data['data']['right']['navigation']['VIEW_HEADER'] = "Navigation";
		
		$this->load->view('admincp/templates/center_right_template', $data);
	}
	
	function save_add() {
		
		$this->load->model('UsergroupModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->UsergroupModel->addUsergroup() ) {
			echo "yes";
		} else {
			if (isset($GLOBALS['error']) && !empty($GLOBALS['error']) ) {
				echo $GLOBALS['error'];
			} else {
				echo 'no';
			}
		}
	}
	
	function update($id)
	{
		$data = array();
		
		$this->load->model('UsergroupModel');
		$usergroup = $this->UsergroupModel->getUsergroupFromId($id);
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/usergroup_form',
			);
		
		$data['RIGHT'] = array(
				'navigation' => 'admincp/includes/right/navigation',
			);
			
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Update Usergroup";
		$data['data']['center']['list']['ANIMAL'] = $usergroup;
		
		$data['data']['right']['navigation']['VIEW_HEADER'] = "Navigation";
		
		$this->load->view('admincp/templates/center_right_template', $data);
	}
	
	function save_update() {
		
		$this->load->model('UsergroupModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->UsergroupModel->updateUsergroup() ) {
			echo "yes";
		} else {
			if (isset($GLOBALS['error']) && !empty($GLOBALS['error']) ) {
				echo $GLOBALS['error'];
			} else {
				echo 'no';
			}
		}
		
	}
}

/* End of file usergroup.php */

?>