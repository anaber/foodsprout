<?php
class Testmobile extends Controller{
	
	
	function Testmobile(){
		
		parent::Controller();
				
		$this->load->plugin('Visits');
		
		$visits = new Visits();
		
		$visits->addProducer(504);
	}
	
	
	function user_agent(){

		$this->load->helper('uagent_info');
		
		$md = new uagent_info();
		
		echo $md->DetectMobileLong();
		
	}
}