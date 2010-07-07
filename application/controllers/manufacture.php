<?php

class Manufacture extends Controller {
	
	function index() {
		$data = array();
		
		// Views to include in the data array
		$data['CENTER'] = array(
				'list' => '/manufacture/manufacture_list',
			);
		
		$data['RIGHT'] = array(
				'ad' => 'includes/left/ad',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "List of Manufacture";
		
		$this->load->view('templates/center_right_narrow_template', $data);
	}
	
	function ajaxSearchManufactures() {
		$this->load->model('ManufactureModel', '', TRUE);
		$restaurants = $this->ManufactureModel->getManufactureJson();
		echo json_encode($restaurants);
	}
	
	function view($id) {
		
		global $GOOGLE_MAP_KEY;
		
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'menu' => '/manufacture/product',
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
		$data['data']['right']['image']['title'] = 'Manufacture Image';
		
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

/* End of file manufacture.php */

?>