<?php

class Chain extends Controller {
	
	function index() {
		$data = array();
		
		// Views to include in the data array
		$data['CENTER'] = array(
				'list' => '/restaurant/fastfood_list',
			);
		
		$data['RIGHT'] = array(
				'ad' => 'includes/left/ad',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "List of Fast Food Resturants";
		
		$this->load->view('templates/center_right_narrow_template', $data);
	}
	
	function fastfood() {
		$data = array();
		
		// Views to include in the data array
		$data['CENTER'] = array(
				'list' => '/restaurant/fastfood_list',
			);
		
		$data['RIGHT'] = array(
				'ad' => 'includes/left/ad',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "List of Restaurant Chains";
		
		$this->load->view('templates/center_right_narrow_template', $data);
	}
	
	// View info about a chain restaurant
	function view($id) {
		
		$data = array();
		
		$restaurantChainId = $this->uri->segment(3);
		
		// Getting information from models
		$this->load->model('RestaurantModel');
		$restaurantChainInfo = $this->RestaurantModel->getRestaurantChainFromId($restaurantChainId);
		
		$this->load->model('RestaurantChainModel');
		$menu = $this->RestaurantChainModel->getRestaurantChainMenu($restaurantChainId);
		
		$this->load->model('RestaurantChainModel');
		$suppliers = $this->RestaurantChainModel->getRestaurantChainSuppliers($restaurantChainId);
		
		// SEO
		$this->load->model('SeoModel');
		$seo = $this->SeoModel->getSeoDetailsFromPage('restaurant_detail');
		
		$seo_data_array = array(
			'restaurant_name' => $restaurantChainInfo->restaurantChain,
			'restaurant_type' => 'Fast Food',
			'cuisines' => 'Fast Food, American, Pizza',
		);
		
		$seo = $this->SeoModel->parseSeoData($seo, $seo_data_array);
		$data['SEO'] = $seo;
		// SEO ENDS here
		
		
		// List of views to be included
		$data['CENTER'] = array(
				'info' => '/restaurant/info_chain',
				'menu' => '/restaurant/menu',
				'suppliers' => '/restaurant/suppliers',
			);
		
		$data['RIGHT'] = array(
				'image' => 'includes/right/image',
				'ad' => 'includes/right/ad',
				'map' => 'includes/right/map',
			);
		
		// Data to be passed to the views
		// Center -> Menu
		$data['data']['center']['info']['RESTAURANT'] = $restaurantChainInfo;
		$data['data']['center']['menu']['MENU'] = $menu;
		$data['data']['center']['suppliers']['SUPPLIER'] = $suppliers;
		
		// Right -> Image
		$data['data']['right']['image']['src'] = '/images/standard/restaurant-na-icon.jpg';
		$data['data']['right']['image']['width'] = '300';
		$data['data']['right']['image']['height'] = '200';
		$data['data']['right']['image']['title'] = '';
		
		// Right -> Map
		$data['data']['right']['map']['width'] = '300';
		$data['data']['right']['map']['height'] = '200';
		$data['data']['right']['map']['hide_map'] = 'no';
		
		$data['data']['right']['suppliers']['VIEW_HEADER'] = "List of Suppliers";
		
		$this->load->view('templates/center_right_template', $data);
	}
	
	function ajaxSearchRestaurantChains() {
		$this->load->model('RestaurantChainModel', '', TRUE);
		$restaurants = $this->RestaurantChainModel->getRestaurantChainsJson();
		echo json_encode($restaurants);
	}
	
}

/* End of file restaurant.php */

?>