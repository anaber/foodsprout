<?php

class Restaurants extends Controller {
	
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
				'mainarea' => 'mobile/restaurant/home',
			);
		
		$this->load->view('templates/mobile_template', $data);
	}
	
	
	function nearme(){
		
		$data = array();
		
		$this->load->model('SeoModel');
		$seo = $this->SeoModel->getSeoDetailsFromPage('index');
		$data['SEO'] = $seo;
		
		// List of views to be included
		$data['CENTER'] = array(
				'mainarea' => 'mobile/restaurant/nearme',
			);
		
		$this->load->view('templates/mobile_template', $data);
		
	}
	function zipcode(){
		
		$data = array();
		
		$this->load->model('SeoModel');
		$seo = $this->SeoModel->getSeoDetailsFromPage('index');
		$data['SEO'] = $seo;
		
		// List of views to be included
		$data['CENTER'] = array(
				'mainarea' => 'mobile/restaurant/zipcode',
			);
		
		$this->load->view('templates/mobile_template', $data);
		
	}
	
	function findzipcode(){
		$data = array();
		
		$this->load->model('SeoModel');
		$seo = $this->SeoModel->getSeoDetailsFromPage('index');
		$data['SEO'] = $seo;
		
		// List of views to be included
		$data['CENTER'] = array(
				'mainarea' => 'mobile/restaurant/zipcoderesults',
			);
			
			
		if(!empty($_POST) && $_POST['zip_code'] != '')	{
				
				$this->load->model('RestaurantModel');
				
				
				$results = $this->RestaurantModel->getRestaurantsMobileByZipCode($this->input->post('zip_code'), $this->input->post('distance'));
				
				$data['search_results'] = $results;
				
	
			}else{
				$data['search_results'] = array();
			}
			
			$this->load->view('templates/mobile_template', $data);
		}
		
	function browsebycity(){
		
		$data = array();
		
		$this->load->model('SeoModel');
		$seo = $this->SeoModel->getSeoDetailsFromPage('index');
		$data['SEO'] = $seo;
		
		// List of views to be included
		$data['CENTER'] = array(
				'mainarea' => 'mobile/restaurant/citysearch'
			);
		
		//load mobile restaurant model
		$this->load->model('mobile/MobileRestaurantModel');
		
		//search by city 
		if(isset($_POST['city']) && $_POST['city'] !=''){
			$data['cities'] =  $this->MobileRestaurantModel->getCitiesByKey($this->input->post('city')); 
		}
		$this->load->view('templates/mobile_template', $data);
	}
	
	function cityrestaurantlist(){
				
		$data = array();
		
		$this->load->model('SeoModel');
		$seo = $this->SeoModel->getSeoDetailsFromPage('index');
		$data['SEO'] = $seo;
		
		// List of views to be included
		$data['CENTER'] = array(
				'mainarea' => 'mobile/restaurant/citysearch'
			);
		
		//load mobile restaurant model
		$this->load->model('mobile/MobileRestaurantModel');
		
		
		
	}
}

/* End of file home.php */

?>