<?php

class User extends Controller {
	
	function __construct() {
		// Ensure the user is logged in before allowing access to any of these methods
		parent::Controller();
		checkUserLogin();
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
	
	// The settings for the user
	function settings() {
		global $LANDING_PAGE;
		if ($this->session->userdata('isAuthenticated') != 1 ) {
			redirect($LANDING_PAGE);
		}
		
		$this->load->model('UserModel');
		$user = $this->UserModel->getUserFromId($this->session->userdata('userId'));
		
		// List of views to be included
		$data['CENTER'] = array(
				'form' => 'user/settings',
		);
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
	/*
	function ajaxCommentByUser() {
		$this->load->model('SupplierModel');
		$suppliers = $this->SupplierModel->getSuppliersByUserJson();
		
		echo json_encode($suppliers);
	}
	*/
	
}

?>