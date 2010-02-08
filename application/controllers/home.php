<?php

class Home extends Controller {
	
	function index()
	{
		$data['main_content'] = 'home';
		$this->load->view('templates/home_template', $data);
	}
	
}

/* End of file home.php */