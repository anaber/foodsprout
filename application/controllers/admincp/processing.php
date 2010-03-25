<?php

class Processing extends Controller {
	
	function __construct()
	{
		parent::Controller();
		if ($this->session->userdata('isAuthenticated') != 1 )
		{
			redirect('admincp/login');
		}
	}
	
	function index()
	{
		$data = array();
		$processings = array();
		
		$this->load->model('ProcessingModel');
		$processings = $this->ProcessingModel->list_processing();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/processing',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Processings";
		$data['data']['center']['list']['PROCESSINGS'] = $processings;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	// Create the form page to add a processing to the database, does not actually add the data, only builds the form
	function add()
	{
		$data = array();
		
		$this->load->model('StateModel');
		$states = $this->StateModel->list_state();
		
		$this->load->model('CountryModel');
		$countries = $this->CountryModel->list_country();
		
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/processing_form',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Add Processing";
		$data['data']['center']['list']['COUNTRIES'] = $countries;
		$data['data']['center']['list']['STATES'] = $states;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	// Update a record using an id
	function update($id)
	{
		$data = array();
		
		$this->load->model('ProcessingModel');
		$processing = $this->ProcessingModel->getProcessingFromId($id);
		
		$this->load->model('StateModel');
		$states = $this->StateModel->list_state();
		
		$this->load->model('CountryModel');
		$countries = $this->CountryModel->list_country();
		
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/processing_form',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Update Processing";
		$data['data']['center']['list']['COUNTRIES'] = $countries;
		$data['data']['center']['list']['STATES'] = $states;
		$data['data']['center']['list']['PROCESSING'] = $processing;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	// Pass the form data to the model to be inserted into the database
	function save_add() {
		
		$this->load->model('ProcessingModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->ProcessingModel->addProcessing() ) {
			
			// TO DO: IF THE USER DOES NOT HAVE JAVASCRIPT WE NEED TO USE SERVER SIDE REDIRECT.  BELOW CODE WILL DO THIS, HOWEVER THE echo 'yes' IS REQUIRED TO PASS TO THE JAVASCRIPT.  CONSIDER A BETTER WAY TO NOTIFY THE JQUERY JAVASCRIPT THAT THE EVENT WAS SUCCESSFUL SO AS TO ALLOW THE PROPER REDIRECT FOR NON JAVASCRIPT
			// Added the new processing successfully, send user to index
			//$this->index();
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
		
		$this->load->model('ProcessingModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->ProcessingModel->updateProcessing() ) {
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

/* End of file company.php */

?>