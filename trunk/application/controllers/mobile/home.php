<?php

class Home extends Controller {
	
	function __construct()
	{
		global $LANDING_PAGE;
		parent::Controller();
	}
	
	// Homepage
	function index() {
		
		$data = array();
		
		$this->load->model('SeoModel');
		$seo = $this->SeoModel->getSeoDetailsFromPage('index');
		$data['SEO'] = $seo;
		
		// List of views to be included
		$data['CENTER'] = array(
				'mainarea' => 'mobile/home',
			);
		
		$this->load->view('templates/mobile_template', $data);
	}
	
	
}

/* End of file home.php */

?>