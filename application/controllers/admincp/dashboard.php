<?php
/*
 * Created on Mar 1, 2010
 *
 * Author: Deepak Kumar
 */

class Dashboard extends Controller {
	
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
		$data['main_content'] = 'admincp/dashboard';
		$this->load->view('admincp/template', $data);
	}
}

/* End of file dashboard.php */

?>