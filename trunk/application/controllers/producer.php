<?php

class Producer extends Controller {
	
	function __construct() {
		parent::Controller();
		checkUserLogin();
	}
	
	/**
	 * Migration: 		Done
	 * Migrated by: 	Deepak
	 * 
	 * Verified: 		Yes
	 * Verified By: 	Deepak
	 */
	function get_producers_based_on_type() {		
		//$q = strtolower($_REQUEST['q']);
		$q = $_REQUEST['q'];
		$producerType = $_REQUEST['supplierType'];
		
		$this->load->model('ProducerModel', '', TRUE);
		
		if ($producerType != '') {
			$companies = $this->ProducerModel->getProducersBasedOnType( $producerType, $q );
		} else {
			$companies = 'No Match';
		}
		
		echo $companies;
	}
	
	
}

/* End of file company.php */

?>