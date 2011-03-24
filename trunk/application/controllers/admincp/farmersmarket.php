<?php

class FarmersMarket extends Controller {
	
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
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/farmers_market',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Farmers Market";
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	// Create the form page to add a farm to the database, does not actually add the data, only builds the form
	function add() {
		global $STATUS;
		$data = array();
		
		$this->load->model('StateModel');
		$states = $this->StateModel->listState();
		
		$this->load->model('CountryModel');
		$countries = $this->CountryModel->listCountry();
		
		// List of views to be included
		$data['CENTER'] = array(
				'form' => 'admincp/farmers_market_form',
			);
		
		// Data to be passed to the views
		$data['data']['center']['form']['VIEW_HEADER'] = "Add Farmers Market";
		$data['data']['center']['form']['COUNTRIES'] = $countries;
		$data['data']['center']['form']['STATES'] = $states;
		$data['data']['center']['form']['STATUS'] = $STATUS;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function update($id) {
		global $STATUS;
		$data = array();
		
		$this->load->model('FarmersMarketModel');
		$farmersMarket = $this->FarmersMarketModel->getFarmersMarketFromId($id);
		
		// List of views to be included
		$data['LEFT'] = array(
				'navigation' => 'admincp/includes/left/nav_farmers_market',
			);
		
		// List of views to be included
		$data['CENTER'] = array(
				'form' => 'admincp/farmers_market_form',
			);
		
		// Data to be passed to the views
		$data['data']['left']['navigation']['VIEW_HEADER'] = "Options";
		$data['data']['left']['navigation']['FARMERS_MARKET_ID'] = $id;
		$data['data']['left']['navigation']['TRID'] = $id;
		
		$data['data']['center']['form']['VIEW_HEADER'] = "Update Farmers Market";
		$data['data']['center']['form']['FARMERS_MARKET'] = $farmersMarket;
		$data['data']['center']['form']['STATUS'] = $STATUS;
		
		$this->load->view('admincp/templates/left_center_template', $data);
		
	}
	
	// Pass the form data to the model to be inserted into the database
	function save_add() {
		
		$this->load->model('FarmersMarketModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->FarmersMarketModel->addFarmersMarket() ) {
			
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
		
		$this->load->model('FarmersMarketModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->FarmersMarketModel->updateFarmersMarket() ) {
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
		
		$this->load->model('FarmersMarketModel');
		$farmersMarket = $this->FarmersMarketModel->getFarmersMarketFromId($id);
		
		$this->load->model('SupplierModel','',true);
		$suppliers = $this->SupplierModel->getSupplierForCompany( '', '', '', '', '', $id );
		
		// List of views to be included
		$data['LEFT'] = array(
				'navigation' => 'admincp/includes/left/nav_farmers_market',
			);
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/supplier_form',
			);
		
		// Data to be passed to the views
		$data['data']['left']['navigation']['VIEW_HEADER'] = "Options";
		$data['data']['left']['navigation']['FARMERS_MARKET_ID'] = $id;
		$data['data']['left']['navigation']['TRID'] = $id;
		
		$data['data']['center']['list']['VIEW_HEADER'] = prepareHeading($farmersMarket->farmersMarketName, '', 'supplier', 'add');
		$data['data']['center']['list']['FARMERS_MARKET'] = $farmersMarket;
		$data['data']['center']['list']['SUPPLIER_TYPES_2'] = $SUPPLIER_TYPES_2;
		$data['data']['center']['list']['TABLE'] = 'farmers_market_supplier';
		$data['data']['center']['list']['SUPPLIERS'] = $suppliers;
		
		$data['BREADCRUMB'] = array(
				'Farmers Market' => '/admincp/farmersmarket',
				$farmersMarket->farmersMarketName => '/admincp/farmersmarket/update/' . $farmersMarket->farmersMarketId,
				'Add Supplier' => '/admincp/farmersmarket/add_supplier/' . $farmersMarket->farmersMarketId,
			);
			
		$this->load->view('admincp/templates/left_center_template', $data);
	}
	
	function update_supplier($id, $trid)
	{
		global $SUPPLIER_TYPES_2;
		$data = array();
		
		$this->load->model('SupplierModel');
		$supplier = $this->SupplierModel->getSupplierFromId($id, 'farmers_market');
		
		$suppliers = $this->SupplierModel->getSupplierForCompany( '', '', '', '', '', $trid );
	
		$this->load->model('FarmersMarketModel');
		$farmersMarket = $this->FarmersMarketModel->getFarmersMarketFromId($trid);
		
		
		// List of views to be included
		$data['LEFT'] = array(
				'navigation' => 'admincp/includes/left/nav_farmers_market',
			);
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/supplier_form',
			);
		
		// Data to be passed to the views
		$data['data']['left']['navigation']['VIEW_HEADER'] = "Options";
		$data['data']['left']['navigation']['FARMERS_MARKET_ID'] = $supplier->supplierId;
		$data['data']['left']['navigation']['SUPPLIER_ID'] = $supplier->supplierId;
		$data['data']['left']['navigation']['TRID'] = $trid;
		
		$data['data']['center']['list']['VIEW_HEADER'] = prepareHeading($farmersMarket->farmersMarketName, $id, 'supplier', 'update');
		$data['data']['center']['list']['SUPPLIER'] = $supplier;
		$data['data']['center']['list']['SUPPLIER_TYPES_2'] = $SUPPLIER_TYPES_2;
		$data['data']['center']['list']['TABLE'] = 'farmers_market_supplier';
		$data['data']['center']['list']['SUPPLIERS'] = $suppliers;
		
		$data['BREADCRUMB'] = array(
				'Farmers Market' => '/admincp/farmersmarket',
				$farmersMarket->farmersMarketName => '/admincp/farmersmarket/add_supplier/' . $trid,
				'Supplier #' . $supplier->supplierId => '/admincp/farmersmarket/update_supplier/' . $supplier->supplierId.'/'.$trid
			);
			
		$this->load->view('admincp/templates/left_center_template', $data);
	}
	
	function add_address($id) {
		$data = array();
		
		$this->load->model('StateModel');
		$states = $this->StateModel->listState();
		
		$this->load->model('CountryModel');
		$countries = $this->CountryModel->listCountry();
		
		$this->load->model('FarmersMarketModel');
		$farmersMarket = $this->FarmersMarketModel->getFarmersMarketFromId($id);
		
		$this->load->model('AddressModel','',true);
		$addresses = $this->AddressModel->getAddressForCompany( '', '', '', '', $id, '', '', '');
		
		// List of views to be included
		$data['LEFT'] = array(
				'navigation' => 'admincp/includes/left/nav_farmers_market',
			);
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/address_form',
			);
		
		// Data to be passed to the views
		$data['data']['left']['navigation']['VIEW_HEADER'] = "Options";
		$data['data']['left']['navigation']['FARMERS_MARKET_ID'] = $id;
		$data['data']['left']['navigation']['TRID'] = $id;
		
		$data['data']['center']['list']['VIEW_HEADER'] = prepareHeading($farmersMarket->farmersMarketName, '', 'address', 'add');
		$data['data']['center']['list']['STATES'] = $states;
		$data['data']['center']['list']['COUNTRIES'] = $countries;
		$data['data']['center']['list']['ADDRESSES'] = $addresses;
		
		$data['BREADCRUMB'] = array(
				'Farmers Market' => '/admincp/farmersmarket',
				$farmersMarket->farmersMarketName => '/admincp/farmersmarket/update/' . $farmersMarket->farmersMarketId,
				'Add Address' => '/admincp/farmersmarket/add_address/' . $farmersMarket->farmersMarketId,
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

		$addresses = $this->AddressModel->getAddressForCompany( '', '', '', '', $address->producerId, '', '', '');
		
		$this->load->model('FarmersMarketModel');
		$farmersMarket = $this->FarmersMarketModel->getFarmersMarketFromId($address->producerId);
		
		// List of views to be included
		$data['LEFT'] = array(
				'navigation' => 'admincp/includes/left/nav_farmers_market',
			);
		
		// List of views to be included
		$data['CENTER'] = array(
				'form' => 'admincp/address_form',
			);
		
		// Data to be passed to the views
		$data['data']['left']['navigation']['VIEW_HEADER'] = "Options";
		$data['data']['left']['navigation']['FARMERS_MARKET_ID'] = $address->producerId;
		$data['data']['left']['navigation']['ADDRESS_ID'] = $address->addressId;
		$data['data']['left']['navigation']['TRID'] = $address->producerId;
		
		$data['data']['center']['form']['VIEW_HEADER'] = prepareHeading($farmersMarket->farmersMarketName, $id, 'address', 'update');
		$data['data']['center']['form']['STATES'] = $states;
		$data['data']['center']['form']['COUNTRIES'] = $countries;
		$data['data']['center']['form']['ADDRESS'] = $address;
		$data['data']['center']['form']['FARMERS_MARKET_ID'] = $address->producerId;
		$data['data']['center']['form']['ADDRESSES'] = $addresses;
		
		$data['BREADCRUMB'] = array(
				'Farmers Market' => '/admincp/farmersmarket',
				$farmersMarket->farmersMarketName => '/admincp/farmersmarket/update/' . $address->producerId,
				'Address #' . $address->addressId => '/admincp/farmersmarket/update_address/' . $address->addressId,
			);
		
		$this->load->view('admincp/templates/left_center_template', $data);
		
	}
	
	function ajaxSearchFarmersMarket() {
		$this->load->model('FarmersMarketModel', '', TRUE);
		$markets = $this->FarmersMarketModel->getFarmersMarketsJsonAdmin();
		echo json_encode($markets);
	}
}

/* End of file company.php */

?>