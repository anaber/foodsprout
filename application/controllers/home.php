<?php

class Home extends Controller {
	
	function __construct() {
		parent::Controller();
		checkUserLogin();
		checkUserAgent();		
	}
	
	// Homepage
	function index() {
		session_start();
		
		$rss_url = base_url() . "uploads/twitter.rss";
		
		$data = array();
		
		$this->load->model('SeoModel');
		$seo = $this->SeoModel->getSeoDetailsFromPage('index');
		$data['SEO'] = $seo;
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'home',
			);
			
		// Get recent restaurants
		$this->load->model('RestaurantModel');
		$newrestaurants = $this->RestaurantModel->listNewRestaurants();
		
		$data['NEWREST'] = $newrestaurants;
		
		// Get recent products
		$this->load->model('ProductModel');
		$newProducts = $this->ProductModel->listNewProducts();
		
		$data['NEWPRODUCTS'] = $newProducts;
		
		// Get new farms
		$this->load->model('FarmModel');
		$newFarms = $this->FarmModel->listNewFarms();
		
		$data['NEWFARMS'] = $newFarms;
			
		// Load the rssparse
		// Get the latest blog posts
		//$this->load->library('RSSParser', array('url' => 'http://twitter.com/statuses/user_timeline/124974783.rss', 'life' => 0));
		$this->load->library('RSSParser', array('url' => $rss_url, 'life' => 0));
	  	
		$twitterdata = array();
		//Get 1 items from the feed
	  	$twitterdata = $this->rssparser->getFeed(1);
	
		$data['TWITTERDATA'] = $twitterdata;
			
		// Get the latest blog posts
		$this->load->library('RSSParser', array('url' => 'http://blog.foodsprout.com/feed/', 'life' => 0));
		  	
		$blogdata = array();
		//Get 1 items from the feed
		$blogdata = $this->rssparser->getFeed(1);
		
		$data['BLOGDATA'] = $blogdata;
			
		// Custom CSS
		$data['CSS'] = array(
				'home'
			);
		
		$this->load->view('templates/center_template', $data);
	}
	
	
}

/* End of file home.php */

?>