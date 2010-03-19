<?php

class Vegetabletype extends Controller {
	
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
		$this->list_vegetabletype();
	}
	
	// List all the vegetabletype in the database
	function list_vegetabletype()
	{
		$data = array();
		$vegetabletypes = array();
		
		$this->load->model('VegetabletypeModel');
		$vegetabletypes = $this->VegetabletypeModel->list_vegetabletype();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/vegetabletype',
			);
		
		$data['RIGHT'] = array(
				'navigation' => 'admincp/includes/right/navigation',
			);
			
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Vegetabletypes";
		$data['data']['center']['list']['VEGETABLETYPES'] = $vegetabletypes;
		
		$data['data']['right']['navigation']['VIEW_HEADER'] = "Navigation";
		
		$this->load->view('admincp/templates/center_right_template', $data);
	}
	
	function add()
	{
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/vegetabletype_form',
			);
		
		$data['RIGHT'] = array(
				'navigation' => 'admincp/includes/right/navigation',
			);
			
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Add Vegetabletype";
		
		$data['data']['right']['navigation']['VIEW_HEADER'] = "Navigation";
		
		$this->load->view('admincp/templates/center_right_template', $data);
	}
	
	function save_add() {
		
		$this->load->model('VegetabletypeModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->VegetabletypeModel->addVegetabletype() ) {
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
		
		$this->load->model('VegetabletypeModel');
		$vegetabletype = $this->VegetabletypeModel->getVegetabletypeFromId($id);
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/vegetabletype_form',
			);
		
		$data['RIGHT'] = array(
				'navigation' => 'admincp/includes/right/navigation',
			);
			
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Update Vegetabletype";
		$data['data']['center']['list']['VEGETABLETYPE'] = $vegetabletype;
		
		$data['data']['right']['navigation']['VIEW_HEADER'] = "Navigation";
		
		$this->load->view('admincp/templates/center_right_template', $data);
	}
	
	function save_update() {
		
		$this->load->model('VegetabletypeModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->VegetabletypeModel->updateVegetabletype() ) {
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

/* End of file vegetabletype.php */

?>