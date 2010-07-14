<?php

class Login extends Controller {
	
	function index()
	{
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'login',
		);
			
		$this->load->view('templates/center_template', $data);		
	}
	
	// Check the user's data is valid
	function validate()
	{
		$this->load->model('LoginModel', '', TRUE);
		$authenticated = $this->LoginModel->validateUser();
		
		if ($authenticated ==  false)
		{	
			if($this->session->userdata('accessBlocked') == 'yes')
			{
				echo 'blocked';
			}
			else
			{
				echo 'no';
			}
		}
		else
		{
			echo 'yes';
		}
		
	}
	
	// End a users session	
	function signout()
	{
		$this->session->sess_destroy();
		redirect('/');
	}
	
	// Create and add a new user to the database
	function create_user()
	{
		
		$this->load->library('form_validation');
		// field name, error message, validation rules
		
		//$this->form_validation->set_rules('firstname', 'Name', 'trim|required');
		//$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		//$this->form_validation->set_rules('zipcode', 'Zip Code', 'trim|required');
		//$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
		//$this->form_validation->set_rules('password2', 'Password Confirmation', 'trim|required|matches[password]');
		
		/* CI's validation engine creating issues, may be we are not using this correctly
		 * We may use this section to validate see if password mathes or not.
		 */
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		//$this->form_validation->set_rules('password2', 'Password Confirmation', 'trim|required');
		
		if($this->form_validation->run() == FALSE)
		{
			echo "passwordNotSame";
		}
		else
		{
			
			$this->load->model('UserModel');
			$create_user = $this->UserModel->create_user();
			
			if($create_user == true)
			{
				// Send the user to the dashboard
				// no need to send them from here. jquery will take care						
				//$this->dashboard();
				
				// Now send them a welcome email
				$this->load->library('email');

				$this->email->from('contact@foodsprout.com', 'Food Sprout');
				$this->email->to($this->input->post('email'));

				$this->email->subject('Welcome to Food Sprout, '.$this->input->post('firstname'));
				$this->email->message('Welcome '.$this->input->post('firstname').', \r\n \r\n Thank you for joining Food Sprout and taking an interest in learning more about where our food comes from and what is in it.  We hope you will also join us in sharing what information you have so that we may all benefit. \r\n \r\n Food Sprout Team');

				$this->email->send();
				echo 'yes';
			}
			else
			{
				$this->load->view('user/create_account');
			}
			
		}
	}
}



?>