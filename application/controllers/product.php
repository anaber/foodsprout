<?php

class Product extends Controller {
	
	function index() {
		global $GOOGLE_MAP_KEY;
		
		$data = array();
		
		// Getting information from models
		$this->load->model('ProductModel');
		$products = $this->ProductModel->list_product();
		
		// List of views to be included
		$data['LEFT'] = array(
				'ad' => 'includes/left/ad',
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
		$data['data']['right']['image']['src'] = '/images/products/burger.jpg';
		$data['data']['right']['image']['width'] = '300';
		$data['data']['right']['image']['height'] = '200';
		$data['data']['right']['image']['title'] = 'Burger Image';
		
		$data['data']['right']['info']['VIEW_HEADER'] = "Product Info";
		
		$data['data']['right']['nutrition']['VIEW_HEADER'] = "Nutritional Information";
		
		$this->load->view('templates/center_right_template', $data);
	}
	
}

/* End of file product.php */

?>