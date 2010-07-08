<?php

class Manufacture extends Controller {
	
	function index() {
		$data = array();
		
		// Views to include in the data array
		$data['CENTER'] = array(
				'list' => '/manufacture/manufacture_list',
			);
		
		$data['RIGHT'] = array(
				'ad' => 'includes/left/ad',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "List of Manufacture";
		
		$this->load->view('templates/center_right_narrow_template', $data);
	}
	
	function ajaxSearchManufactures() {
		$this->load->model('ManufactureModel', '', TRUE);
		$restaurants = $this->ManufactureModel->getManufactureJson();
		echo json_encode($restaurants);
	}
	
	// View all the information about a single manufacture
	function view() {
		
		$data = array();
		
		$manufactureId = $this->uri->segment(3);
		
		// -------- Getting information from models for the views ------------------
		
		
		// Get the basic information about the manufacture
		$this->load->model('ManufactureModel');
		$manufactureinfo = $this->ManufactureModel->getManufactureFromId($manufactureId);
		
		// Get the products the manufacture makes
		$this->load->model('ManufactureModel');
		$products = $this->ManufactureModel->getManufactureProducts($manufactureId);
		
		// Get the suppliers for this manufacture
		$this->load->model('SupplierModel');
		$suppliers = $this->SupplierModel->getSupplierForCompany('', '', $manufactureId, '', '');
		
		// SEO information
		/*
		$this->load->model('SeoModel');
		$seo = $this->SeoModel->getSeoDetailsFromPage('manufacture_detail');
		
		$seo_data_array = array(
			'manufacture_name' => $manufactureinfo->manufactureName,
			'manufacture_type' => 'Manufacture',
			'cuisines' => 'Fast Food, American, Pizza',
		);
		
		$seo = $this->SeoModel->parseSeoData($seo, $seo_data_array);
		$data['SEO'] = $seo;
		*/
		// SEO ends here
		
		// List of views to be included, products, suppliers and distributors
		$data['CENTER'] = array(
				'info' => '/manufacture/info',
				'products' => '/manufacture/product',
				'suppliers' => '/manufacture/suppliers',
				'distributor' => '/manufacture/distributor',
			);
		
		$data['RIGHT'] = array(
				'image' => 'includes/right/image',
				'ad' => 'includes/right/ad',
				'map' => 'includes/right/map',
			);
		
		
		// Data to be passed to the views ----------------------------------------
		
		// Center -> Products, Suppliers, Distributors
		$data['data']['center']['info']['MANUFACTURE'] = $manufactureinfo;
		$data['data']['center']['products']['PRODUCT'] = $products;
		$data['data']['center']['suppliers']['SUPPLIER'] = $suppliers;
		
		// Right -> Image
		$data['data']['right']['image']['src'] = '/images/standard/manufacture-na-icon.jpg';
		$data['data']['right']['image']['width'] = '300';
		$data['data']['right']['image']['height'] = '200';
		$data['data']['right']['image']['title'] = 'Manufacture Image';
		
		// Right -> Map
		$data['data']['right']['map']['width'] = '300';
		$data['data']['right']['map']['height'] = '200';
		$data['data']['right']['map']['hide_map'] = 'no';
		
		$this->load->view('templates/center_right_template', $data);
	}
	
}

/* End of file manufacture.php */

?>