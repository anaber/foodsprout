<?php

class Producttype extends Controller {
	
	function __construct()
	{
		global $ADMIN_LANDING_PAGE;
		parent::Controller();
		if ($this->session->userdata('isAuthenticated') != 1 || $this->session->userdata('userGroup') != 'admin' )
		{
			redirect($ADMIN_LANDING_PAGE);
		}
	}
	
	function index()
	{
		$this->list_producttype();
	}
	
	// List all the producttype in the database
	function list_producttype()
	{
		$data = array();
		$producttypes = array();
		
		$this->load->model('ProductTypeModel');
		$producttypes = $this->ProductTypeModel->listProductType();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/producttype',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "List Product Types";
		$data['data']['center']['list']['PRODUCTTYPES'] = $producttypes;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function add()
	{
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/producttype_form',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Add Product Type";
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function save_add() {
		
		$this->load->model('ProducttypeModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->ProducttypeModel->addProducttype() ) {
			echo "yes";
		} else {
			if (isset($GLOBALS['error']) && !empty($GLOBALS['error']) ) {
				echo $GLOBALS['error'];
			} else {
				echo 'no';
			}
		}
	}
	
	function update($id)
	{
		$data = array();
		
		$this->load->model('ProducttypeModel');
		$producttype = $this->ProducttypeModel->getProducttypeFromId($id);
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/producttype_form',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Update Product Type";
		$data['data']['center']['list']['PRODUCTTYPE'] = $producttype;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function save_update() {
		
		$this->load->model('ProducttypeModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->ProducttypeModel->updateProducttype() ) {
			echo "yes";
		} else {
			if (isset($GLOBALS['error']) && !empty($GLOBALS['error']) ) {
				echo $GLOBALS['error'];
			} else {
				echo 'no';
			}
		}
		
	}
}

/* End of file producttype.php */

?>