<?php

class Manufacture extends Controller {
	
	function __construct() {
		parent::Controller();
		checkUserLogin();
	}
	
	function index() {
		$data = array();
		
		// SEO
		$this->load->model('SeoModel');
		$seo = $this->SeoModel->getSeoDetailsFromPage('manufacture_list');
		$data['SEO'] = $seo;
		
		// validate the data in the URL to make sure we don't have SQL injection
		$urlpage = substr($this->uri->segment(2),4,5);
		if(is_numeric($urlpage))
		{
			$page = $urlpage-1;
		} else {
			$page = 0;
		}
		
		if($this->input->get('pp'))
		{
			$number_perpage = $this->input->get('pp');
			if($number_perpage > 40)
			{
				$perpage = 20;
			}
			else{
				$perpage = $number_perpage;
			}
		}
		else{
			$perpage = 10;
		}
			
		$this->load->model('ManufactureModel');
		$manufactures = $this->ManufactureModel->getManufactures($page,$perpage);
		
		// Views to include in the data array
		$data['CENTER'] = array(
				'list' => '/manufacture/manufacture_listb',
			);		
		
		$data['LEFT'] = array(
				'filter' => 'includes/left/manufacture_filter',
			);
			
		// Data to be passed to the views
		$data['data']['center']['list']['MANUFACTURES'] = $manufactures;
		
		$this->load->view('templates/left_center_template', $data);
	}
	
	function ajaxSearchManufactures() {
		$this->load->model('ManufactureModel', '', TRUE);
		$restaurants = $this->ManufactureModel->getManufactureJson();
		echo json_encode($restaurants);
	}
	
	function searchManufactures($q) {
		$this->load->model('ManufactureModel', '', TRUE);
		$manufactures = $this->ManufactureModel->searchManufactures($q);
		echo $manufactures;
	}
	
	function get_manufactutes_for_auto_suggest() {
		$q = strtolower($_REQUEST['q']);
		$this->load->model('ManufactureModel', '', TRUE);
		$manufactures = $this->ManufactureModel->searchManufacturesForAutoSuggest($q);
		echo $manufactures;
	}
	
	
	function ajaxSearchManufactureInfo() {
		$manufactureId = $this->input->post('manufactureId');
		$this->load->model('ManufactureModel', '', TRUE);
		$manufacture = $this->ManufactureModel->getManufactureFromId($manufactureId);
		echo json_encode($manufacture);
	}
	
	// View all the information about a single manufacture
	function view() {
		global $SUPPLIER_TYPES_2;
		
		$data = array();

		$manufactureId = $this->uri->segment(3);

		$this->load->model('PhotoModel');
		$thumbPhotos = $this->PhotoModel->getThumbPhotos('producer', $manufactureId);
		
		// Getting information from models
		$this->load->model('ManufactureModel');
		$manufacture = $this->ManufactureModel->getManufactureFromId($manufactureId);

		$this->load->model('ProductTypeModel');
		$productTypes = $this->ProductTypeModel->listProductType();

		// SEO
		$this->load->model('SeoModel');
		$seo = $this->SeoModel->getSeoDetailsFromPage('manufacture_detail');

		$seo_data_array = array(
			'manufacture_name' => $manufacture->manufactureName,
			'manufacture_type' => 'Fast Food',
			'cuisines' => 'Fast Food, American, Pizza',
		);

		$seo = $this->SeoModel->parseSeoData($seo, $seo_data_array);
		$data['SEO'] = $seo;
		// SEO ENDS here

		// List of views to be included, these are files that are pulled from different views in the view folders

		// Load all the views for the center column
		$data['LEFT'] = array(
				'img' => '/includes/left/images',
				'info' => 'includes/left/info',
				'map' => 'includes/right/map',
			);

		// Load all the views for the center column
		$data['CENTER'] = array(
				'info' => '/manufacture/info',
			);

		// Load all the views for the right column
		$data['RIGHT'] = array(
				//'ad' => 'includes/banners/sky',
			);

		// Data to be passed to the views
		// Center -> Info
		$data['data']['center']['info']['SUPPLIER_TYPES_2'] = $SUPPLIER_TYPES_2;
		$data['data']['center']['info']['PRODUCT_TYPES'] = $productTypes;
		$data['data']['center']['info']['MANUFACTURE_ID'] = $manufacture->manufactureId;
		$data['data']['center']['info']['TABLE'] = 'manufacture_supplier';
		
		// Left -> Map
		$data['data']['left']['map']['width'] = '225';
		$data['data']['left']['map']['height'] = '225';
		$data['data']['left']['map']['hide_map'] = 'no';
		
		// Left -> Images
		$data['data']['left']['img']['PHOTOS'] = $thumbPhotos;
		
		// Left -> Info
		$INFO = array (
					'url' => $manufacture->url,
					'facebook' => $manufacture->facebook,
					'twitter' => $manufacture->twitter,
				);
		
		$data['data']['left']['info']['INFO'] = $INFO;
		$data['data']['left']['info']['MANUFACTURE'] = $manufacture;
		
		$data['MANUFACTURE'] = $manufacture;
		
		$data['NAME'] = array(
							$manufacture->manufactureName => '',
							);
		
		// Custom CSS
		$data['CSS'] = array(
				'restaurant',
				'supplier',
				'floating_messages'
		);
		
		$this->load->view('templates/left_center_right_template', $data);
		
	}
	
	function ajaxSearchManufactureSuppliers() {
		$q = $this->input->post('q');
		$this->load->model('SupplierModel');
		$suppliers = $this->SupplierModel->getSupplierForProducerJson($q);
		
		echo json_encode($suppliers);
	}
	
	function ajaxSearchManufactureMenus() {
		$this->load->model('ManufactureModel', '', TRUE);
		$menus = $this->ManufactureModel->getManufactureMenusJson();
		echo json_encode($menus);
	}
	
	function ajaxSearchManufactureComments() {
		$this->load->model('CommentModel', '', TRUE);
		$comments = $this->CommentModel->getCommentsJson('manufacture');
		echo json_encode($comments);
	}
	
	function ajaxSearchManufacturePhotos() {
		$this->load->model('PhotoModel', '', TRUE);
		$comments = $this->PhotoModel->getPhotosJson('manufacture');
		echo json_encode($comments);
	}
}

/* End of file manufacture.php */

?>