<?php

class Insect extends Controller {
	
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
		$this->list_insect();
	}
	
	// List all the insect in the database
	function list_insect()
	{
		$data = array();
		$insects = array();
		
		$this->load->model('InsectModel');
		$insects = $this->InsectModel->list_insect();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/insect',
			);
		
		$data['RIGHT'] = array(
				'navigation' => 'admincp/includes/right/navigation',
			);
			
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Insects";
		$data['data']['center']['list']['INSECTS'] = $insects;
		
		$data['data']['right']['navigation']['VIEW_HEADER'] = "Navigation";
		
		$this->load->view('admincp/templates/center_right_template', $data);
	}
	
	function add()
	{
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/insect_form',
			);
		
		$data['RIGHT'] = array(
				'navigation' => 'admincp/includes/right/navigation',
			);
			
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Add Insect";
		
		$data['data']['right']['navigation']['VIEW_HEADER'] = "Navigation";
		
		$this->load->view('admincp/templates/center_right_template', $data);
	}
	
	function save_add() {
		
		$this->load->model('InsectModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->InsectModel->addInsect() ) {
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
		
		$this->load->model('InsectModel');
		$insect = $this->InsectModel->getInsectFromId($id);
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/insect_form',
			);
		
		$data['RIGHT'] = array(
				'navigation' => 'admincp/includes/right/navigation',
			);
			
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Update Insect";
		$data['data']['center']['list']['ANIMAL'] = $insect;
		
		$data['data']['right']['navigation']['VIEW_HEADER'] = "Navigation";
		
		$this->load->view('admincp/templates/center_right_template', $data);
	}
	
	function save_update() {
		
		$this->load->model('InsectModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->InsectModel->updateInsect() ) {
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

/* End of file insect.php */

?>