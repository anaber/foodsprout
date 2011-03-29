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
		
		$data['LISTING_CLASS'] = 'sustainable';
	
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

	// The default listing of all major cities with a search
    function farmersMarket() {
		// SEO
		$this->load->model('SeoModel');
		$seo = $this->SeoModel->getSeoDetailsFromPage('cities_farmersmrkt_index');
		$data['SEO'] = $seo;
		
		$data['LISTING_CLASS'] = 'farmersmarket/city';
	
        // List of views to be included
        $data['CENTER'] = array(
            'content' => 'cities/cities_main',
        );

		// Data to send to the views
		$data['BREADCRUMB'] = array(
							'Food Sprout' => '/',
							'Farmers Markets' => '/farmersmarkets',
							'Farmers Markets by Cities' => '',
						);

        $this->load->view('/templates/center_template', $data);
    }

}
?>