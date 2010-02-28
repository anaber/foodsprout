<?php
/*
 * Created on Mar 1, 2010
 *
 * Author: Deepak Kumar
 */

class Dashboard extends Controller {
	
	function index()
	{
		$data['main_content'] = 'admincp/dashboard';
		$this->load->view('admincp/template', $data);
	}
}

/* End of file company.php */

?>