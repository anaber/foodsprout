<?php

class Farm extends Controller {
	
	function index() {
		global $GOOGLE_MAP_KEY;
		
		$data = array();
		
		// Getting information from models
		$this->load->model('FarmModel');
		$farms = $this->FarmModel->listFarm();
		
		$this->load->model('FarmTypeModel');
		$farmTypes = $this->FarmTypeModel->listFarmType();
		
		
		// List of views to be included
		$data['CENTER'] = array(
				'map' => 'includes/map',
				'list' => '/farm/farm_list',
			);
		
		$data['LEFT'] = array(
				'filter' => 'includes/left/farm_filter',
				'ad' => 'includes/left/ad',
			);
		
		// Data to be passed to the views
		$data['data']['left']['filter']['VIEW_HEADER'] = "Filters";
		$data['data']['left']['filter']['FARMTYPES'] = $farmTypes;
		
		$data['data']['center']['map']['GOOGLE_MAP_KEY'] = $GOOGLE_MAP_KEY;
		$data['data']['center']['map']['VIEW_HEADER'] = "Map";
		$data['data']['center']['map']['width'] = '790';
		$data['data']['center']['map']['height'] = '250';
		
		$data['data']['center']['list']['LIST'] = $farms;
		$data['data']['center']['list']['VIEW_HEADER'] = "List of Farms";
		
		
		
		$this->load->view('templates/left_center_template', $data);
	}
	
	function view() {
		
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'farm/farm_details',
			);
		
		$data['RIGHT'] = array(
				'image' => 'includes/right/image',
				'ad' => 'includes/right/ad',
				'map' => 'includes/right/map',
			);
		
		// Data to be passed to the views
		// Center -> Ingredients		
		$data['data']['center']['products']['VIEW_HEADER'] = "List of producst from Farm";
		
		// Right -> Image
		$data['data']['right']['image']['src'] = '/images/standard/farm-na-icon.jpg';
		$data['data']['right']['image']['width'] = '300';
		$data['data']['right']['image']['height'] = '200';
		$data['data']['right']['image']['title'] = 'McDonalds';
		
		// Center -> Map
		$data['data']['right']['map']['VIEW_HEADER'] = "Farm Location";
		$data['data']['right']['map']['width'] = '300';
		$data['data']['right']['map']['height'] = '200';
		
		$this->load->view('templates/center_right_template', $data);
	}
	
}

/* End of file farm.php */

?>