<?php

class User extends Controller {
	
	function index()
	{
		$data['main_content'] = 'user/create_account';
		$this->load->view('templates/basic_template', $data);		
	}
	
	// Create and add a new user to the database
	function create_user()
	{
		
		$this->load->library('form_validation');
		// field name, error message, validation rules
		
		$this->form_validation->set_rules('firstname', 'Name', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('zipcode', 'Zip Code', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
		$this->form_validation->set_rules('password2', 'Password Confirmation', 'trim|required|matches[password]');
		if($this->form_validation->run() == FALSE)
		{
			$this->index();
		}
		
		else
		{
			$this->load->model('user_model');
			$create_user = $this->user_model->create_user();
			
			if($create_user == true)
			{
				// Send the user to the dashboard						
				$this->dashboard();
				
				// Now send them a welcome email
				$this->load->library('email');

				$this->email->from('welcom@foodproject', 'foodproject');
				$this->email->to($this->input->post('email'));

				$this->email->subject('Welcome to foodproject, '.$this->input->post('firstname'));
				$this->email->message('Welcome to foodproject');

				$this->email->send();

			}
			else
			{
				$this->load->view('user/create_account');
			}
		}
	}	

	// The default page after login, the users dashboard
	function dashboard()
	{
		$data['main_content'] = 'user/dashboard';
		$this->load->view('templates/basic_template', $data);
	}
	
}



?>