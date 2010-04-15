<?php

class RestaurantType extends Controller {
	
	function __construct()
	{
		parent::Controller();
		if ($this->session->userdata('isAuthenticated') != 1 )
		{
			redirect('admincp/login');
		}
	}
	
	function index()
	{
		$this->listRestaurantType();
	}
	
	// List all the restauranttype in the database
	function listRestaurantType()
	{
		$data = array();
		$restaurantTypes = array();
		
		$this->load->model('RestaurantTypeModel');
		$restaurantTypes = $this->RestaurantTypeModel->listRestaurantType();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/restauranttype',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "List of Restaurant Types";
		$data['data']['center']['list']['RESTAURANTTYPES'] = $restaurantTypes;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function add()
	{
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/restauranttype_form',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Add Restaurant Type";
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function saveAdd() {
		
		$this->load->model('RestaurantTypeModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->RestaurantTypeModel->addRestaurantType() ) {
			echo "yes";
		} else {
			if (isset($GLOBALS['error']) && !empty($GLOBALS['error']) ) {
				echo $GLOBALS['error'];
			} else {
				echo 'no';
			}
		}
	}
	
	function update($id)
	{
		$data = array();
		
		$this->load->model('RestaurantTypeModel');
		$restaurantType = $this->RestaurantTypeModel->getRestaurantTypeFromId($id);
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/restauranttype_form',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Update Restaurant Type";
		$data['data']['center']['list']['RESTAURANTTYPE'] = $restaurantType;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function saveUpdate() {
		
		$this->load->model('RestaurantTypeModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->RestaurantTypeModel->updateRestaurantType() ) {
			echo "yes";
		} else {
			if (isset($GLOBALS['error']) && !empty($GLOBALS['error']) ) {
				echo $GLOBALS['error'];
			} else {
				echo 'no';
			}
		}
		
	}
}

/* End of file restauranttype.php */

?>