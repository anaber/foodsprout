<?php

class City extends Controller {
	
	function __construct() {
		parent::Controller();
		checkUserLogin();
	}
	
	function get_cities_based_on_state() {		
		//$q = strtolower($_REQUEST['q']);
		$q = $_REQUEST['q'];
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