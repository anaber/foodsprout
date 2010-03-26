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
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "List Processing Facility Types";
		$data['data']['center']['list']['FACILITYTYPES'] = $facilitytypes;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	// Create the form to add a new facility type
	function add()
	{
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/facilitytype_form',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Add Facilitytype";
		
		$this->load->view('admincp/templates/center_template', $data);
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
	
	// Update the facility type
	function update($id)
	{
		$data = array();
		
		$this->load->model('FacilitytypeModel');
		$facilitytype = $this->FacilitytypeModel->getFacilitytypeFromId($id);
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/facilitytype_form',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Update Facility Type";
		$data['data']['center']['list']['FACILITYTYPE'] = $facilitytype;
		
		$this->load->view('admincp/templates/center_template', $data);
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