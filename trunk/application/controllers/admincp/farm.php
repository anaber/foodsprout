<?php

class Farm extends Controller {
	
	function __construct()
	{
		global $ADMIN_LANDING_PAGE;
		parent::Controller();
		if ($this->session->userdata('isAuthenticated') != 1 || $this->session->userdata('userGroup') != 'admin' )
		{
			redirect($ADMIN_LANDING_PAGE);
		}
	}
	
	function index() {
		global $FARMER_TYPES;
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/farm',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Farms";
		$data['data']['center']['list']['FARMER_TYPES'] = $FARMER_TYPES;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	// Create the form page to add a farm to the database, does not actually add the data, only builds the form
	function add() {
		global $FARMER_TYPES, $STATUS;
		$data = array();
		
		$this->load->model('StateModel');
		$states = $this->StateModel->listState();
		
		$this->load->model('CountryModel');
		$countries = $this->CountryModel->listCountry();
		
		$this->load->model('FarmTypeModel');
		$farmTypes = $this->FarmTypeModel->listFarmType('');
		
		// List of views to be included
		$data['CENTER'] = array(
				'form' => 'admincp/farm_form',
			);
		
		// Data to be passed to the views
		$data['data']['center']['form']['VIEW_HEADER'] = "Add Farm";
		$data['data']['center']['form']['COUNTRIES'] = $countries;
		$data['data']['center']['form']['STATES'] = $states;
		$data['data']['center']['form']['FARM_TYPES'] = $farmTypes;
		$data['data']['center']['form']['FARMER_TYPES'] = $FARMER_TYPES;
		$data['data']['center']['form']['STATUS'] = $STATUS;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function update($id) {
		global $FARMER_TYPES, $STATUS;
		$data = array();
		
		$this->load->model('FarmModel');
		$farm = $this->FarmModel->getFarmFromId($id);
		
		$this->load->model('FarmTypeModel');
		$farmTypes = $this->FarmTypeModel->listFarmType('');
		
		
		// List of views to be included
		$data['LEFT'] = array(
				'navigation' => 'admincp/includes/left/nav_farm',
			);
		
		// List of views to be included
		$data['CENTER'] = array(
				'form' => 'admincp/farm_form',
			);
		
		// Data to be passed to the views
		$data['data']['left']['navigation']['VIEW_HEADER'] = "Options";
		$data['data']['left']['navigation']['FARM_ID'] = $id;
		
		$data['data']['center']['form']['VIEW_HEADER'] = "Update Farm";
		$data['data']['center']['form']['FARM_TYPES'] = $farmTypes;
		$data['data']['center']['form']['FARM'] = $farm;
		$data['data']['center']['form']['FARMER_TYPES'] = $FARMER_TYPES;
		$data['data']['center']['form']['STATUS'] = $STATUS;
		
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
		
		$this->load->model('SupplierModel','',true);
		$suppliers = $this->SupplierModel->getSupplierForCompany( '', $id, '', '', '', '' );
		
		// List of views to be included
		$data['LEFT'] = array(
				'navigation' => 'admincp/includes/left/nav_farm',
			);
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/supplier_form',
			);
		
		// Data to be passed to the views
		$data['data']['left']['navigation']['VIEW_HEADER'] = "Options";
		$data['data']['left']['navigation']['FARM_ID'] = $id;
		
		$data['data']['center']['list']['VIEW_HEADER'] = prepareHeading($farm->farmName, '', 'supplier', 'add');
		$data['data']['center']['list']['FARM'] = $farm;
		$data['data']['center']['list']['SUPPLIER_TYPES_2'] = $SUPPLIER_TYPES_2;
		$data['data']['center']['list']['TABLE'] = 'farm_supplier';
		$data['data']['center']['list']['SUPPLIERS'] = $suppliers;
		
		$data['BREADCRUMB'] = array(
				'Farms' => '/admincp/farm',
				$farm->farmName => '/admincp/farm/update/' . $farm->farmId,
				'Add Supplier' => '/admincp/farm/add_supplier/' . $farm->farmId,
			);
			
		$this->load->view('admincp/templates/left_center_template', $data);
	}
	
	function update_supplier($id)
	{
		global $SUPPLIER_TYPES_2;
		$data = array();
		
		$this->load->model('SupplierModel');
		$supplier = $this->SupplierModel->getSupplierFromId($id, 'farm');
		
		$suppliers = $this->SupplierModel->getSupplierForCompany( '', $supplier->farmId, '', '', '', '');
		
		$this->load->model('FarmModel');
		$farm = $this->FarmModel->getFarmFromId($supplier->farmId);
		
		// List of views to be included
		$data['LEFT'] = array(
				'navigation' => 'admincp/includes/left/nav_farm',
			);
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/supplier_form',
			);
		
		// Data to be passed to the views
		$data['data']['left']['navigation']['VIEW_HEADER'] = "Options";
		$data['data']['left']['navigation']['FARM_ID'] = $supplier->farmId;
		$data['data']['left']['navigation']['SUPPLIER_ID'] = $supplier->supplierId;
		
		$data['data']['center']['list']['VIEW_HEADER'] = prepareHeading($farm->farmName, $id, 'supplier', 'update');
		$data['data']['center']['list']['SUPPLIER'] = $supplier;
		$data['data']['center']['list']['SUPPLIER_TYPES_2'] = $SUPPLIER_TYPES_2;
		$data['data']['center']['list']['TABLE'] = 'farm_supplier';
		$data['data']['center']['list']['SUPPLIERS'] = $suppliers;
		
		$data['BREADCRUMB'] = array(
				'Farms' => '/admincp/farm',
				$farm->farmName => '/admincp/farm/update/' . $supplier->farmId,
				'Supplier #' . $supplier->supplierId => '/admincp/farm/update_supplier/' . $supplier->supplierId,
			);
			
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
		
		$this->load->model('AddressModel','',true);
		$addresses = $this->AddressModel->getAddressForCompany( '', $id, '', '', '', '', '');
		
		// List of views to be included
		$data['LEFT'] = array(
				'navigation' => 'admincp/includes/left/nav_farm',
			);
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/address_form',
			);
		
		// Data to be passed to the views
		$data['data']['left']['navigation']['VIEW_HEADER'] = "Options";
		$data['data']['left']['navigation']['FARM_ID'] = $id;
		
		$data['data']['center']['list']['VIEW_HEADER'] = prepareHeading($farm->farmName, '', 'address', 'add');
		$data['data']['center']['list']['STATES'] = $states;
		$data['data']['center']['list']['COUNTRIES'] = $countries;
		$data['data']['center']['list']['ADDRESSES'] = $addresses;
		
		$data['BREADCRUMB'] = array(
				'Farms' => '/admincp/farm',
				$farm->farmName => '/admincp/farm/update/' . $farm->farmId,
				'Add Address' => '/admincp/farm/add_address/' . $farm->farmId,
			);
		
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
		
		$addresses = $this->AddressModel->getAddressForCompany( '', $address->farmId, '', '', '', '', '');
		
		$this->load->model('FarmModel');
		$farm = $this->FarmModel->getFarmFromId($address->farmId);
		 
		// List of views to be included
		$data['LEFT'] = array(
				'navigation' => 'admincp/includes/left/nav_farm',
			);
		
		// List of views to be included
		$data['CENTER'] = array(
				'form' => 'admincp/address_form',
			);
		
		// Data to be passed to the views
		$data['data']['left']['navigation']['VIEW_HEADER'] = "Options";
		$data['data']['left']['navigation']['FARM_ID'] = $address->farmId;
		$data['data']['left']['navigation']['ADDRESS_ID'] = $address->addressId;
		
		$data['data']['center']['form']['VIEW_HEADER'] = prepareHeading($farm->farmName, $id, 'address', 'update');
		$data['data']['center']['form']['STATES'] = $states;
		$data['data']['center']['form']['COUNTRIES'] = $countries;
		$data['data']['center']['form']['ADDRESS'] = $address;
		$data['data']['center']['form']['FARM_ID'] = $address->farmId;
		$data['data']['center']['form']['ADDRESSES'] = $addresses;
		
		$data['BREADCRUMB'] = array(
				'Farms' => '/admincp/farm',
				$farm->farmName => '/admincp/farm/update/' . $address->farmId,
				'Address #' . $address->addressId => '/admincp/farm/update_address/' . $address->addressId,
			);
		
		$this->load->view('admincp/templates/left_center_template', $data);
		
	}
	
	function ajaxSearchFarms() {
		$this->load->model('FarmModel', '', TRUE);
		$restaurants = $this->FarmModel->getFarmsJsonAdmin();
		echo json_encode($restaurants);
	}
}

/* End of file company.php */

?>