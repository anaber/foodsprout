<?php

class Home extends Controller {
	
	function index()
	{
		global $GOOGLE_MAP_KEY;
		
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'home',
			);
		
		$this->load->view('templates/center_template', $data);
		
	}
	
}

/* End of file home.php */

?>