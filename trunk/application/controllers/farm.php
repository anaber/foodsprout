<?php

class Farm extends Controller {
	
	var $css;
	function __construct() {
		parent::Controller();
		checkUserLogin();
		checkUserAgent();

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
		$farms = $this->FarmModel->getFarmsJson();
		
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
	
	function ajaxSearchFarms() {

		$this->load->model('FarmModel', '', TRUE);
		$farms = $this->FarmModel->getFarmsJson();
		
		$this->load->model('ListModel', '', TRUE);
		$farmListHtml = $this->ListModel->buildFarmList($farms);
		
		$pagingHtml = $this->ListModel->buildPagingLinks($farms['param']);
		$array = array(
			'listHtml' => $farmListHtml,
			'pagingHtml' => $pagingHtml,
			'param' => $farms['param'],
			'geocode' => $farms['geocode'],
		);
		
		echo json_encode($array);		
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
	
	function ajaxGetAllFarmCrops() {
		$c = $this->input->post('c');
		$this->load->model('ProducerCategoryModel');
		$farmCrops = $this->ProducerCategoryModel->listProducerCategory('FARMCROPS', $c);
		echo json_encode($farmCrops);
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
		
		/** ------------------------------
		 *  AJAX stuff starts from here
		 *  ------------------------------ 
		 */
		$q = $farmId;
		$producerName = $farm->farmName;
		
		$this->load->model('ListModel', '', TRUE);
		
		$tab = $this->input->get('tab'); 
		if (!$tab || $tab == 'supplier') {
			$this->load->model('SupplierModel');
			$suppliees = $this->SupplierModel->getSupplieeForSupplierJson($q);
			$params = $suppliees['param'];
		} else if ($tab == 'menu') {
			$this->load->model('RestaurantModel', '', TRUE);
			$menus = $this->RestaurantModel->getRestaurantMenusJson($q);
			$params = $menus['param'];
		} else if ($tab == 'comment') {
			$this->load->model('CommentModel', '', TRUE);
			$comments = $this->CommentModel->getCommentsJson('restaurant', $q);
			$params = $comments['param'];
		} else if ($tab == 'photo') {
			$this->load->model('PhotoModel', '', TRUE);
			$photos = $this->PhotoModel->getPhotosJson('restaurant', $q);
			$params = $photos['param'];
		}
		
		/**
		 * Set tab on INFO pages only
		 */
		$this->ListModel->tab = 'supplier';
		$supplierTabLink = $this->ListModel->buildUrl($params);
		
		$this->ListModel->tab = 'menu';
		$menuTabLink = $this->ListModel->buildUrl($params);
		
		$this->ListModel->tab = 'comment';
		$commentTabLink = $this->ListModel->buildUrl($params);
		
		$this->ListModel->tab = 'photo';
		$photoTabLink = $this->ListModel->buildUrl($params);
		
		if (!$tab || $tab == 'supplier') {
			$this->ListModel->tab = 'supplier';
			$listHtml = $this->ListModel->buildSupplieeList($suppliees, $producerName, 'farm');
		} else if ($tab == 'menu') {
			$this->ListModel->tab = 'menu';
			$listHtml = $this->ListModel->buildMenuList($menus, $producerName, 'farm');
		} else if ($tab == 'comment') {
			$this->ListModel->tab = 'comment';
			$listHtml = $this->ListModel->buildCommentList($comments, $producerName, 'farm');
		} else if ($tab == 'photo') {
			$this->ListModel->tab = 'photo';
			$listHtml = $this->ListModel->buildPhotoList($photos, $producerName, 'farm');
		}
		$data['data']['center']['info']['LIST_DATA'] = $listHtml;
		
		$pagingHtml = $this->ListModel->buildInfoPagingLinks($params);
		$data['data']['center']['info']['PAGING_HTML'] = $pagingHtml;
		
		if ($params['numResults'] > 0) {
			$pagingHtml2 = $this->ListModel->buildInfoPagingLinks($params, '2');
			$data['data']['center']['info']['PAGING_HTML_2'] = $pagingHtml2;
		}
		
		if (! $params['filter']) {
			$params['filter'] = '';
		}
		$jsonParams = json_encode($params);
		
		$data['data']['center']['info']['PARAMS'] = $jsonParams;
		/*
		if ( isset($suppliees) ) {
			$geocode = json_encode($suppliees['geocode']);
			$data['data']['center']['info']['GEOCODE'] = $geocode;
		}
		*/
		
		$data['data']['left']['filter']['PARAMS'] = $params;
		
		$data['data']['left']['img']['PHOTO_TAB_LINK'] = $photoTabLink;
		$data['data']['center']['info']['SUPPLIER_TAB_LINK'] = $supplierTabLink;
		$data['data']['center']['info']['MENU_TAB_LINK'] = $menuTabLink;
		$data['data']['center']['info']['COMMENT_TAB_LINK'] = $commentTabLink;
		$data['data']['center']['info']['PHOTO_TAB_LINK'] = $photoTabLink;
		$data['data']['center']['info']['CURRENT_TAB'] = $this->ListModel->tab;
		
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
		if (!$q) {
			$q = $this->input->get('q');
		}
		$this->load->model('SupplierModel');
		$suppliees = $this->SupplierModel->getSupplieeForSupplierJson($q);
		
		$this->load->model('FarmModel');
		$farm = $this->FarmModel->getFarmFromId($q);
		$producerName = $farm->farmName;
		
		$this->load->model('ListModel', '', TRUE);
		$supplieeListHtml = $this->ListModel->buildSupplieeList($suppliees, $producerName, 'farm');
		$this->ListModel->tab = 'supplier';
		
		$pagingHtml = $this->ListModel->buildInfoPagingLinks($suppliees['param']);
		
		$array = array(
			'listHtml' => $supplieeListHtml,
			'pagingHtml' => $pagingHtml,
			'param' => $suppliees['param'],
			//'geocode' => $suppliees['geocode'],
		);
		
		if ($suppliees['param']['numResults'] > 0) {
			$pagingHtml2 = $this->ListModel->buildInfoPagingLinks($suppliees['param'], '2');
			$array['pagingHtml2'] = $pagingHtml2;
		}
		
		echo json_encode($array);
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
		
		$q = $this->input->post('q'); 
		if (!$q) {
			$q = $this->input->get('q');
		}
		
		$this->load->model('FarmModel');
		$farm = $this->FarmModel->getFarmFromId($q);
		$producerName = $farm->farmName;
		
		$this->load->model('ListModel', '', TRUE);
		$menuListHtml = $this->ListModel->buildCommentList($comments, $producerName, 'farm');
		$this->ListModel->tab = 'comment';
		
		$pagingHtml = $this->ListModel->buildInfoPagingLinks($comments['param']);
		//$pagingHtml2 = $this->ListModel->buildInfoPagingLinks($comments['param'], '2');
		
		$array = array(
			'listHtml' => $menuListHtml,
			'pagingHtml' => $pagingHtml,
			//'pagingHtml2' => $pagingHtml2,
			'param' => $comments['param'],
			//'geocode' => $suppliers['geocode'],
		);
		
		echo json_encode($array);
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
		$photos = $this->PhotoModel->getPhotosJson('farm');
		
		$q = $this->input->post('q'); 
		if (!$q) {
			$q = $this->input->get('q');
		}
		
		$this->load->model('FarmModel');
		$farm = $this->FarmModel->getFarmFromId($q);
		$producerName = $farm->farmName;
		
		$this->load->model('ListModel', '', TRUE);
		$photoListHtml = $this->ListModel->buildPhotoList($photos, $producerName, 'farm');
		$this->ListModel->tab = 'photo';
		
		$pagingHtml = $this->ListModel->buildInfoPagingLinks($photos['param']);
		//$pagingHtml2 = $this->ListModel->buildInfoPagingLinks($photos['param'], '2');
		
		$array = array(
			'listHtml' => $photoListHtml,
			'pagingHtml' => $pagingHtml,
			//'pagingHtml2' => $pagingHtml2,
			'param' => $photos['param'],
			//'geocode' => $suppliers['geocode'],
		);
		
		echo json_encode($array);
	}
}

/* End of file farm.php */

?>