<?php

class Animal extends Controller {
	
	function index()
	{
		$data['main_content'] = 'admincp/animal';
		$this->load->view('admincp/template', $data);
	}
}

/* End of file animal.php */

?>