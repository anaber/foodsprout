<?php

class Home extends Controller {
	
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
		
		$this->load->view('templates/center_template', $data);
		
	}
	
}

/* End of file home.php */

?>