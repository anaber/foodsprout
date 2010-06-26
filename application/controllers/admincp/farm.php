<?php

class Farm extends Controller {
	
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
		$farms = array();
		
		$this->load->model('FarmModel');
		$farms = $this->FarmModel->listFarm();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/farm',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Farms";
		$data['data']['center']['list']['FARMS'] = $farms;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	// Create the form page to add a farm to the database, does not actually add the data, only builds the form
	function add()
	{
		$data = array();
		
		$this->load->model('StateModel');
		$states = $this->StateModel->listState();
		
		$this->load->model('CountryModel');
		$countries = $this->CountryModel->listCountry();
		
		$this->load->model('FarmTypeModel');
		$farmTypes = $this->FarmTypeModel->listFarmType();
		
		// List of views to be included
		$data['CENTER'] = array(
				'form' => 'admincp/farm_form',
			);
		
		// Data to be passed to the views
		$data['data']['center']['form']['VIEW_HEADER'] = "Add Farm";
		$data['data']['center']['form']['COUNTRIES'] = $countries;
		$data['data']['center']['form']['STATES'] = $states;
		$data['data']['center']['form']['FARM_TYPES'] = $farmTypes;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function update($id)
	{
		$data = array();
		
		$this->load->model('FarmModel');
		$farm = $this->FarmModel->getFarmFromId($id);
		
		$this->load->model('FarmTypeModel');
		$farmTypes = $this->FarmTypeModel->listFarmType();
		
		
		// List of views to be included
		$data['LEFT'] = array(
				'nav' => 'admincp/includes/left/nav_farm',
			);
		
		// List of views to be included
		$data['CENTER'] = array(
				'form' => 'admincp/farm_form',
			);
		
		// Data to be passed to the views
		$data['data']['left']['nav']['FARM_ID'] = $id;
		
		$data['data']['center']['form']['VIEW_HEADER'] = "Update Manufacture";
		$data['data']['center']['form']['FARM_TYPES'] = $farmTypes;
		$data['data']['center']['form']['FARM'] = $farm;
		
		$this->load->view('admincp/templates/left_center_template', $data);
		
	}
	
	// Pass the form data to the model to be inserted into the database
	function save_add() {
		
		$this->load->model('FarmModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->FarmModel->addFarm() ) {
			
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
		
		$this->load->model('FarmModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->FarmModel->updateFarm() ) {
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
		global $SUPPLIER_TYPES_2;
		$data = array();
		
		$this->load->model('FarmModel');
		$farm = $this->FarmModel->getFarmFromId($id);
		
		// List of views to be included
		$data['LEFT'] = array(
				'nav' => 'admincp/includes/left/nav_farm',
			);
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/supplier_form',
			);
		
		// Data to be passed to the views
		$data['data']['left']['nav']['FARM_ID'] = $id;
		
		$data['data']['center']['list']['VIEW_HEADER'] = "Add Supplier - " . $farm->farmName;
		$data['data']['center']['list']['FARM'] = $farm;
		$data['data']['center']['list']['SUPPLIER_TYPES_2'] = $SUPPLIER_TYPES_2;
		$data['data']['center']['list']['TABLE'] = 'farm_supplier';
		
		$this->load->view('admincp/templates/left_center_template', $data);
	}
	
	function update_supplier($id)
	{
		global $SUPPLIER_TYPES_2;
		$data = array();
		
		$this->load->model('SupplierModel');
		$supplier = $this->SupplierModel->getSupplierFromId($id, 'farm');
		
		// List of views to be included
		$data['LEFT'] = array(
				'nav' => 'admincp/includes/left/nav_farm',
			);
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/supplier_form',
			);
		
		// Data to be passed to the views
		$data['data']['left']['nav']['FARM_ID'] = $supplier->farmId;
		
		$data['data']['center']['list']['VIEW_HEADER'] = "Update Supplier - " . $id;
		$data['data']['center']['list']['SUPPLIER'] = $supplier;
		$data['data']['center']['list']['SUPPLIER_TYPES_2'] = $SUPPLIER_TYPES_2;
		$data['data']['center']['list']['TABLE'] = 'farm_supplier';
		
		$this->load->view('admincp/templates/left_center_template', $data);
	}
	
	function add_address($id)
	{
		$data = array();
		
		$this->load->model('StateModel');
		$states = $this->StateModel->listState();
		
		$this->load->model('CountryModel');
		$countries = $this->CountryModel->listCountry();
		
		$this->load->model('FarmModel');
		$farm = $this->FarmModel->getFarmFromId($id);
		
		// List of views to be included
		$data['LEFT'] = array(
				'nav' => 'admincp/includes/left/nav_farm',
			);
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/address_form',
			);
		
		// Data to be passed to the views
		$data['data']['left']['nav']['FARM_ID'] = $id;
		
		$data['data']['center']['list']['VIEW_HEADER'] = "Add Address - " . $farm->farmName;
		$data['data']['center']['list']['STATES'] = $states;
		$data['data']['center']['list']['COUNTRIES'] = $countries;
		
		$this->load->view('admincp/templates/left_center_template', $data);
	}
	
	function update_address($id)
	{
		$data = array();
		
		$this->load->model('StateModel');
		$states = $this->StateModel->listState();
		
		$this->load->model('CountryModel');
		$countries = $this->CountryModel->listCountry();
		
		$this->load->model('AddressModel');
		$address = $this->AddressModel->getAddressFromId($id);
		
		// List of views to be included
		$data['LEFT'] = array(
				'nav' => 'admincp/includes/left/nav_farm',
			);
		
		// List of views to be included
		$data['CENTER'] = array(
				'from' => 'admincp/address_form',
			);
		
		// Data to be passed to the views
		$data['data']['left']['nav']['FARM_ID'] = $address->farmId;
		$data['data']['left']['nav']['ADDRESS_ID'] = $address->addressId;
		
		$data['data']['center']['from']['VIEW_HEADER'] = "Update Address - #" . $id;
		$data['data']['center']['from']['STATES'] = $states;
		$data['data']['center']['from']['COUNTRIES'] = $countries;
		$data['data']['center']['from']['ADDRESS'] = $address;
		$data['data']['center']['from']['FARM_ID'] = $address->farmId;
		
		$this->load->view('admincp/templates/left_center_template', $data);
		
	}
	
}

/* End of file company.php */

?>