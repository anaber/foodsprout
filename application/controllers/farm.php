<?php

class Farm extends Controller {
	
	function index() {
		$data = array();
		
		// SEO
		$this->load->model('SeoModel');
		$seo = $this->SeoModel->getSeoDetailsFromPage('farm_list');
		$data['SEO'] = $seo;
		
		$q = $this->input->post('q');
		$f = $this->input->post('f');

		if ( !empty($f) ) {
			$data['CENTER'] = array(
				'list' => '/farm/farm_list',
			);
		} else {
			// List of views to be included
			$data['CENTER'] = array(
					'map' => 'includes/map',
					'list' => '/farm/farm_list',
				);
		}
		
		if ( !empty($f) ) {
			$data['LEFT'] = array(
					'ad' => 'includes/left/ad',
				);
		} else {
			$data['LEFT'] = array(
					'filter' => 'includes/left/farm_filter',
					'ad' => 'includes/left/ad',
				);
		}
		
		// Data to be passed to the views
		if ( empty($f) ) {
		$data['data']['left']['filter']['VIEW_HEADER'] = "Filters";
		}
		
		if ( empty($f) ) {
		$data['data']['center']['map']['VIEW_HEADER'] = "Map";
		$data['data']['center']['map']['width'] = '790';
		$data['data']['center']['map']['height'] = '250';
		}
		
		//$data['data']['center']['list']['LIST'] = $restaurants;
		$data['data']['center']['list']['VIEW_HEADER'] = "List of Farms";
		$data['data']['center']['list']['q'] = $q;
		$data['data']['center']['list']['f'] = $f;
		if ( !empty($f) ) {
			$data['data']['center']['list']['hide_map'] = 'yes';
			$data['data']['center']['list']['hide_filters'] = 'yes';
		} else {
			$data['data']['center']['list']['hide_map'] = 'no';
			$data['data']['center']['list']['hide_filters'] = 'no';
		}
		
		$this->load->view('templates/left_center_template', $data);
	}
	
	function view() {
		
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'farm/farm_details',
			);
		
		$data['RIGHT'] = array(
				'image' => 'includes/right/image',
				'ad' => 'includes/right/ad',
				'map' => 'includes/right/map',
			);
		
		// Data to be passed to the views
		// Center -> Ingredients		
		$data['data']['center']['products']['VIEW_HEADER'] = "List of producst from Farm";
		
		// Right -> Image
		$data['data']['right']['image']['src'] = '/images/standard/farm-na-icon.jpg';
		$data['data']['right']['image']['width'] = '300';
		$data['data']['right']['image']['height'] = '200';
		$data['data']['right']['image']['title'] = 'McDonalds';
		
		// Center -> Map
		$data['data']['right']['map']['VIEW_HEADER'] = "Farm Location";
		$data['data']['right']['map']['width'] = '300';
		$data['data']['right']['map']['height'] = '200';
		
		$this->load->view('templates/center_right_template', $data);
	}
	
	function ajaxSearchFarms() {
		$this->load->model('FarmModel', '', TRUE);
		$restaurants = $this->FarmModel->getFarmssJson();
		echo json_encode($restaurants);
	}
	
	function ajaxGetDistinctUsedFarmType() {
		$c = $this->input->post('c');
		$this->load->model('FarmModel');
		$farmTypes = $this->FarmModel->getDistinctUsedFarmType($c);
		echo json_encode($farmTypes);
	}
	
	function ajaxGetAllFarmType() {
		$c = $this->input->post('c');
		$this->load->model('FarmTypeModel');
		$farmTypes = $this->FarmTypeModel->listFarmType($c);
		echo json_encode($farmTypes);
	}
}

/* End of file farm.php */

?>