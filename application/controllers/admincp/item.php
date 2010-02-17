<?php

class Item extends Controller {
	
	function index()
	{
		$data['main_content'] = 'admincp/item';
		$this->load->view('admincp/template', $data);
	}
}

/* End of file state.php */

?>