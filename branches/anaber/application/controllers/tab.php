<?php

class Tab extends Controller {

    function __construct() {
        parent::Controller();
		checkUserLogin();
    }

    // The default goes to the about page
    function index() {
		// SEO
		$this->load->model('SeoModel');
		$seo = $this->SeoModel->getSeoDetailsFromPage('tab_index');
		$data['SEO'] = $seo;
	
        $data['CENTER'] = array(
            'content' => 'tab/info',
        );

		// Data to send to the views
		$data['BREADCRUMB'] = array(
							'Tab\'s on Us' => '/tab',
						);

        $this->load->view('/templates/center_template', $data);
    }

    // Contact information
    function detail() {
		// SEO
		$this->load->model('SeoModel');
		$seo = $this->SeoModel->getSeoDetailsFromPage('tab_detail');
		$data['SEO'] = $seo;

        $data['CENTER'] = array(
            'content' => 'tab/detail',
        );

        // Data to send to the views
        $data['BREADCRUMB'] = array(
							'Tab\'s on Us' => '/tab',
							'This Week\'s Restaurant' => '',
						);
        
        $this->load->view('/templates/center_template', $data);
    }
	

}
?>