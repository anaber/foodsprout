<?php

class Login extends Controller {
	
	function index()
	{
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/login',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Login";
		
		$this->load->view('admincp/templates/center_template', $data);
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