<?php

class State extends Controller {
	
	function index()
	{
		$data['main_content'] = 'admincp/state';
		$this->load->view('admincp/template', $data);
	}
}

/* End of file state.php */

?>