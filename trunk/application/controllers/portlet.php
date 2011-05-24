<?php

class Portlet extends Controller {

	function __construct() {
		parent::Controller();
	}

	function save_portlet_position() {
        global $RECOMMENDED_CITIES;
		
		$this->load->model('PortletModel', '', TRUE);
		
		$GLOBALS = array();
		
		if ( $this->PortletModel->savePortletPositon() ) {
			echo 'yes';
		} else {
			if (isset($GLOBALS['error']) && !empty($GLOBALS['error']) ) {
				echo $GLOBALS['error'];
			} else {
				echo 'no';
			}
		}
		
	}
}

/* End of file restaurant.php */
?>