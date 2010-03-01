<?php

class Country extends Controller {
	
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
		$this->list_country();
	}
	
	// List all the country in the database
	function list_country()
	{
		$this->load->model('country_model');
		
		// Get all the country in the database
		$query = $this->country_model->list_country();
		if($query)
		{
			$data['rows'] = $this->country_model->list_country();

			$data['main_content'] = 'admincp/country';
			$this->load->view('admincp/template', $data);
		}
		else
		{
			redirect('admincp/home');
		}
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
			$this->load->model('country_model');
			if($query = $this->country_model->add_country())
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