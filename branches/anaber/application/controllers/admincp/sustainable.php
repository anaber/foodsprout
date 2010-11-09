<?php
class Sustainable extends Controller {
	function __construct() {
		global $ADMIN_LANDING_PAGE;
		parent::Controller();
		if ($this->session->userdata('isAuthenticated') != 1 || $this->session->userdata('userGroup') != 'admin' )
		{
			redirect($ADMIN_LANDING_PAGE);
		}
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
				echo "DONE <br />";
			} else {
				echo "FAILED <br />";
			}
		}
	}	
}


?>
