<?php

class Product extends Controller {
	
	function __construct()
	{
		parent::Controller();
		if ($this->session->userdata('isAuthenticated') != 1 )
		{
			redirect('about/privatebeta');
		}
	}
	
	function index() {
		global $GOOGLE_MAP_KEY;
		
		$data = array();
		
		// Getting information from models
		$this->load->model('ProductModel');
		$products = $this->ProductModel->listproduct();
		
		// List of views to be included
		$data['LEFT'] = array(
				'ad' => 'includes/left/ad',
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
	
	function detail($id) {
		
		global $GOOGLE_MAP_KEY;
		
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'ingredients' => 'ingredients',
				'map' => 'includes/map',
				'topics' => 'topics',
				'impact' => 'impact',
			);
		
		$data['RIGHT'] = array(
				'image' => 'includes/right/image',
				'ad' => 'includes/right/ad',
				'info' => 'includes/right/info',
				'nutrition' => 'includes/right/info',
			);
		
		$data['BREADCRUMB'] = array(
				'Home' => '/home',
				'McDonald' => '/company/detail/2',
				'Meat' => '',
			);
		
		// Data to be passed to the views
		// Center -> Ingredients		
		$data['data']['center']['ingredients']['INGREDIENTS'] = array('cheese', 'meat', 'pepper');
		
		// Center -> Map
		$data['data']['center']['map']['GOOGLE_MAP_KEY'] = $GOOGLE_MAP_KEY;
		$data['data']['center']['map']['VIEW_HEADER'] = "Map showing where ingredients, items came from";
		$data['data']['center']['map']['width'] = '650';
		$data['data']['center']['map']['height'] = '200';
		
		
		// Right -> Image
		$data['data']['right']['image']['src'] = '/images/products/burger.jpg';
		$data['data']['right']['image']['width'] = '300';
		$data['data']['right']['image']['height'] = '200';
		$data['data']['right']['image']['title'] = 'Burger Image';
		
		$data['data']['right']['info']['VIEW_HEADER'] = "Product Info";
		
		$data['data']['right']['nutrition']['VIEW_HEADER'] = "Nutritional Information";
		
		$this->load->view('templates/center_right_template', $data);
	}

        function fructose($currentPage = 1, $dispPerPage = 10)
        {
                $hasFructose = 1;
                $data = array();
		$this->load->model('ProductModel');
		$productCount = $this->ProductModel->getProductCount($hasFructose);
		$products = $this->ProductModel->listProductDetails($hasFructose, $currentPage, $dispPerPage);

                
                // List of views to be included
		$data['LEFT'] = array(
				'ad' => 'includes/left/ad',
			);

		$data['CENTER'] = array(
				'list_product' => 'list_product',
			);


		$data['data']['center']['list_product']['VIEW_HEADER'] = "List of Products with Fructose";

		// Data to be passed to the views
		$data['data']['center']['list_product']['DISP_PER_PAGE'] = $dispPerPage;
		$data['data']['center']['list_product']['TOTAL_RECORD_COUNT'] = $productCount;
		$data['data']['center']['list_product']['CURRENT_PAGE'] = $currentPage;
		$data['data']['center']['list_product']['PRODUCTS'] = $products;
		$data['data']['center']['list_product']['PAGING_CALLBACK'] = "/product/fructose";

		$this->load->view('templates/left_center_template', $data);
        }
}

/* End of file product.php */

?>