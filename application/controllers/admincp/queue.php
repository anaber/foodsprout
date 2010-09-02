<?php

class Queue extends Controller {
	
	function __construct()
	{
		parent::Controller();
		if ($this->session->userdata('isAuthenticated') != 1 || $this->session->userdata('userGroup') != 'admin' )
		{
			redirect('admincp/login');
		}
	}
	
	function validateZip () {
		$query = "SELECT * " .
				" FROM zip_source " .
				" WHERE CountryID = 223 limit 1, 6";
		
		$result = $this->db->query($query);
		
		$this->load->model('GoogleMapModel', '', TRUE);
		
		foreach ($result->result_array() as $row) {
			
			$address1 = $row['Zip'] . ', USA';
			$address2 = $row['City'] . ", " . $row['State']  . " " . $row['Zip'] . ', USA';
			
			$cLat = $row['Latitude'];
			$cLng = $row['Longitude'];
			if ($row['Latitude'] > 0) {
				
			} else {
				
				$cLat = $row['Longitude'];
				$cLng = $row['Latitude'];
			}
			
			$latLng1 = $this->GoogleMapModel->geoCodeAddressV3($address1);
			$latLng2 = $this->GoogleMapModel->geoCodeAddressV3($address2);
			
			echo "<ul>";
			echo "<li>". $row['Zip'] ."</li>";
				echo "<ul>";
				echo "<li>Database Table</li>";
					echo "<ul>";
					echo "<li>" . $row['Latitude'] . " (lat), " . $row['Longitude'] ." (lng)</li>";
					echo "<li>" . $cLat . " (lat), " . $cLng ." (lng) --  Correct</li>";
					echo "</ul>";
				
				echo "<li>" . $address1 . "</li>";
					echo "<ul>";
					echo "<li>" . $latLng1['latitude'] . " (lat), " . $latLng1['longitude'] ." (lng) --- " . distance($cLat, $cLng, $latLng1['latitude'], $latLng1['longitude'], "m") . " (distance from database record)</li>";
					echo "</ul>";
				echo "<li>" . $address2 . "</li>";
					echo "<ul>";
					echo "<li>" . $latLng2['latitude'] . " (lat), " . $latLng2['longitude'] ." (lng) --- " . distance($cLat, $cLng, $latLng2['latitude'], $latLng2['longitude'], "m") . " (distance from database record)</li>";
					echo "</ul>";
				
				echo "</ul>";
			echo "</ul>";
		}
	}
	
	function index() {
		global $FARMER_TYPES;
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/farm_queue',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Farm - Queue";
		$data['data']['center']['list']['FARMER_TYPES'] = $FARMER_TYPES;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function farmersmarket() {
		global $FARMER_TYPES;
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/farmers_market_queue',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Farmers Market - Queue";
		$data['data']['center']['list']['FARMER_TYPES'] = $FARMER_TYPES;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function manufacture() {
		global $FARMER_TYPES;
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/manufacture_queue',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Manufacture - Queue";
		$data['data']['center']['list']['FARMER_TYPES'] = $FARMER_TYPES;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	
	function restaurant() {
		global $FARMER_TYPES;
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/restaurant_queue',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Restaurant - Queue";
		$data['data']['center']['list']['FARMER_TYPES'] = $FARMER_TYPES;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	
	function distributor() {
		global $FARMER_TYPES;
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/distributor_queue',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Distributor - Queue";
		$data['data']['center']['list']['FARMER_TYPES'] = $FARMER_TYPES;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function supplier() {
		global $FARMER_TYPES;
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/supplier_queue',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Suppliers - Queue";
		$data['data']['center']['list']['FARMER_TYPES'] = $FARMER_TYPES;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function menu() {
		global $FARMER_TYPES;
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/menu_queue',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Menu Items - Queue";
		$data['data']['center']['list']['FARMER_TYPES'] = $FARMER_TYPES;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function ajaxQueueFarms() {
		$this->load->model('FarmModel', '', TRUE);
		$farms = $this->FarmModel->getQueueFarmsJson();
		echo json_encode($farms);
	}
	
	function ajaxQueueRestaurants() {
		$this->load->model('RestaurantModel', '', TRUE);
		$restaurants = $this->RestaurantModel->getQueueRestaurantsJson();
		echo json_encode($restaurants);
	}
}

/* End of file company.php */

?>