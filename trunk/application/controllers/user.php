<?php

class User extends Controller {
	
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
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'user/dashboard',
			);
		
		// Load all the views for the right column
		$data['RIGHT'] = array(
				'ad' => 'includes/banners/sky',
			);
		
		$this->load->model('RestaurantModel');
		$restaurant = $this->RestaurantModel->getRestaurantFromId(43);
		
		//$data['data']['center']['list']['VIEW_HEADER'] = "My Dashboard";
		$data['RESTAURANT'] = $restaurant;
		
		// Custom CSS
		$data['CSS'] = array(
						'dashboard'
					);
					
		$this->load->view('/dashboard/templates/center_right_template', $data);
	}
	
	// The default page after login, the users dashboard
	function dashboard() {
		global $LANDING_PAGE;
		if ($this->session->userdata('isAuthenticated') != 1 ) {
			redirect($LANDING_PAGE);
		}
		//	echo  $this->session->userdata('userId');
		
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
				'list' => 'user/dashboard',
			);
		
		// Load all the views for the right column
		$data['RIGHT'] = array(
				'ad' => 'includes/banners/sky',
			);
		
		//$this->load->model('RestaurantModel');
		//$restaurant = $this->RestaurantModel->getRestaurantFromId(43);
		
		//$data['data']['center']['list']['VIEW_HEADER'] = "My Dashboard";
		//$data['RESTAURANT'] = $restaurant;
		
		$data['data']['center']['list']['COUNTRIES'] = $countries;
		$data['data']['center']['list']['STATES'] = $states;
		$data['data']['center']['list']['RESTAURANT_TYPES'] = $restaurantTypes;
		$data['data']['center']['list']['CUISINES'] = $cuisines;
		
		// Custom CSS
		$data['CSS'] = array(
						'dashboard',
						//'js/fancybox/jquery.fancybox-1.3.4'
					);
					
		$this->load->view('/dashboard/templates/left_center_template', $data);
	}
	
	// The settings for the user
	function settings() {
		global $LANDING_PAGE;
                
                $this->load->helper('form');
        
		if ($this->session->userdata('isAuthenticated') != 1 ) {
			redirect($LANDING_PAGE);
		}
		
		$this->load->model('UserModel');
		$user = $this->UserModel->getUserFromId($this->session->userdata('userId'));
		
		// List of views to be included
		$data['CENTER'] = array(
				'form' => 'user/settings',
		);
                
                $this->load->model('CityModel');
                $this->load->model('StateModel');

                // get mapped city ID
                $defaultCity = ($user->defaultCity) ? $user->defaultCity : 41;
                
                $city = $this->CityModel->getCityFromId($defaultCity)->city;

                $state = $this->StateModel->getStateFromId($this->CityModel->getCityFromId($defaultCity)->stateId)->stateName;
                
                $data['data']['center']['form']['DEFAULT_CITY'] = ($city) ? $city . ', '. $state : null;

		$data['data']['center']['form']['USER'] = $user;

		
		$this->load->view('templates/center_template', $data);
	}
	
	function updateSettings() {
		global $LANDING_PAGE;
        
		if ($this->session->userdata('isAuthenticated') != 1 ) {
			redirect($LANDING_PAGE);
		}
		$this->load->model('UserModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->UserModel->updateUserSettings() ) {
			echo "yes";
		} else {
			if (isset($GLOBALS['error']) && !empty($GLOBALS['error']) ) {
				echo $GLOBALS['error'];
			} else {
				echo 'no';
			}
		}
	}
	
	// Display the page for the user to change their password
	function password() {
		global $LANDING_PAGE;
		if ($this->session->userdata('isAuthenticated') != 1 ) {
			redirect($LANDING_PAGE);
		}
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'user/password',
		);
			
		$this->load->view('templates/center_template', $data);
	}
	
	function updatePassword() {
		global $LANDING_PAGE;
		if ($this->session->userdata('isAuthenticated') != 1 ) {
			redirect($LANDING_PAGE);
		}
		
		$this->load->model('UserModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->UserModel->updatePassword() ) {
			echo "yes";
		} else {
			if (isset($GLOBALS['error']) && !empty($GLOBALS['error']) ) {
				echo $GLOBALS['error'];
			} else {
				echo 'no';
			}
		}
		
	}
	
	function create() {
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'user/create_account',
		);
		
		$this->load->view('/templates/center_template', $data);
	}
	
	function ajaxSuppliersByUser() {
		$this->load->model('SupplierModel');
		$suppliers = $this->SupplierModel->getSuppliersByUserJson();
		
		echo json_encode($suppliers);
	}
	
	function ajaxMenuByUser() {
		$this->load->model('ProductModel');
		$menu = $this->ProductModel->getProductByUserJson();
		
		echo json_encode($menu);
	}
	
	function ajaxCommentsByUser() {
		$this->load->model('CommentModel');
		$comments = $this->CommentModel->getCommentsFromUserJson();
		
		echo json_encode($comments);
	}
	
	function ajaxRestaurantsByUser() {
		$this->load->model('ProducerModel');
		$restaurants = $this->ProducerModel->getProducersByUserJson('restaurant');
		
		echo json_encode($restaurants);
	}
	
	function ajaxFarmsByUser() {
		$this->load->model('ProducerModel');
		$farms = $this->ProducerModel->getProducersByUserJson('farm');
		
		echo json_encode($farms);
	}
	
	function ajaxFarmersMarketsByUser() {
		$this->load->model('ProducerModel');
		$markets = $this->ProducerModel->getProducersByUserJson('farmers_market');
		
		echo json_encode($markets);
	}
}

?>