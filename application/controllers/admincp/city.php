<?php

class City extends Controller {
	
	function __construct()
	{
		global $ADMIN_LANDING_PAGE;
		parent::Controller();
		if ($this->session->userdata('isAuthenticated') != 1 || $this->session->userdata('access') != 'admin' )
		{
			redirect($ADMIN_LANDING_PAGE);
		}
	}
	
	function index()
	{	
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/city',
			);
			
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Cities";
		
		$this->load->view('admincp/templates/center_template', $data);		
	}
	
	// Search for a city
	function ajaxSearchCity() {
		$this->load->model('CityModel', '', TRUE);
		$cities = $this->CityModel->getCityJsonAdmin();
		echo json_encode($cities);
	}
	
	function add() {
		$data = array();
		
		$this->load->model('StateModel');
		$states = $this->StateModel->listState();
		
		// List of views to be included
		$data['CENTER'] = array(
				'form' => 'admincp/forms/city_form',
			);
		
		// Data to be passed to the views
		$data['data']['center']['form']['VIEW_HEADER'] = "Add City";
		$data['data']['center']['form']['STATES'] = $states;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function update($id) {
		$data = array();
		
		$this->load->model('CityModel');
		$city = $this->CityModel->getCityFromId($id);
		
		$this->load->model('StateModel');
		$states = $this->StateModel->listState();
		
		// List of views to be included
		$data['CENTER'] = array(
				'form' => 'admincp/forms/city_form',
			);
		
		// Data to be passed to the views
		$data['data']['center']['form']['VIEW_HEADER'] = "Update City";
		$data['data']['center']['form']['CITY'] = $city;
		$data['data']['center']['form']['STATES'] = $states;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function save_add() {
		$this->load->model('CityModel', '', TRUE);
		
		$city = $this->input->post('city');
		$stateId = $this->input->post('stateId');
		
		$GLOBALS = array();
		if ( $this->CityModel->addCity($city, $stateId) ) {
			echo 'yes';
		} else {
			if (isset($GLOBALS['error']) && !empty($GLOBALS['error']) ) {
				echo $GLOBALS['error'];
			} else {
				echo 'no';
			}
		}
	}
	
	function save_update() {
		$this->load->model('CityModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->CityModel->updateCity() ) {
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



?>