<?php

class Farm extends Controller {
	
	function index()
	{
		$data['main_content'] = 'admincp/farm';
		$this->load->view('admincp/template', $data);
	}
}

/* End of file farm.php */

?>