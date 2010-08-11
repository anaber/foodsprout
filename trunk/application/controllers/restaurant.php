<?php

class Restaurant extends Controller {
	
	function __construct()
	{
		parent::Controller();
		if ($this->session->userdata('isAuthenticated') != 1 )
		{
			redirect('about/privatebeta');
		}
	}
	
	function index() {
		$data = array();
		
		// SEO
		$this->load->model('SeoModel');
		$seo = $this->SeoModel->getSeoDetailsFromPage('restaurant_list');
		$data['SEO'] = $seo;
		
		$q = $this->input->post('q');
		$f = $this->input->post('f');

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
			// do nothing
		} else {
			$data['LEFT'] = array(
					'filter' => 'includes/left/restaurant_filter',
				);
		}
		
		// Data to be passed to the views
		if ( empty($f) ) {
		// load nothing
		}
		
		if ( empty($f) ) {
		$data['data']['center']['map']['width'] = '795';
		$data['data']['center']['map']['height'] = '250';
		}
		
		$data['data']['center']['list']['VIEW_HEADER'] = "";
		$data['data']['center']['list']['q'] = $q;
		$data['data']['center']['list']['f'] = $f;
		if ( !empty($f) ) {
			$data['data']['center']['list']['hide_map'] = 'yes';
			$data['data']['center']['list']['hide_filters'] = 'yes';
		} else {
			$data['data']['center']['list']['hide_map'] = 'no';
			$data['data']['center']['list']['hide_filters'] = 'no';
		}
		// this is not working???
		//$data['CSS'] = "listing";
		
		
		$this->load->view('templates/left_center_template', $data);
	}
	
	function ajaxSearchRestaurantInfo() {
		$restaurantId = $this->input->post('restaurantId');
		$this->load->model('RestaurantModel', '', TRUE);
		$restaurant = $this->RestaurantModel->getRestaurantFromId($restaurantId);
		echo json_encode($restaurant);
	}
	
	// View the information on a single restaurant
	function view() {
		$this->load->library('functionlib');
		$data = array();
		
		$restaurantId = $this->uri->segment(3);
		
		// Getting information from models for the views
		$this->load->model('RestaurantModel');
		$restaurant = $this->RestaurantModel->getRestaurantFromId($restaurantId);
		
			// Check to see if this restaurant is part of a chain
			$isChain = $restaurant->restaurantChainId;
			if(isset($isChain))
			{
				// Restaurant is part of a chain, get the chain menu and suppliers
				$this->load->model('RestaurantChainModel');
				$chain_menu = $this->RestaurantChainModel->getRestaurantChainMenu($restaurant->restaurantChainId);

				$this->load->model('SupplierModel');
				$chain_suppliers = $this->SupplierModel->getSupplierForCompany('', '', '', '', $restaurant->restaurantChainId, '');
			}
			else
			{
				$chain_menu = array();
				$chain_suppliers = array();
			}
		
		$this->load->model('RestaurantModel');
		$custom_menu = $this->RestaurantModel->getRestaurantMenu($restaurantId);
		
		// Merge the custom menu and chain menu into one array
		$menu = array_merge($chain_menu, $custom_menu);
		
		$this->load->model('SupplierModel');
		$custom_suppliers = $this->SupplierModel->getSupplierForCompany($restaurantId, '', '', '', '', '');
		
		// Merge the custom suppliers into one array
		$suppliers = array_merge($chain_suppliers, $custom_suppliers);
		
		// SEO
		$this->load->model('SeoModel');
		$seo = $this->SeoModel->getSeoDetailsFromPage('restaurant_detail');
		
		$seo_data_array = array(
			'restaurant_name' => $restaurant->restaurantName,
			'restaurant_type' => 'Fast Food',
			'cuisines' => 'Fast Food, American, Pizza',
		);
		
		$seo = $this->SeoModel->parseSeoData($seo, $seo_data_array);
		$data['SEO'] = $seo;
		// SEO ENDS here
		
		
		// List of views to be included
		$data['CENTER'] = array(
				'info' => '/restaurant/info',
			);
		
		$data['RIGHT'] = array(
				'image' => 'includes/right/image',
				'ad' => 'includes/right/ad',
				'map' => 'includes/right/map',
			);
		
		// Data to be passed to the views
		// Center -> Menu
		$data['data']['center']['info']['RESTAURANT'] = $restaurant;
		$data['data']['center']['menu']['MENU'] = $menu;
		$data['data']['center']['suppliers']['SUPPLIERS'] = $suppliers;
		$data['data']['center']['suppliers']['RESTAURANT_ID'] = $restaurant->restaurantId;
		
		
		// Right -> Image
		$data['data']['right']['image']['src'] = '/images/standard/restaurant-na-icon.jpg';
		$data['data']['right']['image']['width'] = '300';
		$data['data']['right']['image']['height'] = '200';
		$data['data']['right']['image']['title'] = '';
		
		// Right -> Map
		$data['data']['right']['map']['width'] = '300';
		$data['data']['right']['map']['height'] = '200';
		$data['data']['right']['map']['hide_map'] = 'no';
		
		$this->load->view('templates/center_template', $data);
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
	
	function add_supplier($id) {
		global $SUPPLIER_TYPES_2;
		$data = array();
		
		$this->load->model('RestaurantModel');
		$restaurant = $this->RestaurantModel->getRestaurantFromId($id);
		
		$this->load->model('SupplierModel','',true);
		$suppliers = $this->SupplierModel->getSupplierForCompany( $id, '', '', '', '', '' );
		
		// SEO
		$this->load->model('SeoModel');
		$seo = $this->SeoModel->getSeoDetailsFromPage('restaurant_detail');
		
		$seo_data_array = array(
			'restaurant_name' => $restaurant->restaurantName,
			'restaurant_type' => 'Fast Food',
			'cuisines' => 'Fast Food, American, Pizza',
		);
		
		$seo = $this->SeoModel->parseSeoData($seo, $seo_data_array);
		$data['SEO'] = $seo;
		// SEO ENDS here
		
		
		// List of views to be included
		$data['CENTER'] = array(
				'info' => '/restaurant/info',
				'list' => '/includes/supplier_form',
			);
		
		$data['RIGHT'] = array(
				'image' => 'includes/right/image',
				'ad' => 'includes/right/ad',
				'map' => 'includes/right/map',
			);
		
		// Data to be passed to the views
		// Center -> Menu
		$data['data']['center']['info']['RESTAURANT'] = $restaurant;
		$data['data']['center']['list']['VIEW_HEADER'] = "Add Supplier";
		//$data['data']['center']['list']['RESTAURANT'] = $restaurant;
		$data['data']['center']['list']['SUPPLIER_TYPES_2'] = $SUPPLIER_TYPES_2;
		$data['data']['center']['list']['TABLE'] = 'restaurant_supplier';
		
		// Right -> Image
		$data['data']['right']['image']['src'] = '/images/standard/restaurant-na-icon.jpg';
		$data['data']['right']['image']['width'] = '300';
		$data['data']['right']['image']['height'] = '200';
		$data['data']['right']['image']['title'] = '';
		
		// Right -> Map
		$data['data']['right']['map']['width'] = '300';
		$data['data']['right']['map']['height'] = '200';
		$data['data']['right']['map']['hide_map'] = 'no';
		
		$this->load->view('templates/center_right_template', $data);
	}
}

/* End of file restaurant.php */

?>