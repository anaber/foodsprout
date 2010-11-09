<?php

class Logout extends Controller {

	function Logout()
	{
		parent::Controller();	
	}
	
	function index() {
		global $ADMIN_LANDING_PAGE;
		$this->session->sess_destroy();
		redirect($ADMIN_LANDING_PAGE, 'refresh');
	}

}

?>