<?php

class Farms extends Controller {

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
				'mainarea' => 'mobile/farms/home',
		);

		$this->load->view('templates/mobile_template', $data);
	}
	
	function customUrl($customUrl){

		$custom_url_data = $this->db->query("select * from custom_url where `custom_url` = '".$customUrl."' ")->result_array();
		$this->_view($custom_url_data[0]['producer_id'],  $custom_url_data[0]['address_id']);
	}

	function _view($producerId ='', $addressId = '' ){

		$data = array();
			
		$this->load->model('PhotoModel');
		$thumbPhotos = $this->PhotoModel->getThumbPhotos('producer', $producerId);
		
		//address id and text
		$data['address'] = $this->db->query("select * from address where address_id = '".$addressId."'")->result_array(); 
		
		//producer info
		$data['producer'] =  $this->db->query("select * from producer where producer_id = '".$producerId."'")->result_array(); 
		
		// Load the library  
		$this->load->library('googlemaps'); 
		
		
		// Initialize the map, passing through any parameters  
		$config['center'] = $data['address'][0]['latitude'].', '.$data['address'][0]['longitude'];  
		$config['zoom'] = '16';
		$config['map_heigh'] = '200';
		$config['map_div_id'] = 'small_map_canvas';
		$config['disableMapTypeControl'] = 'true';
		$config['disableNavigationContro'] = 'false';
		
		
		// Initialize our map. Here you can also pass in additional parameters for customising the map (see below)  
		$this->googlemaps->initialize($config); 
		
		// Add the first marker  
		$marker = array();  
		$marker['position'] = $data['address'][0]['latitude'].', '.$data['address'][0]['longitude']; 
		$marker['infowindow_content'] = $data['address'][0]['address'];  
		$this->googlemaps->add_marker($marker);  
		
		// Create the map. This will return the Javascript to be included in our pages <head></head> section and the HTML code to be  
		// placed where we want the map to appear. 
		$data['map'] = $this->googlemaps->create_map(); 
		// Load our view, passing the map data
				
		
		$data['supliers'] = $this->db->query("SELECT *
													FROM
													producer ,
													supplier, 
													address, 
													custom_url
													
													WHERE
													producer.producer_id =  supplier.supplier AND
													producer.producer_id =  address.producer_id AND
													producer.producer_id =  custom_url.producer_id AND
													address.address_id =  custom_url.address_id AND
													
													producer.producer_id = '".$producerId."'
															")->result_array(); 
		echo "SELECT *
													FROM
													producer ,
													supplier, 
													address
													WHERE
													producer.is_farm =  '1' AND
													producer.producer_id =  supplier.supplier AND
													producer.producer_id =  address.producer_id AND
													producer.producer_id = '".$producerId."'
															";
		// List of views to be included

		$data['CENTER'] = array(
				'mainarea' => 'mobile/farms/view',
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
				
				$this->load->model('mobile/MobileFarmsModel');
				 
				$results = $this->MobileFarmsModel->getFarmsByZipCode( $this->input->post('zipcode'), $this->input->post('distance') );

				if($results != false){
						
					$data['search_results'] = $results;
						
				}
			}
		}

		// List of views to be included
		$data['CENTER'] = array(
				'mainarea' => 'mobile/farms/zipcode',
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

				$this->load->model('mobile/MobileFarmsModel');
				 
				$results = $this->MobileFarmsModel->getCity( $this->input->post('city'));

				if($results != false){
						
					$data['cities'] = $results;

				}
					
			}
		}

		// List of views to be included
		$data['CENTER'] = array(
				'mainarea' => 'mobile/farms/bycity',
		);

		$this->load->view('templates/mobile_template', $data);
	}

	function by_city($cityId = ''){

 
		$data = array();
			
		$this->load->model('SeoModel');
		$seo = $this->SeoModel->getSeoDetailsFromPage('index');
		$data['SEO'] = $seo;

		if($cityId != '' ){
			$this->load->model('mobile/MobileFarmsModel');
	
			$results = $this->MobileFarmsModel->getFarmsByCity($cityId);
				
			if($results != false){
				$data['search_results'] = $results;
			}	
					
		}else{
		
			$data['search_results'] = array();
			
		}
		// List of views to be included
		$data['CENTER'] = array(
				'mainarea' => 'mobile/farms/city',
		);

		$this->load->view('templates/mobile_template', $data);

	}
	
	
	
	function findnearme(){
		
		$data = array();
		
		$this->load->model('SeoModel');
		$seo = $this->SeoModel->getSeoDetailsFromPage('index');
		$data['SEO'] = $seo;
		
		// List of views to be included
		$data['CENTER'] = array(
				'mainarea' => 'mobile/farms/findnearme',
			);
						
		
		$this->load->view('templates/mobile_template', $data);
	}
	
	function nearme(){
		
		$data = array();

		$this->load->model('SeoModel');
		$seo = $this->SeoModel->getSeoDetailsFromPage('index');
		$data['SEO'] = $seo;

		if(isset($_POST['search_near_me']) && $_POST['search_near_me'] != ''){
				
			if(isset($_POST['latitude_input']) && isset($_POST['longitude_input'])
			&& $_POST['latitude_input'] !='' && $_POST['longitude_input'] !='' )	{

				$this->load->model('mobile/MobileFarmsModel');
				 
				$results = $this->MobileFarmsModel->getFarmByCoordinates($this->input->post('latitude_input'), $this->input->post('longitude_input'), $this->input->post('distance') );

				if($results != false){
						
					$data['search_results'] = $results;
				}
							
			}
		}

		// List of views to be included
		$data['CENTER'] = array(
				'mainarea' => 'mobile/farms/nearme',
		);

		$this->load->view('templates/mobile_template', $data);
		
		
		
	}
}