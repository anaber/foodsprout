<?php

class Processing extends Controller {
	
	function index()
	{
		$data['main_content'] = 'processing';
		$this->load->view('templates/list_template', $data);
	}
	
}

/* End of file product.php */