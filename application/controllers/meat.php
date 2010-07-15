<?php

class Meat extends Controller {
	
	function __construct()
	{
		parent::Controller();
	}
	function index()
	{
		$data['main_content'] = 'meat';
		$this->load->view('templates/list_template', $data);
	}
	
}

/* End of file meat.php */

?>