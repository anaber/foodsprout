<?php

class Cuisine extends Controller {
	
	function __construct()
	{
		parent::Controller();
		if ($this->session->userdata('isAuthenticated') != 1 || $this->session->userdata('userGroup') != 'admin' )
		{
			redirect('admincp/login');
		}
	}
	
	function index()
	{
		$this->listCuisine();
	}
	
	// List all the cuisine in the database
	function listCuisine()
	{
		$data = array();
		$cuisines = array();
		
		$this->load->model('CuisineModel');
		$cuisines = $this->CuisineModel->listCuisine();
		
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
	
	function saveAdd() {
		
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
			
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Update Cuisine";
		$data['data']['center']['list']['CUISINE'] = $cuisine;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function saveUpdate() {
		
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