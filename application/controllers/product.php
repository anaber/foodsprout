<?php

class Product extends Controller {
	
	function index()
	{
		$data['main_content'] = 'product/product_list';
		$this->load->view('templates/list_template', $data);
	}
	
}

/* End of file product.php */