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
		
	function signout()
	{
		$this->session->destroy();
		redirect('/');
	}
	
}



?>