<?php

class Photos extends Controller {
	
	function __construct()
	{
		global $ADMIN_LANDING_PAGE;
		parent::Controller();
		if ($this->session->userdata('isAuthenticated') != 1 || $this->session->userdata('userGroup') != 'admin' )
		{
			redirect($ADMIN_LANDING_PAGE);
		}
	}
	
	function index() {
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/photos',
			);			
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Photos";
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function ajaxSearchPhotos()
	{
		$this->load->model('PhotoModel', '', TRUE);
		$photos = $this->PhotoModel->getPhotosAdminJson('restaurant');		

		echo json_encode($photos);

	}	
	
	function photoAction()
	{
		if ($this->input->post('action'))
		{
			$this->load->model('PhotoModel');
			
			if ($this->input->post('action') == 'delete')
			{				
				if ($this->PhotoModel->deletePhoto($this->input->post('photo')))
				{
					echo "Photo Deleted";					
				}
				else 
				{
					echo "Something went wrong.";
				}	
				
			}
			else if ($this->input->post('action') == 'approve')
			{
				if ($this->PhotoModel->approvePhoto($this->input->post('photo')))
				{
					echo "Photo Approved";
				} 
				else 
				{
					echo "Something went wrong.";
				}
			}
			
			exit;
		}
	}
	
}

/* End of file photos.php */

?>