<?php

class Distribution extends Controller {
	
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
		$distributions = array();
		
		$this->load->model('DistributionModel');
		$distributions = $this->DistributionModel->list_distribution();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/distribution',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Distributions";
		$data['data']['center']['list']['DISTRIBUTIONS'] = $distributions;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	// Create the form page to add a distribution to the database, does not actually add the data, only builds the form
	function add()
	{
		$data = array();
		
		$this->load->model('StateModel');
		$states = $this->StateModel->list_state();
		
		$this->load->model('CountryModel');
		$countries = $this->CountryModel->list_country();
		
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/distribution_form',
			);
			
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Add Distribution";
		$data['data']['center']['list']['COUNTRIES'] = $countries;
		$data['data']['center']['list']['STATES'] = $states;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function update($id)
	{
		$data = array();
		
		$this->load->model('DistributionModel');
		$distribution = $this->DistributionModel->getDistributionFromId($id);
		
		$this->load->model('StateModel');
		$states = $this->StateModel->list_state();
		
		$this->load->model('CountryModel');
		$countries = $this->CountryModel->list_country();
		
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/distribution_form',
			);
			
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Update Distribution";
		$data['data']['center']['list']['COUNTRIES'] = $countries;
		$data['data']['center']['list']['STATES'] = $states;
		$data['data']['center']['list']['DISTRIBUTION'] = $distribution;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	// Pass the form data to the model to be inserted into the database
	function save_add() {
		
		$this->load->model('DistributionModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->DistributionModel->addDistribution() ) {
			
			// TO DO: IF THE USER DOES NOT HAVE JAVASCRIPT WE NEED TO USE SERVER SIDE REDIRECT.  BELOW CODE WILL DO THIS, HOWEVER THE echo 'yes' IS REQUIRED TO PASS TO THE JAVASCRIPT.  CONSIDER A BETTER WAY TO NOTIFY THE JQUERY JAVASCRIPT THAT THE EVENT WAS SUCCESSFUL SO AS TO ALLOW THE PROPER REDIRECT FOR NON JAVASCRIPT
			// Added the new distribution successfully, send user to index
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
		
		$this->load->model('DistributionModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->DistributionModel->updateDistribution() ) {
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