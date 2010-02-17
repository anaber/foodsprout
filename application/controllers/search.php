<?php

class Search extends Controller {
	
	function index()
	{
		$data['main_content'] = 'product/product_list';
		$this->load->view('templates/list_template', $data);
	}
	
	function results()
	{
		$data['main_content'] = 'product/product_list';
		$this->load->view('templates/list_template', $data);
	}
	
	function restaurant()
	{
		$data['main_content'] = 'product/product_list';
		$this->load->view('templates/list_template', $data);
	}
	
}

/* End of file search.php */

?>