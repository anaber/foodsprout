<?php

class Processing extends Controller {
	
	function index()
	{
		$data['main_content'] = 'processing/processing_list';
		$this->load->view('templates/list_template', $data);
	}
	
}

/* End of file processing.php */

?>