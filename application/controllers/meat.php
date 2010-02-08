<?php

class Meat extends Controller {
	
	function index()
	{
		$data['main_content'] = 'meat';
		$this->load->view('templates/list_template', $data);
	}
	
}

/* End of file product.php */