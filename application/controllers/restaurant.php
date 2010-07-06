<?php

class Restaurant extends Controller {
	
	function index() {
		$data = array();
		
		// SEO
		$this->load->model('SeoModel');
		$seo = $this->SeoModel->getSeoDetailsFromPage('restaurant_list');
		$data['SEO'] = $seo;
		
		$q = $this->input->post('q');
		$f = $this->input->post('f');
		
		// Getting information from models
		/*
		$this->load->model('RestaurantModel');
		$restaurantTypes = $this->RestaurantModel->getDistinctUsedRestaurantType();
		
		$this->load->model('RestaurantModel');
		$cusines = $this->RestaurantModel->getDistinctUsedCuisine();
		*/
		if ( !empty($f) ) {
			$data['CENTER'] = array(
				'list' => '/restaurant/restaurant_list',
			);
		} else {
			// List of views to be included
			$data['CENTER'] = array(
					'map' => 'includes/map',
					'list' => '/restaurant/restaurant_list',
				);
		}
		
		if ( !empty($f) ) {
			$data['LEFT'] = array(
					'ad' => 'includes/left/ad',
				);
		} else {
			$data['LEFT'] = array(
					'filter' => 'includes/left/restaurant_filter',
					'ad' => 'includes/left/ad',
				);
		}
		
		// Data to be passed to the views
		if ( empty($f) ) {
		$data['data']['left']['filter']['VIEW_HEADER'] = "Filters";
		//$data['data']['left']['filter']['RESTAURANT_TYPES'] = $restaurantTypes;
		//$data['data']['left']['filter']['CUISINES'] = $cusines;
		}
		
		if ( empty($f) ) {
		$data['data']['center']['map']['VIEW_HEADER'] = "Map";
		$data['data']['center']['map']['width'] = '790';
		$data['data']['center']['map']['height'] = '250';
		}
		
		//$data['data']['center']['list']['LIST'] = $restaurants;
		$data['data']['center']['list']['VIEW_HEADER'] = "List of Resturants";
		$data['data']['center']['list']['q'] = $q;
		$data['data']['center']['list']['f'] = $f;
		if ( !empty($f) ) {
			$data['data']['center']['list']['hide_map'] = 'yes';
			$data['data']['center']['list']['hide_filters'] = 'yes';
		} else {
			$data['data']['center']['list']['hide_map'] = 'no';
			$data['data']['center']['list']['hide_filters'] = 'no';
		}
		
		
		$this->load->view('templates/left_center_template', $data);
	}
	
	// View the information on a single restaurant
	function view($id) {
		
		$data = array();
		
		$restaurantId = $this->uri->segment(3);
		
		// TO DO: first check if the restaurant is part of a chain
		// SELECT restaurant_chain_id FROM restaurant WHERE restaurant_id = $restaurantId
		// IF THERE IS A RESULT DO THE FOLLOWING
		// Get the data from the chain_menu
		// SELECT * FROM chain_menu WHERE restaurant_chain_id= RESULT FROM ABOVE QUERY
		//
		// Get any specific menu edits that this exact location has
		//
		// Load the rest of the information as normal (photos, address etc)
		
		// Getting information from models
		$this->load->model('RestaurantModel');
		$restaurantinfo = $this->RestaurantModel->getRestaurantFromId($restaurantId);
		
		// SEO
		$this->load->model('SeoModel');
		$seo = $this->SeoModel->getSeoDetailsFromPage('restaurant_detail');
		
		$seo_data_array = array(
			'restaurant_name' => $restaurantinfo->restaurantName,
			'restaurant_type' => 'Fast Food',
			'cuisines' => 'Fast Food, American, Pizza',
		);
		
		$seo = $this->SeoModel->parseSeoData($seo, $seo_data_array);
		$data['SEO'] = $seo;
		// SEO ENDS here
		
		
		// List of views to be included
		$data['CENTER'] = array(
				'info' => '/restaurant/info',
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
		$data['data']['center']['info']['RESTAURANT'] = $restaurantinfo;
		$data['data']['center']['menu']['MENU'] = array('burger', 'pizza', 'meat');
		$data['data']['center']['menu']['SUPPLIER'] = array('Lopez Foods', 'Stonybrook Farms', 'Niman Ranch');
		
		
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
	
	function ajaxSearchRestaurants() {
		
		/*
		$mtime = microtime(); 
	    $mtime = explode(" ",$mtime); 
	    $mtime = $mtime[1] + $mtime[0]; 
	    $starttime = $mtime; 
		*/
		
		$this->load->model('RestaurantModel', '', TRUE);
		$restaurants = $this->RestaurantModel->getRestaurantsJson();
		echo json_encode($restaurants);
		/*
	    $mtime = microtime(); 
	    $mtime = explode(" ",$mtime); 
	    $mtime = $mtime[1] + $mtime[0]; 
	    $endtime = $mtime; 
	    $totaltime = ($endtime - $starttime); 
	    echo "<br />This page was created in ".$totaltime." seconds";
	    */ 
	}
	
	function ajaxGetDistinctUsedRestaurantType() {
		$c = $this->input->post('c');
		$this->load->model('RestaurantModel');
		$restaurantTypes = $this->RestaurantModel->getDistinctUsedRestaurantType($c);
		echo json_encode($restaurantTypes);
	}
	
	function ajaxGetDistinctUsedCuisine() {
		$c = $this->input->post('c');
		$this->load->model('RestaurantModel');
		$cusines = $this->RestaurantModel->getDistinctUsedCuisine($c);
		echo json_encode($cusines);
	}
	
	function ajaxGetAllCuisine() {
		$this->load->model('CuisineModel');
		$cusines = $this->CuisineModel->listCuisine();
		echo json_encode($cusines);
	}
	
	function ajaxGetAllRestaurantType() {
		$this->load->model('RestaurantTypeModel');
		$restaurantType = $this->RestaurantTypeModel->listRestaurantType();
		echo json_encode($restaurantType);
	}
	
	function map() {
		$this->load->view('map');
	}
}

/* End of file restaurant.php */

?>