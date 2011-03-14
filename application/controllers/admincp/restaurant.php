<?php

class Restaurant extends Controller {
	
	function __construct() {
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
	function add() {
		global $STATUS;
		$data = array();
		
		$this->load->model('StateModel');
		$states = $this->StateModel->listState();
		
		$this->load->model('CountryModel');
		$countries = $this->CountryModel->listCountry();
		
		$this->load->model('ProducerCategoryModel');
		$restaurantTypes = $this->ProducerCategoryModel->listProducerCategory('RESTAURANT', '');
		$cuisines = $this->ProducerCategoryModel->listProducerCategory('CUISINE', '');
		
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
		$data['data']['center']['form']['STATUS'] = $STATUS;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function update($id) {
		global $STATUS;
		$data = array();

		$this->load->model('RestaurantModel');
		$restaurant = $this->RestaurantModel->getRestaurantFromId($id);

		$this->load->model('ProducerCategoryModel');
		$restaurantTypes = $this->ProducerCategoryModel->listProducerCategory('RESTAURANT', '');
		$cuisines = $this->ProducerCategoryModel->listProducerCategory('CUISINE', '');

		//$this->load->model('RestauranttypeModel');
		//$restaurantTypes = $this->RestauranttypeModel->listRestaurantType();
		
		//$this->load->model('CuisineModel');
		//$cuisines = $this->CuisineModel->listCuisine();
		
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
		$data['data']['center']['form']['STATUS'] = $STATUS;
		
		$data['data']['left']['navigation']['VIEW_HEADER'] = "Options";
		$data['data']['left']['navigation']['RESTAURANT_ID'] = $id;
		$data['data']['left']['navigation']['TRID'] = $id;
		
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
		$data['data']['left']['navigation']['TRID'] = $id;
		
		$data['data']['center']['list']['VIEW_HEADER'] = prepareHeading($restaurant->restaurantName, '', 'supplier', 'add');
		$data['data']['center']['list']['RESTAURANT'] = $restaurant;
		$data['data']['center']['list']['SUPPLIER_TYPES_2'] = $SUPPLIER_TYPES_2;
		$data['data']['center']['list']['TABLE'] = 'restaurant_supplier';
		$data['data']['center']['list']['SUPPLIERS'] = $suppliers;
		
		$data['BREADCRUMB'] = array(
				'Restaurants' => '/admincp/restaurant',
				$restaurant->restaurantName => '/admincp/restaurant/update/' . $restaurant->restaurantId,
				'Add Supplier' => '/admincp/restaurant/add_supplier/' . $restaurant->restaurantId,
			);
			
		$this->load->view('admincp/templates/left_center_template', $data);
	}
	
	function update_supplier($id, $trid)
	{
		global $SUPPLIER_TYPES_2;
		$data = array();
		
		$this->load->model('SupplierModel');
		$supplier = $this->SupplierModel->getSupplierFromId($id, 'restaurant');
		
		$suppliers = $this->SupplierModel->getSupplierForCompany( $supplier->supplierId, '', '', '', '', '');
		
		$this->load->model('RestaurantModel');
		$restaurant = $this->RestaurantModel->getRestaurantFromId($supplier->supplierId);

		// Parent Restaurant		
		$p_restaurant = $this->RestaurantModel->getRestaurantFromId($trid);
		
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
		$data['data']['left']['navigation']['RESTAURANT_ID'] = $supplier->supplierId;
		$data['data']['left']['navigation']['TRID'] = $trid;
		
		$data['data']['center']['list']['VIEW_HEADER'] = prepareHeading($restaurant->restaurantName, $id, 'supplier', 'update'); 
		$data['data']['center']['list']['SUPPLIER'] = $supplier;
		$data['data']['center']['list']['SUPPLIER_TYPES_2'] = $SUPPLIER_TYPES_2;
		$data['data']['center']['list']['TABLE'] = 'restaurant_supplier';
		$data['data']['center']['list']['SUPPLIERS'] = $suppliers;
		$data['data']['center']['list']['TRID'] = $trid;
		
		$data['BREADCRUMB'] = array(
				'Restaurants' => '/admincp/restaurant',
				$p_restaurant->restaurantName." Suppliers" => '/admincp/restaurant/add_supplier/' .$trid,
				'Supplier #' . $supplier->supplierId => '/admincp/restaurant/update_supplier/' . $supplier->supplierId.'/'.$trid
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
		
		$this->load->model('RestaurantModel');
		$restaurant = $this->RestaurantModel->getRestaurantFromId($id);

		$this->load->model('AddressModel','',true);
		$addresses = $this->AddressModel->getAddressForCompany( $id, '', '', '', '', '', '', '');
				
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
		$data['data']['left']['navigation']['TRID'] = $id;
		
		$data['data']['center']['list']['VIEW_HEADER'] = prepareHeading($restaurant->restaurantName, '', 'address', 'add'); 
		$data['data']['center']['list']['STATES'] = $states;
		$data['data']['center']['list']['COUNTRIES'] = $countries;
		$data['data']['center']['list']['ADDRESSES'] = $addresses;
		
		$data['BREADCRUMB'] = array(
				'Restaurants' => '/admincp/restaurant',
				$restaurant->restaurantName => '/admincp/restaurant/update/' . $restaurant->restaurantId,
				'Add Address' => '/admincp/restaurant/add_address/' . $restaurant->restaurantId,
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

		$addresses = $this->AddressModel->getAddressForCompany( $address->producerId, '', '', '', '', '', '', '');
		
		$this->load->model('RestaurantModel');
		$restaurant = $this->RestaurantModel->getRestaurantFromId($address->producerId);
		
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
		$data['data']['left']['navigation']['RESTAURANT_ID'] = $address->producerId;
		$data['data']['left']['navigation']['TRID'] = $address->producerId;
		
		$data['data']['center']['form']['VIEW_HEADER'] = prepareHeading($restaurant->restaurantName, $id, 'address', 'update');
		$data['data']['center']['form']['STATES'] = $states;
		$data['data']['center']['form']['COUNTRIES'] = $countries;
		$data['data']['center']['form']['ADDRESS'] = $address;
		$data['data']['center']['form']['RESTAURANT_ID'] = $address->producerId;
		$data['data']['center']['form']['ADDRESSES'] = $addresses;
		
		$data['BREADCRUMB'] = array(
				'Restaurants' => '/admincp/restaurant',
				$restaurant->restaurantName => '/admincp/restaurant/update/' . $address->producerId,
				'Address #' . $address->addressId => '/admincp/restaurant/update_address/' . $address->addressId,
			);
		
		$this->load->view('admincp/templates/left_center_template', $data);
		
	}
	
	
	function add_menu_item($id){
		$data = array();
		
		$this->load->model('ProductTypeModel');
		$productTypes = $this->ProductTypeModel->listProductType();
		
		$this->load->model('ProductModel','',true);
		$products = $this->ProductModel->getProductForCompany($id, '', '', '');
		
		$this->load->model('RestaurantModel');
		$restaurant = $this->RestaurantModel->getRestaurantFromId($id);
		
		// List of views to be included
		$data['CENTER'] = array(
				'form' => 'admincp/menu_form',
			);
		
		$data['LEFT'] = array(
				'navigation' => 'admincp/includes/left/nav_restaurant',
			);
			
		// Data to be passed to the views
		$data['data']['center']['form']['VIEW_HEADER'] = prepareHeading($restaurant->restaurantName, '', 'menu item', 'add');
		$data['data']['center']['form']['PRODUCT_TYPES'] = $productTypes;
		$data['data']['center']['form']['PRODUCTS'] = $products;
		
		$data['data']['left']['navigation']['VIEW_HEADER'] = "Options";
		$data['data']['left']['navigation']['RESTAURANT_ID'] = $id;
		$data['data']['left']['navigation']['TRID'] = $id;
		
		$data['BREADCRUMB'] = array(
				'Restaurants' => '/admincp/restaurant',
				$restaurant->restaurantName => '/admincp/restaurant/update/' . $restaurant->restaurantId,
				'Add Menu Item' => '/admincp/restaurant/add_menu_item/' . $restaurant->restaurantId,
			);
		
		$this->load->view('admincp/templates/left_center_template', $data);
	}
	
	
	function update_menu_item($id) {
		$data = array();
		
		$this->load->model('ProductTypeModel');
		$productTypes = $this->ProductTypeModel->listProductType();
		
		$this->load->model('ProductModel');
		$product = $this->ProductModel->getProductFromId($id);

		$products = $this->ProductModel->getProductForCompany($product->producer_id, '', '', '');

		$this->load->model('RestaurantModel');
		$restaurant = $this->RestaurantModel->getRestaurantFromId($product->producer_id);
		
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
		$data['data']['left']['navigation']['RESTAURANT_ID'] = $product->producer_id;
		$data['data']['left']['navigation']['TRID'] = $product->producer_id;
		
		$data['data']['center']['list']['VIEW_HEADER'] = prepareHeading($restaurant->restaurantName, $id, 'menu item', 'update');
		$data['data']['center']['list']['PRODUCT_TYPES'] = $productTypes;
		$data['data']['center']['list']['PRODUCT'] = $product;
		$data['data']['center']['list']['PRODUCTS'] = $products;
		
		$data['BREADCRUMB'] = array(
				'Restaurants' => '/admincp/restaurant',
				$restaurant->restaurantName => '/admincp/restaurant/update/' . $product->producer_id,
				'Menu Item #' . $product->product_id => '/admincp/restaurant/update_address/' . $product->product_id,
			);
			
		$this->load->view('admincp/templates/left_center_template', $data);
	}
	
	function searchRestaurants() {
		$q = strtolower($_REQUEST['q']);
		$this->load->model('RestaurantModel', '', TRUE);
		$restaurants = $this->RestaurantModel->searchRestaurants($q);
		echo $restaurants;
	}
	
}

/* End of file restaurant.php */

?>