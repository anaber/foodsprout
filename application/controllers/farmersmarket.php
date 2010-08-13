<?php

class FarmersMarket extends Controller {
	
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
		$seo = $this->SeoModel->getSeoDetailsFromPage('farmers_market_list');
		$data['SEO'] = $seo;
		
		$q = $this->input->post('q');
		$f = $this->input->post('f');

		if ( !empty($f) ) {
			$data['CENTER'] = array(
				'list' => '/farmers_market/farmers_market_list',
			);
		} else {
			// List of views to be included
			$data['CENTER'] = array(
					'map' => 'includes/map',
					'list' => '/farmers_market/farmers_market_list',
				);
		}
		
		if ( !empty($f) ) {
			$data['LEFT'] = array(
					
				);
		} else {
			$data['LEFT'] = array(
					'filter' => 'includes/left/farmers_market_filter',
					
				);
		}
		
		// Data to be passed to the views
		if ( empty($f) ) {
		//$data['data']['left']['filter']['VIEW_HEADER'] = "Filters";
		}
		
		if ( empty($f) ) {
		//$data['data']['center']['map']['VIEW_HEADER'] = "Map";
		$data['data']['center']['map']['width'] = '795';
		$data['data']['center']['map']['height'] = '250';
		}
		
		//$data['data']['center']['list']['VIEW_HEADER'] = "Farmers Market";
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
	
	function ajaxSearchFarmersMarket() {
		$this->load->model('FarmersMarketModel', '', TRUE);
		$farmersMarket = $this->FarmersMarketModel->getFarmersMarketJson();
		echo json_encode($farmersMarket);
	}
	
	function ajaxSearchFarmersMarketInfo() {
		$farmersMarketId = $this->input->post('farmersMarketId');
		$this->load->model('FarmersMarketModel', '', TRUE);
		$farmersMarket = $this->FarmersMarketModel->getFarmersMarketFromId($farmersMarketId);
		echo json_encode($farmersMarket);
	}
	
	// View the information on a single restaurant
	function view() {
		$this->load->library('functionlib');
		$data = array();
		
		$farmersMarketId = $this->uri->segment(3);
		
		$this->load->model('FarmersMarketModel');
		$farmersMarket = $this->FarmersMarketModel->getFarmersMarketFromId($farmersMarketId);
		
		$this->load->model('SupplierModel');
		$suppliers = $this->SupplierModel->getSupplierForCompany('', '', '', '', '', $farmersMarketId );
		
		
		// SEO
		$this->load->model('SeoModel');
		$seo = $this->SeoModel->getSeoDetailsFromPage('farm_detail');
		
		$seo_data_array = array(
			'farmers_market_name' => $farmersMarket->farmersMarketName,
			'restaurant_type' => 'Fast Food',
			'cuisines' => 'Fast Food, American, Pizza',
		);
		
		$seo = $this->SeoModel->parseSeoData($seo, $seo_data_array);
		$data['SEO'] = $seo;
		// SEO ENDS here
		
		// List of views to be included
		$data['CENTER'] = array(
				'info' => '/farmers_market/info',
				'suppliers' => '/farmers_market/suppliers',
			);
		
		$data['RIGHT'] = array(
				'image' => 'includes/right/image',
				'ad' => 'includes/right/ad',
				'map' => 'includes/right/map',
			);
		
		
		 
		// Data to be passed to the views
		// Center -> Menu
		$data['data']['center']['info']['FARMERS_MARKET'] = $farmersMarket;
		//$data['data']['center']['companies']['COMPANIES'] = $companies;
		$data['data']['center']['suppliers']['SUPPLIERS'] = $suppliers;
		
		
		// Right -> Image
		$data['data']['right']['image']['src'] = '/img/standard/restaurant-na-icon.jpg';
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

/* End of file farm.php */

?>