<?php

class Company extends Controller {
	
	function index()
	{
		$data['main_content'] = 'admincp/company';
		$this->load->view('admincp/template', $data);
	}
}

/* End of file company.php */

?>