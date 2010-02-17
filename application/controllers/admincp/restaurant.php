<?php

class Restaurant extends Controller {
	
	function index()
	{
		$data['main_content'] = 'admincp/restaurant';
		$this->load->view('admincp/template', $data);
	}
}

/* End of file restaurant.php */

?>