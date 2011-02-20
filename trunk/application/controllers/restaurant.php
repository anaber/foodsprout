<?php

class Restaurant extends Controller {

	function __construct() {
		parent::Controller();
		checkUserLogin();
	}

	function index() {
		global $RECOMMENDED_CITIES;
		$data = array();

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
		/*
		$params = array(
			'page' => 0,
		    'totalPages' => 1,
		    'perPage' => 20,
		    'start' => 1,
		    'end' => 20,
		    'firstPage' => 0,
		    'lastPage' => 0,
		    'numResults' => 20,
		    'sort' => "claims_sustainable DESC, producer",
		    'order' => "ASC",
		    'q' => 98004,
		    'filter' => '',
		    'city' => '',
		    'zoomLevel' => 13
		);
		print_r_pre($params);
		$this->load->model('ListModel', '', TRUE);
		$pagingHtml = $this->ListModel->buildPagingLinks($params);
		die;
		*/
		$this->load->model('RestaurantModel', '', TRUE);
		$restaurants = $this->RestaurantModel->getRestaurantsJson2();
		
		$this->load->model('ListModel', '', TRUE);
		$restaurantListHtml = $this->ListModel->buildRestaurantList($restaurants);
		$data['data']['center']['list']['LIST_DATA'] = $restaurantListHtml;

		$pagingHtml = $this->ListModel->buildPagingLinks($restaurants['param']);
		$data['data']['center']['list']['PAGING_HTML'] = $pagingHtml;
		
		$params = json_encode($restaurants['param']);
		/*
		$params = array(
			'data' => array(
						'param' => $restaurants['param']
					)
		);
		
		$params = json_encode($params);
		*/
		$data['data']['center']['list']['PARAMS'] = $params;
		
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

		$this->load->view('templates/left_center_detail_template', $data);
	}


	function ajaxSearchRestaurants() {

		/*
		 $mtime = microtime();
		 $mtime = explode(" ",$mtime);
		 $mtime = $mtime[1] + $mtime[0];
		 $starttime = $mtime;
		 */

		$this->load->model('RestaurantModel', '', TRUE);
		$restaurants = $this->RestaurantModel->getRestaurantsJson2();
		//echo json_encode($restaurants);
		
		$this->load->model('ListModel', '', TRUE);
		$restaurantListHtml = $this->ListModel->buildRestaurantList($restaurants);
		
		//$data['data']['center']['list']['LIST_DATA'] = $restaurantListHtml;
		$pagingHtml = $this->ListModel->buildPagingLinks($restaurants['param']);
		$array = array(
			'listHtml' => $restaurantListHtml,
			'pagingHtml' => $pagingHtml,
			'param' => $restaurants['param'],
		);
		
		echo json_encode($array);
		//$data['data']['center']['list']['PAGING_HTML'] = $pagingHtml;
		
		
		/*
		 $mtime = microtime();
		 $mtime = explode(" ",$mtime);
		 $mtime = $mtime[1] + $mtime[0];
		 $endtime = $mtime;
		 $totaltime = ($endtime - $starttime);
		 echo "<br />This page was created in ".$totaltime." seconds";
		 */
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
		$addressId = $this->input->post('addressId');
		
		//$q = 174538;
		//$addressId = 489269;
		$this->load->model('RestaurantModel');
		/*
		$restaurant = $this->RestaurantModel->getRestaurantFromId($q);
		//$restaurantChainId = $restaurant->restaurantChainId;
		
		if( !empty($restaurantChainId) ){
			$this->load->model('SupplierModel');
			$suppliers = $this->SupplierModel->getSupplierForRestaurantAndChainJson($q, $restaurantChainId);
		} else {
			$this->load->model('SupplierModel');
			$suppliers = $this->SupplierModel->getSupplierForCompanyJson($q, '', '', '', '', '');
		}
		*/
		
		$this->load->model('SupplierModel');
		$suppliers = $this->SupplierModel->getSupplierForProducerJson($q, $addressId);

		echo json_encode($suppliers);
	}

	function ajaxSearchRestaurantMenus() {
		$this->load->model('RestaurantModel', '', TRUE);
		$restaurants = $this->RestaurantModel->getRestaurantMenusJson();
		echo json_encode($restaurants);
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

		$this->load->view('templates/left_center_template', $data);

	}

	function ajaxSearchRestaurantComments() {
		$this->load->model('CommentModel', '', TRUE);
		$comments = $this->CommentModel->getCommentsJson('restaurant');
		echo json_encode($comments);
	}

	function ajaxSearchRestaurantPhotos() {
		$this->load->model('PhotoModel', '', TRUE);
		$comments = $this->PhotoModel->getPhotosJson('restaurant');
		echo json_encode($comments);
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