<?php

class Country extends Controller {
	
	function __construct()
	{
		parent::Controller();
		// This ensures that if the user is not logged in they cannot access this class at all
		if ($this->session->userdata('isAuthenticated') != 1 || $this->session->userdata('userGroup') != 'admin' )
		{
			redirect('admincp/login');
		}
	}
	
	// By default the index loads the list of countries
	function index()
	{
		$this->list_country();
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
	function add_country()
	{
		// field name, error message, validation rules
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('country_name', 'Fish Name', 'trim|required');
		if($this->form_validation->run() == FALSE)
		{
			$this->index();
		}
		else
		{
			$this->load->model('CountryModel');
			if($query = $this->CountryModel->addCountry())
			{
				redirect('admincp/country');
			}
			else
			{
				$this->index();
			}
		}
		
	}
}

/* End of file country.php */

?>