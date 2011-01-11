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
	function view($restaurantChainId) {
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
				'ad' => 'includes/banners/sky',
			);

		// Data to be passed to the views
		// Center -> Info
		$data['data']['center']['info']['SUPPLIER_TYPES_2'] = $SUPPLIER_TYPES_2;
		$data['data']['center']['info']['PRODUCT_TYPES'] = $productTypes;
		$data['data']['center']['info']['RESTAURANT_CHAIN_ID'] = $restaurantChain->restaurantChainId;
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
		
		$this->load->view('templates/left_center_right_template', $data);
	}

	function ajaxSearchRestaurantChains() {
		$this->load->model('RestaurantChainModel', '', TRUE);
		$restaurants = $this->RestaurantChainModel->getRestaurantChainsJson();
		echo json_encode($restaurants);
	}

	function ajaxSearchRestaurantChainMenus() {
		$this->load->model('RestaurantChainModel', '', TRUE);
		$restaurants = $this->RestaurantChainModel->getRestaurantChainMenusJson();
		echo json_encode($restaurants);
	}

	function ajaxSearchRestaurantChainSuppliers() {
		$q = $this->input->post('q');
		$this->load->model('SupplierModel');
		$suppliers = $this->SupplierModel->getSupplierForProducerJson($q);

		echo json_encode($suppliers);
	}
	
	function ajaxSearchRestaurantChainComments() {
		$this->load->model('CommentModel', '', TRUE);
		$comments = $this->CommentModel->getCommentsJson('restaurant_chain');
		echo json_encode($comments);
	}
	
	function ajaxSearchRestaurantChainPhotos() {
		$this->load->model('PhotoModel', '', TRUE);
		$comments = $this->PhotoModel->getPhotosJson('restaurant_chain');
		echo json_encode($comments);
	}
	
	function customUrl($customUrl){
		$this->load->model('CustomUrlModel');
		$producerId = $this->CustomUrlModel->getProducerIdFromCustomUrl($customUrl, 'restaurant_chain');
		
		if ($producerId) {
			$this->view($producerId);
		} else {
			show_404('page');
		}
	}
	
	
}

/* End of file restaurant.php */

?>