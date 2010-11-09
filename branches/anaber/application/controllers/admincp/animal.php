<?php

class Animal extends Controller {
	
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
		$this->listAnimal();
	}
	
	// List all the animal in the database
	function listAnimal()
	{
		$data = array();
		$animals = array();
		
		$this->load->model('AnimalModel');
		$animals = $this->AnimalModel->listAnimal();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/animal',
			);
			
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Animals";
		$data['data']['center']['list']['ANIMALS'] = $animals;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function add()
	{
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/animal_form',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Add Animal";
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function saveAdd() {
		
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
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Update Animal";
		$data['data']['center']['list']['ANIMAL'] = $animal;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function saveUpdate() {
		
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