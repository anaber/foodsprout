<?php

class Manufacture extends Controller {
	
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
		$manufactures = array();
		
		$this->load->model('ManufactureModel');
		$manufactures = $this->ManufactureModel->listManufacture();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/manufacture',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Manufactures";
		$data['data']['center']['list']['MANUFACTURES'] = $manufactures;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	// Create the form page to add a manufacture to the database, does not actually add the data, only builds the form
	function add()
	{
		$data = array();
		
		$this->load->model('CompanyModel');
		$companies = $this->CompanyModel->listCompany();
		
		$this->load->model('StateModel');
		$states = $this->StateModel->listState();
		
		$this->load->model('CountryModel');
		$countries = $this->CountryModel->listCountry();
		
		$this->load->model('ManufactureTypeModel');
		$manufactureTypes = $this->ManufactureTypeModel->listManufactureType();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/manufacture_form',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Add Manufacture";
		$data['data']['center']['list']['COUNTRIES'] = $countries;
		$data['data']['center']['list']['STATES'] = $states;
		$data['data']['center']['list']['MANUFACTURE_TYPES'] = $manufactureTypes;
		$data['data']['center']['list']['COMPANIES'] = $companies;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	// Update a record using an id
	function update($id)
	{
		$data = array();
		
		$this->load->model('ManufactureModel');
		$manufacture = $this->ManufactureModel->getManufactureFromId($id);
		
		$this->load->model('StateModel');
		$states = $this->StateModel->listState();
		
		$this->load->model('CountryModel');
		$countries = $this->CountryModel->listCountry();
		
		// List of views to be included
		$data['LEFT'] = array(
				'nav' => 'admincp/includes/left/nav_manufacture',
			);
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/manufacture_form',
			);
		
		// Data to be passed to the views
		$data['data']['left']['nav']['MANUFACTURE_ID'] = $id;
		
		$data['data']['center']['list']['VIEW_HEADER'] = "Update Manufacture";
		$data['data']['center']['list']['COUNTRIES'] = $countries;
		$data['data']['center']['list']['STATES'] = $states;
		$data['data']['center']['list']['MANUFACTURE'] = $manufacture;
		
		$this->load->view('admincp/templates/left_center_template', $data);
	}
	
	// Pass the form data to the model to be inserted into the database
	function save_add() {
		
		$this->load->model('ManufactureModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->ManufactureModel->addManufacture() ) {
			
			// TO DO: IF THE USER DOES NOT HAVE JAVASCRIPT WE NEED TO USE SERVER SIDE REDIRECT.  BELOW CODE WILL DO THIS, HOWEVER THE echo 'yes' IS REQUIRED TO PASS TO THE JAVASCRIPT.  CONSIDER A BETTER WAY TO NOTIFY THE JQUERY JAVASCRIPT THAT THE EVENT WAS SUCCESSFUL SO AS TO ALLOW THE PROPER REDIRECT FOR NON JAVASCRIPT
			// Added the new manufacture successfully, send user to index
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
		
		$this->load->model('ManufactureModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->ManufactureModel->updateManufacture() ) {
			echo "yes";
		} else {
			if (isset($GLOBALS['error']) && !empty($GLOBALS['error']) ) {
				echo $GLOBALS['error'];
			} else {
				echo 'no';
			}
		}
		
	}
	
	function add_supplier($id)
	{
		global $SUPPLIER_TYPE;
		$data = array();
		
		$this->load->model('ManufactureModel');
		$manufacture = $this->ManufactureModel->getManufactureFromId($id);
		
		// List of views to be included
		$data['LEFT'] = array(
				'nav' => 'admincp/includes/left/nav_manufacture',
			);
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/supplier_form',
			);
		
		// Data to be passed to the views
		$data['data']['left']['nav']['MANUFACTURE_ID'] = $id;
		
		$data['data']['center']['list']['VIEW_HEADER'] = "Add Supplier - " . $manufacture->manufactureName;
		$data['data']['center']['list']['MANUFACTURE'] = $manufacture;
		$data['data']['center']['list']['SUPPLIER_TYPE'] = $SUPPLIER_TYPE;
		
		$this->load->view('admincp/templates/left_center_template', $data);
	}
	
	
}

/* End of file company.php */

?>