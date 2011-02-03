<?php

class Farmersmarket extends Controller {

	function __construct()
	{
		global $LANDING_PAGE;
		parent::Controller();
	}

	function index(){

		$data = array();

		$this->load->model('SeoModel');
		$seo = $this->SeoModel->getSeoDetailsFromPage('index');
		$data['SEO'] = $seo;

		// List of views to be included
		$data['CENTER'] = array(
				'mainarea' => 'mobile/farmersmarket/home',
		);

		$this->load->view('templates/mobile_template', $data);
	}


	function customUrl($customUrl){

		$custom_url_data = $this->db->query("select * from custom_url where `custom_url` = '".$customUrl."' ")->result_array();
		$this->_view($custom_url_data[0]['address_id']);
	}

	function _view($address_id){

		echo $address_id;

	}


	function nearme(){

		$data = array();

		$this->load->model('SeoModel');
		$seo = $this->SeoModel->getSeoDetailsFromPage('index');
		$data['SEO'] = $seo;

		if(isset($_POST['search_near_me']) && $_POST['search_near_me'] != ''){
				
			if(isset($_POST['latitude_input']) && isset($_POST['longitude_input'])
			&& $_POST['latitude_input'] !='' && $_POST['longitude_input'] !='' )	{

				$this->load->model('mobile/MobileFarmersMarketModel');
				 
				$results = $this->MobileFarmersMarketModel->getFarmersMarketByCoordinates($this->input->post('latitude_input'), $this->input->post('longitude_input'), $this->input->post('distance') );

				if($results != false){
						
					$data['search_results'] = $results;
				}

			}
		}

		// List of views to be included
		$data['CENTER'] = array(
				'mainarea' => 'mobile/farmersmarket/nearme',
		);

		$this->load->view('templates/mobile_template', $data);

	}

	function zipcode(){

		$data = array();

		$this->load->model('SeoModel');
		$seo = $this->SeoModel->getSeoDetailsFromPage('index');
		$data['SEO'] = $seo;
			
		if(isset($_POST['search_zipcode']) && $_POST['search_zipcode'] != ''){
				
			if(isset($_POST['zipcode']) && $_POST['zipcode']!='' )	{

				$this->load->model('mobile/MobileFarmersMarketModel');
				 
				$results = $this->MobileFarmersMarketModel->getFarmersMarketByZipCode( $this->input->post('zipcode'), $this->input->post('distance') );

				if($results != false){
						
					$data['search_results'] = $results;
						
				}

			}
		}

		// List of views to be included
		$data['CENTER'] = array(
				'mainarea' => 'mobile/farmersmarket/zipcode',
		);

		$this->load->view('templates/mobile_template', $data);

	}

	function bycity(){

		$data = array();

		$this->load->model('SeoModel');
		$seo = $this->SeoModel->getSeoDetailsFromPage('index');
		$data['SEO'] = $seo;
			
		if(isset($_POST['search_city']) && $_POST['search_city'] != ''){
				
			if(isset($_POST['city']) && $_POST['city']!='' )	{

				$this->load->model('mobile/MobileFarmersMarketModel');
				 
				$results = $this->MobileFarmersMarketModel->getCity( $this->input->post('city'));

				if($results != false){
						
					$data['cities'] = $results;

				}
					
			}
		}

		// List of views to be included
		$data['CENTER'] = array(
				'mainarea' => 'mobile/farmersmarket/city',
		);

		$this->load->view('templates/mobile_template', $data);
	}

	function by_city($cityId = ''){

 
		$data = array();
			
		$this->load->model('SeoModel');
		$seo = $this->SeoModel->getSeoDetailsFromPage('index');
		$data['SEO'] = $seo;

		if($cityId != '' ){
			$this->load->model('mobile/MobileFarmersMarketModel');
	
			$results = $this->MobileFarmersMarketModel->getFarmersMarketByCity($cityId);
				
			if($results != false){
				$data['search_results'] = $results;
			}	
					
		}else{
		
			$data['search_results'] = array();
			
		}
		// List of views to be included
		$data['CENTER'] = array(
				'mainarea' => 'mobile/farmersmarket/city',
		);

		$this->load->view('templates/mobile_template', $data);

	}

}