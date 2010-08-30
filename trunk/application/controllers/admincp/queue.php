<?php

class Queue extends Controller {
	
	function __construct()
	{
		parent::Controller();
		if ($this->session->userdata('isAuthenticated') != 1 || $this->session->userdata('userGroup') != 'admin' )
		{
			redirect('admincp/login');
		}
	}
	
	function index() {
		global $FARMER_TYPES;
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/farm_queue',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Farm - Queue";
		$data['data']['center']['list']['FARMER_TYPES'] = $FARMER_TYPES;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function farmersmarket() {
		global $FARMER_TYPES;
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/farmers_market_queue',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Farmers Market - Queue";
		$data['data']['center']['list']['FARMER_TYPES'] = $FARMER_TYPES;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function manufacture() {
		global $FARMER_TYPES;
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/manufacture_queue',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Manufacture - Queue";
		$data['data']['center']['list']['FARMER_TYPES'] = $FARMER_TYPES;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	
	function restaurant() {
		global $FARMER_TYPES;
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/restaurant_queue',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Restaurant - Queue";
		$data['data']['center']['list']['FARMER_TYPES'] = $FARMER_TYPES;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	
	function distributor() {
		global $FARMER_TYPES;
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/distributor_queue',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Distributor - Queue";
		$data['data']['center']['list']['FARMER_TYPES'] = $FARMER_TYPES;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function supplier() {
		global $FARMER_TYPES;
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/supplier_queue',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Suppliers - Queue";
		$data['data']['center']['list']['FARMER_TYPES'] = $FARMER_TYPES;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function menu() {
		global $FARMER_TYPES;
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/menu_queue',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Menu Items - Queue";
		$data['data']['center']['list']['FARMER_TYPES'] = $FARMER_TYPES;
		
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
}

/* End of file company.php */

?>