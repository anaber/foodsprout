<?php

class Map extends Controller {
	
	function index()
	{
		global $GOOGLE_MAP_KEY;
		
		$data = array();
		
		// List of views to be included
		$data['LEFT'] = array(
				'result' => 'map/result',
			);
		
		$data['CENTER'] = array(
				'map' => 'map/interactive_map',
			);
		
		// Data to be passed to the views
		
		
		// Center -> Map
		$data['data']['left']['result']['VIEW_HEADER'] = "Results";
		
		$data['data']['center']['map']['GOOGLE_MAP_KEY'] = $GOOGLE_MAP_KEY;
		$data['data']['center']['map']['VIEW_HEADER'] = "Interactive Map";
		$data['data']['center']['map']['width'] = '100%';
		$data['data']['center']['map']['height'] = '500';
		
		
		
		$this->load->view('templates/center_template_fluid', $data);
	}
	
}

/* End of file map.php */

?>