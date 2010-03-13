<?php

class Farm extends Controller {
	
	function index() {
		global $GOOGLE_MAP_KEY;
		
		$data = array();
		
		// Getting information from models
		//$this->load->model('FarmModel');
		//$farms = $this->FarmModel->list_farm();
		$farms = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'farm/farm_list',
			);
		
		$data['RIGHT'] = array(
				'map' => 'includes/map',
				'ad' => 'includes/right/ad',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['LIST'] = $farms;
		$data['data']['center']['list']['VIEW_HEADER'] = "Farm List";
		
		$data['data']['right']['map']['GOOGLE_MAP_KEY'] = $GOOGLE_MAP_KEY;
		$data['data']['right']['map']['VIEW_HEADER'] = "Google Map";
		$data['data']['right']['map']['width'] = '300';
		$data['data']['right']['map']['height'] = '200';
		
		$this->load->view('templates/center_right_template', $data);
	}
	
	function detail($id) {
		
		global $GOOGLE_MAP_KEY;
		
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'farm/farm_details',
				'items' => 'item/item_list',
				'products' => 'product/product_list',
			);
		
		$data['RIGHT'] = array(
				'image' => 'includes/right/image',
				'ad' => 'includes/right/ad',
				'map' => 'includes/map',
				'company' => 'includes/right/company_list',
			);
		
		// Data to be passed to the views
		// Center -> Ingredients		
		$data['data']['center']['products']['VIEW_HEADER'] = "List of producst from Farm";
		
		// Right -> Image
		$data['data']['right']['image']['src'] = '/images/logo/mcdonalds.jpg';
		$data['data']['right']['image']['width'] = '300';
		$data['data']['right']['image']['height'] = '200';
		$data['data']['right']['image']['title'] = 'McDonalds';
		
		// Center -> Map
		$data['data']['right']['map']['GOOGLE_MAP_KEY'] = $GOOGLE_MAP_KEY;
		$data['data']['right']['map']['VIEW_HEADER'] = "Farm Location";
		$data['data']['right']['map']['width'] = '300';
		$data['data']['right']['map']['height'] = '200';
		
		
		
		$data['data']['right']['info']['VIEW_HEADER'] = "Product Info";
		
		$data['data']['right']['nutrition']['VIEW_HEADER'] = "Nutritional Information";
		
		$this->load->view('templates/center_right_template', $data);
	}
	
}

/* End of file farm.php */

?>