<?php

class Why extends Controller {
	
	
	function __construct() {
		parent::Controller();
	}
	
	function index() {
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'business/why',
			);
		
		$this->load->view('business/templates/center_template', $data);
	}
}

/* End of file login.php */

?>