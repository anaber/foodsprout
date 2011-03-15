<?php

class Restaurant extends Controller {

	function __construct() {
		parent::Controller();
		checkUserLogin();
	}

	function index() {
		global $RECOMMENDED_CITIES;
		$data = array();
		//print_r_pre($this->session->userdata);
		//setcookie('seachedZip', 98004, time()+60*60*24*30*365);
		
		// SEO
		$this->load->model('SeoModel');
		$seo = $this->SeoModel->getSeoDetailsFromPage('restaurant_list');
		$data['SEO'] = $seo;

		$q = $this->input->post('q');
		$f = $this->input->post('f');

		if ( !empty($f) ) {
			$data['CENTER'] = array(
				'list' => '/restaurant/restaurant_list',
			);
		} else {
			// List of views to be included
			$data['CENTER'] = array(
					'map' => 'includes/map',
					'list' => '/restaurant/restaurant_list',
			);
		}

		if ( !empty($f) ) {
			// do nothing
		} else {
			$data['LEFT'] = array(
					'filter' => 'includes/left/restaurant_filter',
			);
		}

		// Data to be passed to the views
		if ( empty($f) ) {
			// load nothing
		}

		if ( empty($f) ) {
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

		$data['data']['left']['filter']['RECOMMENDED_CITIES'] = $RECOMMENDED_CITIES;
		
		$this->load->model('RestaurantModel', '', TRUE);
		$restaurants = $this->RestaurantModel->getRestaurantsJson();
		
		$this->load->model('ListModel', '', TRUE);
		$restaurantListHtml = $this->ListModel->buildRestaurantList($restaurants);
		$data['data']['center']['list']['LIST_DATA'] = $restaurantListHtml;

		$pagingHtml = $this->ListModel->buildPagingLinks($restaurants['param']);
		$data['data']['center']['list']['PAGING_HTML'] = $pagingHtml;
		
		if (! $restaurants['param']['filter']) {
			$restaurants['param']['filter'] = '';
		}
		$params = json_encode($restaurants['param']);
		
		$data['data']['center']['list']['PARAMS'] = $params;
		
		$geocode = json_encode($restaurants['geocode']);
		$data['data']['center']['list']['GEOCODE'] = $geocode;
		
		$data['data']['left']['filter']['PARAMS'] = $restaurants['param'];
		
		$this->load->view('templates/left_center_template', $data);
		
	}

	function ajaxSearchRestaurantInfo() {
		$restaurantId = $this->input->post('restaurantId');
		$addressId = $this->input->post('addressId');
		$this->load->model('RestaurantModel', '', TRUE);
		$restaurant = $this->RestaurantModel->getRestaurantFromId($restaurantId, $addressId);
		echo json_encode($restaurant);
	}

	//restaurant custom url
	function customUrl($customUrl){
		
		$this->load->model('CustomUrlModel');
		$producer = $this->CustomUrlModel->getProducerIdFromCustomUrl($customUrl, 'restaurant');
		
		if ($producer) {
			$this->view($producer->producerId, $producer->addressId);
		} else {
			show_404('page');
		}
	}

	// View the information on a single restaurant
	function view($restaurantId = "", $addressId = "") {
		global $SUPPLIER_TYPES_2;

		$this->load->plugin('Visits');
		$visits = new Visits();
		$visits->addProducer($restaurantId);
		$data = array();

		if($restaurantId == ""){
			$restaurantId = $this->uri->segment(3);
		}

		$this->load->model('PhotoModel');
		$thumbPhotos = $this->PhotoModel->getThumbPhotos('producer', $restaurantId);

		// Getting information from models
		$this->load->model('RestaurantModel');
		$restaurant = $this->RestaurantModel->getRestaurantFromId($restaurantId, $addressId);
		
		$this->load->model('ProductTypeModel');
		$productTypes = $this->ProductTypeModel->listProductType();

		// SEO
		$this->load->model('SeoModel');
		$seo = $this->SeoModel->getSeoDetailsFromPage('restaurant_detail');

		$seo_data_array = array(
			'restaurant_name' => $restaurant->restaurantName,
		// need to add more info about the restaurant here
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
				'info' => '/restaurant/info',
		);

		// Load all the views for the right column
		$data['RIGHT'] = array(
				//'ad' => '/includes/banners/sky',
		);

		// Data to be passed to the views
		// Center -> Info
		$data['data']['center']['info']['SUPPLIER_TYPES_2'] = $SUPPLIER_TYPES_2;
		$data['data']['center']['info']['PRODUCT_TYPES'] = $productTypes;
		$data['data']['center']['info']['RESTAURANT_ID'] = $restaurant->restaurantId;
		$data['data']['center']['info']['RESTAURANT_ID'] = $restaurant->restaurantId;
		$data['data']['center']['info']['ADDRESS_ID'] = $addressId;
		$data['data']['center']['info']['TABLE'] = 'restaurant_supplier';

		// Left -> Map
		$data['data']['left']['map']['width'] = '220';
		$data['data']['left']['map']['height'] = '225';
		$data['data']['left']['map']['hide_map'] = 'no';

		// Left -> Images
		$data['data']['left']['img']['PHOTOS'] = $thumbPhotos;

		// Left -> Info
		$INFO = array (
					'url' => $restaurant->url,
					'facebook' => $restaurant->facebook,
					'twitter' => $restaurant->twitter,
		);
		$data['data']['left']['info']['INFO'] = $INFO;

		$data['data']['left']['info']['INFO'] = $INFO;
		$data['data']['left']['info']['RESTAURANT'] = $restaurant;

		$data['RESTAURANT'] = $restaurant;

		$data['NAME'] = array(
		$restaurant->restaurantName => '',
		);

		// Custom CSS
		$data['CSS'] = array(
						'restaurant',
						'supplier',
						'floating_messages'
						);
		
		$q = $restaurantId;
		$this->load->model('SupplierModel');
		$suppliers = $this->SupplierModel->getSupplierForProducerJson($q, $addressId);
		
		$producerName = $restaurant->restaurantName;
		$this->load->model('ListModel', '', TRUE);
		$supplierListHtml = $this->ListModel->buildSupplierList($suppliers, $producerName);
		$data['data']['center']['info']['LIST_DATA'] = $supplierListHtml;
		
		
		$pagingHtml = $this->ListModel->buildInfoPagingLinks($suppliers['param']);
		$data['data']['center']['info']['PAGING_HTML'] = $pagingHtml;
		
		$pagingHtml2 = $this->ListModel->buildInfoPagingLinks($suppliers['param'], '2');
		$data['data']['center']['info']['PAGING_HTML_2'] = $pagingHtml2;
		
		if (! $suppliers['param']['filter']) {
			$suppliers['param']['filter'] = '';
		}
		$params = json_encode($suppliers['param']);
		
		$data['data']['center']['info']['PARAMS'] = $params;
		
		$geocode = json_encode($suppliers['geocode']);
		$data['data']['center']['info']['GEOCODE'] = $geocode;
		
		$data['data']['left']['filter']['PARAMS'] = $suppliers['param'];
		

		$this->load->view('templates/left_center_detail_template', $data);
	}


	function ajaxSearchRestaurants() {

		$this->load->model('RestaurantModel', '', TRUE);
		$restaurants = $this->RestaurantModel->getRestaurantsJson();
		
		$this->load->model('ListModel', '', TRUE);
		$restaurantListHtml = $this->ListModel->buildRestaurantList($restaurants);
		
		$pagingHtml = $this->ListModel->buildPagingLinks($restaurants['param']);
		$array = array(
			'listHtml' => $restaurantListHtml,
			'pagingHtml' => $pagingHtml,
			'param' => $restaurants['param'],
			'geocode' => $restaurants['geocode'],
		);
		
		echo json_encode($array);
	}

	function ajaxGetDistinctUsedRestaurantType() {
		$c = $this->input->post('c');
		$this->load->model('RestaurantModel');
		$restaurantTypes = $this->RestaurantModel->getDistinctUsedRestaurantType($c);
		echo json_encode($restaurantTypes);
	}

	function ajaxGetDistinctUsedCuisine() {
		$c = $this->input->post('c');
		$this->load->model('RestaurantModel');
		$cusines = $this->RestaurantModel->getDistinctUsedCuisine($c);
		echo json_encode($cusines);
	}

	function ajaxGetAllCuisine() {
		//$this->load->model('CuisineModel');
		//$cusines = $this->CuisineModel->listCuisine();
		//echo json_encode($cusines);
		
		$this->load->model('ProducerCategoryModel');
		$cusines = $this->ProducerCategoryModel->listProducerCategory('CUISINE', '');
		echo json_encode($cusines);
	}

	function ajaxGetAllRestaurantType() {
		//$this->load->model('RestaurantTypeModel');
		//$restaurantType = $this->RestaurantTypeModel->listRestaurantType();
		//echo json_encode($restaurantType);
		
		$this->load->model('ProducerCategoryModel');
		$restaurantType = $this->ProducerCategoryModel->listProducerCategory('RESTAURANT', '');
		echo json_encode($restaurantType);
	}

	function map() {
		$this->load->view('map');
	}

	function ajaxSearchRestaurantSuppliers() {
		$q = $this->input->post('q'); 
		if (!$q) {
			$q = $this->input->get('q');
		}
		$addressId = $this->input->post('addressId');
		$this->load->model('SupplierModel');
		$suppliers = $this->SupplierModel->getSupplierForProducerJson($q, $addressId);

		$this->load->model('RestaurantModel');
		$restaurant = $this->RestaurantModel->getRestaurantFromId($q, $addressId);
		
		$producerName = $restaurant->restaurantName;
		$this->load->model('ListModel', '', TRUE);
		$supplierListHtml = $this->ListModel->buildSupplierList($suppliers, $producerName);
		
		$pagingHtml = $this->ListModel->buildInfoPagingLinks($suppliers['param']);
		$pagingHtml2 = $this->ListModel->buildInfoPagingLinks($suppliers['param'], '2');
		
		$array = array(
			'listHtml' => $supplierListHtml,
			'pagingHtml' => $pagingHtml,
			'pagingHtml2' => $pagingHtml2,
			'param' => $suppliers['param'],
			'geocode' => $suppliers['geocode'],
		);
		
		echo json_encode($array);
	}

	function ajaxSearchRestaurantMenus() {
		$this->load->model('RestaurantModel', '', TRUE);
		$menus = $this->RestaurantModel->getRestaurantMenusJson();
		$q = $this->input->post('q'); 
		if (!$q) {
			$q = $this->input->get('q');
		}
		
		$this->load->model('RestaurantModel');
		$restaurant = $this->RestaurantModel->getRestaurantFromId($q);
		
		$producerName = $restaurant->restaurantName;
		
		$this->load->model('ListModel', '', TRUE);
		$menuListHtml = $this->ListModel->buildMenuList($menus, $producerName);
		
		$pagingHtml = $this->ListModel->buildInfoPagingLinks($menus['param']);
		$pagingHtml2 = $this->ListModel->buildInfoPagingLinks($menus['param'], '2');
		
		$array = array(
			'listHtml' => $menuListHtml,
			'pagingHtml' => $pagingHtml,
			//'pagingHtml2' => $pagingHtml2,
			'param' => $menus['param'],
			//'geocode' => $suppliers['geocode'],
		);
		
		echo json_encode($array);
		
	}

	function city($c) {
		global $RECOMMENDED_CITIES;

		$arr = explode ('-', $c);
		$cityName = implode(' ', $arr);

		$this->load->model('CityModel', '', TRUE);
		$city = $this->CityModel->getCityFromName($cityName);

		$data = array();

		// SEO
		$this->load->model('SeoModel');
		$seo = $this->SeoModel->getSeoDetailsFromPage('sustainable_restaurants');

		$seo_data_array = array(
			'city' => $city->city,
		);

		$seo = $this->SeoModel->parseSeoData($seo, $seo_data_array);

		$data['SEO'] = $seo;

		$f = $this->input->post('f');

		// List of views to be included
		$data['CENTER'] = array(
				'map' => 'includes/map',
				'list' => '/restaurant/restaurant_list',
		);

		$data['LEFT'] = array(
				'filter' => 'includes/left/restaurant_filter',
		);

		if ( empty($f) ) {
			$data['data']['center']['map']['width'] = '795';
			$data['data']['center']['map']['height'] = '250';
		}

		$data['data']['center']['list']['CITY'] = $city;
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

		$data['CSS'] = array(
						'listing'
						);
		
		$this->load->model('RestaurantModel', '', TRUE);
		$restaurants = $this->RestaurantModel->getRestaurantsJson($city->cityId);
		
		$this->load->model('ListModel', '', TRUE);
		$restaurantListHtml = $this->ListModel->buildRestaurantList($restaurants);
		$data['data']['center']['list']['LIST_DATA'] = $restaurantListHtml;

		$pagingHtml = $this->ListModel->buildPagingLinks($restaurants['param']);
		$data['data']['center']['list']['PAGING_HTML'] = $pagingHtml;
		
		if (! $restaurants['param']['filter']) {
			$restaurants['param']['filter'] = '';
		}
		$params = json_encode($restaurants['param']);
		$data['data']['center']['list']['PARAMS'] = $params;
		
		$geocode = json_encode($restaurants['geocode']);
		$data['data']['center']['list']['GEOCODE'] = $geocode;
		
		$data['data']['left']['filter']['PARAMS'] = $restaurants['param'];

		$this->load->view('templates/left_center_template', $data);

	}

	function ajaxSearchRestaurantComments() {
		$this->load->model('CommentModel', '', TRUE);
		$comments = $this->CommentModel->getCommentsJson('restaurant');
		
		$q = $this->input->post('q'); 
		if (!$q) {
			$q = $this->input->get('q');
		}
		
		$this->load->model('RestaurantModel');
		$restaurant = $this->RestaurantModel->getRestaurantFromId($q);
		
		$producerName = $restaurant->restaurantName;
		
		$this->load->model('ListModel', '', TRUE);
		$menuListHtml = $this->ListModel->buildCommentList($comments, $producerName);
		
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

	function ajaxSearchRestaurantPhotos() {
		$this->load->model('PhotoModel', '', TRUE);
		$photos = $this->PhotoModel->getPhotosJson('restaurant');
		
		$q = $this->input->post('q'); 
		if (!$q) {
			$q = $this->input->get('q');
		}
		
		$this->load->model('RestaurantModel');
		$restaurant = $this->RestaurantModel->getRestaurantFromId($q);
		
		$producerName = $restaurant->restaurantName;
		
		$this->load->model('ListModel', '', TRUE);
		$photoListHtml = $this->ListModel->buildPhotoList($photos, $producerName);
		
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
	
	function save_add() {
		$this->load->model('RestaurantModel', '', TRUE);
		
		$GLOBALS = array();
		
		if ( $this->RestaurantModel->addRestaurant() ) {
			// TO DO: IF THE USER DOES NOT HAVE JAVASCRIPT WE NEED TO USE SERVER SIDE REDIRECT.  BELOW CODE WILL DO THIS, HOWEVER THE echo 'yes' IS REQUIRED TO PASS TO THE JAVASCRIPT.  CONSIDER A BETTER WAY TO NOTIFY THE JQUERY JAVASCRIPT THAT THE EVENT WAS SUCCESSFUL SO AS TO ALLOW THE PROPER REDIRECT FOR NON JAVASCRIPT
			// Added the new restaurant successfully, send user to index
			//$this->index();
			echo 'yes';
			
		} else {
			if (isset($GLOBALS['error']) && !empty($GLOBALS['error']) ) {
				echo $GLOBALS['error'];
			} else {
				echo 'no';
			}
		}
		
	}

}

/* End of file restaurant.php */
?>