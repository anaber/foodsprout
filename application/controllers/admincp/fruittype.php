<?php

class Fruittype extends Controller {
	
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
		$this->list_fruittype();
	}
	
	// Create a simple list of all the fruit types in the database
	function list_fruittype()
	{
		$data = array();
		$fruittypes = array();
		
		$this->load->model('FruittypeModel');
		$fruittypes = $this->FruittypeModel->list_fruittype();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/fruittype',
			);
		
		$data['RIGHT'] = array(
				'navigation' => 'admincp/includes/right/navigation',
			);
			
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "List of Fruit Types";
		$data['data']['center']['list']['FRUITTYPES'] = $fruittypes;
		
		$data['data']['right']['navigation']['VIEW_HEADER'] = "Navigation";
		
		$this->load->view('admincp/templates/center_right_template', $data);
	}
	
	// Add a new fruit type, this will only create the web form
	function add()
	{
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/fruittype_form',
			);
		
		$data['RIGHT'] = array(
				'navigation' => 'admincp/includes/right/navigation',
			);
			
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Add Fruit Type";
		
		$data['data']['right']['navigation']['VIEW_HEADER'] = "Navigation";
		
		$this->load->view('admincp/templates/center_right_template', $data);
	}
	
	// Take the information from the form and pass it to the model to save it in the database
	function save_add() {
		
		$this->load->model('FruittypeModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->FruittypeModel->addFruittype() ) {
			echo "yes";
		} else {
			if (isset($GLOBALS['error']) && !empty($GLOBALS['error']) ) {
				echo $GLOBALS['error'];
			} else {
				echo 'no';
			}
		}
	}
	
	// Get the information for specific fruit type and populate a HTML form to update the information
	function update($id)
	{
		$data = array();
		
		$this->load->model('FruittypeModel');
		$fruittype = $this->FruittypeModel->getFruittypeFromId($id);
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/fruittype_form',
			);
		
		$data['RIGHT'] = array(
				'navigation' => 'admincp/includes/right/navigation',
			);
			
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Update Fruit Type";
		$data['data']['center']['list']['FRUITTYPE'] = $fruittype;
		
		$data['data']['right']['navigation']['VIEW_HEADER'] = "Navigation";
		
		$this->load->view('admincp/templates/center_right_template', $data);
	}
	
	// Take the information from the update form and send it to the model for updating
	function save_update() {
		
		$this->load->model('FruittypeModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->FruittypeModel->updateFruittype() ) {
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

/* End of file fruittype.php */

?>