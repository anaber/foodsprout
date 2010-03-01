<?php

class Ingredient extends Controller {
	
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
		$data['main_content'] = 'admincp/ingredient';
		$this->load->view('admincp/template', $data);
	}
}

/* End of file ingredient.php */

?>