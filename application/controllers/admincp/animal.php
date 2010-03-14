<?php

class Animal extends Controller {
	
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
		$this->list_animal();
	}
	
	// List all the animal in the database
	function list_animal()
	{
		$data = array();
		$animals = array();
		
		$this->load->model('AnimalModel');
		$animals = $this->AnimalModel->list_animal();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/animal',
			);
		
		$data['RIGHT'] = array(
				'navigation' => 'admincp/includes/right/navigation',
			);
			
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Animals";
		$data['data']['center']['list']['ANIMALS'] = $animals;
		
		$data['data']['right']['navigation']['VIEW_HEADER'] = "Navigation";
		
		$this->load->view('admincp/templates/center_right_template', $data);
	}
	
	function add()
	{
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/animal_form',
			);
		
		$data['RIGHT'] = array(
				'navigation' => 'admincp/includes/right/navigation',
			);
			
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Add Animal";
		
		$data['data']['right']['navigation']['VIEW_HEADER'] = "Navigation";
		
		$this->load->view('admincp/templates/center_right_template', $data);
	}
	
	function save_add() {
		
		$this->load->model('AnimalModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->AnimalModel->addAnimal() ) {
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
		
		$this->load->model('AnimalModel');
		$animal = $this->AnimalModel->getAnimalFromId($id);
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/animal_form',
			);
		
		$data['RIGHT'] = array(
				'navigation' => 'admincp/includes/right/navigation',
			);
			
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Update Animal";
		$data['data']['center']['list']['ANIMAL'] = $animal;
		
		$data['data']['right']['navigation']['VIEW_HEADER'] = "Navigation";
		
		$this->load->view('admincp/templates/center_right_template', $data);
	}
	
	function save_update() {
		
		$this->load->model('AnimalModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->AnimalModel->updateAnimal() ) {
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

/* End of file animal.php */

?>