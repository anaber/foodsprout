<?php

class PlantGroup extends Controller {
	
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
		$this->list_plantgroup();
	}
	
	// Create a simple list of all the fruit types in the database
	function list_plantgroup()
	{
		$data = array();
		$plantGroups = array();
		
		$this->load->model('PlantGroupModel');
		$plantGroups = $this->PlantGroupModel->list_plantgroup();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/plantgroup',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "List of Plant Groups";
		$data['data']['center']['list']['PLANT_GROUPS'] = $plantGroups;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	// Add a new fruit type, this will only create the web form
	function add()
	{
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/plantgroup_form',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Add Plant Group";
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	// Take the information from the form and pass it to the model to save it in the database
	function save_add() {
		
		$this->load->model('PlantGroupModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->PlantGroupModel->addPlantGroup() ) {
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
		
		$this->load->model('PlantGroupModel');
		$plantGroup = $this->PlantGroupModel->getPlantGroupFromId($id);
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/plantgroup_form',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Update Plant Group";
		$data['data']['center']['list']['PLANT_GROUP'] = $plantGroup;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	// Take the information from the update form and send it to the model for updating
	function save_update() {
		
		$this->load->model('PlantGroupModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->PlantGroupModel->updatePlantGroup() ) {
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