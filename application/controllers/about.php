<?php

class About extends Controller {
	
	
	// The default goes to the about page
	function index()
	{
		// List of views to be included
		$data['CENTER'] = array(
				'content' => '/about/about',
		);
		
		// Data to send to the views
		$data['data']['center']['content']['VIEW_HEADER'] = "About Food Sprout";
		
		$this->load->view('/templates/center_template', $data);
	}
	
	// Contact information
	function contact()
	{
		// List of views to be included
		$data['CENTER'] = array(
				'content' => '/about/contact',
		);
		
		// Data to send to the views
		$data['data']['center']['content']['VIEW_HEADER'] = "Contacting Food Sprout";
		
		$this->load->view('/templates/center_template', $data);
	}
	
	
}



?>