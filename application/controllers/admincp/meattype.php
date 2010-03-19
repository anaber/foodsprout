<?php

class Meattype extends Controller {
	
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
		$this->list_meattype();
	}
	
	// List all the meattype in the database
	function list_meattype()
	{
		$data = array();
		$meattypes = array();
		
		$this->load->model('MeattypeModel');
		$meattypes = $this->MeattypeModel->list_meattype();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/meattype',
			);
		
		$data['RIGHT'] = array(
				'navigation' => 'admincp/includes/right/navigation',
			);
			
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "List of Meat Types";
		$data['data']['center']['list']['MEATTYPES'] = $meattypes;
		
		$data['data']['right']['navigation']['VIEW_HEADER'] = "Navigation";
		
		$this->load->view('admincp/templates/center_right_template', $data);
	}
	
	function add()
	{
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/meattype_form',
			);
		
		$data['RIGHT'] = array(
				'navigation' => 'admincp/includes/right/navigation',
			);
			
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Add Meat Type";
		
		$data['data']['right']['navigation']['VIEW_HEADER'] = "Navigation";
		
		$this->load->view('admincp/templates/center_right_template', $data);
	}
	
	function save_add() {
		
		$this->load->model('MeattypeModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->MeattypeModel->addMeattype() ) {
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
		
		$this->load->model('MeattypeModel');
		$meattype = $this->MeattypeModel->getMeattypeFromId($id);
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/meattype_form',
			);
		
		$data['RIGHT'] = array(
				'navigation' => 'admincp/includes/right/navigation',
			);
			
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Update Meattype";
		$data['data']['center']['list']['MEATTYPE'] = $meattype;
		
		$data['data']['right']['navigation']['VIEW_HEADER'] = "Navigation";
		
		$this->load->view('admincp/templates/center_right_template', $data);
	}
	
	function save_update() {
		
		$this->load->model('MeattypeModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->MeattypeModel->updateMeattype() ) {
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

/* End of file meattype.php */

?>