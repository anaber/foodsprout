<?php

class Map extends Controller {
	
	function index()
	{
		global $GOOGLE_MAP_KEY;
		
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'map' => 'map/interactive_map',
				'result' => 'map/result',
			);
		
		// Data to be passed to the views
		
		// Center -> Map
		$data['data']['center']['map']['GOOGLE_MAP_KEY'] = $GOOGLE_MAP_KEY;
		$data['data']['center']['map']['VIEW_HEADER'] = "Interactive Map";
		$data['data']['center']['map']['width'] = '700';
		$data['data']['center']['map']['height'] = '400';
		
		$data['data']['center']['result']['VIEW_HEADER'] = "Result";
		
		$this->load->view('templates/center_template', $data);
	}
	
}

/* End of file map.php */

?>