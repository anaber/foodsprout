<?php

class Dashboard extends Controller {
	
	function __construct() {
		// Ensure the user is logged in before allowing access to any of these methods
		parent::Controller();
		checkUserLogin();
		checkUserAgent();
	}
	
	// The default for the user is the dashboard
	function index() {
		global $LANDING_PAGE;
		if ($this->session->userdata('isAuthenticated') != 1 ) {
			redirect($LANDING_PAGE);
		}
		//	echo  $this->session->userdata('userId');
		
		$userId = $this->session->userdata['userId'];
		$page = 'dashboard';
		$this->load->model('PortletModel', '', TRUE);
        $portlet = $this->PortletModel->getPortletPositon($userId, $page);
        
        $data['LEFT'] = array(
				'options' => 'dashboard/includes/dashboard_options',
			);
		
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'dashboard/home',
			);
		
		// Custom CSS
		$data['CSS'] = array(
						'dashboard',
						'jquery-ui/jquery.ui.slider',
						'jquery-ui/jquery.ui.theme',
					);
		
		$data['data']['center']['list']['PORTLET'] = $portlet;
		$data['data']['center']['list']['PAGE'] = $page;
		
		$this->load->view('/dashboard/templates/left_center_template', $data);
	}
	
	// The default for the user is the dashboard
	function foodLog() {
		global $LANDING_PAGE;
		
		$data['LEFT'] = array(
				'options' => 'dashboard/includes/dashboard_options',
			);
		
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'dashboard/foodlog',
			);
		
		// Custom CSS
		$data['CSS'] = array(
						'dashboard',
					);
		
		$this->load->view('/dashboard/templates/left_center_template', $data);
	}
	
	// The default for the user is the dashboard
	function comments() {
		global $LANDING_PAGE;
		
		$data['LEFT'] = array(
				'options' => 'dashboard/includes/dashboard_options',
			);
		
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'dashboard/comments',
			);
		
		// Custom CSS
		$data['CSS'] = array(
						'dashboard',
					);
		
		$this->load->view('/dashboard/templates/left_center_template', $data);
	}
	
	// The default for the user is the dashboard
	function data() {
		global $LANDING_PAGE;
		
		$data['LEFT'] = array(
				'options' => 'dashboard/includes/dashboard_options',
			);
		
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'dashboard/data',
			);
		
		// Custom CSS
		$data['CSS'] = array(
						'dashboard',
					);
		
		$this->load->view('/dashboard/templates/left_center_template', $data);
	}
	
	// The default for the user is the dashboard
	function manageData() {
		global $LANDING_PAGE;
		
		$data['LEFT'] = array(
				'options' => 'dashboard/includes/dashboard_options',
			);
		
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'dashboard/managedata',
			);
		
		// Custom CSS
		$data['CSS'] = array(
						'dashboard',
					);
		
		$this->load->view('/dashboard/templates/left_center_template', $data);
	}
	
	// The default for the user is the dashboard
	function restaurants() {
		global $LANDING_PAGE;
		if ($this->session->userdata('isAuthenticated') != 1 ) {
			redirect($LANDING_PAGE);
		}
		//	echo  $this->session->userdata('userId');
		
		$data['LEFT'] = array(
				'options' => 'dashboard/includes/dashboard_options',
			);
		
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'dashboard/restaurants',
			);
		
		// Custom CSS
		$data['CSS'] = array(
						'dashboard',
					);
					
		$this->load->view('/dashboard/templates/left_center_template', $data);
	}
	
	// The default for the user is the dashboard
	function farms() {
		global $LANDING_PAGE;
		if ($this->session->userdata('isAuthenticated') != 1 ) {
			redirect($LANDING_PAGE);
		}
		//	echo  $this->session->userdata('userId');
		
		$data['LEFT'] = array(
				'options' => 'dashboard/includes/dashboard_options',
			);
		
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'dashboard/farms',
			);
		
		// Custom CSS
		$data['CSS'] = array(
						'dashboard',
					);
					
		$this->load->view('/dashboard/templates/left_center_template', $data);
	}
	
	// The default for the user is the dashboard
	function markets() {
		global $LANDING_PAGE;
		if ($this->session->userdata('isAuthenticated') != 1 ) {
			redirect($LANDING_PAGE);
		}
		//	echo  $this->session->userdata('userId');
		
		$data['LEFT'] = array(
				'options' => 'dashboard/includes/dashboard_options',
			);
		
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'dashboard/markets',
			);
		
		// Custom CSS
		$data['CSS'] = array(
						'dashboard',
					);
				
		$this->load->view('/dashboard/templates/left_center_template', $data);
	}
	
	// The default for the user is the dashboard
	function menu() {
		global $LANDING_PAGE;
		
		$data['LEFT'] = array(
				'options' => 'dashboard/includes/dashboard_options',
			);
		
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'dashboard/menu',
			);
		
		// Custom CSS
		$data['CSS'] = array(
						'dashboard',
					);
		
		$this->load->view('/dashboard/templates/left_center_template', $data);
	}
	
	// The default for the user is the dashboard
	function suppliers() {
		global $LANDING_PAGE;
		
		$data['LEFT'] = array(
				'options' => 'dashboard/includes/dashboard_options',
			);
		
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'dashboard/suppliers',
			);
		
		// Custom CSS
		$data['CSS'] = array(
						'dashboard',
					);
		
		$this->load->view('/dashboard/templates/left_center_template', $data);
	}
	
	function addrestaurant() {
		
		$this->load->model('StateModel');
		$states = $this->StateModel->listState();
		
		$this->load->model('CountryModel');
		$countries = $this->CountryModel->listCountry();
		
		$this->load->model('ProducerCategoryModel');
		$restaurantTypes = $this->ProducerCategoryModel->listProducerCategory('RESTAURANT', '');
		$cuisines = $this->ProducerCategoryModel->listProducerCategory('CUISINE', '');
		
		$data['LEFT'] = array(
				'options' => 'dashboard/includes/dashboard_options',
			);
		
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'dashboard/restaurant_form',
			);
		
		// Custom CSS
		$data['CSS'] = array(
						'dashboard',
						'jquery.validationEngine'
					);
		
		$data['data']['center']['list']['COUNTRIES'] = $countries;
		$data['data']['center']['list']['STATES'] = $states;
		$data['data']['center']['list']['RESTAURANT_TYPES'] = $restaurantTypes;
		$data['data']['center']['list']['CUISINES'] = $cuisines;
		
		$this->load->view('/dashboard/templates/left_center_template', $data);
	}
	
	function addfarm() {
		
		$this->load->model('StateModel');
		$states = $this->StateModel->listState();
		
		$this->load->model('CountryModel');
		$countries = $this->CountryModel->listCountry();
		
		$this->load->model('ProducerCategoryModel');
		$farmTypes = $this->ProducerCategoryModel->listProducerCategory('FARM', '');
		
		$this->load->model('ProducerCategoryModel');
		$farmCrops = $this->ProducerCategoryModel->listProducerCategory('FARM_CROP', '');
		
		$this->load->model('ProducerCategoryModel');
		$certifications = $this->ProducerCategoryModel->listProducerCategory('CERTIFICATION', '');
		
		$data['LEFT'] = array(
				'options' => 'dashboard/includes/dashboard_options',
			);
		
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'dashboard/farm_form',
			);
		
		// Custom CSS
		$data['CSS'] = array(
						'dashboard',
						'jquery.validationEngine'
					);
		
		$data['data']['center']['list']['COUNTRIES'] = $countries;
		$data['data']['center']['list']['STATES'] = $states;
		$data['data']['center']['list']['FARM_TYPES'] = $farmTypes;
		$data['data']['center']['list']['FARM_CROPS'] = $farmCrops;
		$data['data']['center']['list']['CERTIFICATIONS'] = $certifications;
		
		
		
		$this->load->view('/dashboard/templates/left_center_template', $data);
	}
}

?>