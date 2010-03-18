<?php

class Ingredienttype extends Controller {
	
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
		$this->list_ingredienttype();
	}
	
	// List all the ingredienttype in the database
	function list_ingredienttype()
	{
		$data = array();
		$ingredienttypes = array();
		
		$this->load->model('IngredienttypeModel');
		$ingredienttypes = $this->IngredienttypeModel->list_ingredienttype();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/ingredienttype',
			);
		
		$data['RIGHT'] = array(
				'navigation' => 'admincp/includes/right/navigation',
			);
			
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Ingredienttypes";
		$data['data']['center']['list']['INGREDIENTTYPES'] = $ingredienttypes;
		
		$data['data']['right']['navigation']['VIEW_HEADER'] = "Navigation";
		
		$this->load->view('admincp/templates/center_right_template', $data);
	}
	
	function add()
	{
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/ingredienttype_form',
			);
		
		$data['RIGHT'] = array(
				'navigation' => 'admincp/includes/right/navigation',
			);
			
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Add Ingredienttype";
		
		$data['data']['right']['navigation']['VIEW_HEADER'] = "Navigation";
		
		$this->load->view('admincp/templates/center_right_template', $data);
	}
	
	function save_add() {
		
		$this->load->model('IngredienttypeModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->IngredienttypeModel->addIngredienttype() ) {
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
		
		$this->load->model('IngredienttypeModel');
		$ingredienttype = $this->IngredienttypeModel->getIngredienttypeFromId($id);
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/ingredienttype_form',
			);
		
		$data['RIGHT'] = array(
				'navigation' => 'admincp/includes/right/navigation',
			);
			
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Update Ingredienttype";
		$data['data']['center']['list']['ANIMAL'] = $ingredienttype;
		
		$data['data']['right']['navigation']['VIEW_HEADER'] = "Navigation";
		
		$this->load->view('admincp/templates/center_right_template', $data);
	}
	
	function save_update() {
		
		$this->load->model('IngredienttypeModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->IngredienttypeModel->updateIngredienttype() ) {
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

/* End of file ingredienttype.php */

?>