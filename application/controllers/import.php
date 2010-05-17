<?php

class Import extends Controller {
	
	
	// The default goes to the about page
	function index()
	{
		//$from = $_REQUEST['from'];
		//$to = $_REQUEST['to'];
		$this->load->model('ImportModel');
		//$this->ImportModel->importRestaurantData($from, $to);
		
		for($i = 1; $i <= 484000; $i+=1000) {
		//for($i = 1; $i <= 10000; $i+=1000) {
			$from = $i;
			$to = $from + 999;
			
			//echo $from . ": "  . $to . "<br />";
			$this->ImportModel->importRestaurantData($from, $to);
		}
		
	}
}



?>