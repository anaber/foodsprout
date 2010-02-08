<?php

class Vegetable extends Controller {
	
	function index()
	{
		$data['main_content'] = 'vegetable';
		$this->load->view('templates/list_template', $data);
	}
	
}

/* End of file product.php */