<?php

class ProducerCategoryGroup extends Controller {
	
	function __construct()
	{
		global $ADMIN_LANDING_PAGE;
		parent::Controller();
		if ($this->session->userdata('isAuthenticated') != 1 || $this->session->userdata('userGroup') != 'admin' )
		{
			redirect($ADMIN_LANDING_PAGE);
		}
	}
	
	function index()
	{
		$this->listProducerCategoryGroup();
	}
	
	// List all the facilitytype in the database
	function listProducerCategoryGroup()
	{
		$data = array();
		$producerCategoryGroup = array();
		
		$this->load->model('ProducerCategoryModel');
		$producerCategoryGroup = $this->ProducerCategoryModel->listProducerCategoryGroupAdmin();

		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/producer_category_group',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Producer Attribute Groups";
		$data['data']['center']['list']['PRODUCER_CATEGORIES_GROUPS'] = $producerCategoryGroup;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	// Create the form to add a new facility type
	function add()
	{
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/forms/producer_category_group_form',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Add Producer Category";
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function update($id)
	{
		$data = array();
		
		$this->load->model('ProducerCategoryModel');
		$producerCategoryGroups = $this->ProducerCategoryModel->getProducerCategoryGroupFromId($id);

		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/forms/producer_category_group_form',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Update Producer Category Group";
		$data['data']['center']['list']['PRODUCER_CATEGORY_GROUPS'] = $producerCategoryGroups;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function save_add() {
		
		$this->load->model('ProducerCategoryModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->ProducerCategoryModel->addProducerCategoryGroup() ) {
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
		if ( $this->ProducerCategoryModel->updateProducerCategoryGroup() ) {
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