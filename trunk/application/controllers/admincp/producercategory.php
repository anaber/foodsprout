<?php

class ProducerCategory extends Controller {
	
	function __construct()
	{
		global $ADMIN_LANDING_PAGE;
		parent::Controller();
		if ($this->session->userdata('isAuthenticated') != 1 || $this->session->userdata('access') != 'admin' )
		{
			redirect($ADMIN_LANDING_PAGE);
		}
	}
	
	function index()
	{
		$this->listProducerCategory();
	}
	
	// List all the facilitytype in the database
	function listProducerCategory()
	{
		$data = array();
		$producerCategory = array();
		
		$this->load->model('ProducerCategoryModel');
		$producerCategory = $this->ProducerCategoryModel->listProducerCategoryAdmin();

		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/producer_category',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Producer Categories";
		$data['data']['center']['list']['PRODUCER_CATEGORIES'] = $producerCategory;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	// Create the form to add a new facility type
	function add()
	{
		$data = array();

		$this->load->model('ProducerCategoryModel');
		$producercategorygroups = $this->ProducerCategoryModel->listProducerCategoryGroupAdmin();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/forms/manufacturetype_form',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Add Producer Attribute";
		$data['data']['center']['list']['PRODUCER_CATEGORY_GROUPS'] = $producercategorygroups;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function update($id)
	{
		$data = array();
		
		$this->load->model('ProducerCategoryModel');
		$producercategory = $this->ProducerCategoryModel->getProducerCategoryFromId($id);
		$producercategorygroups = $this->ProducerCategoryModel->listProducerCategoryGroupAdmin();

		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/forms/manufacturetype_form',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Update Producer Category";
		$data['data']['center']['list']['PRODUCER_CATEGORY'] = $producercategory;
		$data['data']['center']['list']['PRODUCER_CATEGORY_GROUPS'] = $producercategorygroups;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function save_add() {
		
		$this->load->model('ProducerCategoryModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->ProducerCategoryModel->addProducerCategory() ) {
			echo "yes";
		} else {
			if (isset($GLOBALS['error']) && !empty($GLOBALS['error']) ) {
				echo $GLOBALS['error'];
			} else {
				echo 'no';
			}
		}
	}
	

	function save_update() {
		
		$this->load->model('ProducerCategoryModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->ProducerCategoryModel->updateProducerCategory() ) {
			echo "yes";
		} else {
			if (isset($GLOBALS['error']) && !empty($GLOBALS['error']) ) {
				echo $GLOBALS['error'];
			} else {
				echo 'no';
			}
		}
		
	}
}

/* End of file facilitytype.php */

?>