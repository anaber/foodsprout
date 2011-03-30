<?php

class Usergroup extends Controller {
	
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
			
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Usergroups";
		$data['data']['center']['list']['USERGROUPS'] = $usergroups;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function add()
	{
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/forms/usergroup_form',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Add Usergroup";
		
		$this->load->view('admincp/templates/center_template', $data);
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
				'list' => 'admincp/forms/usergroup_form',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Update Usergroup";
		$data['data']['center']['list']['ANIMAL'] = $usergroup;
		
		$this->load->view('admincp/templates/center_template', $data);
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