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
						
		// List of views to be included
        $data['NAV'] = array(
            'navigation' => 'business/left_nav',
        );
		
		// List of views to be included
		$data['MAIN'] = array(
				'list' => 'business/home',
			);
		
		// Data to send to the views
		$data['BREADCRUMB'] = array(
							'Business' => '/business',
							'Food Sprout For Your Business' => '',
						);

        $this->load->view('/business/templates/sales_front', $data);
	}
	
}

/* End of file login.php */

?>