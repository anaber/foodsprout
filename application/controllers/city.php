<?php

class City extends Controller {
	
	function __construct() {
		parent::Controller();
		checkUserLogin();
		checkUserAgent();
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
	
	function get_cities_based_on_restaurant() {		
		//$q = strtolower($_REQUEST['q']);
		$q = $_REQUEST['q'];
		$producerId = $_REQUEST['producerId'];
		
		$this->load->model('CityModel', '', TRUE);
		
		if ($producerId != '') {
			$cities = $this->CityModel->getCitiesForProducer ( $producerId, $q );
		} else {
			$cities = 'No Match';
		}
		echo $cities;
	}

        function get_cities_for_user_settings()
        {
            $this->load->model('CityModel');

            $q = $this->input->get('q');

            $cities = $this->CityModel->getCitiesForUser($q);

            echo $cities;
        }
	
}

/* End of file city.php */

?>