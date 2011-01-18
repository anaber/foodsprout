<?php

class Cities extends Controller {

    function __construct() {
        parent::Controller();
    }

    // The default listing of all major cities with a search
    function index() {
		// SEO
		$this->load->model('SeoModel');
		$seo = $this->SeoModel->getSeoDetailsFromPage('cities_index');
		$data['SEO'] = $seo;
	
        // List of views to be included
        $data['CENTER'] = array(
            'content' => 'cities/cities_main',
        );

		// Data to send to the views
		$data['BREADCRUMB'] = array(
							'Food Sprout' => '/',
							'Sustainable Food by Cities' => '',
						);

        $this->load->view('/templates/center_template', $data);
    }

}
?>