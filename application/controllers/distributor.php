<?php

class Distributor extends Controller {
	
	function index() {
		$data = array();
		
		// Views to include in the data array
		$data['CENTER'] = array(
				'list' => '/restaurant/distributor_list',
			);
		
		$data['RIGHT'] = array(
				'ad' => 'includes/left/ad',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "List of Fast Food Resturants";
		
		$this->load->view('templates/center_right_narrow_template', $data);
		
		/*
		global $GOOGLE_MAP_KEY;
		
		$data = array();
		
		// Getting information from models
		$this->load->model('DistributorModel');
		$distributors = $this->DistributorModel->listDistributor();
		
		// List of views to be included
		$data['CENTER'] = array(
				'map' => 'includes/map',
				'list' => '/distributor/distributor_list',
			);
		
		$data['LEFT'] = array(
				'ad' => 'includes/left/ad',
			);
		
		// Data to be passed to the views
		$data['data']['left']['filter']['VIEW_HEADER'] = "Filters";
		
		$data['data']['center']['map']['GOOGLE_MAP_KEY'] = $GOOGLE_MAP_KEY;
		$data['data']['center']['map']['VIEW_HEADER'] = "Map";
		$data['data']['center']['map']['width'] = '790';
		$data['data']['center']['map']['height'] = '250';
		
		$data['data']['center']['list']['LIST'] = $distributors;
		$data['data']['center']['list']['VIEW_HEADER'] = "List of Distributor";		
		
		$this->load->view('templates/left_center_template', $data);
		*/
		
	}
	
	function view($id) {
		
		global $GOOGLE_MAP_KEY;
		
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'menu' => '/distributor/distributor_detail',
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
		$data['data']['right']['image']['title'] = 'Distributor Image';
		
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

/* End of file distributor.php */

?>