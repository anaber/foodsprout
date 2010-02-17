<?php

class Fish extends Controller {
	
	function index()
	{
		$data['main_content'] = 'admincp/fish';
		$this->load->view('admincp/template', $data);
	}
}

/* End of file fish.php */

?>