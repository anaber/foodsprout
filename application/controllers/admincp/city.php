<?php

class City extends Controller {
	
	function __construct()
	{
		global $ADMIN_LANDING_PAGE;
		parent::Controller();
		if ($this->session->userdata('isAuthenticated') != 1 || $this->session->userdata('userGroup') != 'admin' )
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
}



?>