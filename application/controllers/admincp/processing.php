<?php

class Processing extends Controller {
	
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
		$data['main_content'] = 'admincp/processing';
		$this->load->view('admincp/template', $data);
	}
}

/* End of file state.php */

?>