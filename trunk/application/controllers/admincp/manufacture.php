<?php

class Manufacture extends Controller {
	
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
				'list' => 'admincp/manufacture',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Manufactures";
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	// Create the form page to add a manufacture to the database, does not actually add the data, only builds the form
	function add() {
		global $STATUS;
		
		$data = array();
		
		$this->load->model('StateModel');
		$states = $this->StateModel->listState();
		
		$this->load->model('CountryModel');
		$countries = $this->CountryModel->listCountry();
		
		$this->load->model('ProducerCategoryModel');
		$manufactureTypes = $this->ProducerCategoryModel->listProducerCategory('MANUFACTURE', '');
		
		// List of views to be included
		$data['CENTER'] = array(
				'form' => 'admincp/forms/manufacture_form',
			);
		
		// Data to be passed to the views
		$data['data']['center']['form']['VIEW_HEADER'] = "Add Manufacture";
		$data['data']['center']['form']['COUNTRIES'] = $countries;
		$data['data']['center']['form']['STATES'] = $states;
		$data['data']['center']['form']['MANUFACTURE_TYPES'] = $manufactureTypes;
		$data['data']['center']['form']['STATUS'] = $STATUS;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	// Update a record using an id
	function update($id) {
		global $STATUS;
		
		$data = array();
		
		$this->load->model('ManufactureModel');
		$manufacture = $this->ManufactureModel->getManufactureFromId($id);

		$this->load->model('ProducerCategoryModel');
		$manufactureTypes = $this->ProducerCategoryModel->listProducerCategory('MANUFACTURE', '');
		
		// List of views to be included
		$data['LEFT'] = array(
				'navigation' => 'admincp/includes/left/nav_manufacture',
			);
		
		// List of views to be included
		$data['CENTER'] = array(
				'form' => 'admincp/forms/manufacture_form',
			);
		
		// Data to be passed to the views
		$data['data']['left']['navigation']['VIEW_HEADER'] = "Options";
		$data['data']['left']['navigation']['MANUFACTURE_ID'] = $id;
		$data['data']['left']['navigation']['TRID'] = $id;
		
		$data['data']['center']['form']['VIEW_HEADER'] = "Update Manufacture";
		$data['data']['center']['form']['MANUFACTURE_TYPES'] = $manufactureTypes;
		$data['data']['center']['form']['MANUFACTURE'] = $manufacture;
		$data['data']['center']['form']['STATUS'] = $STATUS;
		
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
		global $SUPPLIER_TYPES_2;
		$data = array();
		
		$this->load->model('ManufactureModel');
		$manufacture = $this->ManufactureModel->getManufactureFromId($id);
		
		$this->load->model('SupplierModel','',true);
		$suppliers = $this->SupplierModel->getSupplierForCompany( '', '', $id, '', '', '' );
		
		// List of views to be included
		$data['LEFT'] = array(
				'navigation' => 'admincp/includes/left/nav_manufacture',
			);
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/forms/supplier_form',
			);
		
		// Data to be passed to the views
		$data['data']['left']['navigation']['VIEW_HEADER'] = "Options";
		$data['data']['left']['navigation']['MANUFACTURE_ID'] = $id;
		$data['data']['left']['navigation']['TRID'] = $id;

		$data['data']['center']['list']['VIEW_HEADER'] = prepareHeading($manufacture->manufactureName, '', 'supplier', 'add');
		$data['data']['center']['list']['MANUFACTURE'] = $manufacture;
		$data['data']['center']['list']['SUPPLIER_TYPES_2'] = $SUPPLIER_TYPES_2;
		$data['data']['center']['list']['TABLE'] = 'manufacture_supplier';
		$data['data']['center']['list']['SUPPLIERS'] = $suppliers;
		
		$data['BREADCRUMB'] = array(
				'Manufacture' => '/admincp/manufacture',
				$manufacture->manufactureName => '/admincp/manufacture/update/' . $manufacture->manufactureId,
				'Add Supplier' => '/admincp/manufacture/add_supplier/' . $manufacture->manufactureId,
			);
			
		$this->load->view('admincp/templates/left_center_template', $data);
	}
	
	function update_supplier($id, $trid)
	{
		global $SUPPLIER_TYPES_2;
		$data = array();
		
		$this->load->model('SupplierModel');
		$supplier = $this->SupplierModel->getSupplierFromId($id, 'manufacture');
		
		$suppliers = $this->SupplierModel->getSupplierForCompany( '', '', $trid, '', '', '');

	
		$this->load->model('ManufactureModel');
		$manufacture = $this->ManufactureModel->getManufactureFromId($supplier->supplierId);
		
		// List of views to be included
		$data['LEFT'] = array(
				'navigation' => 'admincp/includes/left/nav_manufacture',
			);
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/forms/supplier_form',
			);
		
		// Data to be passed to the views
		$data['data']['left']['navigation']['VIEW_HEADER'] = "Options";
		$data['data']['left']['navigation']['MANUFACTURE_ID'] = $supplier->supplierId;
		$data['data']['left']['navigation']['SUPPLIER_ID'] = $supplier->supplierId;
		$data['data']['left']['navigation']['TRID'] = $trid;

		$data['data']['center']['list']['VIEW_HEADER'] = prepareHeading($manufacture->manufactureName, $id, 'supplier', 'update');
		$data['data']['center']['list']['SUPPLIER'] = $supplier;
		$data['data']['center']['list']['SUPPLIER_TYPES_2'] = $SUPPLIER_TYPES_2;
		$data['data']['center']['list']['TABLE'] = 'manufacture_supplier';
		$data['data']['center']['list']['SUPPLIERS'] = $suppliers;
		
		$data['BREADCRUMB'] = array(
				'Manufacture' => '/admincp/manufacture',
				$manufacture->manufactureName => '/admincp/manufacture/add_supplier/' .$trid,
				'Supplier #' . $supplier->supplierId => '/admincp/manufacture/update_supplier/' . $supplier->supplierId.'/'.$trid
			);
		
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
		
		$this->load->model('ManufactureModel');
		$manufacture = $this->ManufactureModel->getManufactureFromId($id);
		
		$this->load->model('AddressModel','',true);
		$addresses = $this->AddressModel->getAddressForCompany( '', '', $id, '', '', '', '', '');
		
		// List of views to be included
		$data['LEFT'] = array(
				'navigation' => 'admincp/includes/left/nav_manufacture',
			);
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/forms/address_form',
			);
		
		// Data to be passed to the views
		$data['data']['left']['navigation']['VIEW_HEADER'] = "Options";
		$data['data']['left']['navigation']['MANUFACTURE_ID'] = $id;
		$data['data']['left']['navigation']['TRID'] = $id;
		
		$data['data']['center']['list']['VIEW_HEADER'] = prepareHeading($manufacture->manufactureName, '', 'address', 'add');
		$data['data']['center']['list']['STATES'] = $states;
		$data['data']['center']['list']['COUNTRIES'] = $countries;
		$data['data']['center']['list']['ADDRESSES'] = $addresses;
		
		$data['BREADCRUMB'] = array(
				'Manufacture' => '/admincp/manufacture',
				$manufacture->manufactureName => '/admincp/manufacture/update/' . $manufacture->manufactureId,
				'Add Address' => '/admincp/manufacture/add_address/' . $manufacture->manufactureId,
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
		
		$addresses = $this->AddressModel->getAddressForCompany( '', '', $address->producerId, '', '', '', '', '');
		
		$this->load->model('ManufactureModel');
		$manufacture = $this->ManufactureModel->getManufactureFromId($address->producerId);
		
		// List of views to be included
		$data['LEFT'] = array(
				'navigation' => 'admincp/includes/left/nav_manufacture',
			);
		
		// List of views to be included
		$data['CENTER'] = array(
				'form' => 'admincp/forms/address_form',
			);
		
		// Data to be passed to the views
		$data['data']['left']['navigation']['VIEW_HEADER'] = "Options";
		$data['data']['left']['navigation']['MANUFACTURE_ID'] = $address->producerId;
		$data['data']['left']['navigation']['TRID'] = $address->producerId;
		
		$data['data']['center']['form']['VIEW_HEADER'] = prepareHeading($manufacture->manufactureName, $id, 'address', 'update');
		$data['data']['center']['form']['STATES'] = $states;
		$data['data']['center']['form']['COUNTRIES'] = $countries;
		$data['data']['center']['form']['ADDRESS'] = $address;
		$data['data']['center']['form']['MANUFACTURE_ID'] = $address->producerId;
		$data['data']['center']['form']['ADDRESSES'] = $addresses;
		
		$data['BREADCRUMB'] = array(
				'Manufacture' => '/admincp/manufacture',
				$manufacture->manufactureName => '/admincp/manufacture/update/' . $address->producerId,
				'Address #' . $address->addressId => '/admincp/manufacture/update_address/' . $address->addressId,
			);
		
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
	
	function add_menu_item($id){
		$data = array();
		
		$this->load->model('ProductTypeModel');
		$productTypes = $this->ProductTypeModel->listProductType();

		$this->load->model('ProductModel','',true);
		$products = $this->ProductModel->getProductForCompany('', '', $id, '');
		
		$this->load->model('ManufactureModel');
		$manufacture = $this->ManufactureModel->getManufactureFromId($id);
		
		// List of views to be included
		$data['CENTER'] = array(
				'form' => 'admincp/forms/menu_form',
			);
		
		$data['LEFT'] = array(
				'navigation' => 'admincp/includes/left/nav_manufacture',
			);
			
		// Data to be passed to the views
		$data['data']['center']['form']['VIEW_HEADER'] = prepareHeading($manufacture->manufactureName, '', 'menu item', 'add');
		$data['data']['center']['form']['PRODUCT_TYPES'] = $productTypes;
		$data['data']['center']['form']['PRODUCTS'] = $products;
		
		$data['data']['left']['navigation']['VIEW_HEADER'] = "Options";
		$data['data']['left']['navigation']['MANUFACTURE_ID'] = $id;
		$data['data']['left']['navigation']['TRID'] = $id;
		
		$data['BREADCRUMB'] = array(
				'Manufacture' => '/admincp/manufacture',
				$manufacture->manufactureName => '/admincp/manufacture/update/' . $manufacture->manufactureId,
				'Add Product' => '/admincp/manufacture/add_menu_item/' . $manufacture->manufactureId,
			);
		
		$this->load->view('admincp/templates/left_center_template', $data);
	}
	
	
	function update_menu_item($id, $trid) {

		$data = array();
		
		$this->load->model('ProductTypeModel');
		$productTypes = $this->ProductTypeModel->listProductType();
		
		$this->load->model('ProductModel');
		$product = $this->ProductModel->getProductFromId($id);

		$products = $this->ProductModel->getProductForCompany('', '', $trid, '');

		$this->load->model('ManufactureModel');
		$manufacture = $this->ManufactureModel->getManufactureFromId($trid);
		
		// List of views to be included
		$data['LEFT'] = array(
				'navigation' => 'admincp/includes/left/nav_manufacture',
			);
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/forms/menu_form',
			);

		// Data to be passed to the views
		$data['data']['left']['navigation']['VIEW_HEADER'] = "Options";
		$data['data']['left']['navigation']['MANUFACTURE_ID'] = $trid;
		$data['data']['left']['navigation']['TRID'] = $trid;
		
		$data['data']['center']['list']['VIEW_HEADER'] = prepareHeading($product->productName, $id, 'menu item', 'update');
		$data['data']['center']['list']['PRODUCT_TYPES'] = $productTypes;
		$data['data']['center']['list']['PRODUCT'] = $product;
		$data['data']['center']['list']['PRODUCTS'] = $products;
		
		$data['BREADCRUMB'] = array(
				'Manufacture' => '/admincp/manufacture',
				$manufacture->manufactureName => '/admincp/manufacture/add_menu_item/' . $trid,
				'Product #' . $product->productId => '/admincp/manufacture/update_menu_item/' . $product->productId.'/'. $trid
			);
		
		$this->load->view('admincp/templates/left_center_template', $data);
	}
	
	function ajaxSearchManufactures() {
		$this->load->model('ManufactureModel', '', TRUE);
		$manufactures = $this->ManufactureModel->getManufactureJsonAdmin();
		echo json_encode($manufactures);
	}
}

/* End of file company.php */

?>