<?php

class Product extends Controller {
	
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
		
		$this->load->model('ProductModel');
		$products = $this->ProductModel->listproduct();
		
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/product',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Products";
		$data['data']['center']['list']['PRODUCTS'] = $products;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function add()
	{
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/product_form',
			);
			
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Add Product";
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function update($id)
	{
		$data = array();
		
		$this->load->model('ProductModel');
		$product = $this->ProductModel->getProductFromId($id);
		
		$this->load->model('StateModel');
		$states = $this->StateModel->list_state();
		
		$this->load->model('CountryModel');
		$countries = $this->CountryModel->list_country();
		
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/product_form',
			);
		
		$data['RIGHT'] = array(
				'navigation' => 'admincp/includes/right/navigation',
			);
			
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Update Product";
		$data['data']['center']['list']['COUNTRIES'] = $countries;
		$data['data']['center']['list']['STATES'] = $states;
		$data['data']['center']['list']['COMPANY'] = $product;
		
		$data['data']['right']['navigation']['VIEW_HEADER'] = "Navigation";
		
		$this->load->view('admincp/templates/center_right_template', $data);
	}
	
	function save_add() {
		
		$this->load->model('ProductModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->ProductModel->addProduct() ) {
			
			// TO DO: IF THE USER DOES NOT HAVE JAVASCRIPT WE NEED TO USE SERVER SIDE REDIRECT.  BELOW CODE WILL DO THIS, HOWEVER THE echo 'yes' IS REQUIRED TO PASS TO THE JAVASCRIPT.  CONSIDER A BETTER WAY TO NOTIFY THE JQUERY JAVASCRIPT THAT THE EVENT WAS SUCCESSFUL SO AS TO ALLOW THE PROPER REDIRECT FOR NON JAVASCRIPT
			// Added the new COMPANY successfully, send user to index
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

	function listProduct($hasFructose = 0, $currentPage = 1, $dispPerPage = 200) {
		$data = array();

		$this->load->model('ProductModel');
		$productCount = $this->ProductModel->getProductCount($hasFructose);
		$products = $this->ProductModel->listProductDetails($hasFructose, $currentPage, $dispPerPage);


		// List of views to be included
		$data['CENTER'] = array(
				'list_product' => 'admincp/list_product',
			);

		// Data to be passed to the views
		$data['data']['center']['list_product']['DISP_PER_PAGE'] = $dispPerPage;
		$data['data']['center']['list_product']['TOTAL_RECORD_COUNT'] = $productCount;
		$data['data']['center']['list_product']['CURRENT_PAGE'] = $currentPage;
		$data['data']['center']['list_product']['PRODUCTS'] = $products;
		$data['data']['center']['list_product']['PAGING_CALLBACK'] = "/admincp/product/listProduct/$hasFructose";

		$this->load->view('admincp/templates/center_template', $data);
	}
	
}

/* End of file product.php */

?>