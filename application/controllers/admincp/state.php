<?php

class State extends Controller {
	
	function __construct()
	{
		parent::Controller();
		// To do, add something to make sure the user is an admin and can view this class
		//$this->is_logged_in();	
	}
	
	function index()
	{
		$this->list_state();
	}
	
	// List all the state in the database
	function list_state()
	{
		$this->load->model('state_model');
		
		// Get all the state in the database
		$query = $this->state_model->list_state();
		if($query)
		{
			$data['rows'] = $this->state_model->list_state();

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
			$this->load->model('state_model');
			if($query = $this->state_model->add_state())
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