<?php

class Noaddress extends Controller {
	
	function __construct() {
		global $ADMIN_LANDING_PAGE;
		parent::Controller();
		if ($this->session->userdata('isAuthenticated') != 1 || $this->session->userdata('access') != 'admin' )
		{
			redirect($ADMIN_LANDING_PAGE);
		}
	}
	
	function index() 
	{
		$data = array();
		
		$data['CENTER'] = array(
				'list' => 'admincp/noaddress.php',
			);			
		
		$data['data']['center']['list']['VIEW_HEADER'] = "Producers with No Address";
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function ajaxSearchProducers()
	{
		$this->load->model('ProducerModel', '', TRUE);
		$producers = $this->ProducerModel->getProducersWithNoAddressJson();	
		if (count($producers) > 0) 
		{	
			echo json_encode($producers);
		}
		else 
		{
			echo "No results available.";
		}
	}
	
	
}

/* End of file home.php */

?>