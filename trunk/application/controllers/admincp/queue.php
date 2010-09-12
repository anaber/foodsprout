<?php

class Queue extends Controller {
	
	function __construct()
	{
		global $ADMIN_LANDING_PAGE;
		parent::Controller();
		if ($this->session->userdata('isAuthenticated') != 1 || $this->session->userdata('userGroup') != 'admin' )
		{
			redirect($ADMIN_LANDING_PAGE);
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
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/farm_queue',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Farm - Queue";
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function farmersmarket() {
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/farmers_market_queue',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Farmers Market - Queue";
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function manufacture() {
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/manufacture_queue',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Manufacture - Queue";
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function restaurant() {
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/restaurant_queue',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Restaurant - Queue";
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	
	function distributor() {
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/distributor_queue',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Distributor - Queue";
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function supplier() {
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/supplier_queue',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Suppliers - Queue";
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function menu() {
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/menu_queue',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Menu Items - Queue";
		
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
	
	function ajaxQueueManufactures() {
		$this->load->model('ManufactureModel', '', TRUE);
		$manufactures = $this->ManufactureModel->getQueueManufacturesJson();
		echo json_encode($manufactures);
	}
	
	function ajaxQueueDistributors() {
		$this->load->model('DistributorModel', '', TRUE);
		$distributors = $this->DistributorModel->getQueueDistributorJson();
		echo json_encode($distributors);
	}
	
	function ajaxQueueFarmersMarket() {
		$this->load->model('FarmersMarketModel', '', TRUE);
		$farmersMarket = $this->FarmersMarketModel->getQueueFarmersMarketJson();
		echo json_encode($farmersMarket);
	}
	
	function ajaxQueueSuppliers() {
		$this->load->model('SupplierModel', '', TRUE);
		$suppliers = $this->SupplierModel->getQueueSuppliersJson();
		echo json_encode($suppliers);
	}
	
	function ajaxQueueMenuItems() {
		$this->load->model('ProductModel', '', TRUE);
		$products = $this->ProductModel->getQueueProductsJson();
		echo json_encode($products);
	}
	
}

/* End of file queue.php */

?>