<?php

class Farm extends Controller {
	
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
		$farms = array();
		
		$this->load->model('FarmModel');
		$farms = $this->FarmModel->list_farm();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/farm',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Farms";
		$data['data']['center']['list']['FARMS'] = $farms;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	// Create the form page to add a farm to the database, does not actually add the data, only builds the form
	function add()
	{
		$data = array();
		
		$this->load->model('StateModel');
		$states = $this->StateModel->list_state();
		
		$this->load->model('CountryModel');
		$countries = $this->CountryModel->list_country();
		
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/farm_form',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Add Farm";
		$data['data']['center']['list']['COUNTRIES'] = $countries;
		$data['data']['center']['list']['STATES'] = $states;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function update($id)
	{
		$data = array();
		
		$this->load->model('FarmModel');
		$farm = $this->FarmModel->getFarmFromId($id);
		
		$this->load->model('StateModel');
		$states = $this->StateModel->list_state();
		
		$this->load->model('CountryModel');
		$countries = $this->CountryModel->list_country();
		
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/farm_form',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Update Farm";
		$data['data']['center']['list']['COUNTRIES'] = $countries;
		$data['data']['center']['list']['STATES'] = $states;
		$data['data']['center']['list']['FARM'] = $farm;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	// Pass the form data to the model to be inserted into the database
	function save_add() {
		
		$this->load->model('FarmModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->FarmModel->addFarm() ) {
			
			// TO DO: IF THE USER DOES NOT HAVE JAVASCRIPT WE NEED TO USE SERVER SIDE REDIRECT.  BELOW CODE WILL DO THIS, HOWEVER THE echo 'yes' IS REQUIRED TO PASS TO THE JAVASCRIPT.  CONSIDER A BETTER WAY TO NOTIFY THE JQUERY JAVASCRIPT THAT THE EVENT WAS SUCCESSFUL SO AS TO ALLOW THE PROPER REDIRECT FOR NON JAVASCRIPT
			// Added the new farm successfully, send user to index
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
		
		$this->load->model('FarmModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->FarmModel->updateFarm() ) {
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