<?php

class Company extends Controller {
	
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
		
		$this->load->model('CompanyModel');
		$companies = $this->CompanyModel->listCompany();
		
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/company',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Companies";
		$data['data']['center']['list']['COMPANIES'] = $companies;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function add()
	{
		$data = array();
		
		$this->load->model('StateModel');
		$states = $this->StateModel->list_state();
		
		$this->load->model('CountryModel');
		$countries = $this->CountryModel->list_country();
		
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/company_form',
			);
		
		$data['RIGHT'] = array(
				'navigation' => 'admincp/includes/right/navigation',
			);
			
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Add Company";
		$data['data']['center']['list']['COUNTRIES'] = $countries;
		$data['data']['center']['list']['STATES'] = $states;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function update($id)
	{
		$data = array();
		
		$this->load->model('CompanyModel');
		$company = $this->CompanyModel->getCompanyFromId($id);
		
		$this->load->model('StateModel');
		$states = $this->StateModel->list_state();
		
		$this->load->model('CountryModel');
		$countries = $this->CountryModel->list_country();
		
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/company_form',
			);
		
		$data['LEFT'] = array(
				'navigation' => 'admincp/includes/left/nav_company',
			);
			
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Update Company";
		$data['data']['center']['list']['COUNTRIES'] = $countries;
		$data['data']['center']['list']['STATES'] = $states;
		$data['data']['center']['list']['COMPANY'] = $company;
		
		$data['data']['left']['navigation']['VIEW_HEADER'] = "Options";
		
		$this->load->view('admincp/templates/left_center_template', $data);
	}
	
	function save_add() {
		
		$this->load->model('CompanyModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->CompanyModel->addCompany() ) {
			
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
	
	function get_companies_based_on_type() {
		$this->load->model('CompanyModel', '', TRUE);
		$companies = $this->CompanyModel->getCompanyBasedOnType( $this->input->post('companyType') );
		echo json_encode($companies);
	}
	
}

/* End of file company.php */

?>