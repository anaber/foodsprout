<?php

class Insect extends Controller {
	
	function __construct()
	{
		global $ADMIN_LANDING_PAGE;
		parent::Controller();
		if ($this->session->userdata('isAuthenticated') != 1 || $this->session->userdata('access') != 'admin' )
		{
			redirect($ADMIN_LANDING_PAGE);
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
			
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Insects";
		$data['data']['center']['list']['INSECTS'] = $insects;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function add()
	{
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/forms/insect_form',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Add Insect";
		
		$this->load->view('admincp/templates/center_template', $data);
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
				'list' => 'admincp/forms/insect_form',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Update Insect";
		$data['data']['center']['list']['INSECT'] = $insect;
		
		$this->load->view('admincp/templates/center_template', $data);
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