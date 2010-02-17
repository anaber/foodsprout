<?php

class Distribution extends Controller {
	
	function index()
	{
		$data['main_content'] = 'admincp/distribution';
		$this->load->view('admincp/template', $data);
	}
}

/* End of file distribution.php */

?>