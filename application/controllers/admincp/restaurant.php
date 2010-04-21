<?php

class Restaurant extends Controller {
	
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
		
		$this->load->model('RestaurantModel');
		$restaurants = $this->RestaurantModel->listRestaurant();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/restaurant',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Restaurants";
		$data['data']['center']['list']['RESTAURANTS'] = $restaurants;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	// This function will create the form to add a restaurant but does not save the data to the database
	function add()
	{
		$data = array();
		
		$this->load->model('CompanyModel');
		$companies = $this->CompanyModel->listCompany();
		
		$this->load->model('StateModel');
		$states = $this->StateModel->listState();
		
		$this->load->model('CountryModel');
		$countries = $this->CountryModel->listCountry();
		
		$this->load->model('RestauranttypeModel');
		$restaurantTypes = $this->RestauranttypeModel->listRestaurantType();
		
		$this->load->model('CuisineModel');
		$cuisines = $this->CuisineModel->listCuisine();
		
		
		// List of views to be included
		$data['CENTER'] = array(
				'form' => 'admincp/restaurant_form',
			);
		
		// Data to be passed to the views
		$data['data']['center']['form']['VIEW_HEADER'] = "Add Restaurant";
		$data['data']['center']['form']['COUNTRIES'] = $countries;
		$data['data']['center']['form']['STATES'] = $states;
		$data['data']['center']['form']['RESTAURANT_TYPES'] = $restaurantTypes;
		$data['data']['center']['form']['CUISINES'] = $cuisines;
		$data['data']['center']['form']['COMPANIES'] = $companies;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function update($id)
	{
		$data = array();
		
		$this->load->model('RestaurantModel');
		$restaurant = $this->RestaurantModel->getRestaurantFromId($id);
		
		$this->load->model('StateModel');
		$states = $this->StateModel->listState();
		
		$this->load->model('CountryModel');
		$countries = $this->CountryModel->listCountry();
		
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/restaurant_form',
			);
		
		$data['LEFT'] = array(
				'navigation' => 'admincp/includes/left/nav_restaurant',
			);
			
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Update Restaurant";
		$data['data']['center']['list']['COUNTRIES'] = $countries;
		$data['data']['center']['list']['STATES'] = $states;
		$data['data']['center']['list']['RESTAURANT'] = $restaurant;
		
		$data['data']['right']['navigation']['VIEW_HEADER'] = "Options";
		
		$this->load->view('admincp/templates/left_center_template', $data);
	}
	
	// This function will save the new restaurant data into the database
	function save_add() {
		
		$this->load->model('RestaurantModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->RestaurantModel->addRestaurant() ) {
			// TO DO: IF THE USER DOES NOT HAVE JAVASCRIPT WE NEED TO USE SERVER SIDE REDIRECT.  BELOW CODE WILL DO THIS, HOWEVER THE echo 'yes' IS REQUIRED TO PASS TO THE JAVASCRIPT.  CONSIDER A BETTER WAY TO NOTIFY THE JQUERY JAVASCRIPT THAT THE EVENT WAS SUCCESSFUL SO AS TO ALLOW THE PROPER REDIRECT FOR NON JAVASCRIPT
			// Added the new restaurant successfully, send user to index
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
	
	// Send the updated information to the model to be updated in the database
	function save_update() {
		
		$this->load->model('RestaurantModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->RestaurantModel->updateRestaurant() ) {
			
			// The new restaurant was successfully updated, send user to index
			//$this->index();
			/* TO-DO:
			 * Method used above to redirect user on home page from server isde is creating issues. 
			 * It returns the whole HTML content. So when we have got JavaScript enabled, jquery does not work as expected.
			 * We will need to think about one solution whcih can work in both the cases, jquery and server side (without JS)  
			 */
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
		global $SUPPLIER_TYPES;
		$data = array();
		
		$this->load->model('RestaurantModel');
		$restaurant = $this->RestaurantModel->getRestaurantFromId($id);
		
		// List of views to be included
		$data['LEFT'] = array(
				'nav' => 'admincp/includes/left/nav_restaurant',
			);
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/supplier_form',
			);
		
		// Data to be passed to the views
		$data['data']['left']['nav']['RESTAURANT_ID'] = $id;
		
		$data['data']['center']['list']['VIEW_HEADER'] = "Add Supplier - " . $restaurant->restaurantName;
		$data['data']['center']['list']['RESTAURANT'] = $restaurant;
		$data['data']['center']['list']['SUPPLIER_TYPES'] = $SUPPLIER_TYPES;
		
		$this->load->view('admincp/templates/left_center_template', $data);
	}
	
	function update_supplier($id)
	{
		global $SUPPLIER_TYPES;
		$data = array();
		
		$this->load->model('SupplierModel');
		$supplier = $this->SupplierModel->getSupplierFromId($id, 'restaurant');
		
		// List of views to be included
		$data['LEFT'] = array(
				'nav' => 'admincp/includes/left/nav_restaurant',
			);
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/supplier_form',
			);
		
		// Data to be passed to the views
		$data['data']['left']['nav']['RESTAURANT_ID'] = $supplier->restaurantId;
		
		$data['data']['center']['list']['VIEW_HEADER'] = "Update Supplier - " . $id;
		$data['data']['center']['list']['SUPPLIER'] = $supplier;
		$data['data']['center']['list']['SUPPLIER_TYPES'] = $SUPPLIER_TYPES;
		
		$this->load->view('admincp/templates/left_center_template', $data);
	}
	/*
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
	*/
	
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
}

/* End of file restaurant.php */

?>