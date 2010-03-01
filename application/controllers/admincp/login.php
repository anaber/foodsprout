<?php

class Login extends Controller {
	
	function index()
	{
		$data['main_content'] = '';
		$this->load->view('admincp/login', $data);
	}
	
	// Check to see that the user is valid
	function validate()
	{
		
		$this->load->model('login_model', '', TRUE);
		$authenticated = $this->login_model->validateAdmin();
		
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
	
}

/* End of file login.php */

?>