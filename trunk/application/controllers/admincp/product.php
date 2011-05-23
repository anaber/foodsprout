<?php

class Product extends Controller {
	
	function __construct()
	{
		global $ADMIN_LANDING_PAGE;
		parent::Controller();
		if ($this->session->userdata('isAuthenticated') != 1 || $this->session->userdata('access') != 'admin' )
		{
			redirect($ADMIN_LANDING_PAGE);
		}
	}
	
	function index() {
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/product',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Products";
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function fructose() {
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/product',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Products with Fructose";
		
		// Center -> List
		$data['data']['center']['list']['FRUCTOSE'] = true;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function add()
	{
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/forms/product_form',
			);
			
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Add Product";
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function update($id) {
		$data = array();
		
		$this->load->model('ProductModel');
		$product = $this->ProductModel->getProductFromId($id);
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/forms/product_form',
			);
		
		$data['RIGHT'] = array(
				'navigation' => 'admincp/includes/right/navigation',
			);
			
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Update Product";
		$data['data']['center']['list']['COMPANY'] = $product;
		
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
	
	function ajaxSearchProducts() {
		$this->load->model('ProductModel', '', TRUE);
		$products = $this->ProductModel->getProductsJsonAdmin();
		echo json_encode($products);
	}
	
}

/* End of file product.php */

?>