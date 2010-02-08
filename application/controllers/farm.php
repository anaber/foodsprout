<?php

class Farm extends Controller {
	
	function index()
	{
		$data['main_content'] = 'farm/farm_list';
		$this->load->view('templates/list_template', $data);
	}
	
}

/* End of file product.php */