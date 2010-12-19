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
	
	function cityrestaurantlist($cityID, $page=0){
				
		$data = array();
		
		if(!empty($_POST['page'])){
			
			$page = $this->input->post('page');
			
		}
		
		$perPage = 50; 
		
		$this->load->model('SeoModel');
		$seo = $this->SeoModel->getSeoDetailsFromPage('index');
		$data['SEO'] = $seo;
		
		//load mobile restaurant model
		$this->load->model('mobile/MobileRestaurantModel');
		
		
		//create query limits
		if($page != 0){	
			$page = $page - 1;
			$start  = $page*$perPage;
			$stop = ($page*$perPage) + $perPage;		
		}else{	
			$start = 0; 
			$stop = $perPage;
		}
		
		//getting results from model
		$data['results'] = $this->MobileRestaurantModel->getRestaurantsByCityId($cityID, $start, $stop);
		
		//calculate page numbers
		$pagesNumber = ceil($data['results']['totalrecords']/$perPage); 
		
		//estabilishing values for display to users
		$data['start']  = $start+1; 
		if($this->input->post('page') == $pagesNumber){
			$data['stop']  = $data['results']['totalrecords']; 
		}else{
			$data['stop'] = $stop;
		}
		$data['searched_page'] = $page+1;
		$data['city_id'] = $cityID;
		
		//getting all jump steps 
		$data['pages'] = range(1, $pagesNumber);

		// List of views to be included
		$data['CENTER'] = array(
				'mainarea' => 'mobile/restaurant/list'
			);

		
		$this->load->view('templates/mobile_template', $data);
		
	}
}

/* End of file home.php */

?>