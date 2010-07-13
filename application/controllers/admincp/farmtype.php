<?php

class FarmType extends Controller {
	
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
		$this->listFarmType();
	}
	
	// List all the FarmType in the database
	function listFarmType()
	{
		$data = array();
		$farmTypes = array();
		
		$this->load->model('FarmTypeModel');
		$farmTypes = $this->FarmTypeModel->listFarmType('');
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/farmtype',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "List Farm Types";
		$data['data']['center']['list']['FARM_TYPES'] = $farmTypes;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	// Create the form to add a new farm type
	function add()
	{
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/farmtype_form',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Add Farm Type";
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function saveAdd() {
		
		$this->load->model('FarmTypeModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->FarmTypeModel->addFarmType() ) {
			echo "yes";
		} else {
			if (isset($GLOBALS['error']) && !empty($GLOBALS['error']) ) {
				echo $GLOBALS['error'];
			} else {
				echo 'no';
			}
		}
	}
	
	// Update the facility type
	function update($id)
	{
		$data = array();
		
		$this->load->model('FarmTypeModel');
		$farmType = $this->FarmTypeModel->getFarmTypeFromId($id);
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/farmtype_form',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Update Farm Type";
		$data['data']['center']['list']['FARM_TYPE'] = $farmType;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function saveUpdate() {
		
		$this->load->model('FarmTypeModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->FarmTypeModel->updateFarmType() ) {
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

/* End of file farmtype.php */

?>