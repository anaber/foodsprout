<?php

class Restaurant extends Controller {
	
	function index()
	{
		$data['main_content'] = 'company/company_list';
		$this->load->view('templates/list_template', $data);
	}
	
}

/* End of file restaurant.php */

?>