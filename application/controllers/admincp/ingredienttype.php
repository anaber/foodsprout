<?php

class Ingredienttype extends Controller {
	
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
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "List Ingredient Types";
		$data['data']['center']['list']['INGREDIENTTYPES'] = $ingredienttypes;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	// Create the form to add a new ingredient type to the database
	function add()
	{
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/forms/ingredienttype_form',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Add an Ingredient Type";
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	// Save the information by sending 
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
	
	// Create the HTML form and populate the info from the database into the form
	function update($id)
	{
		$data = array();
		
		$this->load->model('IngredienttypeModel');
		$ingredienttype = $this->IngredienttypeModel->getIngredienttypeFromId($id);
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/forms/ingredienttype_form',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Update Ingredient Type";
		$data['data']['center']['list']['INGREDIENTTYPE'] = $ingredienttype;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	// Save the information into the database
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