<?php

class Restaurants extends Controller {
	
	function __construct()
	{
		global $LANDING_PAGE;
		parent::Controller();
		
		$this->load->plugin('Visits');
		
		$visits = new Visits();
		
		$visits->addVisit();
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
	
	function customUrl($customUrl){

		$custom_url_data = $this->db->query("select * from custom_url where `custom_url` = '".$customUrl."' ")->result_array();
		/*echo "<pre>";
		print_r($custom_url_data);
		echo "</pre>";*/
		if ($custom_url_data) {
			
			$this->_view($custom_url_data[0]['producer_id'],  $custom_url_data[0]['address_id']);
			
		} else {
			show_404('page');
		}
		
		
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
				
		//load supliers model
		$this->load->model('SupplierModel');
		$suppliers = $this->SupplierModel->getSupplierForProducerJson($producerId, $addressId);
		$data['supliers'] = (array) $suppliers['results'];
		
		// List of views to be included

		$data['CENTER'] = array(
				'mainarea' => 'mobile/restaurant/view',
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
			
		if(isset($_POST['latitude_input']) && isset($_POST['longitude_input']) && $_POST['latitude_input'] !='' && $_POST['longitude_input'] !='' )	{
			$this->load->model('RestaurantModel');
			
			$results = $this->RestaurantModel->getRestaurantsMobileByCoordinates($this->input->post('latitude_input'), $this->input->post('longitude_input'), $this->input->post('distance'));
			
			if($results != false ){
				
				$data['search_results'] = $results;
				
			}else{
				
				$data['search_results'] = array();
 				
			}
			
		}	
		
		$this->load->view('templates/mobile_template', $data);
		
	}
	
	
	function findnearme(){
		
		$data = array();
		
		$this->load->model('SeoModel');
		$seo = $this->SeoModel->getSeoDetailsFromPage('index');
		$data['SEO'] = $seo;
		
		// List of views to be included
		$data['CENTER'] = array(
				'mainarea' => 'mobile/restaurant/findnearme',
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
				
				if($results != false){
						
					$data['search_results'] = $results;

				}else{
					
					$data['search_results'] = array();
					
				}
	
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
		
		if($pagesNumber!=0){
			$data['pages'] = range(1, $pagesNumber);
		}else{
			
			$data['pages'] =  1;
			
		}

		// List of views to be included
		$data['CENTER'] = array(
				'mainarea' => 'mobile/restaurant/list'
			);

		
		$this->load->view('templates/mobile_template', $data);
		
	}
}

/* End of file home.php */

?>