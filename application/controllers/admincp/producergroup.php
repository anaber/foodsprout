<?php

class Producergroup extends Controller 
{
	function __construct()
	{
		global $ADMIN_LANDING_PAGE;
		parent::Controller();
		if ($this->session->userdata('isAuthenticated') != 1 )
		{
			redirect($ADMIN_LANDING_PAGE);
		}
	}

	function index() 
	{
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/producer_group',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Producer Groups";
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function ajaxSearchProducerGroups()
	{
		$this->load->model('CompanyModel', '', TRUE);
		$producergroups = $this->CompanyModel->getProducerGroupsJsonAdmin();
		echo json_encode($producergroups);
	}
	
 	function ajaxSearchProducers()
    {
	    $this->load->model('CompanyModel');
	
	    $q = explode(',', $this->input->get('q'));
	            
	    $q = trim($q[0]);
	
	    $producers = $this->CompanyModel->getProducers($q);
	
	    if (count($producers) > 0)
	    {
		    foreach ($producers AS $prod)
		    {
	    		echo trim(json_encode($prod['producer']."|".$prod['producer_id']), '"')."\n";
		    }
	    }
	}
	
	function ajaxSearchConglomerate()
    {
	    $this->load->model('CompanyModel');
	
	    $q = explode(',', $this->input->get('q'));
	            
	    $q = trim($q[0]);
	
	    $conglomerates = $this->CompanyModel->searchCompanies($q);
		
	    if (count($conglomerates) > 0)
	    {
		    foreach ($conglomerates AS $cong)
		    {
		    	echo trim(json_encode($cong['conglomerate_name']."|".$cong['producer_conglomerate_id']), '"')."\n";
		    }
	    }
	}
	
	function add_group()
	{
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/forms/producer_group_form',
			);
		
		$data['RIGHT'] = array(
				'navigation' => 'admincp/includes/right/navigation',
			);
			
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Add Group";
		
		$this->load->view('admincp/templates/center_template', $data);
	}
}