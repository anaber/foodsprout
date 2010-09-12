<?php

class Item extends Controller {
	
	function __construct()
	{
		global $ADMIN_LANDING_PAGE;
		parent::Controller();
		if ($this->session->userdata('isAuthenticated') != 1 || $this->session->userdata('userGroup') != 'admin' )
		{
			redirect($ADMIN_LANDING_PAGE);
		}
	}
	
	function index()
	{
		$data['main_content'] = 'admincp/item';
		$this->load->view('admincp/template', $data);
	}
}

/* End of file state.php */

?>