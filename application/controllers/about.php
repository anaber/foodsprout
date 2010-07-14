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
	
	// Feedback page to gather feedback from users
	function feedback()
	{
		
	}
	
	// The first page that loads on the beta
	function privatebeta()
	{
		$data = array();
		
		$this->load->model('SeoModel');
		$seo = $this->SeoModel->getSeoDetailsFromPage('index');
		$data['SEO'] = $seo;
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'beta/beta1',
			);
		
		$this->load->view('templates/center_template_beta', $data);
	}
	
	// The second page for the beta test, AB test this page with Google Site Optimizer
	function beta()
	{
		$data = array();
		
		$this->load->model('SeoModel');
		$seo = $this->SeoModel->getSeoDetailsFromPage('index');
		$data['SEO'] = $seo;
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'beta/beta2',
			);
		
		$this->load->view('templates/center_template_beta', $data);
	}
	
	
}



?>