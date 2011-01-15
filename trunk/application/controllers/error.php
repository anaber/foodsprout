<?php
class Error extends Controller {
 
	function error_404()
	{
		$this->load->view('includes/header');
		
		$this->load->view('errors/body');

		$this->load->view('includes/footer');
	}
	
	
}