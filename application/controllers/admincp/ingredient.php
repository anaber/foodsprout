<?php

class Ingredient extends Controller {
	
	function index()
	{
		$data['main_content'] = 'admincp/ingredient';
		$this->load->view('admincp/template', $data);
	}
}

/* End of file ingredient.php */

?>