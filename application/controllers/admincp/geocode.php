<?php

class Geocode extends Controller {
	
	function __construct() {
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
				" WHERE CountryID = 223 " .
				" AND Geocoded = 0 " .
				" ORDER BY Zip limit 0, 15";
		
		$result = $this->db->query($query);
		
		$this->load->model('GoogleMapModel', '', TRUE);
		/*
		$address = 'ROCKY HILL, NJ 8553, USA';
		$latLng = $this->GoogleMapModel->geoCodeAddressV3($address);
		*/
		
		foreach ($result->result_array() as $row) {
			$zip = $row['Zip'];
			
			if (strlen ($zip) == 4 ) {
				$zip = '0'.$zip;
			}
			
			$address1 = $zip . ', USA';
			$address2 = $row['City'] . ", " . $row['State']  . " " . $zip . ', USA';
			
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
					echo "<li>Approximate:" . ( ($latLng1['approximate'] == 1) ? 'YES' : 'NO') . "</li>";
					echo "</ul>";
				echo "<li>" . $address2 . "</li>";
					echo "<ul>";
					echo "<li>" . $latLng2['latitude'] . " (lat), " . $latLng2['longitude'] ." (lng) --- " . distance($cLat, $cLng, $latLng2['latitude'], $latLng2['longitude'], "m") . " (distance from database record)</li>";
					echo "<li>Approximate:" . ( ($latLng2['approximate'] == 1) ? 'YES' : 'NO') . "</li>";
					echo "</ul>";
				
				echo "</ul>";
			echo "</ul>";
		}
	}
	
	function validateZip2 () {
		
		$query = "SELECT * " .
				" FROM zipcode " .
				" WHERE geocoded = 0 " .
				//" OR approximate = 1 " .
				" ORDER BY zipcode limit 0, 15";
		
		$result = $this->db->query($query);
		
		$this->load->model('GoogleMapModel', '', TRUE);
		
		foreach ($result->result_array() as $row) {
			$zip = $row['zipcode'];
			
			$address = $zip . ', USA';
			$latLng = array();
			
			$latLng = $this->GoogleMapModel->geoCodeAddressV3($address);
			
			echo "<ul>";
			echo "<li>". $zip ."</li>";
				echo "<ul>";
				
					echo "<li>" . $address . "</li>";
					echo "<ul>";
					echo "<li>" . $latLng['latitude'] . " (lat), " . $latLng['longitude'] ." (lng) </li>";
					echo "<li>Approximate:" . ( ($latLng['approximate'] == 1) ? 'YES' : 'NO') . "</li>";
					echo "</ul>";
				
				echo "</ul>";
			echo "</ul>";
		}
	}
	
}

/* End of file geocode.php */

?>