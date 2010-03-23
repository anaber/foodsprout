<?php

class State extends Controller {
	
	function __construct()
	{
		parent::Controller();
		
		// This ensures that if the user is not logged in they cannot access this class at all
		if ($this->session->userdata('isAuthenticated') != 1 )
		{
			redirect('admincp/login');
		}
	}
	
	// By default the index loads the list of countries
	function index()
	{
		$this->list_state();
	}
	
	// List all the state in the database
	function list_state()
	{
		$data = array();
		$states = array();
		
		$this->load->model('StateModel');
		$states = $this->StateModel->list_state();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/state',
			);
			
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "States";
		$data['data']['center']['list']['STATES'] = $states;
		
		$this->load->view('admincp/templates/center_template', $data);
		
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