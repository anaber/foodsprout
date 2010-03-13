<?php

class Fish extends Controller {
	
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
		$this->list_fish();
	}
	
	// List all the fish in the database
	function list_fish()
	{
		$this->load->model('FishModel');
		
		// Get all the fish in the database
		$query = $this->FishModel->list_fish();
		if($query)
		{
			$data['rows'] = $this->FishModel->list_fish();

			$data['main_content'] = 'admincp/fish';
			$this->load->view('admincp/template', $data);
		}
		else
		{
			redirect('admincp/home');
		}
	}
	
	// Add a fish to the database
	function add_fish()
	{
		// field name, error message, validation rules
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('fish_name', 'Fish Name', 'trim|required');
		if($this->form_validation->run() == FALSE)
		{
			$this->index();
		}
		else
		{
			$this->load->model('fish_model');
			if($query = $this->fish_model->add_fish())
			{
				redirect('admincp/fish');
			}
			else
			{
				$this->index();
			}
		}
		
	}
}

/* End of file fish.php */

?>