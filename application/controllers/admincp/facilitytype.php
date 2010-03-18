<?php

class Facilitytype extends Controller {
	
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
		$this->list_facility_type();
	}
	
	// List all the facilitytype in the database
	function list_facility_type()
	{
		$data = array();
		$facilitytypes = array();
		
		$this->load->model('FacilitytypeModel');
		$facilitytypes = $this->FacilitytypeModel->list_facility_type();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/facilitytype',
			);
		
		$data['RIGHT'] = array(
				'navigation' => 'admincp/includes/right/navigation',
			);
			
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Facilitytypes";
		$data['data']['center']['list']['FACILITYTYPES'] = $facilitytypes;
		
		$data['data']['right']['navigation']['VIEW_HEADER'] = "Navigation";
		
		$this->load->view('admincp/templates/center_right_template', $data);
	}
	
	function add()
	{
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/facilitytype_form',
			);
		
		$data['RIGHT'] = array(
				'navigation' => 'admincp/includes/right/navigation',
			);
			
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Add Facilitytype";
		
		$data['data']['right']['navigation']['VIEW_HEADER'] = "Navigation";
		
		$this->load->view('admincp/templates/center_right_template', $data);
	}
	
	function save_add() {
		
		$this->load->model('FacilitytypeModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->FacilitytypeModel->addFacilitytype() ) {
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
		
		$this->load->model('FacilitytypeModel');
		$facilitytype = $this->FacilitytypeModel->getFacilitytypeFromId($id);
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/facilitytype_form',
			);
		
		$data['RIGHT'] = array(
				'navigation' => 'admincp/includes/right/navigation',
			);
			
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Update Facilitytype";
		$data['data']['center']['list']['ANIMAL'] = $facilitytype;
		
		$data['data']['right']['navigation']['VIEW_HEADER'] = "Navigation";
		
		$this->load->view('admincp/templates/center_right_template', $data);
	}
	
	function save_update() {
		
		$this->load->model('FacilitytypeModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->FacilitytypeModel->updateFacilitytype() ) {
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