<?php

class Login extends Controller {
	
	function index()
	{
		$data['main_content'] = 'signup_form';
		$this->load->view('includes/template-home', $data);		
	}
	
	function validate()
	{
		
		$this->load->model('user_model');
		$query = $this->user_model->validate();
		
		if($query)  // if the user is validated..
		{
			$query = $this->db->query("SELECT userid,firstname FROM user WHERE email='".$this->input->post('email')."'");

			if ($query->num_rows() > 0)
			{
			   $row = $query->row();
			   $userid = $row->userid;
			   $name = $row->firstname;
			}		
			
			$data = array(
				'email' => $this->input->post('email'),
				'userid' => $userid,
				'name' => $name,
				'is_logged_in' => true
			);
				
			$this->session->set_userdata($data);
			
			// Did the user come from the view hint page?
			if($this->input->post('reply') == 1) //Yes
			{
				//$this->session->set_flashdata('hintcode', $this->input->post('hintcode'));
				redirect('hint/reply/'.$this->input->post('hintcode'));
			}
			else //No
			{
				redirect('hint');
			}
			
			
		}
		else
		{
			 redirect('login/error');
		}
		
	}
	
	function error()
	{
		$data['main_content'] = 'login_error';
		$this->load->view('includes/template-home', $data);		
	}
	
	function signup()
	{
		$data['main_content'] = 'signup_form';
		$this->load->view('includes/template-home', $data);
	}
	
	function create_user()
	{
		
		$this->load->library('form_validation');
		// field name, error message, validation rules
		
		$this->form_validation->set_rules('firstname', 'Name', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
		$this->form_validation->set_rules('password2', 'Password Confirmation', 'trim|required|matches[password]');
		if($this->form_validation->run() == FALSE)
		{
			$this->signup();
		}
		else
		{
			$this->load->model('user_model');
			if($query = $this->user_model->create_user())
			{
										
				// let's go ahead and set their session now
				$this->load->model('user_model');
				$query = $this->user_model->validate();

				if($query)  // if the user is validated...
				{
					// Get their userid and name so we can set it in the session now
					$query = $this->db->query("SELECT userid,firstname,email FROM user WHERE email='".$this->input->post('email')."'");

					if ($query->num_rows() > 0)
					{
					   	$row = $query->row();
						$userid = $row->userid;
						$name = $row->firstname;
						$email = $row->email;
					}
					
					// Put all the data into the array for the session
					$data = array(
						'email' => $email,
						'userid' => $userid,
						'name' => $name,
						'is_logged_in' => true
					);

					// Put the data into the session
					$this->session->set_userdata($data);
					
					// Did they come from the view hint page?
					if($this->input->post('reply') == 1)
					{
						// user craeation was good
						$this->session->set_flashdata('hintcode', $this->input->post('hintcode'));
						redirect('hint/reply');
					}
					else
					{
										
						// Display all the categories for after the first hint box
						$this->load->model('category_model');
						$data['rows'] = $this->category_model->getCategory();
					
						// user creation was successful so load the page
						$data['main_content'] = 'signup_success';
						$this->load->view('includes/template-home', $data);
					}
				}
				else
				{
					 $this->index();
				}
				
				// Now send them a welcome email
				$this->load->library('email');

				$this->email->from('hint@hinthound.com', 'HintHound');
				$this->email->to($this->input->post('email'));

				$this->email->subject('Welcome to HintHound, '.$this->input->post('firstname'));
				$this->email->message('Welcome to HintHound! We provide a fun and exciting form of correspondence that puts zest back in the lives of millions of our users, whether it be re-sparking romance for a couple or helping facilitate a dialog that would have otherwise gone unspoken.
				
HintHound is America\'s favorite courier for your private messages. Let us help spice up your life and those around you! Start HintHounding today.');

				$this->email->send();

				// Uncomment below to view message
				// echo $this->email->print_debugger();
			}
			else
			{
				$this->load->view('signup_form');
			}
		}
	}
	
	function signout()
	{
		$this->session->destroy();
		redirect('/');
	}
	
}



?>