<?php

class Restaurant extends Controller {
	
	function index() {
		global $GOOGLE_MAP_KEY;
		
		$data = array();
		
		// Getting information from models
		$this->load->model('RestaurantModel');
		$restaurants = $this->RestaurantModel->listRestaurant();
		
		$this->load->model('RestaurantTypeModel');
		$restaurantTypes = $this->RestaurantTypeModel->listRestaurantType();
		
		$this->load->model('CuisineModel');
		$cusines = $this->CuisineModel->listCuisine();
		
		// List of views to be included
		$data['CENTER'] = array(
				'map' => 'includes/map',
				'list' => '/restaurant/restaurant_list',
			);
		
		$data['LEFT'] = array(
				'filter' => 'includes/left/restaurant_filter',
				'ad' => 'includes/left/ad',
			);
		
		// Data to be passed to the views
		$data['data']['left']['filter']['VIEW_HEADER'] = "Filters";
		$data['data']['left']['filter']['RESTAURANTTYPES'] = $restaurantTypes;
		$data['data']['left']['filter']['CUISINES'] = $cusines;
		
		$data['data']['center']['map']['GOOGLE_MAP_KEY'] = $GOOGLE_MAP_KEY;
		$data['data']['center']['map']['VIEW_HEADER'] = "Map";
		$data['data']['center']['map']['width'] = '790';
		$data['data']['center']['map']['height'] = '250';
		
		$data['data']['center']['list']['LIST'] = $restaurants;
		$data['data']['center']['list']['VIEW_HEADER'] = "List of Resturants";
		
		
		
		$this->load->view('templates/left_center_template', $data);
	}
	
	function view($id) {
		
		global $GOOGLE_MAP_KEY;
		
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'menu' => '/restaurant/menu',
			);
		
		$data['RIGHT'] = array(
				'image' => 'includes/right/image',
				'ad' => 'includes/right/ad',
				'map' => 'includes/map',
				'supliers' => 'suppliers',
			);
		
		// Data to be passed to the views
		// Center -> Ingredients		
		$data['data']['center']['menu']['MENU'] = array('burger', 'pizza', 'meat');
		
		
		// Right -> Image
		$data['data']['right']['image']['src'] = '/images/products/burger.jpg';
		$data['data']['right']['image']['width'] = '300';
		$data['data']['right']['image']['height'] = '200';
		$data['data']['right']['image']['title'] = 'Restaurant Image';
		
		// Right -> Map
		$data['data']['right']['map']['GOOGLE_MAP_KEY'] = $GOOGLE_MAP_KEY;
		$data['data']['right']['map']['VIEW_HEADER'] = "Google Map";
		$data['data']['right']['map']['width'] = '300';
		$data['data']['right']['map']['height'] = '200';
		
		
		//$data['data']['right']['info']['VIEW_HEADER'] = "Product Info";
		
		$data['data']['right']['suppliers']['VIEW_HEADER'] = "List of Suppliers";
		
		$this->load->view('templates/center_right_template', $data);
	}
	
}

/* End of file restaurant.php */

?>