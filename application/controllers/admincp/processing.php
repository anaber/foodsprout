<?php

class Processing extends Controller {
	
	function index()
	{
		$data['main_content'] = 'admincp/processing';
		$this->load->view('admincp/template', $data);
	}
}

/* End of file state.php */

?>