<?php

class Home extends Controller {
	
	function __construct()
	{
		parent::Controller();
		if ($this->session->userdata('isAuthenticated') != 1 )
		{
			redirect('about/privatebeta');
		}
	}
	
	// Homepage
	function index()
	{
		$data = array();
		
		$this->load->model('SeoModel');
		$seo = $this->SeoModel->getSeoDetailsFromPage('index');
		$data['SEO'] = $seo;
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'home',
			);
			
		// Custom CSS
		$data['CSS'] = array(
				'home'
			);
		
		$this->load->view('templates/center_template', $data);
	}
	
	
}

/* End of file home.php */

?>