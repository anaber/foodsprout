<?php

class Map extends Controller {
	
	function index()
	{
		$data['main_content'] = 'map';
		$this->load->view('templates/home_template', $data);
	}
	
}

/* End of file home.php */