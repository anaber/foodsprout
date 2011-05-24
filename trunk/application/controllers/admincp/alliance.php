<?php

class Alliance extends Controller {
	
	function __construct()
	{
		global $ADMIN_LANDING_PAGE;
		parent::Controller();
		if ($this->session->userdata('isAuthenticated') != 1 )
		{
			redirect($ADMIN_LANDING_PAGE);
		}
	}
	
	function index() {
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/alliance',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Alliance";
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function add()
	{
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/forms/alliance_form',
			);
		
		$data['RIGHT'] = array(
				'navigation' => 'admincp/includes/right/navigation',
			);
			
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Add Alliance";
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function update($id)
	{
		$data = array();
		
		$this->load->model('AllianceModel');
		$alliance = $this->AllianceModel->getAllianceFromId($id);
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/forms/alliance_form',
			);
		
			
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Update Alliance";
		$data['data']['center']['list']['COMPANY'] = $alliance;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function save_add() {
		
		$this->load->model('AllianceModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->AllianceModel->addAlliance($this->input->post('allianceName')) ) {
			
			// TO DO: IF THE USER DOES NOT HAVE JAVASCRIPT WE NEED TO USE SERVER SIDE REDIRECT.  BELOW CODE WILL DO THIS, HOWEVER THE echo 'yes' IS REQUIRED TO PASS TO THE JAVASCRIPT.  CONSIDER A BETTER WAY TO NOTIFY THE JQUERY JAVASCRIPT THAT THE EVENT WAS SUCCESSFUL SO AS TO ALLOW THE PROPER REDIRECT FOR NON JAVASCRIPT
			// Added the new COMPANY successfully, send user to index
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
		
		$this->load->model('AllianceModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->AllianceModel->updateAlliance() ) {
			echo "yes";
		} else {
			if (isset($GLOBALS['error']) && !empty($GLOBALS['error']) ) {
				echo $GLOBALS['error'];
			} else {
				echo 'no';
			}
		}
		
	}
	
	function get_companies_based_on_type($q) {
		$this->load->model('ProducerModel', '', TRUE);
		$arr = explode('___' , $q);
		$producerType = $arr[0];
		$q = $arr[1];
		if ($producerType != '') {
			$producers = $this->ProducerModel->getProducersBasedOnType( $producerType, $q );
		} else {
			$producers = 'No Match';
		}
		echo $producers;
	}
	
	function searchCompanies() {
		$q = strtolower($_REQUEST['q']);
		$this->load->model('AllianceModel', '', TRUE);
		$companies = $this->AllianceModel->searchCompanies($q);
		echo $companies;
	}
	
	function ajaxSearchCompanies() {
		$this->load->model('AllianceModel', '', TRUE);
		$companies = $this->AllianceModel->getCompaniesJsonAdmin();
		echo json_encode($companies);
	}
}

/* End of file alliance.php */

?>