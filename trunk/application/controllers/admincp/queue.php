<?php

class Queue extends Controller {
	
	function __construct()
	{
		global $ADMIN_LANDING_PAGE;
		parent::Controller();
		if ($this->session->userdata('isAuthenticated') != 1 || $this->session->userdata('access') != 'admin' )
		{
			redirect($ADMIN_LANDING_PAGE);
		}
	}
	
	function index() {
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/farm_queue',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Farm - Queue";
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function farmersmarket() {
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/farmers_market_queue',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Farmers Market - Queue";
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function manufacture() {
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/manufacture_queue',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Manufacture - Queue";
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function restaurant() {
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/restaurant_queue',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Restaurant - Queue";
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	
	function distributor() {
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/distributor_queue',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Distributor - Queue";
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function supplier() {
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/supplier_queue',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Suppliers - Queue";
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function menu() {
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/menu_queue',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Menu Items - Queue";
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function ajaxQueueFarms() {
		$this->load->model('FarmModel', '', TRUE);
		$farms = $this->FarmModel->getQueueFarmsJson();
		echo json_encode($farms);
	}
	
	function ajaxQueueRestaurants() {
		$this->load->model('RestaurantModel', '', TRUE);
		$restaurants = $this->RestaurantModel->getQueueRestaurantsJson();
		echo json_encode($restaurants);
	}
	
	function ajaxQueueManufactures() {
		$this->load->model('ManufactureModel', '', TRUE);
		$manufactures = $this->ManufactureModel->getQueueManufacturesJson();
		echo json_encode($manufactures);
	}
	
	function ajaxQueueDistributors() {
		$this->load->model('DistributorModel', '', TRUE);
		$distributors = $this->DistributorModel->getQueueDistributorJson();
		echo json_encode($distributors);
	}
	
	function ajaxQueueFarmersMarket() {
		$this->load->model('FarmersMarketModel', '', TRUE);
		$farmersMarket = $this->FarmersMarketModel->getQueueFarmersMarketJson();
		echo json_encode($farmersMarket);
	}
	
	function ajaxQueueSuppliers() {
		$this->load->model('SupplierModel', '', TRUE);
		$suppliers = $this->SupplierModel->getQueueSuppliersJson();
		echo json_encode($suppliers);
	}
	
	function ajaxQueueMenuItems() {
		$this->load->model('ProductModel', '', TRUE);
		$products = $this->ProductModel->getQueueProductsJson();
		echo json_encode($products);
	}
	
}

/* End of file queue.php */

?>