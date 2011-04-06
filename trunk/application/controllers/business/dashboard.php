<?php
/*
 * Created on Mar 1, 2010
 *
 * Author: Deepak Kumar
 */

class Dashboard extends Controller {
	
	function __construct()
	{
		global $BUSINESS_LANDING_PAGE;
		parent::Controller();
		if ($this->session->userdata('isAuthenticated') != 1 || $this->session->userdata('userGroup') != 'business' )
		{
			redirect($BUSINESS_LANDING_PAGE);
		}
	}
	
	function index()
	{
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