<?php

class Vegetabletype extends Controller {
	
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
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Vegetable Types";
		$data['data']['center']['list']['VEGETABLETYPES'] = $vegetabletypes;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function add()
	{
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/forms/vegetabletype_form',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Add Vegetable Type";
		
		$this->load->view('admincp/templates/center_template', $data);
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
				'list' => 'admincp/forms/vegetabletype_form',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Update Vegetable Type";
		$data['data']['center']['list']['VEGETABLETYPE'] = $vegetabletype;
		
		$this->load->view('admincp/templates/center_template', $data);
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