<?php
class Testmobile extends Controller{
	
	
	function Testmobile(){
		
		parent::Controller();
	}
	
	
	function user_agent(){

		$this->load->helper('uagent_info');
		
		$md = new uagent_info();
		
		echo $md->DetectMobileLong();
		
	}
}