<?php

class Plant extends Controller {
	
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
		$this->list_plant();
	}
	
	// List all the plants in the database
	function list_plant()
	{
		$data = array();
		$plants = array();
		
		$this->load->model('PlantModel');
		$plants = $this->PlantModel->list_plant();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/plant',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Plants";
		$data['data']['center']['list']['PLANTS'] = $plants;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function add()
	{
		$data = array();
		
		$this->load->model('PlantGroupModel');
		$plantGroups = $this->PlantGroupModel->list_plantGroup();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/forms/plant_form',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Add Plant";
		$data['data']['center']['list']['PLANT_GROUPS'] = $plantGroups;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function save_add() {
		
		$this->load->model('PlantModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->PlantModel->addPlant() ) {
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
		
		$this->load->model('PlantModel');
		$plant = $this->PlantModel->getPlantFromId($id);
		
		$this->load->model('PlantGroupModel');
		$plantGroups = $this->PlantGroupModel->list_plantGroup();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/forms/plant_form',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Update Plant";
		$data['data']['center']['list']['PLANT'] = $plant;
		$data['data']['center']['list']['PLANT_GROUPS'] = $plantGroups;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function save_update() {
		
		$this->load->model('PlantModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->PlantModel->updatePlant() ) {
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

/* End of file plant.php */

?>