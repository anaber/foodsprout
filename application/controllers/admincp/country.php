<?php

class Country extends Controller {
	
	function index()
	{
		$data['main_content'] = 'admincp/country';
		$this->load->view('admincp/template', $data);
	}
}

/* End of file country.php */

?>