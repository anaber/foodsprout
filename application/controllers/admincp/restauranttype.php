<?php

class Restauranttype extends Controller {
	
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
		$this->list_restauranttype();
	}
	
	// List all the restauranttype in the database
	function list_restauranttype()
	{
		$data = array();
		$restauranttypes = array();
		
		$this->load->model('RestauranttypeModel');
		$restauranttypes = $this->RestauranttypeModel->list_restauranttype();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/restauranttype',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "List of Restaurant Types";
		$data['data']['center']['list']['RESTAURANTTYPES'] = $restauranttypes;
		
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
	
	function save_add() {
		
		$this->load->model('RestauranttypeModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->RestauranttypeModel->addRestauranttype() ) {
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
		
		$this->load->model('RestauranttypeModel');
		$restauranttype = $this->RestauranttypeModel->getRestauranttypeFromId($id);
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/restauranttype_form',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Update Restaurant Type";
		$data['data']['center']['list']['RESTAURANTTYPE'] = $restauranttype;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function save_update() {
		
		$this->load->model('RestauranttypeModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->RestauranttypeModel->updateRestauranttype() ) {
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