<?php

class Distribution extends Controller {
	
	function index()
	{
		$data['main_content'] = 'distribution/distribution_list';
		$this->load->view('templates/list_template', $data);
	}
	
}

/* End of file processing.php */

?>