<?php

class FarmersMarket extends Controller {
	
	function __construct() {
		parent::Controller();
		checkUserLogin();
		checkUserAgent($this->uri->segment(1), $this->uri->segment(2));
	}
	
	function index() {
		global $FARMERS_MARKET_RADIUS, $FARMERS_MARKET_DEFAULT_RADIUS;
		$data = array();
		
		// SEO
		$this->load->model('SeoModel');
		$seo = $this->SeoModel->getSeoDetailsFromPage('farmers_market_list');
		$data['SEO'] = $seo;
		
		$q = $this->input->post('q');
		$f = $this->input->post('f');

		//$this->load->model('FarmersMarketModel', '', TRUE);
		//$farmersMarket = $this->FarmersMarketModel->getFarmersMarketJson();

        // get featured cities for sidebar
        $this->getLeftFeaturedCities($data);
		
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
		$data['data']['left']['filter']['FARMERS_MARKET_RADIUS'] = $FARMERS_MARKET_RADIUS;
		$data['data']['left']['filter']['FARMERS_MARKET_DEFAULT_RADIUS'] = $FARMERS_MARKET_DEFAULT_RADIUS;
		
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
		
		// CSS files to use
		$data['CSS'] = array(
			'listing',
			'jquery-ui/jquery.ui.slider',
			'jquery-ui/jquery.ui.theme',
		);
		
		$this->load->model('FarmersMarketModel', '', TRUE);
		$farmersMarket = $this->FarmersMarketModel->getFarmersMarketJson();
		
		$this->load->model('ListModel', '', TRUE);
		$farmersMarketListHtml = $this->ListModel->buildFarmersMarketList($farmersMarket);
		$data['data']['center']['list']['LIST_DATA'] = $farmersMarketListHtml;

		$pagingHtml = $this->ListModel->buildPagingLinks($farmersMarket['param']);
		$data['data']['center']['list']['PAGING_HTML'] = $pagingHtml;
		
		if (! $farmersMarket['param']['filter']) {
			$farmersMarket['param']['filter'] = '';
		}
		$params = json_encode($farmersMarket['param']);
		
		$data['data']['center']['list']['PARAMS'] = $params;
		
		$geocode = json_encode($farmersMarket['geocode']);
		$data['data']['center']['list']['GEOCODE'] = $geocode;
		
		$data['data']['left']['filter']['PARAMS'] = $farmersMarket['param'];
		
		$this->load->view('templates/left_center_template', $data);
	}
	
	function ajaxSearchFarmersMarket() {

		$this->load->model('FarmersMarketModel', '', TRUE);
		$farmersMarket = $this->FarmersMarketModel->getFarmersMarketJson();
		
		$this->load->model('ListModel', '', TRUE);
		$farmersMarketListHtml = $this->ListModel->buildFarmersMarketList($farmersMarket);
		
		$pagingHtml = $this->ListModel->buildPagingLinks($farmersMarket['param']);
		$array = array(
			'listHtml' => $farmersMarketListHtml,
			'pagingHtml' => $pagingHtml,
			'param' => $farmersMarket['param'],
			'geocode' => $farmersMarket['geocode'],
		);
		
		echo json_encode($array);
	}
	
	function ajaxSearchFarmersMarketInfo() {
		$farmersMarketId = $this->input->post('farmersMarketId');
		$addressId = $this->input->post('addressId');
		$this->load->model('FarmersMarketModel', '', TRUE);
		$farmersMarket = $this->FarmersMarketModel->getFarmersMarketFromId($farmersMarketId,$addressId);
		echo json_encode($farmersMarket);
	}
	
	
	//farm custom url
	function customUrl($customUrl){
		$this->load->model('CustomUrlModel');
		$producer = $this->CustomUrlModel->getProducerIdFromCustomUrl($customUrl, 'farmers_market');
		
		if ($producer) {
					
			$this->view($producer->producerId, $producer->addressId);
		} else {
			show_404('page');
		}
	}
	
	// View the information on a single restaurant
	function view($farmersMarketId = '', $addressId = '') {
		global $SUPPLIER_TYPES_2;
		
		$this->load->plugin('Visits');
		
		$visits = new Visits();
		
		$visits->addProducer($farmersMarketId);
		
		$data = array();

		if($farmersMarketId == ""){
			$farmersMarketId = $this->uri->segment(3);
		}
		
		$this->load->model('PhotoModel');
		$thumbPhotos = $this->PhotoModel->getThumbPhotos('producer', $farmersMarketId);
		
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
				'info' => 'includes/left/info',
				'map' => 'includes/right/map',
			);


		// Load all the views for the center column
		$data['CENTER'] = array(
				'info' => '/farmers_market/info',
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
		$data['data']['center']['info']['TABLE'] = 'farmers_market_supplier';
		
		// Left -> Map
		$data['data']['left']['map']['width'] = '220';
		$data['data']['left']['map']['height'] = '225';
		$data['data']['left']['map']['hide_map'] = 'no';
		
		// Left -> Images
		$data['data']['left']['img']['PHOTOS'] = $thumbPhotos;
		
		// Left -> Info
		$INFO = array (
					'url' => $farmersMarket->url,
					'facebook' => $farmersMarket->facebook,
					'twitter' => $farmersMarket->twitter,
				);
		$data['data']['left']['info']['INFO'] = $INFO;
		$data['data']['left']['info']['FARMERS_MARKET'] = $farmersMarket;
		
		$data['FARMERS_MARKET'] = $farmersMarket;
		
		$data['NAME'] = array(
							$farmersMarket->farmersMarketName => '',
							);
		
		// Custom CSS
		$data['CSS'] = array(
			'restaurant',
			'supplier',
			'floating_messages'
		);
		
		/** ------------------------------
		 *  AJAX stuff starts from here
		 *  ------------------------------ 
		 */
		$q = $farmersMarketId;
		$producerName = $farmersMarket->farmersMarketName;
		
		$this->load->model('ListModel', '', TRUE);
		
		$tab = $this->input->get('tab'); 
		if (!$tab || $tab == 'supplier') {
			$this->load->model('SupplierModel');
			$suppliers = $this->SupplierModel->getSupplierForProducerJson($q, $addressId);
			$params = $suppliers['param'];
		} else if ($tab == 'menu') {
			$this->load->model('RestaurantModel', '', TRUE);
			$menus = $this->RestaurantModel->getRestaurantMenusJson($q);
			$params = $menus['param'];
		} else if ($tab == 'comment') {
			$this->load->model('CommentModel', '', TRUE);
			$comments = $this->CommentModel->getCommentsJson('farmers_market', $q);
			$params = $comments['param'];
		} else if ($tab == 'photo') {
			$this->load->model('PhotoModel', '', TRUE);
			$photos = $this->PhotoModel->getPhotosJson('farmers_market', $q);
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
			$listHtml = $this->ListModel->buildSupplierList($suppliers, $producerName, 'farmers_market');
		} else if ($tab == 'menu') {
			$this->ListModel->tab = 'menu';
			$listHtml = $this->ListModel->buildMenuList($menus, $producerName, 'farmers_market');
		} else if ($tab == 'comment') {
			$this->ListModel->tab = 'comment';
			$listHtml = $this->ListModel->buildCommentList($comments, $producerName, 'farmers_market');
		} else if ($tab == 'photo') {
			$this->ListModel->tab = 'photo';
			$listHtml = $this->ListModel->buildPhotoList($photos, $producerName, 'farmers_market');
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
		
		if ( isset($suppliers) ) {
			$geocode = json_encode($suppliers['geocode']);
			$data['data']['center']['info']['GEOCODE'] = $geocode;
		}
		
		$data['data']['left']['filter']['PARAMS'] = $params;
		
		$data['data']['left']['img']['PHOTO_TAB_LINK'] = $photoTabLink;
		$data['data']['center']['info']['SUPPLIER_TAB_LINK'] = $supplierTabLink;
		$data['data']['center']['info']['MENU_TAB_LINK'] = $menuTabLink;
		$data['data']['center']['info']['COMMENT_TAB_LINK'] = $commentTabLink;
		$data['data']['center']['info']['PHOTO_TAB_LINK'] = $photoTabLink;
		$data['data']['center']['info']['CURRENT_TAB'] = $this->ListModel->tab;
		
		$this->load->view('templates/left_center_detail_template', $data);
	}
	
	function ajaxSearchFarmersMarketSuppliers() {
		$q = $this->input->post('q'); 
		if (!$q) {
			$q = $this->input->get('q');
		}
		$addressId = $this->input->post('addressId');
		$this->load->model('SupplierModel');
		$suppliers = $this->SupplierModel->getSupplierForProducerJson($q, $addressId);

		$this->load->model('ProducerModel');
		$producer = $this->ProducerModel->getProducerFromId($q);
		$producerName = $producer->producer;
		
		$this->load->model('ListModel', '', TRUE);
		$supplierListHtml = $this->ListModel->buildSupplierList($suppliers, $producerName, 'farmers_market');
		$this->ListModel->tab = 'supplier';
		
		$pagingHtml = $this->ListModel->buildInfoPagingLinks($suppliers['param']);
		
		$array = array(
			'listHtml' => $supplierListHtml,
			'pagingHtml' => $pagingHtml,
			'param' => $suppliers['param'],
			'geocode' => $suppliers['geocode'],
		);
		
		if ($suppliers['param']['numResults'] > 0) {
			$pagingHtml2 = $this->ListModel->buildInfoPagingLinks($suppliers['param'], '2');
			$array['pagingHtml2'] = $pagingHtml2;
		}
		
		echo json_encode($array);
	}
	
	function ajaxSearchFarmersMarketComments() {
		$this->load->model('CommentModel', '', TRUE);
		$comments = $this->CommentModel->getCommentsJson('farmers_market');
		
		$q = $this->input->post('q'); 
		if (!$q) {
			$q = $this->input->get('q');
		}
		
		$this->load->model('ProducerModel');
		$producer = $this->ProducerModel->getProducerFromId($q);
		$producerName = $producer->producer;
		
		$this->load->model('ListModel', '', TRUE);
		$menuListHtml = $this->ListModel->buildCommentList($comments, $producerName, 'farmers_market');
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
	
	function ajaxSearchFarmersMarketPhotos() {
		$this->load->model('PhotoModel', '', TRUE);
		$photos = $this->PhotoModel->getPhotosJson('farmers_market');
		
		$q = $this->input->post('q'); 
		if (!$q) {
			$q = $this->input->get('q');
		}
		
		$this->load->model('ProducerModel');
		$producer = $this->ProducerModel->getProducerFromId($q);
		$producerName = $producer->producer;
		
		$this->load->model('ListModel', '', TRUE);
		$photoListHtml = $this->ListModel->buildPhotoList($photos, $producerName, 'farmers_market');
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
	
	function city($c) {
		global $FARMERS_MARKET_RADIUS, $FARMERS_MARKET_DEFAULT_RADIUS,
				$RECOMMENDED_CITIES;

                // set the flag to determine URL for cities view
                $this->session->set_userdata('farmersmarket', 1);
                
		$this->load->model('CityModel', '', TRUE);
		$city = $this->CityModel->getCityFromCustomUrl($c);
		
		$data = array();
		
		// SEO
		$this->load->model('SeoModel');
		$seo = $this->SeoModel->getSeoDetailsFromPage('farmers_market_city_list');
		
		$seo_data_array = array(
			'city' => $city->city,
		);
		
		$seo = $this->SeoModel->parseSeoData($seo, $seo_data_array);
		
		$data['SEO'] = $seo;

            // get featured cities for sidebar
            $this->getLeftFeaturedCities($data);
		
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
		$data['data']['left']['filter']['FARMERS_MARKET_RADIUS'] = $FARMERS_MARKET_RADIUS;
		$data['data']['left']['filter']['FARMERS_MARKET_DEFAULT_RADIUS'] = $FARMERS_MARKET_DEFAULT_RADIUS;
		
		if ( empty($f) ) {
		//$data['data']['center']['map']['VIEW_HEADER'] = "Map";
		$data['data']['center']['map']['width'] = '795';
		$data['data']['center']['map']['height'] = '250';
		}
		
		//$data['data']['center']['list']['VIEW_HEADER'] = "Farmers Market";
		$data['data']['center']['list']['CITY'] = $city;
		$data['data']['center']['list']['q'] = $q;
		$data['data']['center']['list']['f'] = $f;
		if ( !empty($f) ) {
			$data['data']['center']['list']['hide_map'] = 'yes';
			$data['data']['center']['list']['hide_filters'] = 'yes';
		} else {
			$data['data']['center']['list']['hide_map'] = 'no';
			$data['data']['center']['list']['hide_filters'] = 'no';
		}
		
		$data['data']['left']['filter']['CITY'] = $city;
		$data['data']['left']['filter']['RECOMMENDED_CITIES'] = $RECOMMENDED_CITIES;
		
		// CSS files to use
		$data['CSS'] = array(
			'listing',
			'jquery-ui/jquery.ui.slider',
			'jquery-ui/jquery.ui.theme',
		);
		
		$this->load->model('FarmersMarketModel', '', TRUE);
		$farmersMarket = $this->FarmersMarketModel->getFarmersMarketJson($city->cityId);
		
		$this->load->model('ListModel', '', TRUE);
		$farmersMarketListHtml = $this->ListModel->buildFarmersMarketList($farmersMarket);
		$data['data']['center']['list']['LIST_DATA'] = $farmersMarketListHtml;

		$pagingHtml = $this->ListModel->buildPagingLinks($farmersMarket['param']);
		$data['data']['center']['list']['PAGING_HTML'] = $pagingHtml;
		
		if (! $farmersMarket['param']['filter']) {
			$farmersMarket['param']['filter'] = '';
		}
		$params = json_encode($farmersMarket['param']);
		
		$data['data']['center']['list']['PARAMS'] = $params;
		
		$geocode = json_encode($farmersMarket['geocode']);
		$data['data']['center']['list']['GEOCODE'] = $geocode;
		
		$data['data']['left']['filter']['PARAMS'] = $farmersMarket['param'];
		
		$this->load->view('templates/left_center_template', $data);
		
	}

    private function getLeftFeaturedCities(array &$data)
    {
        // get left featured cities
        $this->load->model('CityModel');
        $featuredLeftCities = $this->CityModel->getLeftFeaturedCities();

        $data['featureds'] = $featuredLeftCities;
    }
}

/* End of file farm.php */

?>