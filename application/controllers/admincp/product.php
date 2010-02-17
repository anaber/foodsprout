<?php

class Product extends Controller {
	
	function index()
	{
		$data['main_content'] = 'admincp/product';
		$this->load->view('admincp/template', $data);
	}
	
}

/* End of file product.php */

?>