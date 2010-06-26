<?php

class RestaurantChain extends Controller {
	
	function __construct()
	{
		parent::Controller();
		if ($this->session->userdata('isAuthenticated') != 1 )
		{
			redirect('admincp/login');
		}
	}
	
	// Default is to list all the restaurants
	function index()
	{
		$data = array();
		$restaurants = array();
		
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
	function add()
	{
		$data = array();
		
		$this->load->model('RestauranttypeModel');
		$restaurantTypes = $this->RestauranttypeModel->listRestaurantType();
		
		// List of views to be included
		$data['CENTER'] = array(
				'form' => 'admincp/restaurant_chain_form',
			);
		
		// Data to be passed to the views
		$data['data']['center']['form']['VIEW_HEADER'] = "Add Restaurant Chain";
		$data['data']['center']['form']['RESTAURANT_TYPES'] = $restaurantTypes;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function update($id)
	{
		$data = array();
		
		$this->load->model('RestaurantChainModel');
		$restaurant = $this->RestaurantChainModel->getRestaurantChainFromId($id);
		
		$this->load->model('RestauranttypeModel');
		$restaurantTypes = $this->RestauranttypeModel->listRestaurantType();
		
		// List of views to be included
		$data['CENTER'] = array(
				'form' => 'admincp/restaurant_chain_form',
			);
		
		$data['LEFT'] = array(
				'navigation' => 'admincp/includes/left/nav_restaurant',
			);
			
		// Data to be passed to the views
		$data['data']['center']['form']['VIEW_HEADER'] = "Update Restaurant Chain";
		$data['data']['center']['form']['RESTAURANT'] = $restaurant;
		$data['data']['center']['form']['RESTAURANT_TYPES'] = $restaurantTypes;
		
		$data['data']['left']['navigation']['VIEW_HEADER'] = "Options";
		$data['data']['left']['navigation']['RESTAURANT_ID'] = $id;
		
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
	
	function add_menu_item(){
		$data = array();
		
		$this->load->model('IngredientModel');
		$ingredients = $this->IngredientModel->list_ingredient();
		
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/restaurant_menu_form',
			);
		
		$data['LEFT'] = array(
				'navigation' => 'admincp/includes/left/nav_restaurant',
			);
			
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Add Menu Item";
		$data['data']['center']['list']['INGREDIENTS'] = $ingredients;
		
		$data['data']['left']['navigation']['VIEW_HEADER'] = "Options";
		
		$this->load->view('admincp/templates/left_center_template', $data);
		
	}
	
	function add_supplier($id)
	{
		global $SUPPLIER_TYPES_2;
		$data = array();
		
		$this->load->model('RestaurantChainModel');
		$restaurantChain = $this->RestaurantChainModel->getRestaurantChainFromId($id);
		
		// List of views to be included
		$data['LEFT'] = array(
				'nav' => 'admincp/includes/left/nav_restaurantchain',
			);
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/supplier_form',
			);
		
		// Data to be passed to the views
		$data['data']['left']['nav']['RESTAURANT_CHAIN_ID'] = $id;
		
		$data['data']['center']['list']['VIEW_HEADER'] = "Add Supplier - " . $restaurantChain->restaurantChain . " (Chain)";
		$data['data']['center']['list']['RESTAURANT_CHAIN'] = $restaurantChain;
		$data['data']['center']['list']['SUPPLIER_TYPES_2'] = $SUPPLIER_TYPES_2;
		$data['data']['center']['list']['TABLE'] = 'restaurant_chain_supplier';
		
		$this->load->view('admincp/templates/left_center_template', $data);
	}
	
	function update_supplier($id)
	{
		global $SUPPLIER_TYPES_2;
		$data = array();
		
		$this->load->model('SupplierModel');
		$supplier = $this->SupplierModel->getSupplierFromId($id, 'restaurant_chain');
		
		// List of views to be included
		$data['LEFT'] = array(
				'nav' => 'admincp/includes/left/nav_restaurantchain',
			);
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/supplier_form',
			);
		
		// Data to be passed to the views
		$data['data']['left']['nav']['RESTAURANT_CHAIN_ID'] = $supplier->restaurantChainId;
		
		$data['data']['center']['list']['VIEW_HEADER'] = "Update Supplier - " . $id;
		$data['data']['center']['list']['SUPPLIER'] = $supplier;
		$data['data']['center']['list']['SUPPLIER_TYPES_2'] = $SUPPLIER_TYPES_2;
		$data['data']['center']['list']['TABLE'] = 'restaurant_chain_supplier';
		
		$this->load->view('admincp/templates/left_center_template', $data);
	}
	
	function add_address($id)
	{
		$data = array();
		
		$this->load->model('StateModel');
		$states = $this->StateModel->listState();
		
		$this->load->model('CountryModel');
		$countries = $this->CountryModel->listCountry();
		
		$this->load->model('RestaurantModel');
		$restaurant = $this->RestaurantModel->getRestaurantFromId($id);
		
		// List of views to be included
		$data['LEFT'] = array(
				'nav' => 'admincp/includes/left/nav_restaurant',
			);
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/address_form',
			);
		
		// Data to be passed to the views
		$data['data']['left']['nav']['RESTAURANT_ID'] = $id;
		
		$data['data']['center']['list']['VIEW_HEADER'] = "Add Address - " . $restaurant->restaurantName;
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
				'nav' => 'admincp/includes/left/nav_restaurant',
			);
		
		// List of views to be included
		$data['CENTER'] = array(
				'from' => 'admincp/address_form',
			);
		
		// Data to be passed to the views
		$data['data']['left']['nav']['RESTAURANT_ID'] = $address->restaurantId;
		$data['data']['left']['nav']['ADDRESS_ID'] = $address->addressId;
		
		$data['data']['center']['from']['VIEW_HEADER'] = "Update Address - #" . $id;
		$data['data']['center']['from']['STATES'] = $states;
		$data['data']['center']['from']['COUNTRIES'] = $countries;
		$data['data']['center']['from']['ADDRESS'] = $address;
		$data['data']['center']['from']['RESTAURANT_ID'] = $address->restaurantId;
		
		$this->load->view('admincp/templates/left_center_template', $data);
		
	}
	/*
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
	*/
	
	function searchRestaurantChains($q) {
		$this->load->model('RestaurantChainModel', '', TRUE);
		$restaurantChains = $this->RestaurantChainModel->searchRestaurantChains($q);
		echo $restaurantChains;
	}
	
}

/* End of file restaurant.php */

?>