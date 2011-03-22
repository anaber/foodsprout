<?php

class Product extends Controller {
	
	function __construct() {
		parent::Controller();
		checkUserLogin();
	}
	

	
	function index(){
		
		$data = array();
		
		// Views to include in the data array
		$data['CENTER'] = array(
				'list' => '/product/center',
				'search_view' => '/product/advanced_search',
				'main_view' => '/product/top_list',
			);
		
		$data['LEFT'] = array(
				'filter' => 'includes/left/product_filter',
			);
			
		$this->load->model('ProductModel', '', TRUE);
		
		$data['recentlyAddedProducts'] = $this->ProductModel->recentlyAddedProducts();
		$data['recentlyEatenProducts'] = $this->ProductModel->recentlyEatenProducts();
		
		$this->load->view('templates/left_center_template', $data);
		
	}
	
	function search(){
		
		$data = array();
		
		$searchTerm ="search keyword";
		
		// Views to include in the data array
		$data['CENTER'] = array(
				'list' => '/product/center',
				'search_view' => '/product/advanced_search',
				'main_view' => '/product/search_results',
			);
		
		$data['LEFT'] = array(
				'filter' => 'includes/left/product_filter',
			);
		
		$startPage = 0;	
			
		//if isset post add search term to session
		if(isset($_POST) && !empty($_POST['search_term'])){
				
			$this->session->set_userdata('search_term', $this->input->post('search_term', true));

			$searchTerm = $this->input->post('search_term', true);
				
		}
		//if isset uri segment 3 read search term from session 
		if($this->uri->segment(3) != false && $this->uri->segment(3) != '' && is_numeric($this->uri->segment(3)) ){
			
			$startPage = $this->uri->segment(3);
			
			$searchTerm = $this->session->userdata('search_term');
			
		}

		//if not isset post and uri then  try to find last search
		if(!isset($_POST['search_term']) && !is_numeric($this->uri->segment(3))){
			
						
			$startPage = 0;
			
			$searchTerm = $this->session->userdata('search_term')!= false ? $this->session->userdata('search_term') : "search keyword";
			
		}
			//load product model
			$this->load->model('ProductModel', '', TRUE);
			
			//load pagination library
			$this->load->library('pagination');
			
			//disable query strings 
			$this->config->set_item('enable_query_strings', 'false'); 
			
			
			//pagination config
			$config['base_url'] = base_url().'product/search/';
			
			$config['total_rows'] = $this->ProductModel->searchProductsByNameTotalRows($searchTerm);

			$config['per_page'] = '20';
			
			$config['num_links'] = '3';
			
			$config['uri_segment'] = '3';
						
			$this->pagination->initialize($config); 
			
			
		$data['searchResults'] = $this->ProductModel->searchProductsByName($searchTerm, $startPage, $config['per_page']);

		$data['search_term'] = $searchTerm;
		$data['totalRows'] = $config['total_rows'];
		$this->load->view('templates/left_center_template', $data);
		
	}

	function customUrl($customUrl = ''){
		
		$this->load->model('CustomUrlModel');
		
		$producer = $this->CustomUrlModel->getProductIdFromCustomUrl($customUrl);
		
		if ($producer) {
			
			$this->view($producer[0]->product_id);
			
		} else {
			show_404('page');
		}
	}
	
	
	function view($productId = ''){
		
			
		$data = array();
		
		// Views to include in the data array
		$data['CENTER'] = array(
				'list' => '/product/center',
				'search_view' => '/product/advanced_search',
				'main_view' => '/product/product_details',
			);
		
		$data['LEFT'] = array(
				'filter' => 'includes/left/product_filter',
			);
			
				// Load all the views for the right column
		$data['RIGHT'] = array(
				//'ad' => 'includes/banners/sky',
			); 
			
		//load product model
		$this->load->model('ProductModel', '', TRUE);
		
		$data['productDetails'] = $this->ProductModel->getProductFromId($productId); 	
			
			
		$this->load->view('templates/left_center_template', $data);
	}
	
	
	function eaten($productId=''){
			
		if($productId == ''){
			return false;
		}
		
		$data = array();
		
		//form secure
		$rand_number = rand(132354,932356);
		$this->session->set_userdata('secure_string', $rand_number);
		$data['unique_form_id'] = md5($rand_number); 
		
		//TODO - move this query to model
		
		//get producer type
		$producerType = $this->db->query("SELECT product.product_type_id
							FROM
							product 
							WHERE
							product.product_id = '".$productId."'")->result(); 
		
		//if producer type = restaurant 
		if($producerType[0]->product_type_id == 1){
			
			//load address list
			$this->load->model('ProductModel');
			
			$data['addressList'] = $this->ProductModel->getAddressByProductId($productId);
			
		}
		$data['product_id'] = $productId;
		$this->load->view('product/ateadd', $data); 
		
	}
		
	function addeaten(){
		
		$auth = $this->session->userdata('isAuthenticated'); 
		
		if($auth != 1){
			
			exit('Auth error!');
			
		}
		
		//if session and form values match 
		if($this->input->post('form_id') == md5($this->session->userdata('secure_string'))){

			//remove session to not be used again 
			$this->session->unset_userdata('some_name');	
			
			$params = array(); 
			
			if(isset($_POST['product_id']) && $_POST['product_id'] != ''){
				$params['product_id'] = $this->input->post('product_id', true);
			}else{
				$params['product_id'] = "";
			}
			
			$params['rating_date'] = date("Y-m-d H:i:s", time());
			
			if(isset($_POST['rating']) && $_POST['rating'] != ''){
				$params['rating'] = $this->input->post('rating', true);
			}else{
				$params['rating'] = "";
			}
			
			if(isset($_POST['comment']) && $_POST['comment'] != ''){
				$params['comment'] = $this->input->post('comment', true);
			}else{
				$params['comment'] = "";
			}
			
			if(isset($_POST['consumed_date']) && $_POST['consumed_date'] != ''){
				$params['consumed_date'] = $this->input->post('consumed_date', true);
			}else{
				$params['consumed_date'] = "";
			}
			
			
			if(isset($_POST['address_id']) && $_POST['address_id'] != ''){
				$params['address_id'] = $this->input->post('address_id', true);
			}else{
				$params['address_id'] = "";
			}
			
			$params['user_id'] = $this->session->userdata('userId'); 
			
			try{
				
				if(sizeof($params) > 0 ){
					
					$this->db->insert('product_consumed', $params); 
					
				}
			}catch(Exception $e){
				
				echo 'Caught exception: ',  $e->getMessage(), "\n";
				
			}
			
			echo '<p>Thank you for your submission!</p>
				<p><a href="#" onclick="window.parent.tb_remove(); return false">Continue</a>';
		
			
		}else{
			die('Form id error!'); 
		}
	}
	
	
	// --------------------------- old methods ------------------------//
	
	function old_index() {
		
		$data = array();
		
		// Views to include in the data array
		$data['CENTER'] = array(
				'list' => '/product/product_list',
			);
		
		$data['LEFT'] = array(
				'filter' => 'includes/left/product_filter',
			);
		
		
			
		$this->load->view('templates/left_center_template', $data);
	}

	
	function newProducts() {
		global $GOOGLE_MAP_KEY;
		$data = array();
		
		// Getting information from models
		$this->load->model('ProductModel');
		$products = $this->ProductModel->listNewProducts();
		
		// List of views to be included
		$data['LEFT'] = array(
				'ad' => 'includes/banners/sky',
			);
		
		$data['CENTER'] = array(
				'map'  => 'includes/map',
				'list' => '/product/product_list',
			);
		
		// Data to be passed to the views
		$data['data']['center']['map']['GOOGLE_MAP_KEY'] = $GOOGLE_MAP_KEY;
		$data['data']['center']['map']['VIEW_HEADER'] = "Distributor Map";
		$data['data']['center']['map']['width'] = '790';
		$data['data']['center']['map']['height'] = '250';
		
		$data['data']['center']['list']['VIEW_HEADER'] = "Product List";
		$data['data']['center']['list']['LIST'] = $products;
		
		$this->load->view('templates/left_center_template', $data);
	}
	
//	function view($id) {
//		global $GOOGLE_MAP_KEY;
//		
//		$data = array();
//		
//		// List of views to be included
//		$data['CENTER'] = array(
//				'ingredients' => 'ingredients',
//				'map' => 'includes/map',
//				'topics' => 'topics',
//				'impact' => 'impact',
//			);
//		
//		$data['RIGHT'] = array(
//				'image' => 'includes/right/image',
//				'ad' => 'includes/right/ad',
//				'info' => 'includes/right/info',
//				'nutrition' => 'includes/right/info',
//			);
//		
//		$data['BREADCRUMB'] = array(
//				'Home' => '/home',
//				'McDonald' => '/company/detail/2',
//				'Meat' => '',
//			);
//		
//		// Data to be passed to the views
//		// Center -> Ingredients		
//		$data['data']['center']['ingredients']['INGREDIENTS'] = array('cheese', 'meat', 'pepper');
//		
//		// Center -> Map
//		$data['data']['center']['map']['GOOGLE_MAP_KEY'] = $GOOGLE_MAP_KEY;
//		$data['data']['center']['map']['VIEW_HEADER'] = "Map showing where ingredients, items came from";
//		$data['data']['center']['map']['width'] = '650';
//		$data['data']['center']['map']['height'] = '200';
//		
//		
//		// Right -> Image
//		$data['data']['right']['image']['src'] = '/img/products/burger.jpg';
//		$data['data']['right']['image']['width'] = '300';
//		$data['data']['right']['image']['height'] = '200';
//		$data['data']['right']['image']['title'] = 'Burger Image';
//		
//		$data['data']['right']['info']['VIEW_HEADER'] = "Product Info";
//		
//		$data['data']['right']['nutrition']['VIEW_HEADER'] = "Nutritional Information";
//		
//		$this->load->view('templates/center_right_template', $data);
//	}
	
	/**
	 * Migration: 		Done
	 * Migrated by: 	Deepak
	 * 
	 * Verified: 		Yes
	 * Verified By: 	Deepak
	 */
	// list of products with fructose
	function fructose() {
		$data = array();
		
		// validate the data in the URL to make sure we don't have SQL injection
		$urlpage = substr($this->uri->segment(3),4,5);


		if(is_numeric($urlpage))
			$page = $urlpage-1;
		else
			$page = 0;
		
		if($this->input->get('pp')) {
			$number_perpage = $this->input->get('pp');
			
			if($number_perpage > 40)
				$perpage = 20;
			else
				$perpage = $number_perpage;
		} else
			$perpage = 10;
		
		// SEO
		$this->load->model('SeoModel');
		$seo = $this->SeoModel->getSeoDetailsFromPage('fructose_list');
		$data['SEO'] = $seo;

		// GET PRODUCT WITH FRUCTOSE
		$this->load->model('ProductModel', '', TRUE);
		$products = $this->ProductModel->getProductWithFructose($page, $perpage);

		// If entered page is greater than retrieved totalPages, redirect to last page
		if( $urlpage > $products['param']['totalPages'] )
			redirect("/product/fructose/page".$products['param']['totalPages']."?pp=".$products['param']['perPage']);

		// Views to include in the data array
		$data['CENTER'] = array(
				'list' => '/product/product_list',
			);
		
		$data['LEFT'] = array(
				'filter' => 'includes/left/product_filter',
			);
		
		// Center -> List
		$data['data']['center']['list']['FRUCTOSE'] = true;
		$data['data']['center']['list']['PRODUCTS'] = $products;
		
		$this->load->view('templates/left_center_template', $data);
	}
	
	/**
	 * Migration: 		Done
	 * Migrated by: 	Deepak
	 * 
	 * Verified: 		Yes
	 * Verified By: 	Deepak
	 */
	function ajaxSearchProducts() {
		$this->load->model('ProductModel', '', TRUE);
		$products = $this->ProductModel->getProductJson();
		echo json_encode($products);
	}
	
	/**
	 * Migration: 		Done
	 * Migrated by: 	Deepak
	 * 
	 * Verified: 		Yes
	 * Verified By: 	Deepak
	 */
	function get_products_for_auto_suggest() {
		$q = strtolower($_REQUEST['q']);
		
		$this->load->model('ProductModel', '', TRUE);
		$products = $this->ProductModel->searchProducts($q);
		echo $products;
	}
	
}

/* End of file product.php */

?>