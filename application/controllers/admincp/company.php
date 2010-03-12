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
		
		$this->load->model('state_model');
		$states = $this->state_model->list_state();
		
		$this->load->model('country_model');
		$countries = $this->country_model->list_country();
		
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/company',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Companies";
		$data['data']['center']['list']['COUNTRIES'] = $countries;
		$data['data']['center']['list']['STATES'] = $states;
		
		$this->load->view('admincp/templates/center_template', $data);
		
		
	}
	
	function add()
	{
		$data = array();
		
		$this->load->model('state_model');
		$states = $this->state_model->list_state();
		
		$this->load->model('country_model');
		$countries = $this->country_model->list_country();
		
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/company_form',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Add Companies";
		$data['data']['center']['list']['COUNTRIES'] = $countries;
		$data['data']['center']['list']['STATES'] = $states;
		
		$this->load->view('admincp/templates/center_template', $data);
		
	}
	
	function update()
	{
		$id = $this->input->get('id');
		echo "Update ID : " . $id . "<br />";
		
		$this->load->model('state_model');
		$states = $this->state_model->list_state();
		
		$this->load->model('country_model');
		$countries = $this->country_model->list_country();
		
		$data['main_content'] = 'admincp/company_form';
		$data['data'] = array(
			'STATES' => $states,
			'COUNTRIES' => $countries,
		);
		
		$this->load->view('admincp/template', $data);
	}
	
	function save_add() {
		
		$this->load->model('company_model', '', TRUE);
		print_r_pre($_REQUEST);
		/*
		$GLOBALS = array();
		if ( $this->company_model->addCompany() ) {
			echo "yes";
		} else {
			if (isset($GLOBALS['error']) && !empty($GLOBALS['error']) ) {
				echo $GLOBALS['error'];
			} else {
				echo 'no';
			}
		}
		*/
	}
	
	function save_update() {
		
		$this->load->model('company_model', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->company_model->updateCompany() ) {
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