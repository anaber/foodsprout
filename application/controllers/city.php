<?php

class City extends Controller {
	
	function __construct()
	{
		global $LANDING_PAGE;
		parent::Controller();
		if ($this->session->userdata('isAuthenticated') != 1 )
		{
			redirect($LANDING_PAGE);
		}
	}
	
	function get_cities_based_on_state() {		
		$q = strtolower($_REQUEST['q']);
		$stateId = $_REQUEST['stateId'];
		
		$this->load->model('CityModel', '', TRUE);
		
		if ($stateId != '') {
			$cities = $this->CityModel->getCityBasedOnState ( $stateId, $q );
		} else {
			$cities = 'No Match';
		}
		echo $cities;
	}
	
}

/* End of file city.php */

?>