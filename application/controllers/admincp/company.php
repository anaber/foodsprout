<?php

class Company extends Controller {
	
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
				'list' => 'admincp/company',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Companies";
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function add()
	{
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/forms/company_form',
			);
		
		$data['RIGHT'] = array(
				'navigation' => 'admincp/includes/right/navigation',
			);
			
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Add Company";
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function update($id)
	{
		$data = array();
		
		$this->load->model('CompanyModel');
		$company = $this->CompanyModel->getCompanyFromId($id);
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/forms/company_form',
			);
		
			
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Update Company";
		$data['data']['center']['list']['COMPANY'] = $company;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function save_add() {
		
		$this->load->model('CompanyModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->CompanyModel->addCompany($this->input->post('companyName')) ) {
			
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
		
		$this->load->model('CompanyModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->CompanyModel->updateCompany() ) {
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
		$this->load->model('CompanyModel', '', TRUE);
		$companies = $this->CompanyModel->searchCompanies($q);
		echo $companies;
	}
	
	function ajaxSearchCompanies() {
		$this->load->model('CompanyModel', '', TRUE);
		$companies = $this->CompanyModel->getCompaniesJsonAdmin();
		echo json_encode($companies);
	}
}

/* End of file company.php */

?>