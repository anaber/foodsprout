<?php

class Company extends Controller {
	
	function __construct()
	{
		parent::Controller();
		if ($this->session->userdata('isAuthenticated') != 1 )
		{
			redirect('about/privatebeta');
		}
	}
	
	function index() {
		global $GOOGLE_MAP_KEY;
		
		$data = array();
		
		// Getting information from models
		$this->load->model('CompanyModel');
		$companies = $this->CompanyModel->list_company();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'company/company_list',
			);
		
		$data['RIGHT'] = array(
				'map' => 'includes/map',
				'ad' => 'includes/right/ad',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['LIST'] = $companies;
		$data['data']['center']['list']['VIEW_HEADER'] = "Company List";
		
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
				'list' => 'product/product_list',
			);
		
		$data['RIGHT'] = array(
				'image' => 'includes/right/image',
				'ad' => 'includes/right/ad',
				'map' => 'includes/map',
				'company' => 'company/distribution_center',
			);
		
		$data['BREADCRUMB'] = array(
				'Home' => '/home',
				'McDonald' => '',
			);
		
		// Data to be passed to the views
		// Center -> Ingredients		
		$data['data']['center']['ingredients']['INGREDIENTS'] = array('cheese', 'meat', 'pepper');
		
		// Right -> Image
		$data['data']['right']['image']['src'] = '/img/logo/mcdonalds.jpg';
		$data['data']['right']['image']['width'] = '300';
		$data['data']['right']['image']['height'] = '200';
		$data['data']['right']['image']['title'] = 'McDonalds';
		
		// Center -> Map
		$data['data']['right']['map']['GOOGLE_MAP_KEY'] = $GOOGLE_MAP_KEY;
		$data['data']['right']['map']['VIEW_HEADER'] = "Company Location";
		$data['data']['right']['map']['width'] = '300';
		$data['data']['right']['map']['height'] = '200';
		
		
		
		$data['data']['right']['info']['VIEW_HEADER'] = "Product Info";
		
		$data['data']['right']['nutrition']['VIEW_HEADER'] = "Nutritional Information";
		
		$this->load->view('templates/center_right_template', $data);
	}
	
	function distribution($id) {
		
		global $GOOGLE_MAP_KEY;
		
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'distribution/distribution_detail',
			);
		
		$data['RIGHT'] = array(
				'image' => 'includes/right/image',
				'ad' => 'includes/right/ad',
				'map' => 'includes/map',
			);
		
		// Data to be passed to the views
		
		// Right -> Image
		$data['data']['right']['image']['src'] = '/img/logo/mcdonalds.jpg';
		$data['data']['right']['image']['width'] = '300';
		$data['data']['right']['image']['height'] = '200';
		$data['data']['right']['image']['title'] = 'McDonalds';
		
		// Center -> Map
		$data['data']['right']['map']['GOOGLE_MAP_KEY'] = $GOOGLE_MAP_KEY;
		$data['data']['right']['map']['VIEW_HEADER'] = "Location";
		$data['data']['right']['map']['width'] = '300';
		$data['data']['right']['map']['height'] = '200';
		
		
		
		
		$this->load->view('templates/center_right_template', $data);
	}
	
}

/* End of file company.php */

?>