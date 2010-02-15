<?php

class Login extends Controller {
	
	function index()
	{
		$data['main_content'] = 'admincp/login';
		$this->load->view('admincp/template', $data);
	}
	
	// Check to see that the user is valid
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
			
		}
		else
		{
			 redirect('admincp/login');
		}
		
	}
	
}

/* End of file login.php */