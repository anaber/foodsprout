<?php

class Product extends Controller {
	
	function __construct()
	{
		parent::Controller();
	}
	
	function index() {
		if ($this->session->userdata('isAuthenticated') != 1 ) {
			redirect('about/privatebeta');
		}
		$data = array();
		
		// Views to include in the data array
		$data['CENTER'] = array(
				'list' => '/product/product_list',
			);
		
		$data['LEFT'] = array(
				'filter' => 'includes/left/product_filter',
			);
		
		$this->load->view('templates/left_center_template', $data);
	}
	
	function newProducts() {
		global $GOOGLE_MAP_KEY;
		$data = array();
		
		// Getting information from models
		$this->load->model('ProductModel');
		$products = $this->ProductModel->listNewProducts();
		
		// List of views to be included
		$data['LEFT'] = array(
				'ad' => 'includes/banners/sky',
			);
		
		$data['CENTER'] = array(
				'map'  => 'includes/map',
				'list' => '/product/product_list',
			);
		
		// Data to be passed to the views
		$data['data']['center']['map']['GOOGLE_MAP_KEY'] = $GOOGLE_MAP_KEY;
		$data['data']['center']['map']['VIEW_HEADER'] = "Distributor Map";
		$data['data']['center']['map']['width'] = '790';
		$data['data']['center']['map']['height'] = '250';
		
		$data['data']['center']['list']['VIEW_HEADER'] = "Product List";
		$data['data']['center']['list']['LIST'] = $products;
		
		$this->load->view('templates/left_center_template', $data);
	}
	
	function detail($id) {
		if ($this->session->userdata('isAuthenticated') != 1 ) {
			redirect('about/privatebeta');
		}
		
		global $GOOGLE_MAP_KEY;
		
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'ingredients' => 'ingredients',
				'map' => 'includes/map',
				'topics' => 'topics',
				'impact' => 'impact',
			);
		
		$data['RIGHT'] = array(
				'image' => 'includes/right/image',
				'ad' => 'includes/right/ad',
				'info' => 'includes/right/info',
				'nutrition' => 'includes/right/info',
			);
		
		$data['BREADCRUMB'] = array(
				'Home' => '/home',
				'McDonald' => '/company/detail/2',
				'Meat' => '',
			);
		
		// Data to be passed to the views
		// Center -> Ingredients		
		$data['data']['center']['ingredients']['INGREDIENTS'] = array('cheese', 'meat', 'pepper');
		
		// Center -> Map
		$data['data']['center']['map']['GOOGLE_MAP_KEY'] = $GOOGLE_MAP_KEY;
		$data['data']['center']['map']['VIEW_HEADER'] = "Map showing where ingredients, items came from";
		$data['data']['center']['map']['width'] = '650';
		$data['data']['center']['map']['height'] = '200';
		
		
		// Right -> Image
		$data['data']['right']['image']['src'] = '/img/products/burger.jpg';
		$data['data']['right']['image']['width'] = '300';
		$data['data']['right']['image']['height'] = '200';
		$data['data']['right']['image']['title'] = 'Burger Image';
		
		$data['data']['right']['info']['VIEW_HEADER'] = "Product Info";
		
		$data['data']['right']['nutrition']['VIEW_HEADER'] = "Nutritional Information";
		
		$this->load->view('templates/center_right_template', $data);
	}
	
	// list of products with fructose
	function fructose() {
		$data = array();
		
		// Views to include in the data array
		$data['CENTER'] = array(
				'list' => '/product/product_list',
			);
		
		$data['LEFT'] = array(
				'filter' => 'includes/left/product_filter',
			);
		
		// Center -> List
		$data['data']['center']['list']['FRUCTOSE'] = true;
		
		$this->load->view('templates/left_center_template', $data);
	}
	
	function ajaxSearchProducts() {
		$this->load->model('ProductModel', '', TRUE);
		$products = $this->ProductModel->getProductJson();
		echo json_encode($products);
	}
	
	function get_products_for_auto_suggest() {
		$q = strtolower($_REQUEST['q']);
		
		$this->load->model('ProductModel', '', TRUE);
		$products = $this->ProductModel->searchProducts($q);
		echo $products;
	}
	
}

/* End of file product.php */

?>