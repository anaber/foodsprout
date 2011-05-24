<?php

class Claim extends Controller {
	
	function __construct() {
		parent::Controller();
	}
	
	function index($producerId, $addressId = '') {
		global $BUSINESS_LANDING_PAGE;
		
		$loginUrl = $BUSINESS_LANDING_PAGE . "?frm=business/claim/" . $producerId . ( !empty($addressId) ? ',' . $addressId : '');
		if ($this->session->userdata('isAuthenticated') != 1 ) {
			redirect($loginUrl);
		} else {
			die('Claim here');
		}
		
		$data = array();
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'business/dashboard',
			);
			
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Business Services";
		
		$this->load->view('business/templates/center_template', $data);
	}
}

/* End of file dashboard.php */

?>