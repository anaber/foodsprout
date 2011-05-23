<?php

class Success extends Controller {
	
	
	function __construct() {
		parent::Controller();
	}
	
	function index() {
		$data = array();
		
		// Data to send to the views
		$data['BREADCRUMB'] = array(
							'Business' => '/business',
							'Success Stories' => '',
						);
		
		// List of views to be included
        $data['NAV'] = array(
            'navigation' => 'business/left_nav',
        );
		
		// List of views to be included
		$data['MAIN'] = array(
				'list' => 'business/success-stories',
			);
		
		$this->load->view('business/templates/sales_front', $data);
	}
}

/* End of file login.php */

?>