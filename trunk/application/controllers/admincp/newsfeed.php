<?php

class Newsfeed extends Controller {
	
	function __construct()
	{
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
				'list' => 'admincp/newsfeed'
			);
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function ajaxSearchNewsfeed()
	{
		$this->load->model('NewsfeedModel');
		$newsfeed = $this->NewsfeedModel->getNewsFeedJsonAdmin();
		/*echo "<pre>";
		print_r($newsfeed);
		echo "</pre>";*/
		echo json_encode($newsfeed);
	}
	
	function add()
	{
		if ($this->input->post('save'))
		{
			$this->load->model('NewsfeedModel');
			$this->NewsfeedModel->addNews();
		}
		
		/*echo "<pre>";
		print_r($this->session->userdata('userId'));
		echo "</pre>";*/
		
		$data['CENTER'] = array(
				'form' => 'admincp/forms/newsfeed_form.php',
			);
		
		// Data to be passed to the views
		$data['data']['center']['form']['VIEW_HEADER'] = 'Add News';
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
}

/* End of file newsfeed.php */

?>