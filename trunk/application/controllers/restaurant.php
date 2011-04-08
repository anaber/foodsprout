<?php

class Restaurant extends Controller {

	function __construct() {
		parent::Controller();
		checkUserLogin();
		checkUserAgent();

                $this->load->helper('cookie');
                $this->load->helper('url');
	}

	function index() {
            global $RECOMMENDED_CITIES;

            // any access to this action will delete stored links to farmers market
            if ($this->session->userdata('farmersmarket'))
            {
                $this->session->unset_userdata('farmersmarket');
            }

            // get left featured cities
            $this->load->model('CityModel');
            $featuredLeftCities = $this->CityModel->getLeftFeaturedCities();
        
        
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

            $data['data']['left']['filter']['featureds'] = $featuredLeftCities;

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
		//print_r_pre($restaurant);
		
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
		
		/** ------------------------------
		 *  AJAX stuff starts from here
		 *  ------------------------------ 
		 */
		$q = $restaurantId;
		$producerName = $restaurant->restaurantName;
		
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
			$listHtml = $this->ListModel->buildSupplierList($suppliers, $producerName, 'restaurant');
		} else if ($tab == 'menu') {
			$this->ListModel->tab = 'menu';
			$listHtml = $this->ListModel->buildMenuList($menus, $producerName, 'restaurant');
		} else if ($tab == 'comment') {
			$this->ListModel->tab = 'comment';
			$listHtml = $this->ListModel->buildCommentList($comments, $producerName, 'restaurant');
		} else if ($tab == 'photo') {
			$this->ListModel->tab = 'photo';
			$listHtml = $this->ListModel->buildPhotoList($photos, $producerName, 'restaurant');
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
		$supplierListHtml = $this->ListModel->buildSupplierList($suppliers, $producerName, 'restaurant');
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
		$menuListHtml = $this->ListModel->buildMenuList($menus, $producerName, 'restaurant');
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

	function city($c) {
		global $RECOMMENDED_CITIES;

                // any access to this action will delete stored links to farmers market
                if ($this->session->userdata('farmersmarket'))
                {
                    $this->session->unset_userdata('farmersmarket');
                }

		$this->load->model('CityModel', '', TRUE);
                
		$city = $this->CityModel->getCityFromCustomUrl($c);

                if ($city->cityId)
                {
                    $cookie = array(
                        'value' => $city->cityId,
                        'name' => 'LastCityCookie',
                        'expire' => 60 * 60 * 24 *14 // 2 weeks
                    );

                    set_cookie($cookie);
                }
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
		// $data['data']['left']['filter']['RECOMMENDED_CITIES'] = $RECOMMENDED_CITIES;// get left featured cities

                $this->load->model('CityModel');
                $featuredLeftCities = $this->CityModel->getLeftFeaturedCities();
                $data['data']['left']['filter']['featureds'] = $featuredLeftCities;


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
		$menuListHtml = $this->ListModel->buildCommentList($comments, $producerName, 'restaurant');
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
		$photoListHtml = $this->ListModel->buildPhotoList($photos, $producerName, 'restaurant');
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