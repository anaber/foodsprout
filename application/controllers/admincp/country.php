<?php

class Country extends Controller {
	
	function __construct()
	{
		global $ADMIN_LANDING_PAGE;
		parent::Controller();
		// This ensures that if the user is not logged in they cannot access this class at all
		if ($this->session->userdata('isAuthenticated') != 1 || $this->session->userdata('userGroup') != 'admin' )
		{
			redirect($ADMIN_LANDING_PAGE);
		}
	}
	
	// By default the index loads the list of countries
	function index()
	{
		$this->list_country();
	}
	
	// Search for a country
	function ajaxSearchCountry() {
		$this->load->model('CountryModel', '', TRUE);
		$countries = $this->CountryModel->getCountryJsonAdmin();
		echo json_encode($countries);
	}

	
	function add() {
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'form' => 'admincp/forms/country_form',
			);
		
		// Data to be passed to the views
		$data['data']['center']['form']['VIEW_HEADER'] = "Add Country";
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function update($id) {
		$data = array();
		
		$this->load->model('CountryModel');
		$country = $this->CountryModel->getCountryFromId($id);
		
		// List of views to be included
		$data['CENTER'] = array(
				'form' => 'admincp/forms/country_form',
			);
		
		// Data to be passed to the views
		$data['data']['center']['form']['VIEW_HEADER'] = "Update City";
		$data['data']['center']['form']['COUNTRY'] = $country;
		
		$this->load->view('admincp/templates/center_template', $data);
	}	
	
	// List all the country in the database
	function list_country()
	{
		$data = array();
		$countries = array();
		
		$this->load->model('CountryModel');
		$countries = $this->CountryModel->listCountry();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/country',
			);
			
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Countries";
		$data['data']['center']['list']['COUNTRIES'] = $countries;
		
		$this->load->view('admincp/templates/center_template', $data);
		
	}
	
	// Add a country to the database
	function save_add()
	{
		// field name, error message, validation rules
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('country_name', 'Country Name', 'trim|required');

		if($this->form_validation->run() == FALSE) {
			echo validation_errors();
		}else{
			$this->load->model('CountryModel');

			if($query = $this->CountryModel->addCountry())
				echo 'yes';
		}
		
	}

	// Update country
	function save_edit()
	{
		// field name, error message, validation rules
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('country_name', 'Country Name', 'trim|required');

		if($this->form_validation->run() == FALSE) {
			echo validation_errors();
		}else{
			$this->load->model('CountryModel');

			if($query = $this->CountryModel->updateCountry())
				echo 'yes';
		}
		
	}

}

/* End of file country.php */

?>