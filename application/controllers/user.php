<?php

class User extends Controller {
	
	function index()
	{
		$data['main_content'] = 'user/create_account';
		$this->load->view('templates/basic_template', $data);		
	}
	
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
			if($query = $this->user_model->create_user())
			{
										
				// let's go ahead and set their session now
				$this->load->model('login_model');
				$query = $this->user_model->validate();
				
				// Now send them a welcome email
				$this->load->library('email');

				$this->email->from('welcom@foodproject', 'foodproject');
				$this->email->to($this->input->post('email'));

				$this->email->subject('Welcome to foodproject, '.$this->input->post('firstname'));
				$this->email->message('Welcome to foodproject');

				$this->email->send();

				// Uncomment below to view message
				// echo $this->email->print_debugger();
			}
			else
			{
				$this->load->view('user/create_account');
			}
		}
	}	
}



?>