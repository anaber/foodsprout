<?php
set_time_limit(0);

error_reporting(E_ALL ^ E_WARNING);
	
$defines_file = '../includes/properties.php';
if (file_exists($defines_file))
{
	require_once($defines_file);
} 

$sustainable = new Sustainable();

$sustainable->index();
//$geocode->geocodeZip();




class Sustainable {
	var $db;
	
	function __construct() {
		global $DB_HOST, $DB_USER, $DB_PASSWORD, $DATABSE;
		$this->db = mysql_connect($DB_HOST, $DB_USER, $DB_PASSWORD);
		mysql_select_db($DATABSE, $this->db);
	}
	
	function index() {
		$this->updateRestaurantWithSustainableAddress();
	}
	
	function updateRestaurantWithSustainableAddress() {
		$query = 'SELECT restaurant_id FROM address WHERE claims_sustainable =1';
		
		$result = mysql_query($query);
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			$query = 'UPDATE restaurant SET claims_sustainable = 1 WHERE restaurant_id 	 = ' . $row['restaurant_id'];
			echo $row['restaurant_id'] . ' : ';
			if ( mysql_query($query) ) {
				echo "DONE \n";
			} else {
				echo "FAILED \n";
			}
		}
	}	
}


?>
