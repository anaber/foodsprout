<?php

class About extends Controller {
	
	
	// The default goes to the about page
	function index()
	{
		// List of views to be included
		$data['LEFT'] = array(
				'navigation' => 'about/left_nav',
			);
		
		$data['CENTER'] = array(
				'content' => 'about/about',
		);
		
		// Data to send to the views
		$data['data']['left']['navigation']['VIEW_HEADER'] = "Food Sprout >";
		$data['data']['center']['content']['VIEW_HEADER'] = "About Food Sprout";
		
		$this->load->view('/templates/left_center_template', $data);
	}
	
	// Contact information
	function contact()
	{
		// List of views to be included
		$data['LEFT'] = array(
				'navigation' => 'about/left_nav',
			);
		
		$data['CENTER'] = array(
				'content' => 'about/contact',
		);
		
		// Data to send to the views
		$data['data']['left']['navigation']['VIEW_HEADER'] = "Food Sprout >";
		$data['data']['center']['content']['VIEW_HEADER'] = "Contacting Food Sprout";
		
		$this->load->view('/templates/left_center_template', $data);
	}
	
	// Information for business owners
	function business()
	{
		// List of views to be included
		$data['LEFT'] = array(
				'navigation' => 'about/left_nav',
			);
		
		$data['CENTER'] = array(
				'content' => 'about/business',
		);
		
		// Data to send to the views
		$data['data']['left']['navigation']['VIEW_HEADER'] = "Food Sprout >";
		$data['data']['center']['content']['VIEW_HEADER'] = "Information for Restaurant &amp; Businesses";
		
		$this->load->view('/templates/left_center_template', $data);
	}
	
	
}



?>