<?php

class State extends Controller {
	
	function __construct()
	{
		parent::Controller();
	}
	
	function ajaxSearchStates() {
		$this->load->model('StateModel');
		$states = $this->StateModel->listState();
		echo json_encode($states);
	}
	
}

/* End of file state.php */

?>