<?php

class Cities extends Controller {

    function __construct() {
        parent::Controller();
        $this->load->helper('url');
        $this->load->helper('form');

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
        if ($this->session->userdata('farmersmarket'))
        {
            $data['BREADCRUMB'] = array(
                'Food Sprout' => '/',
                'Farmers Markets' => '/farmersmarket',
                'Farmers Markets in Cities' => '',
            );
        }
        else
        {
            $data['BREADCRUMB'] = array(
                'Food Sprout' => '/',
                'Sustainable Food by Cities' => '',
            );
        }

        // get additional data on cities and states
        foreach($this->getCitiesViewData() as $key => $value)
        {
            $data[$key] = $value;
        }

        $data['listing_url'] = 'sustainable';
        
        $this->load->view('/templates/center_template', $data);
    }

	// The default listing of all major cities with a search
    function farmersMarket() {
        // SEO
        $this->load->model('SeoModel');
        $seo = $this->SeoModel->getSeoDetailsFromPage('cities_farmersmrkt_index');
        $data['SEO'] = $seo;

        $data['listing_url'] = 'farmersmarket/city';
	
        // List of views to be included
        $data['CENTER'] = array(
            'content' => 'cities/cities_main',
        );

        // Data to send to the views
        $data['BREADCRUMB'] = array(
            'Food Sprout' => '/',
            'Farmers Markets' => '/farmersmarket',
            'Farmers Markets by Cities' => '',
        );

        $this->session->set_userdata('farmersmarket', 1);

        // get additional data on cities and states
        foreach($this->getCitiesViewData() as $key => $value)
        {
            $data[$key] = $value;
        }

        $this->load->view('/templates/center_template', $data);
    }

    function state($state_name)
    {
        $state = str_replace('-', ' ', $state_name);

        $this->load->model('CityModel');
        
        $cities = $this->CityModel->getCitiesInStateGrouped($state_name);

        $data['CENTER'] = array(
            'content' => 'cities/cities_state'
        );

        $data['listing_url'] = ($this->session->userdata('farmersmarket')) ? 'farmersmarket/city':'sustainable';

        $data['cities'] = $cities;

        $data['state'] = ($state == 'd.c.') ? 'D.C.' : ucwords($state);

        if ($this->session->userdata('farmersmarket'))
        {
             $data['BREADCRUMB'] = array(
                'Food Sprout' => '/',
                'Farmers Markets' => '/farmersmarket',
                'Farmers Market Cities' => '/cities/farmersmarket',
                'Farmers Market Cities in ' . ucwords($state) => ''
            );
        }
        else
        {
            $data['BREADCRUMB'] = array(
                'Food Sprout' => '/',
                'Sustainable Food By Cities' => '/cities/',
                'Sustainable Food By Cities in ' . ucwords($state) => ''
            );
        }

        $this->load->view('templates/center_template', $data);
    }

    /**
     * Get the default city, the main cities and the states
     *
     * @return array
     */
    private function getCitiesViewData()
    {
        $data[] = array();
        
        // get a user's default city if a user is logged in
        if (FALSE != ($userId = $this->session->userdata('userId')))
        {
            $this->load->model('UserModel');
            $user = $this->UserModel->getUserFromId($userId);
                
            // get city name from user default city (which references city_id)
            $this->load->model('CityModel');
            $default_city = $this->CityModel->getCityFromId($user->defaultCity)->city;
        }

        $data['default_city'] = isset($default_city) ? $default_city : null;

        // get the list of cities
        $this->load->model('CityModel');
        $data['cities'] = $this->CityModel->getCitiesGrouped();

        // get the list of states
        $this->load->model('StateModel');
        $data['states'] = $this->StateModel->getStatesGrouped();

        return $data;

    }
}
?>