<?php

class Why extends Controller {
	
	
	function __construct() {
		parent::Controller();
	}
	
	function index() {
		$data = array();
		
		// List of views to be included
        $data['NAV'] = array(
            'navigation' => 'business/left_nav',
        );

		// Data to send to the views
		$data['BREADCRUMB'] = array(
							'Business' => '/business',
							'Why Food Sprout' => '',
						);
		
		// List of views to be included
		$data['MAIN'] = array(
				'list' => 'business/why',
			);
		
		$this->load->view('business/templates/sales_front', $data);
	}
}

/* End of file login.php */

?>