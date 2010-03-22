<?php

class Ingredient extends Controller {
	
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
		$data = array();
		
		$this->load->model('IngredientModel');
		$ingredients = $this->IngredientModel->list_ingredient();
		
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/ingredient',
			);
		
		$data['RIGHT'] = array(
				'navigation' => 'admincp/includes/right/navigation',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Ingredients";
		$data['data']['center']['list']['INGREDIENTS'] = $ingredients;
		
		$data['data']['right']['navigation']['VIEW_HEADER'] = "Navigation";
		
		$this->load->view('admincp/templates/center_right_template', $data);
	}
	
	function add()
	{
		$data = array();
		
		$this->load->model('IngredienttypeModel');
		$ingredienttypes = $this->IngredienttypeModel->list_ingredienttype();
		
		$this->load->model('VegetabletypeModel');
		$vegetabletypes = $this->VegetabletypeModel->list_vegetabletype();
		
		$this->load->model('MeattypeModel');
		$meattypes = $this->MeattypeModel->list_meattype();
		
		$this->load->model('FruittypeModel');
		$fruittypes = $this->FruittypeModel->list_fruittype();
		
		$this->load->model('PlantModel');
		$plants = $this->PlantModel->list_plant();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/ingredient_form',
			);
		
		$data['RIGHT'] = array(
				'navigation' => 'admincp/includes/right/navigation',
			);
			
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Add Ingredient";
		$data['data']['center']['list']['INGREDIENTTYPES'] = $ingredienttypes;
		$data['data']['center']['list']['VEGETABLETYPES'] = $vegetabletypes;
		$data['data']['center']['list']['MEATTYPES'] = $meattypes;
		$data['data']['center']['list']['FRUITTYPES'] = $fruittypes;
		$data['data']['center']['list']['PLANTS'] = $plants;
		
		$data['data']['right']['navigation']['VIEW_HEADER'] = "Navigation";
		
		$this->load->view('admincp/templates/center_right_template', $data);
	}
	
	function update($id)
	{
		$data = array();
		
		$this->load->model('IngredientModel');
		$ingredient = $this->IngredientModel->getIngredientFromId($id);
		
		$this->load->model('StateModel');
		$states = $this->StateModel->list_state();
		
		$this->load->model('CountryModel');
		$countries = $this->CountryModel->list_country();
		
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/ingredient_form',
			);
		
		$data['RIGHT'] = array(
				'navigation' => 'admincp/includes/right/navigation',
			);
			
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Update Ingredient";
		$data['data']['center']['list']['COUNTRIES'] = $countries;
		$data['data']['center']['list']['STATES'] = $states;
		$data['data']['center']['list']['COMPANY'] = $ingredient;
		
		$data['data']['right']['navigation']['VIEW_HEADER'] = "Navigation";
		
		$this->load->view('admincp/templates/center_right_template', $data);
	}
	
	function save_add() {
		
		$this->load->model('IngredientModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->IngredientModel->addIngredient() ) {
			
			// TO DO: IF THE USER DOES NOT HAVE JAVASCRIPT WE NEED TO USE SERVER SIDE REDIRECT.  BELOW CODE WILL DO THIS, HOWEVER THE echo 'yes' IS REQUIRED TO PASS TO THE JAVASCRIPT.  CONSIDER A BETTER WAY TO NOTIFY THE JQUERY JAVASCRIPT THAT THE EVENT WAS SUCCESSFUL SO AS TO ALLOW THE PROPER REDIRECT FOR NON JAVASCRIPT
			// Added the new COMPANY successfully, send user to index
			//$this->index();
			echo 'yes';
			
		} else {
			if (isset($GLOBALS['error']) && !empty($GLOBALS['error']) ) {
				echo $GLOBALS['error'];
			} else {
				echo 'no';
			}
		}
		
	}
	
	function save_update() {
		
		$this->load->model('IngredientModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->IngredientModel->updateIngredient() ) {
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

/* End of file ingredient.php */

?>