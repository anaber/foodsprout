<?php

class Manufacture extends Controller {
	
	function __construct()
	{
		parent::Controller();
		if ($this->session->userdata('isAuthenticated') != 1 )
		{
			redirect('about/privatebeta');
		}
	}
	
	function index() {
		$data = array();
		
		// Views to include in the data array
		$data['CENTER'] = array(
				'list' => '/manufacture/manufacture_list',
			);
		
		
		$data['LEFT'] = array(
				'filter' => 'includes/left/manufacture_filter',
			);
		
		$this->load->view('templates/left_center_template', $data);
	}
	
	function ajaxSearchManufactures() {
		$this->load->model('ManufactureModel', '', TRUE);
		$restaurants = $this->ManufactureModel->getManufactureJson();
		echo json_encode($restaurants);
	}
	
	function searchManufactures($q) {
		$this->load->model('ManufactureModel', '', TRUE);
		$companies = $this->ManufactureModel->searchManufactures($q);
		echo $companies;
	}
	
	function ajaxSearchManufactureInfo() {
		$manufactureId = $this->input->post('manufactureId');
		$this->load->model('ManufactureModel', '', TRUE);
		$manufacture = $this->ManufactureModel->getManufactureFromId($manufactureId);
		echo json_encode($manufacture);
	}
	
	// View all the information about a single manufacture
	function view() {
		$this->load->library('functionlib'); 
		
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
		$suppliers = $this->SupplierModel->getSupplierForCompany('', '', $manufactureId, '', '', '');
		
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
		$data['data']['right']['image']['src'] = '/img/standard/manufacture-na-icon.jpg';
		$data['data']['right']['image']['width'] = '300';
		$data['data']['right']['image']['height'] = '200';
		$data['data']['right']['image']['title'] = 'Manufacture Image';
		
		// Right -> Map
		$data['data']['right']['map']['width'] = '300';
		$data['data']['right']['map']['height'] = '200';
		$data['data']['right']['map']['hide_map'] = 'no';
		
		$this->load->view('templates/center_right_template', $data);
	}
	
	function supplier_save_add() {
		
		$this->load->model('SupplierModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->SupplierModel->addSupplierIntermediate() ) {
			echo 'yes';
		} else {
			if (isset($GLOBALS['error']) && !empty($GLOBALS['error']) ) {
				echo $GLOBALS['error'];
			} else {
				echo 'no';
			}
		}
	}
	
	function supplier_save_update() {
		$this->load->model('SupplierModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->SupplierModel->updateSupplierIntermediate() ) {
			echo 'yes';
		} else {
			if (isset($GLOBALS['error']) && !empty($GLOBALS['error']) ) {
				echo $GLOBALS['error'];
			} else {
				echo 'no';
			}
		}
	}
	
}

/* End of file manufacture.php */

?>