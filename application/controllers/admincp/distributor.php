<?php

class Distributor extends Controller {
	
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
		$distributors = array();
		
		$this->load->model('DistributorModel');
		$distributors = $this->DistributorModel->listDistributor();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/distributor',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Distributors";
		$data['data']['center']['list']['DISTRIBUTORS'] = $distributors;
		
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
		
		// List of views to be included
		$data['CENTER'] = array(
				'form' => 'admincp/distributor_form',
			);
		
		// Data to be passed to the views
		$data['data']['center']['form']['VIEW_HEADER'] = "Add Distributor";
		$data['data']['center']['form']['COUNTRIES'] = $countries;
		$data['data']['center']['form']['STATES'] = $states;
		$data['data']['center']['form']['COMPANIES'] = $companies;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	// Update a record using an id
	function update($id)
	{
		$data = array();
		
		$this->load->model('CompanyModel');
		$companies = $this->CompanyModel->listCompany();

		$this->load->model('DistributorModel');
		$distributor = $this->DistributorModel->getDistributorFromId($id);
		
		// List of views to be included
		$data['LEFT'] = array(
				'nav' => 'admincp/includes/left/nav_distributor',
			);
		
		// List of views to be included
		$data['CENTER'] = array(
				'form' => 'admincp/distributor_form',
			);
		
		// Data to be passed to the views
		$data['data']['left']['nav']['DISTRIBUTOR_ID'] = $id;
		
		$data['data']['center']['form']['VIEW_HEADER'] = "Update Distributor";
		$data['data']['center']['form']['DISTRIBUTOR'] = $distributor;
		$data['data']['center']['form']['COMPANIES'] = $companies;
		
		$this->load->view('admincp/templates/left_center_template', $data);
	}
	
	// Pass the form data to the model to be inserted into the database
	function save_add() {
		
		$this->load->model('DistributorModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->DistributorModel->addDistributor() ) {
			
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
		
		$this->load->model('DistributorModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->DistributorModel->updateDistributor() ) {
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
		global $SUPPLIER_TYPES;
		$data = array();
		
		$this->load->model('DistributorModel');
		$distributor = $this->DistributorModel->getDistributorFromId($id);
		
		// List of views to be included
		$data['LEFT'] = array(
				'nav' => 'admincp/includes/left/nav_distributor',
			);
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/supplier_form',
			);
		
		// Data to be passed to the views
		$data['data']['left']['nav']['DISTRIBUTOR_ID'] = $id;
		
		$data['data']['center']['list']['VIEW_HEADER'] = "Add Supplier - " . $distributor->distributorName;
		$data['data']['center']['list']['DISTRIBUTOR'] = $distributor;
		$data['data']['center']['list']['SUPPLIER_TYPES'] = $SUPPLIER_TYPES;
		
		$this->load->view('admincp/templates/left_center_template', $data);
	}
	
	function update_supplier($id)
	{
		global $SUPPLIER_TYPES;
		$data = array();
		
		$this->load->model('SupplierModel');
		$supplier = $this->SupplierModel->getSupplierFromId($id, 'distributor');
		
		// List of views to be included
		$data['LEFT'] = array(
				'nav' => 'admincp/includes/left/nav_distributor',
			);
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/supplier_form',
			);
		
		// Data to be passed to the views
		$data['data']['left']['nav']['DISTRIBUTOR_ID'] = $supplier->distributorId;
		
		$data['data']['center']['list']['VIEW_HEADER'] = "Update Supplier - " . $id;
		$data['data']['center']['list']['SUPPLIER'] = $supplier;
		$data['data']['center']['list']['SUPPLIER_TYPES'] = $SUPPLIER_TYPES;
		
		$this->load->view('admincp/templates/left_center_template', $data);
	}
	
	
	function supplier_save_add() {
		
		$this->load->model('SupplierModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->SupplierModel->addSupplierIntermediate() ) {
			echo 'yes';
		} else {
			if (isset($GLOBALS['error']) && !empty($GLOBALS['error']) ) {
				echo $GLOBALS['error'];
			} else {
				echo 'no';
			}
		}
		
	}
	
	function supplier_save_update() {
		
		$this->load->model('SupplierModel', '', TRUE);
		
		
		$GLOBALS = array();
		if ( $this->SupplierModel->updateSupplierIntermediate() ) {
			echo 'yes';
		} else {
			if (isset($GLOBALS['error']) && !empty($GLOBALS['error']) ) {
				echo $GLOBALS['error'];
			} else {
				echo 'no';
			}
		}
		
	}
	
	function add_address($id)
	{
		$data = array();
		
		$this->load->model('StateModel');
		$states = $this->StateModel->listState();
		
		$this->load->model('CountryModel');
		$countries = $this->CountryModel->listCountry();
		
		$this->load->model('DistributorModel');
		$distributor = $this->DistributorModel->getDistributorFromId($id);
		
		// List of views to be included
		$data['LEFT'] = array(
				'nav' => 'admincp/includes/left/nav_distributor',
			);
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/address_form',
			);
		
		// Data to be passed to the views
		$data['data']['left']['nav']['DISTRIBUTOR_ID'] = $id;
		
		$data['data']['center']['list']['VIEW_HEADER'] = "Add Address - " . $distributor->distributorName;
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
				'nav' => 'admincp/includes/left/nav_distributor',
			);
		
		// List of views to be included
		$data['CENTER'] = array(
				'from' => 'admincp/address_form',
			);
		
		// Data to be passed to the views
		$data['data']['left']['nav']['DISTRIBUTOR_ID'] = $address->distributorId;
		$data['data']['left']['nav']['ADDRESS_ID'] = $address->addressId;
		
		$data['data']['center']['from']['VIEW_HEADER'] = "Update Address - #" . $id;
		$data['data']['center']['from']['STATES'] = $states;
		$data['data']['center']['from']['COUNTRIES'] = $countries;
		$data['data']['center']['from']['ADDRESS'] = $address;
		$data['data']['center']['from']['DISTRIBUTOR_ID'] = $address->distributorId;
		
		$this->load->view('admincp/templates/left_center_template', $data);
		
	}
	
	function address_save_add() {
		
		$this->load->model('AddressModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->AddressModel->addAddressIntermediate() ) {
			echo 'yes';
		} else {
			if (isset($GLOBALS['error']) && !empty($GLOBALS['error']) ) {
				echo $GLOBALS['error'];
			} else {
				echo 'no';
			}
		}
	
	}
	
	function address_save_update() {
		
		$this->load->model('AddressModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->AddressModel->updateAddress() ) {
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

/* End of file company.php */

?>