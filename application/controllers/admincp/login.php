<?php

class Login extends Controller {
	
	
	function __construct()
	{
		parent::Controller();
		
		if ($this->session->userdata('isAuthenticated') == 1 ) {
			if ($this->session->userdata('access') == 'admin' ) {
				redirect('/admincp/dashboard');
			} else {
				redirect('/');
			}
		}
		
	}
	
	function index()
	{
		$data = array();
		
		//print_r_pre($this->session->userdata);
		
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
		
		$this->load->model('LoginModel', '', TRUE);
		$authenticated = $this->LoginModel->validateAdmin();
		
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