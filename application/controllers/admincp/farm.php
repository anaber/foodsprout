<?php

class Farm extends Controller {
	
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
		$data['main_content'] = 'admincp/farm';
		$this->load->view('admincp/template', $data);
	}
}

/* End of file farm.php */

?>