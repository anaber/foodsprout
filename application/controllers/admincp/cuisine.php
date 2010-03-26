<?php

class Cuisine extends Controller {
	
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
		$this->list_cuisine();
	}
	
	// List all the cuisine in the database
	function list_cuisine()
	{
		$data = array();
		$cuisines = array();
		
		$this->load->model('CuisineModel');
		$cuisines = $this->CuisineModel->list_cuisine();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/cuisine',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Cuisines";
		$data['data']['center']['list']['CUISINES'] = $cuisines;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function add()
	{
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/cuisine_form',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Add Cuisine";
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function save_add() {
		
		$this->load->model('CuisineModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->CuisineModel->addCuisine() ) {
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
		
		$this->load->model('CuisineModel');
		$cuisine = $this->CuisineModel->getCuisineFromId($id);
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/cuisine_form',
			);
		
		$data['RIGHT'] = array(
				'navigation' => 'admincp/includes/right/navigation',
			);
			
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Update Cuisine";
		$data['data']['center']['list']['CUISINE'] = $cuisine;
		
		$data['data']['right']['navigation']['VIEW_HEADER'] = "Navigation";
		
		$this->load->view('admincp/templates/center_right_template', $data);
	}
	
	function save_update() {
		
		$this->load->model('CuisineModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->CuisineModel->updateCuisine() ) {
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

/* End of file cuisine.php */

?>