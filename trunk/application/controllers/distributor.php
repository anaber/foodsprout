<?php

class Distributor extends Controller {
	
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
				'list' => '/distributor/distributor_list',
			);
		
		$data['RIGHT'] = array(
				'ad' => 'includes/banners/sky',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "List of Distributor";
		
		$this->load->view('templates/center_right_narrow_template', $data);
	}
	
	function ajaxSearchDistributors() {
		$this->load->model('DistributorModel', '', TRUE);
		$restaurants = $this->DistributorModel->getDistributorsJson();
		echo json_encode($restaurants);
	}
	
	function ajaxSearchDistributorInfo() {
		$distributorId = $this->input->post('distributorId');
		$this->load->model('DistributorModel', '', TRUE);
		$distributor = $this->DistributorModel->getDistributorFromId($distributorId);
		echo json_encode($distributor);
	}
	
	// View the information about a specific distributor
	function view() {
		$this->load->library('functionlib');

        $data = array();
		
		$distributorId = $this->uri->segment(3);
		
		// -------- Getting information from models for the views ------------------
		
		
		// Get the basic information about the manufacture
		$this->load->model('DistributorModel');
		$distributorinfo = $this->DistributorModel->getDistributorFromId($distributorId);
		
		// List of views to be included
		$data['CENTER'] = array(
				'info' => '/distributor/info',
				//'menu' => '/distributor/distributor_detail',
			);
		
		$data['RIGHT'] = array(
				'image' => 'includes/right/image',
				'ad' => 'includes/right/ad',
				'map' => 'includes/right/map',
				//'supliers' => 'suppliers',
			);
		
		// Data to be passed to the views
		
		// Center -> Manufactures they carry, businesses they supply
		$data['data']['center']['info']['DISTRIBUTOR'] =  $distributorinfo;
		$data['data']['center']['menu']['MENU'] = array('burger', 'pizza', 'meat');
		
		// Right -> Image
		$data['data']['right']['image']['src'] = '/img/standard/distributor-na-icon.jpg';
		$data['data']['right']['image']['width'] = '300';
		$data['data']['right']['image']['height'] = '200';
		$data['data']['right']['image']['title'] = 'Distributor Image';
		
		// Right -> Map
		$data['data']['right']['map']['width'] = '300';
		$data['data']['right']['map']['height'] = '200';
		
		$this->load->view('templates/center_right_template', $data);
	}
	
}

/* End of file distributor.php */

?>