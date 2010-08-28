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
		global $FARM_RADIUS, $FARM_DEFAULT_RADIUS;
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
		$data['data']['left']['filter']['FARM_RADIUS'] = $FARM_RADIUS;
		$data['data']['left']['filter']['FARM_DEFAULT_RADIUS'] = $FARM_DEFAULT_RADIUS;
		
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
		global $SUPPLIER_TYPES_2;
		
		$data = array();

		$farmersMarketId = $this->uri->segment(3);

		// Getting information from models
		$this->load->model('FarmersMarketModel');
		$farmersMarket = $this->FarmersMarketModel->getFarmersMarketFromId($farmersMarketId);

		$this->load->model('ProductTypeModel');
		$productTypes = $this->ProductTypeModel->listProductType();

		// SEO
		$this->load->model('SeoModel');
		$seo = $this->SeoModel->getSeoDetailsFromPage('farm_detail');

		$seo_data_array = array(
			'farm_name' => $farmersMarket->farmersMarketName,
			'restaurant_type' => 'Fast Food',
			'cuisines' => 'Fast Food, American, Pizza',
		);

		$seo = $this->SeoModel->parseSeoData($seo, $seo_data_array);
		$data['SEO'] = $seo;
		// SEO ENDS here

		// List of views to be included, these are files that are pulled from different views in the view folders

		// Load all the views for the center column
		$data['LEFT'] = array(
				'img' => '/includes/left/images',
				'map' => 'includes/right/map',
			);


		// Load all the views for the center column
		$data['CENTER'] = array(
				'info' => '/farmers_market/info',
			);

		// Load all the views for the right column
		$data['RIGHT'] = array(
				'ad' => 'includes/banners/sky',
			);

		// Data to be passed to the views
		// Center -> Info
		$data['data']['center']['info']['SUPPLIER_TYPES_2'] = $SUPPLIER_TYPES_2;
		$data['data']['center']['info']['PRODUCT_TYPES'] = $productTypes;
		$data['data']['center']['info']['TABLE'] = 'farmers_market_supplier';
		
		// Left -> Map
		$data['data']['left']['map']['width'] = '225';
		$data['data']['left']['map']['height'] = '225';
		$data['data']['left']['map']['hide_map'] = 'no';
		
		$data['FARMERS_MARKET'] = $farmersMarket;
		
		$data['NAME'] = array(
							$farmersMarket->farmersMarketName => '',
							);
		
		// Custom CSS
		$data['CSS'] = array(
						'restaurant'
						);
		
		
		$this->load->view('templates/left_center_right_template', $data);
	}
	
	function ajaxSearchFarmersMarketSuppliers() {
		$q = $this->input->post('q');
		$this->load->model('SupplierModel');
		$suppliers = $this->SupplierModel->getSupplierForCompanyJson('', '', '', '', '', $q);

		echo json_encode($suppliers);
	}
	
}

/* End of file farm.php */

?>