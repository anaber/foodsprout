<?php

class Farm extends Controller {
	
	var $css;
	function __construct()
	{
		parent::Controller();
		if ($this->session->userdata('isAuthenticated') != 1 )
		{
			redirect('about/privatebeta');
		}
		$this->css = array(
			'farm',
		);
	}
	
	function index() {
		global $FARM_RADIUS, $FARM_DEFAULT_RADIUS;
		$data = array();
		
		// SEO
		$this->load->model('SeoModel');
		$seo = $this->SeoModel->getSeoDetailsFromPage('farm_list');
		$data['SEO'] = $seo;
		
		$q = $this->input->post('q');
		$f = $this->input->post('f');

		if ( !empty($f) ) {
			$data['CENTER'] = array(
				'list' => '/farm/farm_list',
			);
		} else {
			// List of views to be included
			$data['CENTER'] = array(
					'map' => 'includes/map',
					'list' => '/farm/farm_list',
				);
		}
		
		if ( !empty($f) ) {
			$data['LEFT'] = array(
					//'ad' => 'includes/banners/sky',
				);
		} else {
			$data['LEFT'] = array(
					'filter' => 'includes/left/farm_filter'
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
		
		$data['data']['center']['list']['q'] = $q;
		$data['data']['center']['list']['f'] = $f;
		if ( !empty($f) ) {
			$data['data']['center']['list']['hide_map'] = 'yes';
			$data['data']['center']['list']['hide_filters'] = 'yes';
		} else {
			$data['data']['center']['list']['hide_map'] = 'no';
			$data['data']['center']['list']['hide_filters'] = 'no';
		}
		
		$data['CSS'] = array(
						'listing',
						$this->css,
					);
		
		$this->load->view('templates/left_center_template', $data);
	}
	
	function ajaxSearchFarms() {
		$this->load->model('FarmModel', '', TRUE);
		$restaurants = $this->FarmModel->getFarmsJson();
		echo json_encode($restaurants);
	}
	
	function ajaxGetDistinctUsedFarmType() {
		$c = $this->input->post('c');
		$this->load->model('FarmModel');
		$farmTypes = $this->FarmModel->getDistinctUsedFarmType($c);
		echo json_encode($farmTypes);
	}
	
	function ajaxGetAllFarmType() {
		$c = $this->input->post('c');
		$this->load->model('FarmTypeModel');
		$farmTypes = $this->FarmTypeModel->listFarmType($c);
		echo json_encode($farmTypes);
	}
	
	function ajaxSearchFarmInfo() {
		$farmId = $this->input->post('farmId');
		$this->load->model('FarmModel', '', TRUE);
		$farm = $this->FarmModel->getFarmFromId($farmId);
		echo json_encode($farm);
	}
	
	// View the information on a single restaurant
	function view() {
		/*
		$this->load->library('functionlib');
		$data = array();
		
		$farmId = $this->uri->segment(3);
		
		$this->load->model('FarmModel');
		$farm = $this->FarmModel->getFarmFromId($farmId);
		
		$this->load->model('SupplierModel');
		$companies = $this->SupplierModel->getCompaniesForSupplier('', $farmId, '', '');
		
		// SEO
		$this->load->model('SeoModel');
		$seo = $this->SeoModel->getSeoDetailsFromPage('farm_detail');
		
		$seo_data_array = array(
			'farm_name' => $farm->farmName,
			'restaurant_type' => 'Fast Food',
			'cuisines' => 'Fast Food, American, Pizza',
		);
		
		$seo = $this->SeoModel->parseSeoData($seo, $seo_data_array);
		$data['SEO'] = $seo;
		// SEO ENDS here
		
		// List of views to be included
		$data['CENTER'] = array(
				'info' => '/farm/info',
				'companies' => '/farm/companies',
			);
		
		$data['RIGHT'] = array(
				'image' => 'includes/right/image',
				'ad' => 'includes/right/ad',
				'map' => 'includes/right/map',
			);
		 
		// Data to be passed to the views
		// Center -> Menu
		$data['data']['center']['info']['FARM'] = $farm;
		$data['data']['center']['companies']['COMPANIES'] = $companies;
		
		// Right -> Image
		$data['data']['right']['image']['src'] = '/img/standard/restaurant-na-icon.jpg';
		$data['data']['right']['image']['width'] = '300';
		$data['data']['right']['image']['height'] = '200';
		$data['data']['right']['image']['title'] = '';
		
		// Right -> Map
		$data['data']['right']['map']['width'] = '300';
		$data['data']['right']['map']['height'] = '200';
		$data['data']['right']['map']['hide_map'] = 'no';
		
		// Custom CSS
		if (!empty ($this->css) ) {
			$data['CSS'] = $this->css;
		}
		
		$this->load->view('templates/center_template', $data);
		*/
		
		global $SUPPLIER_TYPES_2;
		
		$data = array();

		$farmId = $this->uri->segment(3);

		// Getting information from models
		$this->load->model('FarmModel');
		$farm = $this->FarmModel->getFarmFromId($farmId);

		$this->load->model('ProductTypeModel');
		$productTypes = $this->ProductTypeModel->listProductType();

		// SEO
		$this->load->model('SeoModel');
		$seo = $this->SeoModel->getSeoDetailsFromPage('farm_detail');

		$seo_data_array = array(
			'farm_name' => $farm->farmName,
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
				'info' => 'includes/left/info',
			);

		// Load all the views for the center column
		$data['CENTER'] = array(
				'info' => '/farm/info',
			);

		// Load all the views for the right column
		$data['RIGHT'] = array(
				'ad' => 'includes/banners/sky',
			);

		// Data to be passed to the views
		// Center -> Info
		$data['data']['center']['info']['SUPPLIER_TYPES_2'] = $SUPPLIER_TYPES_2;
		$data['data']['center']['info']['PRODUCT_TYPES'] = $productTypes;
		$data['data']['center']['info']['TABLE'] = 'farm_supplier';
		
		// Left -> Map
		$data['data']['left']['map']['width'] = '225';
		$data['data']['left']['map']['height'] = '225';
		$data['data']['left']['map']['hide_map'] = 'no';
		
		// Left -> Info
		$INFO = array (
					'url' => $farm->url,
					'facebook' => $farm->facebook,
					'twitter' => $farm->twitter,
				);
		$data['data']['left']['info']['INFO'] = $INFO;
		
		$data['FARM'] = $farm;
		
		$data['NAME'] = array(
							$farm->farmName => '',
							);
		
		// Custom CSS
		if (!empty ($this->css) ) {
			$data['CSS'] = array(
							'restaurant'
						);
		}
		
		$this->load->view('templates/left_center_right_template', $data);
	}
	
	function ajaxSearchFarmCompanies() {
		$q = $this->input->post('q');
		$this->load->model('SupplierModel');
		$companies = $this->SupplierModel->getCompaniesForSupplierJson('', $q, '', '');
			
		echo json_encode($companies);
	}
	
}

/* End of file farm.php */

?>