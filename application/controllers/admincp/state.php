<?php

class State extends Controller {
	
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
		$this->list_state();
	}
	
	// List all the state in the database
	function list_state()
	{
		$this->load->model('StateModel');
		
		// Get all the state in the database
		$query = $this->StateModel->list_state();
		if($query)
		{
			$data['rows'] = $this->StateModel->list_state();

			$data['main_content'] = 'admincp/state';
			$this->load->view('admincp/template', $data);
		}
		else
		{
			redirect('admincp/home');
		}
	}
	
	// Add a state to the database
	function add_state()
	{
		// field name, error message, validation rules
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('state_name', 'Fish Name', 'trim|required');
		if($this->form_validation->run() == FALSE)
		{
			$this->index();
		}
		else
		{
			$this->load->model('StateModel');
			if($query = $this->StateModel->add_state())
			{
				redirect('admincp/state');
			}
			else
			{
				$this->index();
			}
		}
		
	}
}

/* End of file state.php */

?>