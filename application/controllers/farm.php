<?php

class Farm extends Controller {
	
	var $css;
	function __construct() {
		parent::Controller();
		checkUserLogin();
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
		
		// CSS files to use
		$data['CSS'] = array(
						'listing',
						'jquery-ui/jquery.ui.slider',
						'jquery-ui/jquery.ui.theme',
					);
		
		$this->load->model('FarmModel', '', TRUE);
		$farms = $this->FarmModel->getFarmsJson2();
		
		$this->load->model('ListModel', '', TRUE);
		$farmListHtml = $this->ListModel->buildFarmList($farms);
		$data['data']['center']['list']['LIST_DATA'] = $farmListHtml;

		$pagingHtml = $this->ListModel->buildPagingLinks($farms['param']);
		$data['data']['center']['list']['PAGING_HTML'] = $pagingHtml;
		
		if (! $farms['param']['filter']) {
			$farms['param']['filter'] = '';
		}
		$params = json_encode($farms['param']);
		
		$data['data']['center']['list']['PARAMS'] = $params;
		
		$geocode = json_encode($farms['geocode']);
		$data['data']['center']['list']['GEOCODE'] = $geocode;
		
		$data['data']['left']['filter']['PARAMS'] = $farms['param'];
		
		$this->load->view('templates/left_center_template', $data);
	}
	
	/*
	function ajaxSearchFarms() {
		$this->load->model('FarmModel', '', TRUE);
		$restaurants = $this->FarmModel->getFarmsJson2();
		echo json_encode($restaurants);
	}
	*/
	
	function ajaxSearchFarms() {

		$this->load->model('FarmModel', '', TRUE);
		$farms = $this->FarmModel->getFarmsJson2();
		//echo json_encode($restaurants);
		
		$this->load->model('ListModel', '', TRUE);
		$farmListHtml = $this->ListModel->buildFarmList($farms);
		
		//$data['data']['center']['list']['LIST_DATA'] = $restaurantListHtml;
		$pagingHtml = $this->ListModel->buildPagingLinks($farms['param']);
		$array = array(
			'listHtml' => $farmListHtml,
			'pagingHtml' => $pagingHtml,
			'param' => $farms['param'],
			'geocode' => $farms['geocode'],
		);
		
		echo json_encode($array);
		//$data['data']['center']['list']['PAGING_HTML'] = $pagingHtml;
		
	}
	
	function ajaxGetDistinctUsedFarmType() {
		$c = $this->input->post('c');
		$this->load->model('FarmModel');
		$farmTypes = $this->FarmModel->getDistinctUsedFarmType($c);
		echo json_encode($farmTypes);
	}
	
	/**
	 * Migration: 		Done
	 * Migrated by: 	Deepak
	 * 
	 * Verified: 		Yes
	 * Verified By: 	Deepak
	 */
	function ajaxGetAllFarmType() {
		$c = $this->input->post('c');
		$this->load->model('ProducerCategoryModel');
		$farmTypes = $this->ProducerCategoryModel->listProducerCategory('FARM', $c);
		echo json_encode($farmTypes);
	}
	
	function ajaxSearchFarmInfo() {
		$farmId = $this->input->post('farmId');
		$addressId = $this->input->post('addressId');
		$this->load->model('FarmModel', '', TRUE);
		$farm = $this->FarmModel->getFarmFromId($farmId,$addressId);
		echo json_encode($farm);
	}

	
	//farm custom url
	function customUrl($customUrl){
		$this->load->model('CustomUrlModel');
		$producer = $this->CustomUrlModel->getProducerIdFromCustomUrl($customUrl, 'farm');
		
		if ($producer) {
			$this->view($producer->producerId, $producer->addressId);
		} else {
			show_404('page');
		}
	}
	
	// View the information on a single farm
	function view($farmId = '', $addressId = '') {
		
		global $SUPPLIER_TYPES_2;
		
		$this->load->plugin('Visits');
		$visits = new Visits();
		$visits->addProducer($farmId);
		$data = array();
		
		if($farmId == ''){
			$farmId = $this->uri->segment(3);
		}

		$this->load->model('PhotoModel');
		$thumbPhotos = $this->PhotoModel->getThumbPhotos('producer', $farmId);
		
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
				'info' => 'includes/left/info',
				'map' => 'includes/right/map',
			);

		// Load all the views for the center column
		$data['CENTER'] = array(
				'info' => '/farm/info',
			);

		// Load all the views for the right column
		$data['RIGHT'] = array(
				//'ad' => 'includes/banners/sky',
			);

		// Data to be passed to the views
		// Center -> Info
		$data['data']['center']['info']['SUPPLIER_TYPES_2'] = $SUPPLIER_TYPES_2;
		$data['data']['center']['info']['PRODUCT_TYPES'] = $productTypes;
		$data['data']['center']['info']['ADDRESS_ID'] = $addressId;
		$data['data']['center']['info']['TABLE'] = 'farm_supplier';
		
		// Left -> Map
		$data['data']['left']['map']['width'] = '220';
		$data['data']['left']['map']['height'] = '225';
		$data['data']['left']['map']['hide_map'] = 'no';
		
		// Left -> Images
		$data['data']['left']['img']['PHOTOS'] = $thumbPhotos;
		
		// Left -> Info
		$INFO = array (
					'url' => $farm->url,
					'facebook' => $farm->facebook,
					'twitter' => $farm->twitter,
				);
		$data['data']['left']['info']['INFO'] = $INFO;
		$data['data']['left']['info']['FARM'] = $farm;
		
		$data['FARM'] = $farm;
		
		$data['NAME'] = array(
							$farm->farmName => '',
							);
		
		// Custom CSS
		if (!empty ($this->css) ) {
			$data['CSS'] = array(
							'restaurant',
							'supplier',
							'floating_messages'
						);
		}
		
		$this->load->view('templates/left_center_detail_template', $data);
	}
	
	/**
	 * Not used any more
	 * Can be removed
	 */
	function ajaxSearchFarmCompanies() {
		$q = $this->input->post('q');
		$this->load->model('SupplierModel');
		$companies = $this->SupplierModel->getCompaniesForSupplierJson('', $q, '', '');
			
		echo json_encode($companies);
	}
	
	/**
	 * Migration: 		Done
	 * Migrated by: 	Deepak
	 * 
	 * Verified: 		Yes
	 * Verified By: 	Deepak
	 */
	function ajaxSearchFarmSuppliee() {
		$q = $this->input->post('q');
		//$q = 176022;
		$this->load->model('SupplierModel');
		$suppliee = $this->SupplierModel->getSupplieeForSupplierJson($q);
			
		echo json_encode($suppliee);
	}
	
	/**
	 * Migration: 		Done
	 * Migrated by: 	Deepak
	 * 
	 * Verified: 		Yes
	 * Verified By: 	Deepak
	 */
	function ajaxSearchFarmComments() {
		$this->load->model('CommentModel', '', TRUE);
		$comments = $this->CommentModel->getCommentsJson('farm');
		echo json_encode($comments);
	}
	
	/**
	 * Migration: 		Done
	 * Migrated by: 	Deepak
	 * 
	 * Verified: 		Yes
	 * Verified By: 	Deepak
	 */
	function ajaxSearchFarmPhotos() {
		$this->load->model('PhotoModel', '', TRUE);
		$comments = $this->PhotoModel->getPhotosJson('farm');
		echo json_encode($comments);
	}
}

/* End of file farm.php */

?>