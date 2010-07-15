<?php

class Distributor extends Controller {
	
	function __construct()
	{
		parent::Controller();
		if ($this->session->userdata('isAuthenticated') != 1 || $this->session->userdata('userGroup') != 'admin' )
		{
			redirect('admincp/login');
		}
	}
	
	function index()
	{
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/distributor',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Distributors";
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	// Create the form page to add a manufacture to the database, does not actually add the data, only builds the form
	function add()
	{
		$data = array();
		
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
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	// Update a record using an id
	function update($id)
	{
		$data = array();
		
		$this->load->model('DistributorModel');
		$distributor = $this->DistributorModel->getDistributorFromId($id);
		
		// List of views to be included
		$data['LEFT'] = array(
				'navigation' => 'admincp/includes/left/nav_distributor',
			);
		
		// List of views to be included
		$data['CENTER'] = array(
				'form' => 'admincp/distributor_form',
			);
		
		// Data to be passed to the views
		$data['data']['left']['navigation']['VIEW_HEADER'] = "Options";
		$data['data']['left']['navigation']['DISTRIBUTOR_ID'] = $id;
		
		$data['data']['center']['form']['VIEW_HEADER'] = "Update Distributor";
		$data['data']['center']['form']['DISTRIBUTOR'] = $distributor;
		
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
		global $SUPPLIER_TYPES_2;
		$data = array();
		
		$this->load->model('DistributorModel');
		$distributor = $this->DistributorModel->getDistributorFromId($id);
		
		$this->load->model('SupplierModel','',true);
		$suppliers = $this->SupplierModel->getSupplierForCompany( '', '', '', $id, '' );
		
		// List of views to be included
		$data['LEFT'] = array(
				'navigation' => 'admincp/includes/left/nav_distributor',
			);
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/supplier_form',
			);
		
		// Data to be passed to the views
		$data['data']['left']['navigation']['VIEW_HEADER'] = "Options";
		$data['data']['left']['navigation']['DISTRIBUTOR_ID'] = $id;
		
		$data['data']['center']['list']['VIEW_HEADER'] = "Add Supplier - " . $distributor->distributorName . ' (D)';
		$data['data']['center']['list']['DISTRIBUTOR'] = $distributor;
		$data['data']['center']['list']['SUPPLIER_TYPES_2'] = $SUPPLIER_TYPES_2;
		$data['data']['center']['list']['TABLE'] = 'distributor_supplier';
		$data['data']['center']['list']['SUPPLIERS'] = $suppliers;
		
		$this->load->view('admincp/templates/left_center_template', $data);
	}
	
	function update_supplier($id)
	{
		global $SUPPLIER_TYPES_2;
		$data = array();
		
		$this->load->model('SupplierModel');
		$supplier = $this->SupplierModel->getSupplierFromId($id, 'distributor');
		
		$suppliers = $this->SupplierModel->getSupplierForCompany( '', '', '', $supplier->distributorId, '');
		
		// List of views to be included
		$data['LEFT'] = array(
				'navigation' => 'admincp/includes/left/nav_distributor',
			);
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/supplier_form',
			);
		
		// Data to be passed to the views
		$data['data']['left']['navigation']['VIEW_HEADER'] = "Options";
		$data['data']['left']['navigation']['DISTRIBUTOR_ID'] = $supplier->distributorId;
		
		$data['data']['center']['list']['VIEW_HEADER'] = "Update Supplier - " . $id . ' (D)';
		$data['data']['center']['list']['SUPPLIER'] = $supplier;
		$data['data']['center']['list']['SUPPLIER_TYPES_2'] = $SUPPLIER_TYPES_2;
		$data['data']['center']['list']['TABLE'] = 'distributor_supplier';
		$data['data']['center']['list']['SUPPLIERS'] = $suppliers;
		
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
		
		$this->load->model('AddressModel','',true);
		$addresses = $this->AddressModel->getAddressForCompany( '', '', '', $id, '', '');
		
		// List of views to be included
		$data['LEFT'] = array(
				'navigation' => 'admincp/includes/left/nav_distributor',
			);
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/address_form',
			);
		
		// Data to be passed to the views
		$data['data']['left']['navigation']['VIEW_HEADER'] = "Options";
		$data['data']['left']['navigation']['DISTRIBUTOR_ID'] = $id;
		
		$data['data']['center']['list']['VIEW_HEADER'] = "Add Address - " . $distributor->distributorName . ' (D)';
		$data['data']['center']['list']['STATES'] = $states;
		$data['data']['center']['list']['COUNTRIES'] = $countries;
		$data['data']['center']['list']['ADDRESSES'] = $addresses;
		
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
		
		$addresses = $this->AddressModel->getAddressForCompany( '', '', '', $address->distributorId, '', '');
		
		// List of views to be included
		$data['LEFT'] = array(
				'navigation' => 'admincp/includes/left/nav_distributor',
			);
		
		// List of views to be included
		$data['CENTER'] = array(
				'form' => 'admincp/address_form',
			);
		
		// Data to be passed to the views
		$data['data']['left']['navigation']['VIEW_HEADER'] = "Options";
		$data['data']['left']['navigation']['DISTRIBUTOR_ID'] = $address->distributorId;
		
		$data['data']['center']['form']['VIEW_HEADER'] = "Update Address - #" . $id . ' (D)';
		$data['data']['center']['form']['STATES'] = $states;
		$data['data']['center']['form']['COUNTRIES'] = $countries;
		$data['data']['center']['form']['ADDRESS'] = $address;
		$data['data']['center']['form']['DISTRIBUTOR_ID'] = $address->distributorId;
		$data['data']['center']['form']['ADDRESSES'] = $addresses;
		
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
	
	function ajaxSearchDistributors() {
		$this->load->model('DistributorModel', '', TRUE);
		$distributors = $this->DistributorModel->getDistributorsJsonAdmin();
		echo json_encode($distributors);
	}
}

/* End of file company.php */

?>