<?php

class Chain extends Controller {
	var $css;
	function __construct() {
		parent::Controller();
		checkUserLogin();
		
		$this->css = array(
			'restaurant',
		);
	}

	function index() {
		global $RECOMMENDED_CITIES;
		$data = array();
		
		// SEO
		$this->load->model('SeoModel');
		$seo = $this->SeoModel->getSeoDetailsFromPage('chain_list');
		$data['SEO'] = $seo;
		
		// validate the data in the URL to make sure we don't have SQL injection
		$urlpage = substr($this->uri->segment(2),4,5);
		if(is_numeric($urlpage))
		{
			$page = $urlpage-1;
		} else {
			$page = 0;
		}
		
		if($this->input->get('pp'))
		{
			$number_perpage = $this->input->get('pp');
			if($number_perpage > 60)
			{
				$perpage = 60;
			}
			else{
				$perpage = $number_perpage;
			}
		}
		else{
			$perpage = 60;
		}
		
		$this->load->model('RestaurantChainModel');
		$chains = $this->RestaurantChainModel->getRestaurantChains($page, $perpage);
		
		// Views to include in the data array
		$data['CENTER'] = array(
				'list' => '/restaurant/fastfood_list',
			);

		$data['LEFT'] = array(
				'filter' => 'includes/left/chain_filter',
			);

		// Data to be passed to the views
		$data['data']['left']['filter']['RECOMMENDED_CITIES'] = $RECOMMENDED_CITIES;
		$data['data']['center']['list']['CHAINS'] = $chains;
		
		$this->load->view('templates/left_center_template', $data);
	}

	function fastfood() {
		global $RECOMMENDED_CITIES;
		$data = array();
		
		// SEO
		$this->load->model('SeoModel');
		$seo = $this->SeoModel->getSeoDetailsFromPage('chain_list');
		$data['SEO'] = $seo;

		// Views to include in the data array
		$data['CENTER'] = array(
				'list' => '/restaurant/fastfood_list',
			);

		$data['LEFT'] = array(
				'filter' => 'includes/left/chain_filter',
			);

		// Data to be passed to the views
		// $data['data']['center']['list']['VIEW_HEADER'] = "List of Restaurant Chains";
		$data['data']['left']['filter']['RECOMMENDED_CITIES'] = $RECOMMENDED_CITIES;
		$this->load->view('templates/left_center_template', $data);
	}

	// View info about a chain restaurant
	function view($restaurantChainId = '', $addressId = '') {
		global $SUPPLIER_TYPES_2;
		
		$data = array();

		if($restaurantChainId == ''){
			$restaurantChainId = $this->uri->segment(3);
		}
		
		$this->load->model('PhotoModel');
		$thumbPhotos = $this->PhotoModel->getThumbPhotos('producer', $restaurantChainId);
		
		// Getting information from models
		$this->load->model('RestaurantModel');
		$restaurantChain = $this->RestaurantModel->getRestaurantChainFromId($restaurantChainId);

		$this->load->model('ProductTypeModel');
		$productTypes = $this->ProductTypeModel->listProductType();

		// SEO
		$this->load->model('SeoModel');
		$seo = $this->SeoModel->getSeoDetailsFromPage('chain_detail');

		$seo_data_array = array(
			'restaurant_name' => $restaurantChain->restaurantChain,
		);

		$seo = $this->SeoModel->parseSeoData($seo, $seo_data_array);
		$data['SEO'] = $seo;
		// SEO ENDS here

		// List of views to be included, these are files that are pulled from different views in the view folders

		// Load all the views for the center column
		$data['LEFT'] = array(
				'img' => '/includes/left/images',
			);


		// Load all the views for the center column
		$data['CENTER'] = array(
				'info' => '/restaurant/info_chain',
			);

		// Load all the views for the right column
		$data['RIGHT'] = array(
				//'ad' => 'includes/banners/sky',
			);

		// Data to be passed to the views
		// Center -> Info
		$data['data']['center']['info']['SUPPLIER_TYPES_2'] = $SUPPLIER_TYPES_2;
		$data['data']['center']['info']['PRODUCT_TYPES'] = $productTypes;
		$data['data']['center']['info']['RESTAURANT_CHAIN_ID'] = $restaurantChain->restaurantChainId;
		$data['data']['center']['info']['ADDRESS_ID'] = $addressId;
		$data['data']['center']['info']['TABLE'] = 'restaurant_chain_supplier';
		
		// Left -> Images
		$data['data']['left']['img']['PHOTOS'] = $thumbPhotos;
		
		$data['RESTAURANT_CHAIN'] = $restaurantChain;
		
		$data['NAME'] = array(
							$restaurantChain->restaurantChain => '',
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
		$q = $restaurantChainId;
		$producerName = $restaurantChain->restaurantChain;
		
		$this->load->model('ListModel', '', TRUE);
		
		$tab = $this->input->get('tab'); 
		if (!$tab || $tab == 'supplier') {
			$this->load->model('SupplierModel');
			$suppliers = $this->SupplierModel->getSupplierForProducerJson($q, $addressId);
			$params = $suppliers['param'];
		} else if ($tab == 'menu') {
			$this->load->model('RestaurantModel', '', TRUE);
			$menus = $this->RestaurantChainModel->getRestaurantChainMenusJson($q);
			$params = $menus['param'];
		} else if ($tab == 'comment') {
			$this->load->model('CommentModel', '', TRUE);
			$comments = $this->CommentModel->getCommentsJson('restaurant_chain', $q);
			$params = $comments['param'];
		} else if ($tab == 'photo') {
			$this->load->model('PhotoModel', '', TRUE);
			$photos = $this->PhotoModel->getPhotosJson('restaurant_chain', $q);
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
			$listHtml = $this->ListModel->buildSupplierList($suppliers, $producerName);
		} else if ($tab == 'menu') {
			$this->ListModel->tab = 'menu';
			$listHtml = $this->ListModel->buildMenuList($menus, $producerName);
		} else if ($tab == 'comment') {
			$this->ListModel->tab = 'comment';
			$listHtml = $this->ListModel->buildCommentList($comments, $producerName);
		} else if ($tab == 'photo') {
			$this->ListModel->tab = 'photo';
			$listHtml = $this->ListModel->buildPhotoList($photos, $producerName);
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
		
		$data['data']['center']['info']['SUPPLIER_TAB_LINK'] = $supplierTabLink;
		$data['data']['center']['info']['MENU_TAB_LINK'] = $menuTabLink;
		$data['data']['center']['info']['COMMENT_TAB_LINK'] = $commentTabLink;
		$data['data']['center']['info']['PHOTO_TAB_LINK'] = $photoTabLink;
		$data['data']['center']['info']['CURRENT_TAB'] = $this->ListModel->tab;
		
		$this->load->view('templates/left_center_right_template', $data);
	}

	function ajaxSearchRestaurantChains() {
		$this->load->model('RestaurantChainModel', '', TRUE);
		$restaurants = $this->RestaurantChainModel->getRestaurantChainsJson();
		echo json_encode($restaurants);
	}

	function ajaxSearchRestaurantChainMenus() {
		$this->load->model('RestaurantChainModel', '', TRUE);
		$menus = $this->RestaurantChainModel->getRestaurantChainMenusJson();
		$q = $this->input->post('q'); 
		if (!$q) {
			$q = $this->input->get('q');
		}
		
		$this->load->model('RestaurantModel');
		$restaurantChain = $this->RestaurantModel->getRestaurantChainFromId($q);
		$producerName = $restaurantChain->restaurantChain;
		
		$this->load->model('ListModel', '', TRUE);
		$menuListHtml = $this->ListModel->buildMenuList($menus, $producerName);
		$this->ListModel->tab = 'menu';
		
		$pagingHtml = $this->ListModel->buildInfoPagingLinks($menus['param']);
		
		$array = array(
			'listHtml' => $menuListHtml,
			'pagingHtml' => $pagingHtml,
			'param' => $menus['param'],
			//'geocode' => $menus['geocode'],
		);
		
		if ($menus['param']['numResults'] > 0) {
			$pagingHtml2 = $this->ListModel->buildInfoPagingLinks($menus['param'], '2');
			$array['pagingHtml2'] = $pagingHtml2;
		}
		
		echo json_encode($array);
	}

	function ajaxSearchRestaurantChainSuppliers() {
		
		$q = $this->input->post('q'); 
		if (!$q) {
			$q = $this->input->get('q');
		}
		$addressId = $this->input->post('addressId');
		$this->load->model('SupplierModel');
		$suppliers = $this->SupplierModel->getSupplierForProducerJson($q, $addressId);

		$this->load->model('RestaurantModel');
		$restaurantChain = $this->RestaurantModel->getRestaurantChainFromId($q);
		$producerName = $restaurantChain->restaurantChain;
		
		$this->load->model('ListModel', '', TRUE);
		$supplierListHtml = $this->ListModel->buildSupplierList($suppliers, $producerName);
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
	
	function ajaxSearchRestaurantChainComments() {
		
		$this->load->model('CommentModel', '', TRUE);
		$comments = $this->CommentModel->getCommentsJson('restaurant_chain');
		
		$q = $this->input->post('q'); 
		if (!$q) {
			$q = $this->input->get('q');
		}
		
		$this->load->model('RestaurantModel');
		$restaurantChain = $this->RestaurantModel->getRestaurantChainFromId($q);
		$producerName = $restaurantChain->restaurantChain;
		
		$this->load->model('ListModel', '', TRUE);
		$menuListHtml = $this->ListModel->buildCommentList($comments, $producerName);
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
	
	function ajaxSearchRestaurantChainPhotos() {
		$this->load->model('PhotoModel', '', TRUE);
		$photos = $this->PhotoModel->getPhotosJson('restaurant_chain');
		
		$q = $this->input->post('q'); 
		if (!$q) {
			$q = $this->input->get('q');
		}
		
		$this->load->model('RestaurantModel');
		$restaurantChain = $this->RestaurantModel->getRestaurantChainFromId($q);
		$producerName = $restaurantChain->restaurantChain;
		
		$this->load->model('ListModel', '', TRUE);
		$photoListHtml = $this->ListModel->buildPhotoList($photos, $producerName);
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
	
	function customUrl($customUrl){
		$this->load->model('CustomUrlModel');
		$producer = $this->CustomUrlModel->getProducerIdFromCustomUrl($customUrl, 'restaurant_chain');
		
		if ($producer) {
			$this->view($producer->producerId, $producer->addressId);
		} else {
			show_404('page');
		}
	}
	
	
}

/* End of file restaurant.php */

?>