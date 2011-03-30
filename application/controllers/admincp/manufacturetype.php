<?php

class Manufacturetype extends Controller {
	
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
		$this->list_manufacture_type();
	}
	
	// List all the facilitytype in the database
	function list_manufacture_type()
	{
		$data = array();
		$manufactureTypes = array();
		
		$this->load->model('ManufacturetypeModel');
		$manufactureTypes = $this->ManufacturetypeModel->listManufactureType();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/manufacturetype',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "List Manufacture Types";
		$data['data']['center']['list']['MANUFACTURETYPES'] = $manufactureTypes;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	// Create the form to add a new facility type
	function add()
	{
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/forms/manufacturetype_form',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Add Manufacture Type";
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function save_add() {
		
		$this->load->model('ManufacturetypeModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->ManufacturetypeModel->addManufactureType() ) {
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
		
		$this->load->model('ManufacturetypeModel');
		$manufacturetype = $this->ManufacturetypeModel->getManufactureTypeFromId($id);
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/forms/manufacturetype_form',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Update Manufacture Type";
		$data['data']['center']['list']['MANUFACTURETYPE'] = $manufacturetype;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function save_update() {
		
		$this->load->model('ManufacturetypeModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->ManufacturetypeModel->updateManufacturetype() ) {
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

/* End of file facilitytype.php */

?>