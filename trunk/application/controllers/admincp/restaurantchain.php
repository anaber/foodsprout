<?php

class RestaurantChain extends Controller {
	
	function __construct()
	{
		global $ADMIN_LANDING_PAGE;
		parent::Controller();
		if ($this->session->userdata('isAuthenticated') != 1 || $this->session->userdata('userGroup') != 'admin' )
		{
			redirect($ADMIN_LANDING_PAGE);
		}
	}
	
	// Default is to list all the restaurants
	function index() {
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/restaurantchain',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Restaurant Chains";
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function ajaxSearchRestaurantChains() {
		$this->load->model('RestaurantChainModel', '', TRUE);
		$restaurants = $this->RestaurantChainModel->getRestaurantChainsJsonAdmin();
		echo json_encode($restaurants);
	}
	
	// This function will create the form to add a restaurant but does not save the data to the database
	function add() {
		global $STATUS;
		$data = array();
		
		$this->load->model('ProducerCategoryModel');
		$restaurantTypes = $this->ProducerCategoryModel->listProducerCategory('RESTAURANT', '');
		
		// List of views to be included
		$data['CENTER'] = array(
				'form' => 'admincp/restaurant_chain_form',
			);
		
		// Data to be passed to the views
		$data['data']['center']['form']['VIEW_HEADER'] = "Add Restaurant Chain";
		$data['data']['center']['form']['RESTAURANT_TYPES'] = $restaurantTypes;
		$data['data']['center']['form']['STATUS'] = $STATUS;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function update($id) {
		global $STATUS;
		
		$data = array();
		
		$this->load->model('RestaurantChainModel');
		$restaurant = $this->RestaurantChainModel->getRestaurantChainFromId($id);
		
		$this->load->model('ProducerCategoryModel');
		$restaurantTypes = $this->ProducerCategoryModel->listProducerCategory('RESTAURANT', '');
		
		// List of views to be included
		$data['CENTER'] = array(
				'form' => 'admincp/restaurant_chain_form',
			);
		
		$data['LEFT'] = array(
				'navigation' => 'admincp/includes/left/nav_restaurantchain',
			);
			
		// Data to be passed to the views
		$data['data']['center']['form']['VIEW_HEADER'] = "Update Restaurant Chain";
		$data['data']['center']['form']['RESTAURANT'] = $restaurant;
		$data['data']['center']['form']['RESTAURANT_TYPES'] = $restaurantTypes;
		$data['data']['center']['form']['STATUS'] = $STATUS;
		
		$data['data']['left']['navigation']['VIEW_HEADER'] = "Options";
		$data['data']['left']['navigation']['RESTAURANT_CHAIN_ID'] = $id;
		$data['data']['left']['navigation']['TRID'] = $id;
		
		$this->load->view('admincp/templates/left_center_template', $data);
	}
	
	// This function will save the new restaurant data into the database
	function save_add() {
		
		$this->load->model('RestaurantChainModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->RestaurantChainModel->addRestaurantChain() ) {
			echo 'yes';
		} else {
			if (isset($GLOBALS['error']) && !empty($GLOBALS['error']) ) {
				echo $GLOBALS['error'];
			} else {
				echo 'no';
			}
		}
	
	}
	
	// Send the updated information to the model to be updated in the database
	function save_update() {
		
		$this->load->model('RestaurantChainModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->RestaurantChainModel->updateRestaurantChain() ) {
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
		$products = $this->ProductModel->getProductForCompany('', $id, '', '');
		
		$this->load->model('RestaurantChainModel');
		$restaurantChain = $this->RestaurantChainModel->getRestaurantChainFromId($id);
		
		// List of views to be included
		$data['CENTER'] = array(
				'form' => 'admincp/menu_form',
			);
		
		$data['LEFT'] = array(
				'navigation' => 'admincp/includes/left/nav_restaurantchain',
			);
			
		// Data to be passed to the views
		$data['data']['center']['form']['VIEW_HEADER'] = prepareHeading($restaurantChain->restaurantChain, '', 'menu item', 'add');
		$data['data']['center']['form']['PRODUCT_TYPES'] = $productTypes;
		$data['data']['center']['form']['PRODUCTS'] = $products;
		
		$data['data']['left']['navigation']['VIEW_HEADER'] = "Options";
		$data['data']['left']['navigation']['RESTAURANT_CHAIN_ID'] = $id;
		$data['data']['left']['navigation']['TRID'] = $id;
		
		$data['BREADCRUMB'] = array(
				'Restaurant Chain' => '/admincp/restaurantchain',
				$restaurantChain->restaurantChain => '/admincp/restaurantchain/update/' . $restaurantChain->restaurantChainId,
				'Add Menu Item' => '/admincp/restaurantchain/add_menu_item/' . $restaurantChain->restaurantChainId,
			);
			
		$this->load->view('admincp/templates/left_center_template', $data);
	}
	
	function update_menu_item($id, $trid) {
		$data = array();
		
		$this->load->model('ProductTypeModel');
		$productTypes = $this->ProductTypeModel->listProductType();
		
		$this->load->model('ProductModel');
		$product = $this->ProductModel->getProductFromId($id);
		
		$products = $this->ProductModel->getProductForCompany('', $trid, '', '');

		$this->load->model('RestaurantChainModel');
		$restaurantChain = $this->RestaurantChainModel->getRestaurantChainFromId($trid);
		
		// List of views to be included
		$data['LEFT'] = array(
				'navigation' => 'admincp/includes/left/nav_restaurantchain',
			);
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/menu_form',
			);
		
		// Data to be passed to the views
		$data['data']['left']['navigation']['VIEW_HEADER'] = "Options";
		$data['data']['left']['navigation']['RESTAURANT_ID'] = $trid;
		$data['data']['left']['navigation']['TRID'] = $trid;
		
		$data['data']['center']['list']['VIEW_HEADER'] = prepareHeading($restaurantChain->restaurantChain, $id, 'menu item', 'update');
		$data['data']['center']['list']['PRODUCT_TYPES'] = $productTypes;
		$data['data']['center']['list']['PRODUCT'] = $product;
		$data['data']['center']['list']['PRODUCTS'] = $products;
		
		$data['BREADCRUMB'] = array(
				'Restaurant Chain' => '/admincp/restaurantchain',
				$restaurantChain->restaurantChain => '/admincp/restaurantchain/add_menu_item/' . $trid,
				'Menu Item #' . $product->productId => '/admincp/restaurantchain/update_menu_item/' . $product->productId.'/'. $trid
			);

		
		$this->load->view('admincp/templates/left_center_template', $data);
	}
	
	function menu_item_save_add() {
		
		$this->load->model('ProductModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->ProductModel->addProductIntermediate() ) {
			echo 'yes';
		} else {
			if (isset($GLOBALS['error']) && !empty($GLOBALS['error']) ) {
				echo $GLOBALS['error'];
			} else {
				echo 'no';
			}
		}
	
	}
	
	function menu_item_save_update() {
		
		$this->load->model('ProductModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->ProductModel->updateProduct() ) {
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
		
		$this->load->model('RestaurantChainModel');
		$restaurantChain = $this->RestaurantChainModel->getRestaurantChainFromId($id);
		
		$this->load->model('SupplierModel','',true);
		$suppliers = $this->SupplierModel->getSupplierForCompany( '', '', '', '', $id, '' );
		
		// List of views to be included
		$data['LEFT'] = array(
				'navigation' => 'admincp/includes/left/nav_restaurantchain',
			);
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/supplier_form',
			);
		
		// Data to be passed to the views
		$data['data']['left']['navigation']['VIEW_HEADER'] = "Options";
		$data['data']['left']['navigation']['RESTAURANT_CHAIN_ID'] = $id;
		$data['data']['left']['navigation']['TRID'] = $id;
		
		$data['data']['center']['list']['VIEW_HEADER'] = prepareHeading($restaurantChain->restaurantChain, '', 'supplier', 'add');
		$data['data']['center']['list']['RESTAURANT_CHAIN'] = $restaurantChain;
		$data['data']['center']['list']['SUPPLIER_TYPES_2'] = $SUPPLIER_TYPES_2;
		$data['data']['center']['list']['TABLE'] = 'restaurant_chain_supplier';
		$data['data']['center']['list']['SUPPLIERS'] = $suppliers;
		
		$data['BREADCRUMB'] = array(
				'Restaurant Chain' => '/admincp/restaurantchain',
				$restaurantChain->restaurantChain => '/admincp/restaurantchain/update/' . $restaurantChain->restaurantChainId,
				'Add Supplier' => '/admincp/restaurantchain/add_supplier/' . $restaurantChain->restaurantChainId,
			);
		
		$this->load->view('admincp/templates/left_center_template', $data);
	}
	
	function update_supplier($id)
	{
		global $SUPPLIER_TYPES_2;
		$data = array();
		
		$this->load->model('SupplierModel');
		$supplier = $this->SupplierModel->getSupplierFromId($id, 'restaurant_chain');
		
		$suppliers = $this->SupplierModel->getSupplierForCompany( '', '', '', '', $trid, '');
	
		$this->load->model('RestaurantChainModel');
		$restaurantChain = $this->RestaurantChainModel->getRestaurantChainFromId($supplier->restaurantChainId);
		
		// List of views to be included
		$data['LEFT'] = array(
				'navigation' => 'admincp/includes/left/nav_restaurantchain',
			);
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/supplier_form',
			);
		
		// Data to be passed to the views
		$data['data']['left']['navigation']['VIEW_HEADER'] = "Options";
		$data['data']['left']['navigation']['RESTAURANT_CHAIN_ID'] = $supplier->restaurantChainId;
		$data['data']['left']['navigation']['SUPPLIER_ID'] = $supplier->supplierId;
		$data['data']['left']['navigation']['TRID'] = $trid;

		$data['data']['center']['list']['VIEW_HEADER'] = prepareHeading($restaurantChain->restaurantChain, $id, 'supplier', 'update');
		$data['data']['center']['list']['SUPPLIER'] = $supplier;
		$data['data']['center']['list']['SUPPLIER_TYPES_2'] = $SUPPLIER_TYPES_2;
		$data['data']['center']['list']['TABLE'] = 'restaurant_chain_supplier';
		$data['data']['center']['list']['SUPPLIERS'] = $suppliers;
		
		$data['BREADCRUMB'] = array(
				'Restaurant Chain' => '/admincp/restaurantchain',
				$restaurantChain->restaurantChain => '/admincp/restaurantchain/update/' . $supplier->restaurantChainId,
				'Supplier #' . $supplier->supplierId => '/admincp/restaurantchain/update_supplier/' . $supplier->supplierId,
			);
			
		$this->load->view('admincp/templates/left_center_template', $data);
	}
	
	function searchRestaurantChains() {
		$q = strtolower($_REQUEST['q']);
		$this->load->model('RestaurantChainModel', '', TRUE);
		$restaurantChains = $this->RestaurantChainModel->searchRestaurantChains($q);
		echo $restaurantChains;
	}
	
}

/* End of file restaurant.php */

?>