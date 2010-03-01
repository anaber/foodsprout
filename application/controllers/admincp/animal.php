<?php

class Animal extends Controller {
	
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
		$this->list_animal();
	}
	
	// List all the animal in the database
	function list_animal()
	{
		$this->load->model('animal_model');
		
		// Get all the animal in the database
		$query = $this->animal_model->list_animal();
		if($query)
		{
			$data['rows'] = $this->animal_model->list_animal();

			$data['main_content'] = 'admincp/animal';
			$this->load->view('admincp/template', $data);
		}
		else
		{
			redirect('admincp/home');
		}
	}
	
	// Add a animal to the database
	function add_animal()
	{
		// field name, error message, validation rules
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('animal_name', 'Fish Name', 'trim|required');
		if($this->form_validation->run() == FALSE)
		{
			$this->index();
		}
		else
		{
			$this->load->model('animal_model');
			if($query = $this->animal_model->add_animal())
			{
				redirect('admincp/animal');
			}
			else
			{
				$this->index();
			}
		}
		
	}
}

/* End of file animal.php */

?>