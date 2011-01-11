<?php
class Visitors_test extends Controller{
	
	
	function Visitors_test(){
		
		parent::Controller(); 
		
	}
	
	function index(){
		
		$this->load->plugin('Visits');
		
		$visits = new Visits();
		
		print_r($visits->totalByWeek('/visitors_test/index/sdadsadsa', '1'));
		
	}
	
	function minimlogtime(){
		
	$this->load->plugin('Visits');
		
		$visits = new Visits();
		
		echo $visits->minimLogTime();
	}
}