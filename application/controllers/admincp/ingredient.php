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
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Ingredients";
		$data['data']['center']['list']['INGREDIENTS'] = $ingredients;
		
		$this->load->view('admincp/templates/center_template', $data);
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
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Add Ingredient";
		$data['data']['center']['list']['INGREDIENT_TYPES'] = $ingredienttypes;
		$data['data']['center']['list']['VEGETABLE_TYPES'] = $vegetabletypes;
		$data['data']['center']['list']['MEAT_TYPES'] = $meattypes;
		$data['data']['center']['list']['FRUIT_TYPES'] = $fruittypes;
		$data['data']['center']['list']['PLANTS'] = $plants;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function update($id)
	{
		$data = array();
		
		$this->load->model('IngredientModel');
		$ingredient = $this->IngredientModel->getIngredientFromId($id);
		
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
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Update Ingredient";
		$data['data']['center']['list']['INGREDIENT'] = $ingredient;
		$data['data']['center']['list']['INGREDIENT_TYPES'] = $ingredienttypes;
		$data['data']['center']['list']['VEGETABLE_TYPES'] = $vegetabletypes;
		$data['data']['center']['list']['MEAT_TYPES'] = $meattypes;
		$data['data']['center']['list']['FRUIT_TYPES'] = $fruittypes;
		$data['data']['center']['list']['PLANTS'] = $plants;
		
		$this->load->view('admincp/templates/center_template', $data);
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