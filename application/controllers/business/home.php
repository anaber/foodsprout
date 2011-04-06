<?php

class Home extends Controller {
	
	
	function __construct() {
		parent::Controller();
	}
	
	function index() {
		$data = array();
		
		// Custom CSS
		$data['ASSETS']['CSS'] = array(
					//	'restaurant',
						);
		
		// Custom JS
		$data['ASSETS']['JS'] = array(
						'flowplayer/flowplayer-3.2.6.min',
						);
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'business/home',
			);
		
		$this->load->view('business/templates/center_template', $data);
	}
	
}

/* End of file login.php */

?>