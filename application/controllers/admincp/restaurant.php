<?php

class Restaurant extends Controller {
	
	function __construct()
	{
		parent::Controller();
		if ($this->session->userdata('isAuthenticated') != 1 || $this->session->userdata('userGroup') != 'admin' )
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
				'list' => 'admincp/restaurant',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Restaurants";
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function ajaxSearchRestaurants() {
		$this->load->model('RestaurantModel', '', TRUE);
		$restaurants = $this->RestaurantModel->getRestaurantsJsonAdmin();
		echo json_encode($restaurants);
	}
	
	// This function will create the form to add a restaurant but does not save the data to the database
	function add()
	{
		$data = array();
		
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
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function update($id)
	{
		$data = array();
		
		$this->load->model('RestaurantModel');
		$restaurant = $this->RestaurantModel->getRestaurantFromId($id);
		
		$this->load->model('RestauranttypeModel');
		$restaurantTypes = $this->RestauranttypeModel->listRestaurantType();
		
		$this->load->model('CuisineModel');
		$cuisines = $this->CuisineModel->listCuisine();
		
		// List of views to be included
		$data['CENTER'] = array(
				'form' => 'admincp/restaurant_form',
			);
		
		$data['LEFT'] = array(
				'navigation' => 'admincp/includes/left/nav_restaurant',
			);
			
		// Data to be passed to the views
		$data['data']['center']['form']['VIEW_HEADER'] = "Update Restaurant";
		$data['data']['center']['form']['RESTAURANT'] = $restaurant;
		$data['data']['center']['form']['RESTAURANT_TYPES'] = $restaurantTypes;
		$data['data']['center']['form']['CUISINES'] = $cuisines;
		
		$data['data']['left']['navigation']['VIEW_HEADER'] = "Options";
		$data['data']['left']['navigation']['RESTAURANT_ID'] = $id;
		
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
	
	function add_supplier($id)
	{
		global $SUPPLIER_TYPES_2;
		$data = array();
		
		$this->load->model('RestaurantModel');
		$restaurant = $this->RestaurantModel->getRestaurantFromId($id);
		
		$this->load->model('SupplierModel','',true);
		$suppliers = $this->SupplierModel->getSupplierForCompany( $id, '', '', '', '', '' );
		
		// List of views to be included
		$data['LEFT'] = array(
				'navigation' => 'admincp/includes/left/nav_restaurant',
			);
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/supplier_form',
			);
		
		// Data to be passed to the views
		$data['data']['left']['navigation']['VIEW_HEADER'] = "Options";
		$data['data']['left']['navigation']['RESTAURANT_ID'] = $id;
		
		$data['data']['center']['list']['VIEW_HEADER'] = "Add Supplier - " . $restaurant->restaurantName . ' (R)';
		$data['data']['center']['list']['RESTAURANT'] = $restaurant;
		$data['data']['center']['list']['SUPPLIER_TYPES_2'] = $SUPPLIER_TYPES_2;
		$data['data']['center']['list']['TABLE'] = 'restaurant_supplier';
		$data['data']['center']['list']['SUPPLIERS'] = $suppliers;
		
		$this->load->view('admincp/templates/left_center_template', $data);
	}
	
	function update_supplier($id)
	{
		global $SUPPLIER_TYPES_2;
		$data = array();
		
		$this->load->model('SupplierModel');
		$supplier = $this->SupplierModel->getSupplierFromId($id, 'restaurant');
		
		$suppliers = $this->SupplierModel->getSupplierForCompany( $supplier->restaurantId, '', '', '', '', '');
		
		// List of views to be included
		$data['LEFT'] = array(
				'navigation' => 'admincp/includes/left/nav_restaurant',
			);
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/supplier_form',
			);
		
		// Data to be passed to the views
		$data['data']['left']['navigation']['VIEW_HEADER'] = "Options";
		$data['data']['left']['navigation']['RESTAURANT_ID'] = $supplier->restaurantId;
		
		$data['data']['center']['list']['VIEW_HEADER'] = "Update Supplier - " . $id . ' (R)';
		$data['data']['center']['list']['SUPPLIER'] = $supplier;
		$data['data']['center']['list']['SUPPLIER_TYPES_2'] = $SUPPLIER_TYPES_2;
		$data['data']['center']['list']['TABLE'] = 'restaurant_supplier';
		$data['data']['center']['list']['SUPPLIERS'] = $suppliers;
		
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
		
		$this->load->model('AddressModel','',true);
		$addresses = $this->AddressModel->getAddressForCompany( $id, '', '', '', '', '', '');
				
		// List of views to be included
		$data['LEFT'] = array(
				'navigation' => 'admincp/includes/left/nav_restaurant',
			);
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/address_form',
			);
		
		// Data to be passed to the views
		$data['data']['left']['navigation']['VIEW_HEADER'] = "Options";
		$data['data']['left']['navigation']['RESTAURANT_ID'] = $id;
		
		$data['data']['center']['list']['VIEW_HEADER'] = "Add Address - " . $restaurant->restaurantName . ' (R)';
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
		
		$addresses = $this->AddressModel->getAddressForCompany( $address->restaurantId, '', '', '', '', '', '');
		
		
		// List of views to be included
		$data['LEFT'] = array(
				'navigation' => 'admincp/includes/left/nav_restaurant',
			);
		
		// List of views to be included
		$data['CENTER'] = array(
				'form' => 'admincp/address_form',
			);
		
		// Data to be passed to the views
		$data['data']['left']['navigation']['VIEW_HEADER'] = "Options";
		$data['data']['left']['navigation']['RESTAURANT_ID'] = $address->restaurantId;
		
		$data['data']['center']['form']['VIEW_HEADER'] = "Update Address - #" . $id . ' (R)';
		$data['data']['center']['form']['STATES'] = $states;
		$data['data']['center']['form']['COUNTRIES'] = $countries;
		$data['data']['center']['form']['ADDRESS'] = $address;
		$data['data']['center']['form']['RESTAURANT_ID'] = $address->restaurantId;
		$data['data']['center']['form']['ADDRESSES'] = $addresses;
		
		$this->load->view('admincp/templates/left_center_template', $data);
		
	}
	
	
	function add_menu_item($id){
		$data = array();
		
		$this->load->model('ProductTypeModel');
		$productTypes = $this->ProductTypeModel->listProductType();
		
		$this->load->model('ProductModel','',true);
		$products = $this->ProductModel->getProductForCompany($id, '', '', '');
		
		// List of views to be included
		$data['CENTER'] = array(
				'form' => 'admincp/menu_form',
			);
		
		$data['LEFT'] = array(
				'navigation' => 'admincp/includes/left/nav_restaurant',
			);
			
		// Data to be passed to the views
		$data['data']['center']['form']['VIEW_HEADER'] = "Add Menu Item (R)";
		$data['data']['center']['form']['PRODUCT_TYPES'] = $productTypes;
		$data['data']['center']['form']['PRODUCTS'] = $products;
		
		$data['data']['left']['navigation']['VIEW_HEADER'] = "Options";
		$data['data']['left']['navigation']['RESTAURANT_ID'] = $id;
		
		$this->load->view('admincp/templates/left_center_template', $data);
	}
	
	
	function update_menu_item($id) {
		$data = array();
		
		$this->load->model('ProductTypeModel');
		$productTypes = $this->ProductTypeModel->listProductType();
		
		$this->load->model('ProductModel');
		$product = $this->ProductModel->getProductFromId($id);
		
		$products = $this->ProductModel->getProductForCompany($product->restaurantId, '', '', '');
		
		// List of views to be included
		$data['LEFT'] = array(
				'navigation' => 'admincp/includes/left/nav_restaurant',
			);
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/menu_form',
			);
		
		// Data to be passed to the views
		$data['data']['left']['navigation']['VIEW_HEADER'] = "Options";
		$data['data']['left']['navigation']['RESTAURANT_ID'] = $product->restaurantId;
		
		$data['data']['center']['list']['VIEW_HEADER'] = "Update Menu Item - " . $id . ' (R)';
		$data['data']['center']['list']['PRODUCT_TYPES'] = $productTypes;
		$data['data']['center']['list']['PRODUCT'] = $product;
		$data['data']['center']['list']['PRODUCTS'] = $products;
		
		$this->load->view('admincp/templates/left_center_template', $data);
	}
	
	
}

/* End of file restaurant.php */

?>