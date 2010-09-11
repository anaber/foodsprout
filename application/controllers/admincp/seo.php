<?php

class Seo extends Controller {
	
	function __construct()
	{
		parent::Controller();
		if ($this->session->userdata('isAuthenticated') != 1 || $this->session->userdata('userGroup') != 'admin' )
		{
			redirect('admincp/login');
		}
	}
	
	function index() {
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/seo',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "SEO Pages";
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	// Create the form page to add a farm to the database, does not actually add the data, only builds the form
	function add() {
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'form' => 'admincp/seo_form',
			);
		
		// Data to be passed to the views
		$data['data']['center']['form']['VIEW_HEADER'] = "Add Seo Page";
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function update($id) {
		$data = array();
		
		$this->load->model('SeoModel');
		$seo = $this->SeoModel->getSeoPageFromId($id);
		
		// List of views to be included
		$data['LEFT'] = array(
				'navigation' => 'admincp/includes/left/nav_farm',
			);
		
		// List of views to be included
		$data['CENTER'] = array(
				'form' => 'admincp/seo_form',
			);
		
		// Data to be passed to the views
		$data['data']['center']['form']['VIEW_HEADER'] = "Update SEO Page";
		$data['data']['center']['form']['SEO'] = $seo;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	// Pass the form data to the model to be inserted into the database
	function save_add() {
		$this->load->model('SeoModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->SeoModel->addSeoPage() ) {
			echo 'yes';
		} else {
			if (isset($GLOBALS['error']) && !empty($GLOBALS['error']) ) {
				echo $GLOBALS['error'];
			} else {
				echo 'no';
			}
		}
	}
	
	function save_update() {
		$this->load->model('SeoModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->SeoModel->updateSeoPage() ) {
			echo "yes";
		} else {
			if (isset($GLOBALS['error']) && !empty($GLOBALS['error']) ) {
				echo $GLOBALS['error'];
			} else {
				echo 'no';
			}
		}
	}
	
	function ajaxSearchSeo() {
		$this->load->model('SeoModel', '', TRUE);
		$seo = $this->SeoModel->getSeoJsonAdmin();
		echo json_encode($seo);
	}
}

/* End of file company.php */

?>