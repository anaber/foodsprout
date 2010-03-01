<?php

class Company extends Controller {
	
	function __construct()
	{
		parent::Controller();
		if ($this->session->userdata('isAuthenticated') != 1 )
		{
			redirect('admincp/login');
		}
	}
	
	function index()
	{
		$data['main_content'] = 'admincp/company';
		$this->load->view('admincp/template', $data);
	}
}

/* End of file company.php */

?>