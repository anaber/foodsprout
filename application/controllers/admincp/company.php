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
		$this->load->model('state_model');
		$states = $this->state_model->list_state();
		
		$this->load->model('country_model');
		$countries = $this->country_model->list_country();
		
		$data['main_content'] = 'admincp/company';
		$data['data'] = array(
			'STATES' => $states,
			'COUNTRIES' => $countries,
		);
		
		$this->load->view('admincp/template', $data);
	}
	
	function add()
	{
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
	
}

/* End of file company.php */

?>